<?php

namespace App\Services;

class PrayerCalculationService
{
    /**
     * Koordinat Ka'bah di Makkah Al-Mukarramah.
     */
    public const KAABA_LAT = 21.4225;
    public const KAABA_LNG = 39.8262;

    /**
     * Hitung sudut arah Kiblat (dalam derajat dari Utara searah jarum jam, 0° = Utara, 90° = Timur).
     */
    public function calculateQiblaDirection(float $latitude, float $longitude): float
    {
        $latRad = deg2rad($latitude);
        $lngRad = deg2rad($longitude);
        $kaabaLatRad = deg2rad(self::KAABA_LAT);
        $kaabaLngRad = deg2rad(self::KAABA_LNG);

        $deltaLng = $kaabaLngRad - $lngRad;

        $y = sin($deltaLng);
        $x = cos($latRad) * tan($kaabaLatRad) - sin($latRad) * cos($deltaLng);

        $qiblaRad = atan2($y, $x);
        $qiblaDeg = fmod((rad2deg($qiblaRad) + 360), 360);

        return round($qiblaDeg, 1);
    }

    /**
     * Dapatkan arah mata angin dalam bahasa Indonesia (e.g. Barat Laut, dsb).
     */
    public function getCompassBearingLabel(float $degrees): string
    {
        $degrees = fmod(($degrees + 360), 360);
        $directions = [
            'Utara', 'Utara Timur Laut', 'Timur Laut', 'Timur-Timur Laut',
            'Timur', 'Timur Tenggara', 'Tenggara', 'Selatan Tenggara',
            'Selatan', 'Selatan Barat Daya', 'Barat Daya', 'Barat-Barat Daya',
            'Barat', 'Barat Laut', 'Barat-Barat Laut', 'Utara Barat Laut',
        ];
        $index = (int) round($degrees / 22.5) % 16;
        return $directions[$index] ?? 'Barat Laut';
    }

    /**
     * Perhitungan waktu salat menggunakan rumus astronomi hisab standar Kemenag RI / MABIMS:
     * - Subuh: sudut matahari -20°
     * - Ashar: bayangan objek = 1 + panjang bayangan tengah hari (Syafi'i)
     * - Maghrib: matahari terbenam (-0.833° refraksi dan radius)
     * - Isya: sudut matahari -18°
     * Ditambah ikhtiyath (pengaman) 2 menit sesuai standar Kemenag.
     */
    public function calculatePrayerTimes(float $latitude, float $longitude, float $timezoneOffset = 7.0, ?\DateTimeInterface $date = null): array
    {
        $date = $date ? clone $date : new \DateTime('now', new \DateTimeZone('UTC'));
        
        // Julian Day
        $year = (int)$date->format('Y');
        $month = (int)$date->format('m');
        $day = (int)$date->format('d');

        if ($month <= 2) {
            $year -= 1;
            $month += 12;
        }

        $a = floor($year / 100);
        $b = 2 - $a + floor($a / 4);
        $jd = floor(365.25 * ($year + 4716)) + floor(30.6001 * ($month + 1)) + $day + $b - 1524.5;

        // D: Hari sejak Julian epoch 2000
        $d = $jd - 2451545.0;

        // Posisi matahari
        $g = fmod(357.529 + 0.98560028 * $d, 360);
        $q = fmod(280.459 + 0.98564736 * $d, 360);
        $l = fmod($q + 1.915 * sin(deg2rad($g)) + 0.020 * sin(deg2rad(2 * $g)), 360);

        // Kemiringan sumbu bumi (obliquity)
        $e = 23.439 - 0.00000036 * $d;

        // Deklinasi matahari (delta) & Right Ascension (ra)
        $sinDelta = sin(deg2rad($e)) * sin(deg2rad($l));
        $delta = asin($sinDelta); // dalam radian

        $ra = rad2deg(atan2(cos(deg2rad($e)) * sin(deg2rad($l)), cos(deg2rad($l)))) / 15;
        if ($ra < 0) {
            $ra += 24;
        }

        // Equation of Time (jam desimal)
        $eqt = ($q / 15) - $ra;
        if ($eqt > 12) $eqt -= 24;
        if ($eqt < -12) $eqt += 24;

        // Transit matahari (Dzuhur)
        $transit = 12 + $timezoneOffset - ($longitude / 15) - $eqt;

        $latRad = deg2rad($latitude);

        // Helper sudut waktu (Hour Angle)
        $hourAngle = function ($altitudeDeg) use ($latRad, $delta) {
            $altRad = deg2rad($altitudeDeg);
            $cosH = (sin($altRad) - sin($latRad) * sin($delta)) / (cos($latRad) * cos($delta));
            if ($cosH > 1 || $cosH < -1) {
                return null;
            }
            return rad2deg(acos($cosH)) / 15;
        };

        // 1. Subuh (-20 derajat sudut matahari Kemenag)
        $subuhH = $hourAngle(-20);
        $subuh = $subuhH !== null ? $transit - $subuhH : $transit - 1.5;

        // 2. Terbit / Sunrise (-0.833 derajat)
        $sunriseH = $hourAngle(-0.833);
        $sunrise = $sunriseH !== null ? $transit - $sunriseH : $transit - 1.0;

        // 3. Dzuhur
        $dzuhur = $transit;

        // 4. Ashar (Syafi'i: t = tan(abs(lat - delta) + 1))
        $deltaDeg = rad2deg($delta);
        $asharAlt = rad2deg(atan(1 / (1 + tan(deg2rad(abs($latitude - $deltaDeg))))));
        $asharH = $hourAngle($asharAlt);
        $ashar = $asharH !== null ? $transit + $asharH : $transit + 3.0;

        // 5. Maghrib (-0.833 derajat matahari tenggelam)
        $maghribH = $hourAngle(-0.833);
        $maghrib = $maghribH !== null ? $transit + $maghribH : $transit + 6.0;

        // 6. Isya (-18 derajat sudut malam Kemenag)
        $isyaH = $hourAngle(-18);
        $isya = $isyaH !== null ? $transit + $isyaH : $transit + 7.2;

        // Format desimal jam ke H:i (dengan penambahan ikhtiyath 2 menit untuk kehati-hatian syariah)
        $formatTime = function ($decimalHour, $ikhtiyathMinutes = 2) {
            $decimalHour += ($ikhtiyathMinutes / 60);
            $hours = floor($decimalHour);
            $minutes = floor(($decimalHour - $hours) * 60);
            $hours = (int)fmod($hours + 24, 24);
            return sprintf('%02d:%02d', $hours, $minutes);
        };

        return [
            'fajr' => $formatTime($subuh, 2),
            'sunrise' => $formatTime($sunrise, 0),
            'dhuhr' => $formatTime($dzuhur, 2),
            'asr' => $formatTime($ashar, 2),
            'maghrib' => $formatTime($maghrib, 2),
            'isha' => $formatTime($isya, 2),
        ];
    }
}

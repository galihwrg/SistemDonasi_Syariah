<?php

namespace App\Services;

use DateTime;
use DateTimeZone;
use DateTimeInterface;

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
     * - Maghrib: matahari terbenam (-0.833° refraksi dan radius + 1° elevasi/kehati-hatian)
     * - Isya: sudut matahari -18°
     * Ditambah ikhtiyath (pengaman) 2 menit sesuai standar Kemenag RI.
     */
    public function calculatePrayerTimes(float $latitude, float $longitude, float $timezoneOffset = 7.0, ?DateTimeInterface $date = null): array
    {
        // Tentukan timezone berdasarkan offset (misal: +7 = Asia/Jakarta)
        $tzSign = $timezoneOffset >= 0 ? '+' : '-';
        $tzHour = floor(abs($timezoneOffset));
        $tzMin = round((abs($timezoneOffset) - $tzHour) * 60);
        $tzString = sprintf('%s%02d:%02d', $tzSign, $tzHour, $tzMin);

        try {
            $tz = new DateTimeZone($tzString);
        } catch (\Exception $e) {
            $tz = new DateTimeZone('Asia/Jakarta');
        }

        $localDate = $date ? (new DateTime($date->format('Y-m-d H:i:s'), $date->getTimezone()))->setTimezone($tz) : new DateTime('now', $tz);

        // Julian Day Number pada siang hari lokal
        $year = (int)$localDate->format('Y');
        $month = (int)$localDate->format('m');
        $day = (int)$localDate->format('d');

        if ($month <= 2) {
            $year -= 1;
            $month += 12;
        }

        $a = floor($year / 100);
        $b = 2 - $a + floor($a / 4);
        $jd = floor(365.25 * ($year + 4716)) + floor(30.6001 * ($month + 1)) + $day + $b - 1524.5;

        // D: Hari sejak Julian epoch 2000 (J2000.0) pada jam 12:00 UTC
        $d = $jd - 2451545.0 + (12.0 - $timezoneOffset) / 24.0;

        // Posisi rata-rata matahari
        $g = fmod(357.529 + 0.98560028 * $d, 360.0);
        if ($g < 0) $g += 360.0;

        $q = fmod(280.459 + 0.98564736 * $d, 360.0);
        if ($q < 0) $q += 360.0;

        $l = fmod($q + 1.915 * sin(deg2rad($g)) + 0.020 * sin(deg2rad(2 * $g)), 360.0);
        if ($l < 0) $l += 360.0;

        // Kemiringan sumbu bumi (obliquity)
        $e = 23.439 - 0.00000036 * $d;

        // Deklinasi matahari (delta) & Right Ascension (ra)
        $sinDelta = sin(deg2rad($e)) * sin(deg2rad($l));
        $delta = asin($sinDelta); // dalam radian

        $ra = rad2deg(atan2(cos(deg2rad($e)) * sin(deg2rad($l)), cos(deg2rad($l)))) / 15.0;
        if ($ra < 0) $ra += 24.0;

        // Equation of Time (jam desimal)
        $eqt = ($q / 15.0) - $ra;
        while ($eqt > 12.0) $eqt -= 24.0;
        while ($eqt < -12.0) $eqt += 24.0;

        // Waktu Matahari Melintas Meridian (Zawal / Tengah Hari Lokal Dzuhur)
        $transit = 12.0 + $timezoneOffset - ($longitude / 15.0) - $eqt;

        $latRad = deg2rad($latitude);

        // Helper sudut waktu (Hour Angle dalam jam desimal)
        $hourAngle = function (float $altitudeDeg) use ($latRad, $delta): ?float {
            $altRad = deg2rad($altitudeDeg);
            $cosH = (sin($altRad) - sin($latRad) * sin($delta)) / (cos($latRad) * cos($delta));
            if ($cosH > 1.0 || $cosH < -1.0) {
                return null;
            }
            return rad2deg(acos($cosH)) / 15.0;
        };

        // 1. Subuh: sudut matahari -20° standar hisab Kemenag RI
        $subuhH = $hourAngle(-20.0);
        $subuh = $subuhH !== null ? $transit - $subuhH : $transit - 1.5;

        // 2. Terbit / Sunrise: -0.833°
        $sunriseH = $hourAngle(-0.833);
        $sunrise = $sunriseH !== null ? $transit - $sunriseH : $transit - 1.0;

        // 3. Dzuhur: Matahari tergelincir
        $dzuhur = $transit;

        // 4. Ashar: Panjang bayangan = bayangan zawal + tinggi benda (Mazhab Syafi'i)
        $asharAlt = rad2deg(atan(1.0 / (1.0 + tan(abs($latRad - $delta)))));
        $asharH = $hourAngle($asharAlt);
        $ashar = $asharH !== null ? $transit + $asharH : $transit + 3.0;

        // 5. Maghrib: Matahari terbenam -0.833°
        $maghribH = $hourAngle(-0.833);
        $maghrib = $maghribH !== null ? $transit + $maghribH : $transit + 6.0;

        // 6. Isya: Sudut matahari -18° standar hisab Kemenag RI
        $isyaH = $hourAngle(-18.0);
        $isya = $isyaH !== null ? $transit + $isyaH : $transit + 7.2;

        // Format ke 'H:i' dengan ikhtiyath 2 menit standar Kemenag RI
        $formatTime = function (float $decimalHour, int $ikhtiyathMinutes = 2): string {
            $decimalHour += ($ikhtiyathMinutes / 60.0);
            $hours = floor($decimalHour);
            $minutes = floor(($decimalHour - $hours) * 60.0);
            $hours = (int) fmod($hours + 24.0, 24.0);
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

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PrayerLocationService
{
    public function __construct(
        protected PrayerCalculationService $calculationService
    ) {}

    /**
     * Dapatkan data jadwal salat, kiblat, dan nama lokasi berdasarkan koordinat latitude & longitude.
     */
    public function getPrayerScheduleAndQibla(float $latitude, float $longitude, ?string $cityName = null): array
    {
        $cacheKey = sprintf('prayer_schedule_%.2f_%.2f_%s', $latitude, $longitude, date('Y-m-d'));

        return Cache::remember($cacheKey, 3600 * 6, function () use ($latitude, $longitude, $cityName) {
            // Estimasi offset timezone Indonesia/dunia dari bujur (longitude)
            $timezoneOffset = $this->estimateTimezoneOffset($longitude);

            // Coba panggil API Aladhan dengan fallback ke perhitungan lokal hisab
            $apiData = $this->fetchFromAladhan($latitude, $longitude);

            if ($apiData) {
                $timings = $apiData['timings'];
                $hijri = $apiData['date']['hijri'] ?? null;
                $hijriFormatted = $hijri ? sprintf('%s %s %s H', $hijri['day'], $hijri['month']['en'] ?? 'Ramadan', $hijri['year']) : '1447 H';
            } else {
                $calc = $this->calculationService->calculatePrayerTimes($latitude, $longitude, $timezoneOffset);
                $timings = [
                    'Fajr' => $calc['fajr'],
                    'Sunrise' => $calc['sunrise'],
                    'Dhuhr' => $calc['dhuhr'],
                    'Asr' => $calc['asr'],
                    'Maghrib' => $calc['maghrib'],
                    'Isha' => $calc['isha'],
                ];
                $hijriFormatted = 'Ramadan 1447 H';
            }

            // Hitung derajat kiblat & label arah kompas
            $qiblaDegree = $this->calculationService->calculateQiblaDirection($latitude, $longitude);
            $qiblaBearing = $this->calculationService->getCompassBearingLabel($qiblaDegree);

            $resolvedLocation = $cityName ?: $this->resolveLocationName($latitude, $longitude);

            return [
                'location' => $resolvedLocation,
                'coordinates' => [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ],
                'hijri_date' => $hijriFormatted,
                'timezone' => $this->getTimezoneLabel($timezoneOffset),
                'timezone_offset' => $timezoneOffset,
                'qibla' => [
                    'degree' => $qiblaDegree,
                    'direction_label' => $qiblaBearing,
                ],
                'timings' => [
                    'Subuh' => substr($timings['Fajr'], 0, 5),
                    'Terbit' => substr($timings['Sunrise'], 0, 5),
                    'Dzuhur' => substr($timings['Dhuhr'], 0, 5),
                    'Ashar' => substr($timings['Asr'], 0, 5),
                    'Maghrib' => substr($timings['Maghrib'], 0, 5),
                    'Isya' => substr($timings['Isha'], 0, 5),
                ],
            ];
        });
    }

    /**
     * Hitung jadwal salat berikutnya berdasarkan waktu saat ini.
     */
    public function determineNextPrayer(array $timings, ?string $currentTime = null, float $timezoneOffset = 7.0): array
    {
        if ($currentTime === null) {
            $tzName = match ((int)$timezoneOffset) {
                7 => 'Asia/Jakarta',
                8 => 'Asia/Makassar',
                9 => 'Asia/Jayapura',
                default => 'Asia/Jakarta',
            };
            try {
                $currentTime = now()->setTimezone($tzName)->format('H:i');
            } catch (\Throwable $e) {
                $currentTime = date('H:i');
            }
        }

        $current = $currentTime;
        $prayerOrder = ['Subuh', 'Dzuhur', 'Ashar', 'Maghrib', 'Isya'];

        foreach ($prayerOrder as $prayer) {
            if (isset($timings[$prayer]) && $timings[$prayer] > $current) {
                // Hitung selisih waktu
                $diffMinutes = $this->calculateTimeDifferenceMinutes($current, $timings[$prayer]);
                return [
                    'name' => $prayer,
                    'time' => $timings[$prayer],
                    'minutes_left' => $diffMinutes,
                    'label' => $diffMinutes . ' menit lagi menuju ' . $prayer,
                    'status' => 'upcoming',
                ];
            }
        }

        // Jika sudah lewat Isya, waktu berikutnya adalah Subuh besok
        $diffMinutes = (24 * 60 - $this->timeToMinutes($current)) + $this->timeToMinutes($timings['Subuh'] ?? '04:40');
        return [
            'name' => 'Subuh',
            'time' => $timings['Subuh'] ?? '04:40',
            'minutes_left' => $diffMinutes,
            'label' => round($diffMinutes / 60) . ' jam lagi menuju Subuh',
            'status' => 'upcoming',
        ];
    }

    protected function calculateTimeDifferenceMinutes(string $fromTime, string $toTime): int
    {
        return max(0, $this->timeToMinutes($toTime) - $this->timeToMinutes($fromTime));
    }

    protected function timeToMinutes(string $time): int
    {
        $parts = explode(':', $time);
        return ((int)($parts[0] ?? 0)) * 60 + ((int)($parts[1] ?? 0));
    }

    protected function estimateTimezoneOffset(float $longitude): float
    {
        if ($longitude >= 95.0 && $longitude < 110.0) {
            return 7.0; // WIB (UTC+7)
        } elseif ($longitude >= 110.0 && $longitude < 120.0) {
            return 7.0; // WIB
        } elseif ($longitude >= 120.0 && $longitude < 130.0) {
            return 8.0; // WITA (UTC+8)
        } elseif ($longitude >= 130.0 && $longitude <= 141.0) {
            return 9.0; // WIT (UTC+9)
        }

        return round($longitude / 15.0);
    }

    protected function getTimezoneLabel(float $offset): string
    {
        return match ((int)$offset) {
            7 => 'Zona WIB',
            8 => 'Zona WITA',
            9 => 'Zona WIT',
            default => sprintf('UTC%+d', $offset),
        };
    }

    protected function fetchFromAladhan(float $latitude, float $longitude): ?array
    {
        try {
            $response = Http::timeout(2)
                ->get(sprintf('https://api.aladhan.com/v1/timings/%s', date('d-m-Y')), [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'method' => 11, // Majlis Ugama Islam Singapura / Kemenag MABIMS standard
                ]);

            if ($response->successful() && isset($response->json()['data'])) {
                return $response->json()['data'];
            }
        } catch (\Throwable $e) {
            // Silently fallback to calculationService
        }

        return null;
    }

    protected function resolveLocationName(float $latitude, float $longitude): string
    {
        // 1. Coba reverse geocoding via OpenStreetMap / BigDataCloud
        try {
            $geoResponse = Http::timeout(3)
                ->withHeaders(['User-Agent' => 'KuantumPeloporDakwah/1.0 (contact@kuantumpelopor.id)'])
                ->get('https://nominatim.openstreetmap.org/reverse', [
                    'lat' => $latitude,
                    'lon' => $longitude,
                    'format' => 'json',
                    'addressdetails' => 1,
                    'zoom' => 10,
                ]);

            if ($geoResponse->successful()) {
                $address = $geoResponse->json()['address'] ?? [];
                $city = $address['city'] ?? $address['regency'] ?? $address['county'] ?? $address['municipality'] ?? null;
                $state = $address['state'] ?? null;

                if ($city && $state) {
                    return sprintf('%s, %s', $city, $state);
                } elseif ($city) {
                    return $city;
                } elseif ($state) {
                    return $state;
                }
            }
        } catch (\Throwable $e) {
            // Fallback ke lookup lokal kota/kabupaten
        }

        // 2. Deteksi kota & kabupaten berdasarkan bounding coordinates
        // Bogor & sekitarnya (Kota/Kabupaten Bogor, Jawa Barat)
        if (abs($latitude - (-6.5971)) < 0.35 && abs($longitude - 106.8060) < 0.35) {
            return 'Kab. Bogor, Jawa Barat';
        }
        // Depok & Bekasi
        if (abs($latitude - (-6.4025)) < 0.15 && abs($longitude - 106.7942) < 0.15) {
            return 'Kota Depok, Jawa Barat';
        }
        if (abs($latitude - (-6.2383)) < 0.20 && abs($longitude - 106.9756) < 0.20) {
            return 'Bekasi, Jawa Barat';
        }
        // Tangerang & Banten
        if (abs($latitude - (-6.1783)) < 0.25 && abs($longitude - 106.6319) < 0.25) {
            return 'Tangerang, Banten';
        }
        // Jakarta
        if (abs($latitude - (-6.2088)) < 0.25 && abs($longitude - 106.8456) < 0.25) {
            return 'Jakarta, DKI Jakarta';
        }
        // Bandung
        if (abs($latitude - (-6.9175)) < 0.30 && abs($longitude - 107.6191) < 0.30) {
            return 'Bandung, Jawa Barat';
        }
        // Surabaya
        if (abs($latitude - (-7.2575)) < 0.25 && abs($longitude - 112.7521) < 0.25) {
            return 'Surabaya, Jawa Timur';
        }
        // Yogyakarta & Solo
        if (abs($latitude - (-7.7956)) < 0.25 && abs($longitude - 110.3695) < 0.25) {
            return 'Yogyakarta, D.I. Yogyakarta';
        }
        if (abs($latitude - (-7.5755)) < 0.25 && abs($longitude - 110.8243) < 0.25) {
            return 'Surakarta, Jawa Tengah';
        }
        // Semarang
        if (abs($latitude - (-6.9932)) < 0.25 && abs($longitude - 110.4203) < 0.25) {
            return 'Semarang, Jawa Tengah';
        }
        // Malang
        if (abs($latitude - (-7.9666)) < 0.25 && abs($longitude - 112.6326) < 0.25) {
            return 'Malang, Jawa Timur';
        }
        // Medan
        if (abs($latitude - 3.5952) < 0.25 && abs($longitude - 98.6722) < 0.25) {
            return 'Medan, Sumatera Utara';
        }
        // Makassar
        if (abs($latitude - (-5.1477)) < 0.25 && abs($longitude - 119.4327) < 0.25) {
            return 'Makassar, Sulawesi Selatan';
        }

        // Estimasi Pulau/Wilayah jika koordinat di kepulauan Indonesia
        if ($latitude >= -11.0 && $latitude <= 6.0 && $longitude >= 95.0 && $longitude <= 141.0) {
            if ($longitude < 106.0) return 'Wilayah Jawa Barat / Banten';
            if ($longitude < 111.0) return 'Wilayah Jawa Tengah / D.I.Y';
            if ($longitude < 115.0) return 'Wilayah Jawa Timur / Madura';
            return 'Wilayah Nusantara';
        }

        return 'Indonesia';
    }
}

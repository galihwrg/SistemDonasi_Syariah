<?php

namespace Tests\Feature;

use Tests\TestCase;

class PrayerTimeAndQiblaTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_prayer_times_page_can_be_rendered_with_calculated_data(): void
    {
        $response = $this->get(route('waktu-salat'));

        $response->assertStatus(200);
        $response->assertSee('Waktu Salat');
        $response->assertSee('Arah Kiblat');
        $response->assertSee('Menghadap');
        $response->assertSee('Subuh');
        $response->assertSee('Dzuhur');
        $response->assertSee('Ashar');
        $response->assertSee('Maghrib');
        $response->assertSee('Isya');
        $response->assertSee('Jadwal 5 Waktu Salat');
    }

    public function test_prayer_times_api_returns_json_schedule_for_custom_coordinates(): void
    {
        // Uji koordinat Kota Bandung (-6.9175, 107.6191)
        $response = $this->getJson(route('api.waktu-salat', [
            'lat' => -6.9175,
            'lng' => 107.6191,
            'city' => 'Bandung, Jawa Barat',
        ]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                'location',
                'coordinates' => ['latitude', 'longitude'],
                'hijri_date',
                'timezone',
                'timezone_offset',
                'qibla' => [
                    'degree',
                    'direction_label',
                ],
                'timings' => [
                    'Subuh',
                    'Terbit',
                    'Dzuhur',
                    'Ashar',
                    'Maghrib',
                    'Isya',
                ],
                'next_prayer' => [
                    'name',
                    'time',
                    'minutes_left',
                    'label',
                    'status',
                ],
            ],
        ]);

        $data = $response->json('data');
        $this->assertEquals('Bandung, Jawa Barat', $data['location']);
        $this->assertIsNumeric($data['qibla']['degree']);
        // Arah kiblat dari Jawa Barat berkisar ~295 derajat
        $this->assertGreaterThan(290, $data['qibla']['degree']);
        $this->assertLessThan(300, $data['qibla']['degree']);
    }

    public function test_prayer_times_api_validates_coordinate_inputs(): void
    {
        $response = $this->getJson(route('api.waktu-salat', [
            'lat' => 'invalid_lat',
            'lng' => 106.8456,
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['lat']);
    }
}

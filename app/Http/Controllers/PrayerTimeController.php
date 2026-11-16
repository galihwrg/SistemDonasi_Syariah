<?php

namespace App\Http\Controllers;

use App\Services\PrayerLocationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrayerTimeController extends Controller
{
    public function __construct(
        protected PrayerLocationService $prayerService
    ) {}

    /**
     * Tampilkan halaman jadwal waktu salat dan kompas arah kiblat.
     */
    public function index(Request $request): View
    {
        // Default koordinat Jakarta Pusat
        $latitude = (float) $request->query('lat', -6.2088);
        $longitude = (float) $request->query('lng', 106.8456);
        $city = $request->query('city');

        $prayerData = $this->prayerService->getPrayerScheduleAndQibla($latitude, $longitude, $city);
        $nextPrayer = $this->prayerService->determineNextPrayer($prayerData['timings']);

        return view('prayer-times.index', compact('prayerData', 'nextPrayer'));
    }

    /**
     * Endpoint API JSON untuk update real-time via navigator.geolocation client.
     */
    public function api(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'city' => 'nullable|string|max:100',
        ]);

        $latitude = (float) $validated['lat'];
        $longitude = (float) $validated['lng'];
        $city = $validated['city'] ?? null;

        $prayerData = $this->prayerService->getPrayerScheduleAndQibla($latitude, $longitude, $city);
        $nextPrayer = $this->prayerService->determineNextPrayer($prayerData['timings']);

        return response()->json([
            'status' => 'success',
            'data' => array_merge($prayerData, [
                'next_prayer' => $nextPrayer,
            ]),
        ]);
    }
}

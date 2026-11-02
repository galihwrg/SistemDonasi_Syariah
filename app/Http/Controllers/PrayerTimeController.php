<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PrayerTimeController extends Controller
{
    /**
     * Tampilkan halaman jadwal waktu salat dan kompas arah kiblat.
     */
    public function index(): View
    {
        return view('prayer-times.index');
    }
}

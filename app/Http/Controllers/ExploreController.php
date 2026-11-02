<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ExploreController extends Controller
{
    /**
     * Tampilkan halaman jelajah karya visual.
     */
    public function index(): View
    {
        return view('explore.index');
    }
}

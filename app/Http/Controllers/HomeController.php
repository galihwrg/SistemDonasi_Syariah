<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman beranda.
     */
    public function index(): View
    {
        return view('home');
    }
}

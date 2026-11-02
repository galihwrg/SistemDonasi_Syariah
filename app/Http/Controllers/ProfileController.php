<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil pengguna dan manajemen rekening.
     */
    public function index(): View
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }
}

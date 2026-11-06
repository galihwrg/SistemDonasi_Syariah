<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman beranda galeri visual islami.
     */
    public function index(): View
    {
        $categories = Category::all();

        $artworks = Artwork::approved()
            ->with(['user', 'category'])
            ->withSum(['donations as total_donations' => function ($query) {
                $query->where('payment_status', 'settlement');
            }], 'amount')
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('categories', 'artworks'));
    }
}

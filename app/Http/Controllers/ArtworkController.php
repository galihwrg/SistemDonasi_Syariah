<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class ArtworkController extends Controller
{
    /**
     * Tampilkan halaman form unggah karya visual baru.
     */
    public function create(): View
    {
        $categories = Category::all();

        return view('artworks.create', compact('categories'));
    }
}

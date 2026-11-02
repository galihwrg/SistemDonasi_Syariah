<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CollectionController extends Controller
{
    /**
     * Tampilkan halaman koleksi karya tersimpan.
     */
    public function index(): View
    {
        return view('collections.index');
    }
}

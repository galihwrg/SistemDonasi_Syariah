<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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

    /**
     * Tampilkan detail karya visual dakwah.
     */
    public function show(string $slug): View
    {
        $artwork = Artwork::with(['user', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Hitung akumulasi donasi terkumpul untuk karya ini
        $totalDonation = $artwork->donations()
            ->where('payment_status', 'settlement')
            ->sum('amount');

        return view('artworks.show', compact('artwork', 'totalDonation'));
    }

    /**
     * Unduh file foto asli 1-klik (bebas wakaf) dan catat jumlah unduhan.
     */
    public function download(string $slug)
    {
        $artwork = Artwork::where('slug', $slug)->firstOrFail();

        // Tingkatkan counter unduhan
        $artwork->increment('download_count');

        // Jika tersimpan di storage lokal publik
        if (Storage::disk('public')->exists($artwork->image_path)) {
            return Storage::disk('public')->download($artwork->image_path, $artwork->slug . '.jpg');
        }

        // Jika berupa URL eksternal (Unsplash/CDN), alihkan ke URL gambar
        if (filter_var($artwork->image_path, FILTER_VALIDATE_URL)) {
            return redirect()->away($artwork->image_path);
        }

        return redirect()->back()->with('error', 'Berkas gambar tidak ditemukan.');
    }
}

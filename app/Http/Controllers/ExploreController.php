<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExploreController extends Controller
{
    /**
     * Tampilkan halaman jelajah karya visual (Mobile & Desktop Responsif).
     */
    public function index(Request $request): View
    {
        $categories = Category::all();
        $selectedCategory = $request->query('kategori');
        $searchQuery = $request->query('q');
        $sortBy = $request->query('sort', 'terbaru'); // terbaru, terpopuler, donasi

        $query = Artwork::approved()
            ->with(['user', 'category'])
            ->withSum(['donations as total_donations' => function ($q) {
                $q->where('payment_status', 'settlement');
            }], 'amount')
            ->when($selectedCategory, function ($q, $cat) {
                $q->whereHas('category', function ($sub) use ($cat) {
                    $sub->where('slug', $cat);
                });
            })
            ->when($searchQuery, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%")
                        ->orWhere('narration', 'like', "%{$search}%")
                        ->orWhere('quran_reference', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%");
                        });
                });
            });

        // Pengurutan sesuai kriteria penerimaan Issue #8
        match ($sortBy) {
            'terpopuler' => $query->orderByDesc('download_count')->latest('id'),
            'donasi' => $query->orderByDesc('total_donations')->latest('id'),
            default => $query->latest('id'),
        };

        $artworks = $query->get();

        // Metrik statistik galeri untuk banner desktop
        $totalActiveArtworks = Artwork::approved()->count();
        $totalInfaqAmount = \App\Models\Donation::where('payment_status', 'settlement')->sum('amount');

        return view('explore.index', compact(
            'categories',
            'artworks',
            'selectedCategory',
            'searchQuery',
            'sortBy',
            'totalActiveArtworks',
            'totalInfaqAmount'
        ));
    }
}

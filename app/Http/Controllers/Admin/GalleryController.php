<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Category;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * Tampilkan galeri karya publik versi desktop admin (Stitch: kuantum_pelopor_indonesia_lihat_galeri_desktop).
     */
    public function index(Request $request): View
    {
        abort_unless($request->user() && $request->user()->isAdmin(), 403, 'Akses khusus administrator.');

        $selectedCategory = $request->query('kategori');
        $searchQuery = $request->query('q');
        $sortBy = $request->query('sort', 'terbaru');

        $categories = Category::all();

        // Metrik Ringkasan Banner
        $totalActiveArtworks = Artwork::where('status', 'approved')->count();
        $totalInfaqAmount = (int) Donation::where('payment_status', 'settlement')->sum('amount');

        $query = Artwork::with(['user', 'category'])
            ->where('status', 'approved');

        if ($selectedCategory) {
            $query->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory);
            });
        }

        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                    ->orWhere('description', 'like', "%{$searchQuery}%")
                    ->orWhereHas('user', function ($uq) use ($searchQuery) {
                        $uq->where('name', 'like', "%{$searchQuery}%");
                    });
            });
        }

        switch ($sortBy) {
            case 'terpopuler':
                $query->orderByDesc('download_count')->orderByDesc('id');
                break;
            case 'donasi':
                $query->withSum(['donations as verified_donations_sum' => function ($q) {
                    $q->where('payment_status', 'settlement');
                }], 'amount')
                ->orderByDesc('verified_donations_sum')
                ->orderByDesc('id');
                break;
            case 'terlama':
                $query->orderBy('id', 'asc');
                break;
            default:
                $query->latest('id');
                break;
        }

        $artworks = $query->paginate(12)->withQueryString();

        return view('admin.gallery.index', compact(
            'artworks',
            'categories',
            'selectedCategory',
            'searchQuery',
            'sortBy',
            'totalActiveArtworks',
            'totalInfaqAmount'
        ));
    }
}

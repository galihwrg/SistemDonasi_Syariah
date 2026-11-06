<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExploreController extends Controller
{
    /**
     * Tampilkan halaman jelajah karya visual.
     */
    public function index(Request $request): View
    {
        $categories = Category::all();
        $selectedCategory = $request->query('kategori');
        $searchQuery = $request->query('q');

        $artworks = Artwork::approved()
            ->with(['user', 'category'])
            ->withSum(['donations as total_donations' => function ($query) {
                $query->where('payment_status', 'settlement');
            }], 'amount')
            ->when($selectedCategory, function ($query, $cat) {
                $query->whereHas('category', function ($q) use ($cat) {
                    $q->where('slug', $cat);
                });
            })
            ->when($searchQuery, function ($query, $q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('narration', 'like', "%{$q}%")
                        ->orWhere('quran_reference', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->get();

        return view('explore.index', compact('categories', 'artworks', 'selectedCategory', 'searchQuery'));
    }
}

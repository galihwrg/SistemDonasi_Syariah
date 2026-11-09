<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\SavedCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollectionController extends Controller
{
    /**
     * Tampilkan halaman koleksi karya tersimpan milik pengguna yang sedang aktif.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $selectedCategorySlug = $request->query('kategori');

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        if (!$user) {
            return view('collections.index', [
                'savedArtworks' => collect(),
                'categories' => $categories,
                'selectedCategorySlug' => $selectedCategorySlug,
                'totalSaved' => 0,
            ]);
        }

        // Ambil query karya tersimpan pengguna
        $query = $user->savedArtworks()
            ->with(['user', 'category'])
            ->latest('saved_collections.created_at');

        $totalSaved = (clone $query)->count();

        if ($selectedCategorySlug) {
            $query->whereHas('category', function ($q) use ($selectedCategorySlug) {
                $q->where('slug', $selectedCategorySlug);
            });
        }

        $savedArtworks = $query->get();

        return view('collections.index', [
            'savedArtworks' => $savedArtworks,
            'categories' => $categories,
            'selectedCategorySlug' => $selectedCategorySlug,
            'totalSaved' => $totalSaved,
        ]);
    }

    /**
     * Toggle bookmark/koleksi karya tersimpan (AJAX/Fetch JSON).
     */
    public function toggle(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan masuk terlebih dahulu untuk menyimpan ke koleksi.',
                'redirect' => route('login'),
            ], 401);
        }

        $validated = $request->validate([
            'artwork_id' => ['required', 'exists:artworks,id'],
        ]);

        $artwork = Artwork::findOrFail($validated['artwork_id']);

        $existing = SavedCollection::where('user_id', $user->id)
            ->where('artwork_id', $artwork->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $saved = false;
            $message = 'Karya berhasil dihapus dari koleksi Anda.';
        } else {
            SavedCollection::create([
                'user_id' => $user->id,
                'artwork_id' => $artwork->id,
            ]);
            $saved = true;
            $message = 'Alhamdulillah, karya berhasil disimpan ke Koleksi Saya.';
        }

        $totalSaved = $user->savedCollections()->count();

        return response()->json([
            'success' => true,
            'saved' => $saved,
            'total_saved' => $totalSaved,
            'message' => $message,
            'artwork_id' => $artwork->id,
        ]);
    }
}

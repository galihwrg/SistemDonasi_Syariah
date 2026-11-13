<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CurationController extends Controller
{
    /**
     * Tampilkan antrean kurasi foto karya umat.
     */
    public function index(Request $request): View
    {
        abort_unless($request->user() && $request->user()->isAdmin(), 403, 'Akses khusus administrator.');
        $statusFilter = $request->query('status', 'all'); // all, pending, approved, rejected
        $categoryFilter = $request->query('kategori');
        $searchQuery = $request->query('q');

        $categories = Category::all();

        // Hitung metrik ringkasan
        $metrics = [
            'total' => Artwork::count(),
            'pending' => Artwork::where('status', 'pending')->count(),
            'approved' => Artwork::where('status', 'approved')->count(),
            'rejected' => Artwork::where('status', 'rejected')->count(),
        ];

        $query = Artwork::with(['user', 'category'])
            ->latest('id');

        if ($statusFilter !== 'all' && in_array($statusFilter, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $statusFilter);
        }

        if ($categoryFilter) {
            $query->whereHas('category', function ($q) use ($categoryFilter) {
                $q->where('slug', $categoryFilter);
            });
        }

        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                    ->orWhere('narration', 'like', "%{$searchQuery}%")
                    ->orWhereHas('user', function ($sub) use ($searchQuery) {
                        $sub->where('name', 'like', "%{$searchQuery}%");
                    });
            });
        }

        $artworks = $query->paginate(10)->withQueryString();

        return view('admin.curation.index', compact('artworks', 'categories', 'metrics', 'statusFilter', 'categoryFilter', 'searchQuery'));
    }

    /**
     * Setujui foto karya untuk tayang di galeri publik.
     */
    public function approve(Request $request, Artwork $artwork): RedirectResponse|JsonResponse
    {
        abort_unless($request->user() && $request->user()->isAdmin(), 403, 'Akses khusus administrator.');

        $artwork->update([
            'status' => 'approved',
            'rejection_reason' => null,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Karya '{$artwork->title}' berhasil disetujui dan kini tayang di galeri publik.",
            ]);
        }

        return redirect()->back()->with('success', "Alhamdulillah! Karya '{$artwork->title}' berhasil disetujui dan kini tayang di galeri publik.");
    }

    /**
     * Tolak foto karya dengan alasan syariah/etika/kualitas.
     */
    public function reject(Request $request, Artwork $artwork): RedirectResponse|JsonResponse
    {
        abort_unless($request->user() && $request->user()->isAdmin(), 403, 'Akses khusus administrator.');

        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ], [
            'rejection_reason.required' => 'Mohon sertakan alasan penolakan karya.',
            'rejection_reason.max' => 'Alasan penolakan maksimal 500 karakter.',
        ]);

        $artwork->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Karya '{$artwork->title}' telah ditolak dengan catatan alasan.",
            ]);
        }

        return redirect()->back()->with('success', "Karya '{$artwork->title}' telah ditolak.");
    }
}

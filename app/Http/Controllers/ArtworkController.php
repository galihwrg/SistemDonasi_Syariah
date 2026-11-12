<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
     * Simpan unggahan karya visual dakwah baru dari kontributor.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:10240'], // Maksimal 10MB
            'narration' => ['nullable', 'string', 'max:1500'],
            'quran_reference' => ['nullable', 'string', 'max:255'],
            'quran_arabic' => ['nullable', 'string'],
            'quran_translation' => ['nullable', 'string'],
        ], [
            'title.required' => 'Judul karya wajib diisi.',
            'category_id.required' => 'Kategori karya wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'image.required' => 'Foto karya dakwah wajib diunggah.',
            'image.image' => 'Berkas yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, PNG, atau WEBP.',
            'image.max' => 'Ukuran gambar maksimal 10MB.',
        ]);

        $file = $request->file('image');
        $dimensions = null;

        // Ambil resolusi gambar asli jika memungkinkan
        if ($file && $file->isValid()) {
            $imageInfo = @getimagesize($file->getPathname());
            if ($imageInfo) {
                $dimensions = "{$imageInfo[0]} x {$imageInfo[1]} px";
            }
        }

        // Generate slug unik
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Artwork::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        // Simpan file ke disk 'public' di direktori 'artworks'
        $path = $file->store('artworks', 'public');

        $artwork = Artwork::create([
            'user_id' => $request->user()->id,
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'narration' => $validated['narration'] ?? null,
            'quran_reference' => $validated['quran_reference'] ?? null,
            'quran_arabic' => $validated['quran_arabic'] ?? null,
            'quran_translation' => $validated['quran_translation'] ?? null,
            'image_path' => $path,
            'dimensions' => $dimensions ?? '3840 x 2160 px',
            'status' => 'pending', // Menunggu kurasi admin
            'download_count' => 0,
        ]);

        return redirect()->route('artworks.my')->with('success', 'Alhamdulillah! Karya Anda berhasil diunggah dan sedang dalam antrean kurasi admin.');
    }

    /**
     * Tampilkan halaman kelola "Postingan Saya" milik kontributor aktif.
     */
    public function myArtworks(Request $request): View
    {
        $user = $request->user();

        // Ambil seluruh karya kontributor beserta total donasi terkumpul
        $artworks = Artwork::where('user_id', $user->id)
            ->with(['category'])
            ->withSum(['donations as total_donations' => function ($query) {
                $query->where('payment_status', 'settlement');
            }], 'amount')
            ->latest('id')
            ->get();

        // Metrik statistik kontributor
        $totalUploaded = $artworks->count();
        $totalApproved = $artworks->where('status', 'approved')->count();
        $totalPending = $artworks->where('status', 'pending')->count();
        $totalRejected = $artworks->where('status', 'rejected')->count();
        $totalDownloads = $artworks->sum('download_count');
        $totalSaldoInfaq = $artworks->sum(fn ($art) => $art->total_donations ?? 0);

        return view('artworks.my', compact(
            'user',
            'artworks',
            'totalUploaded',
            'totalApproved',
            'totalPending',
            'totalRejected',
            'totalDownloads',
            'totalSaldoInfaq'
        ));
    }

    /**
     * Hapus postingan karya milik kontributor.
     */
    public function destroy(Request $request, Artwork $artwork): RedirectResponse
    {
        // Pastikan hanya pemilik karya atau admin yang dapat menghapus
        if ($artwork->user_id !== $request->user()->id && !$request->user()->isAdmin()) {
            abort(403, 'Anda tidak berhak menghapus karya ini.');
        }

        // Hapus file dari storage jika ada
        if ($artwork->image_path && Storage::disk('public')->exists($artwork->image_path)) {
            Storage::disk('public')->delete($artwork->image_path);
        }

        $artwork->delete();

        return redirect()->back()->with('success', 'Karya berhasil dihapus.');
    }

    /**
     * Tampilkan detail karya visual dakwah.
     */
    public function show(string $slug): View
    {
        $artwork = Artwork::with(['user', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Jika karya belum approved, hanya pemilik atau admin yang boleh melihat
        if ($artwork->status !== 'approved') {
            if (!auth()->check() || (auth()->id() !== $artwork->user_id && !auth()->user()->isAdmin())) {
                abort(404);
            }
        }

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

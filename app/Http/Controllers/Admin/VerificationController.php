<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContributorVerification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerificationController extends Controller
{
    /**
     * Tampilkan antrean konfirmasi verifikasi dokumen akun kontributor.
     */
    public function index(Request $request): View
    {
        abort_unless($request->user() && $request->user()->isAdmin(), 403, 'Akses khusus administrator.');

        $statusFilter = $request->query('status', 'all'); // all, pending, approved, rejected, mahasiswa, umum
        $typeFilter = $request->query('type'); // mahasiswa, umum
        $searchQuery = $request->query('q');

        // Hitung metrik ringkasan
        $metrics = [
            'total' => ContributorVerification::count(),
            'pending' => ContributorVerification::where('status', 'pending')->count(),
            'approved' => ContributorVerification::where('status', 'approved')->count(),
            'rejected' => ContributorVerification::where('status', 'rejected')->count(),
            'mahasiswa' => ContributorVerification::where('id_type', 'ktm')->count(),
            'umum' => ContributorVerification::where('id_type', 'ktp')->count(),
        ];

        $query = ContributorVerification::with(['user'])
            ->latest('id');

        // Filter tab status
        if ($statusFilter === 'pending') {
            $query->where('status', 'pending');
        } elseif ($statusFilter === 'approved') {
            $query->where('status', 'approved');
        } elseif ($statusFilter === 'rejected') {
            $query->where('status', 'rejected');
        } elseif ($statusFilter === 'mahasiswa') {
            $query->where('id_type', 'ktm');
        } elseif ($statusFilter === 'umum') {
            $query->where('id_type', 'ktp');
        }

        // Filter dropdown type
        if ($typeFilter && in_array($typeFilter, ['mahasiswa', 'umum'])) {
            $expectedType = ($typeFilter === 'mahasiswa') ? 'ktm' : 'ktp';
            $query->where('id_type', $expectedType);
        }

        // Pencarian nama, email, kampus, nomor identitas
        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('id_number', 'like', "%{$searchQuery}%")
                    ->orWhere('campus_name', 'like', "%{$searchQuery}%")
                    ->orWhereHas('user', function ($sub) use ($searchQuery) {
                        $sub->where('name', 'like', "%{$searchQuery}%")
                            ->orWhere('email', 'like', "%{$searchQuery}%");
                    });
            });
        }

        $verifications = $query->paginate(10)->withQueryString();

        return view('admin.verification.index', compact(
            'verifications',
            'metrics',
            'statusFilter',
            'typeFilter',
            'searchQuery'
        ));
    }

    /**
     * Setujui verifikasi dokumen dan aktifkan akun kontributor.
     */
    public function approve(Request $request, ContributorVerification $verification): RedirectResponse|JsonResponse
    {
        abort_unless($request->user() && $request->user()->isAdmin(), 403, 'Akses khusus administrator.');

        $notes = $request->input('admin_notes');

        $verification->update([
            'status' => 'approved',
            'admin_notes' => $notes,
            'verified_at' => now(),
        ]);

        // Aktifkan status terverifikasi pada model User agar fitur rekening terbuka otomatis
        $user = $verification->user;
        if ($user) {
            $user->update([
                'is_verified' => true,
                'nim_nik' => $verification->id_number,
                'campus_name' => $verification->campus_name ?? $user->campus_name,
            ]);
        }

        $message = "Alhamdulillah! Akun '{$user->name}' berhasil diverifikasi dan fitur rekening penyaluran donasi kini aktif.";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Tolak pengajuan verifikasi dengan catatan perbaikan/revisi.
     */
    public function reject(Request $request, ContributorVerification $verification): RedirectResponse|JsonResponse
    {
        abort_unless($request->user() && $request->user()->isAdmin(), 403, 'Akses khusus administrator.');

        $validated = $request->validate([
            'admin_notes' => ['required', 'string', 'max:500'],
        ], [
            'admin_notes.required' => 'Mohon sertakan catatan alasan penolakan/revisi dokumen.',
            'admin_notes.max' => 'Catatan maksimal 500 karakter.',
        ]);

        $verification->update([
            'status' => 'rejected',
            'admin_notes' => $validated['admin_notes'],
            'verified_at' => now(),
        ]);

        // Nonaktifkan status terverifikasi jika sebelumnya pernah aktif
        $user = $verification->user;
        if ($user) {
            $user->update([
                'is_verified' => false,
            ]);
        }

        $message = "Pengajuan verifikasi '{$user->name}' telah ditolak dengan catatan evaluasi.";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}

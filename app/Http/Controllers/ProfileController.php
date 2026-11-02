<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\ContributorVerification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil pengguna dan manajemen rekening.
     */
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load(['primaryBankAccount', 'bankAccounts', 'latestVerification']);

        $primaryAccount = $user->primaryBankAccount;
        $latestVerification = $user->latestVerification;

        // Hitung total donasi terkumpul dari karya milik kontributor ini
        $totalDonation = DB::table('donations')
            ->join('artworks', 'donations.artwork_id', '=', 'artworks.id')
            ->where('artworks.user_id', $user->id)
            ->where('donations.payment_status', 'settlement')
            ->sum('donations.amount');

        return view('profile.index', compact('user', 'primaryAccount', 'latestVerification', 'totalDonation'));
    }

    /**
     * Ajukan verifikasi identitas (KTM / KTP).
     */
    public function submitVerification(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'id_type' => ['required', 'in:ktm,ktp'],
            'id_number' => ['required', 'string', 'max:50'],
            'campus_name' => ['nullable', 'string', 'max:255'],
            'document' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120'], // Max 5MB
        ], [
            'id_type.required' => 'Jenis identitas wajib dipilih.',
            'id_number.required' => 'Nomor identitas (NIM/NIK) wajib diisi.',
            'document.required' => 'Foto dokumen identitas wajib diunggah.',
            'document.image' => 'Dokumen harus berupa file gambar.',
            'document.mimes' => 'Format file harus JPG atau PNG.',
            'document.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        $path = $request->file('document')->store('verifications', 'public');

        ContributorVerification::create([
            'user_id' => $user->id,
            'id_type' => $validated['id_type'],
            'id_number' => $validated['id_number'],
            'campus_name' => $validated['campus_name'] ?? $user->campus_name,
            'document_path' => $path,
            'status' => 'pending',
        ]);

        // Simpan id_number / nim_nik ke user record
        $user->update([
            'nim_nik' => $validated['id_number'],
            'campus_name' => $validated['campus_name'] ?? $user->campus_name,
        ]);

        return redirect()->route('profile')->with('success', 'Pengajuan verifikasi berhasil dikirim. Tim KPi akan meninjau dokumen Anda.');
    }

    /**
     * Tambah atau ubah rekening bank penyaluran donasi.
     */
    public function storeBankAccount(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->is_verified) {
            return redirect()->route('profile')->with('error', 'Akun harus diverifikasi terlebih dahulu sebelum menambahkan rekening.');
        }

        $validated = $request->validate([
            'bank_name' => ['required', 'string', 'max:100'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_holder_name' => ['required', 'string', 'max:150'],
        ], [
            'bank_name.required' => 'Nama bank wajib diisi.',
            'account_number.required' => 'Nomor rekening wajib diisi.',
            'account_holder_name.required' => 'Nama pemilik rekening wajib diisi.',
        ]);

        // Jadikan rekening baru sebagai primary
        BankAccount::where('user_id', $user->id)->update(['is_primary' => false]);

        BankAccount::create([
            'user_id' => $user->id,
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'account_holder_name' => $validated['account_holder_name'],
            'is_primary' => true,
        ]);

        return redirect()->route('profile')->with('success', 'Rekening penyaluran donasi berhasil disimpan.');
    }
}

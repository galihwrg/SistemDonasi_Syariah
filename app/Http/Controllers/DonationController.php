<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Donation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    /**
     * Simpan transaksi infaq / donasi apresiasi karya dakwah.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'artwork_id' => ['required', 'exists:artworks,id'],
            'amount' => ['required', 'numeric', 'min:5000'],
            'donor_name' => ['nullable', 'string', 'max:100'],
            'donor_contact' => ['nullable', 'string', 'max:100'],
            'prayer_message' => ['nullable', 'string', 'max:500'],
            'payment_method' => ['required', 'in:qris,bsi_va,bank_transfer'],
        ], [
            'amount.required' => 'Nominal donasi wajib dipilih atau diisi.',
            'amount.min' => 'Nominal donasi minimal Rp 5.000.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'payment_method.in' => 'Metode pembayaran tidak valid.',
        ]);

        $orderId = 'INFAQ-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        $donation = Donation::create([
            'artwork_id' => $validated['artwork_id'],
            'donor_name' => $validated['donor_name'] ?: 'Hamba Allah',
            'donor_contact' => $validated['donor_contact'],
            'prayer_message' => $validated['prayer_message'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'midtrans_order_id' => $orderId,
            // midtrans_snap_token akan diisi di Sprint 4 via Midtrans SDK
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Niat infaq Anda telah tercatat dengan amanah.',
                'donation' => $donation,
            ]);
        }

        return redirect()->back()->with('success', 'Alhamdulillah, data infaq Anda telah tercatat.');
    }
}

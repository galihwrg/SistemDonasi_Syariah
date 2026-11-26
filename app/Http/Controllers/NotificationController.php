<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Tandai sebuah notifikasi telah dibaca.
     */
    public function markAsRead(Request $request, string $id): RedirectResponse|JsonResponse
    {
        $notification = $request->user()->notifications()->where('id', $id)->firstOrFail();
        $notification->markAsRead();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi telah ditandai dibaca.',
            ]);
        }

        $targetUrl = $notification->data['action_url'] ?? route('profile');
        return redirect()->to($targetUrl);
    }

    /**
     * Tandai semua notifikasi pengguna telah dibaca.
     */
    public function markAllAsRead(Request $request): RedirectResponse|JsonResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Semua notifikasi telah ditandai dibaca.',
            ]);
        }

        return redirect()->back()->with('success', 'Semua notifikasi telah dibaca.');
    }
}


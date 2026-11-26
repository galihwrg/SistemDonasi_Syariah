<?php

namespace App\Notifications;

use App\Models\ContributorVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VerificationStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ContributorVerification $verification,
        public string $status, // 'approved' atau 'rejected'
        public ?string $notes = null
    ) {}

    /**
     * Menggunakan channel database untuk in-app notification.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Data notifikasi yang disimpan di tabel notifications.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $isApproved = $this->status === 'approved';
        $docLabel = strtoupper($this->verification->id_type);

        return [
            'type' => 'verification_status',
            'verification_id' => $this->verification->id,
            'status' => $this->status,
            'title' => $isApproved
                ? "Verifikasi {$docLabel} Disetujui"
                : "Verifikasi {$docLabel} Ditolak",
            'message' => $isApproved
                ? "Alhamdulillah! Dokumen {$docLabel} Anda telah dikonfirmasi dan disetujui oleh admin. Fitur rekening donasi dakwah kini aktif."
                : "Pengajuan verifikasi dokumen {$docLabel} Anda belum disetujui. Catatan: " . ($this->notes ?: 'Silakan periksa kembali foto dokumen Anda.'),
            'admin_notes' => $this->notes,
            'action_url' => route('profile'),
            'icon' => $isApproved ? 'verified' : 'cancel',
            'icon_color' => $isApproved ? '#0F382C' : '#BA1A1A',
        ];
    }
}


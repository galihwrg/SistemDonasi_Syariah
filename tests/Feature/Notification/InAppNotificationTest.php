<?php

namespace Tests\Feature\Notification;

use App\Models\ContributorVerification;
use App\Models\User;
use App\Notifications\VerificationStatusNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InAppNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_notification_in_header_and_read_it(): void
    {
        $user = User::factory()->create();
        $verification = ContributorVerification::create([
            'user_id' => $user->id,
            'id_type' => 'ktm',
            'id_number' => '065121001',
            'document_path' => 'verifications/test.jpg',
            'status' => 'approved',
        ]);

        $user->notify(new VerificationStatusNotification($verification, 'approved', 'Selamat dokumen sah'));

        $this->assertEquals(1, $user->unreadNotifications()->count());

        $notif = $user->unreadNotifications()->first();

        // Tes tandai notifikasi telah dibaca
        $response = $this->actingAs($user)->patch(route('notifications.read', $notif->id));
        $response->assertRedirect(route('profile'));

        $this->assertEquals(0, $user->fresh()->unreadNotifications()->count());
    }

    public function test_user_can_mark_all_notifications_as_read(): void
    {
        $user = User::factory()->create();
        $verification = ContributorVerification::create([
            'user_id' => $user->id,
            'id_type' => 'ktp',
            'id_number' => '3201010101010001',
            'document_path' => 'verifications/test.jpg',
            'status' => 'rejected',
            'admin_notes' => 'KTP buram',
        ]);

        $user->notify(new VerificationStatusNotification($verification, 'rejected', 'KTP buram'));

        $response = $this->actingAs($user)->post(route('notifications.read-all'));
        $response->assertRedirect();
        $this->assertEquals(0, $user->fresh()->unreadNotifications()->count());
    }
}

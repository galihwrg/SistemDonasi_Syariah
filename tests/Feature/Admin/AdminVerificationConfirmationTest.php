<?php

namespace Tests\Feature\Admin;

use App\Models\ContributorVerification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminVerificationConfirmationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_guest_cannot_access_verification_index_and_is_redirected(): void
    {
        $response = $this->get(route('admin.verification.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_cannot_access_verification_index_and_receives_403(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get(route('admin.verification.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_access_verification_index_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'name' => 'Admin Pelopor']);
        $student = User::factory()->create([
            'name' => 'Fajar Shadiq Pratama',
            'user_type' => 'mahasiswa',
            'campus_name' => 'Universitas Gadjah Mada',
        ]);

        ContributorVerification::create([
            'user_id' => $student->id,
            'id_type' => 'ktm',
            'id_number' => '21/478912/TK/52100',
            'campus_name' => 'Universitas Gadjah Mada',
            'document_path' => 'verifications/ktm.jpg',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.verification.index'));

        $response->assertStatus(200);
        $response->assertSee('Konfirmasi Akun');
        $response->assertSee('Menunggu Verifikasi');
        $response->assertSee('Terverifikasi / Aktif');
        $response->assertSee('Revisi Dokumen');
        $response->assertSee('Fajar Shadiq Pratama');
        $response->assertSee('Universitas Gadjah Mada');
        $response->assertSee('21/478912/TK/52100');
        $response->assertSee('Tinjau Berkas &amp; Detail', false);
    }

    public function test_admin_can_approve_contributor_verification_and_activates_user_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create([
            'name' => 'Aisyah Nurul',
            'is_verified' => false,
        ]);

        $verification = ContributorVerification::create([
            'user_id' => $user->id,
            'id_type' => 'ktp',
            'id_number' => '3201234567890001',
            'document_path' => 'verifications/ktp.jpg',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.verification.approve', $verification->id), [
            'admin_notes' => 'Dokumen sah dan terverifikasi.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $verification->refresh();
        $this->assertEquals('approved', $verification->status);
        $this->assertNotNull($verification->verified_at);

        // Pastikan status user menjadi terverifikasi
        $user->refresh();
        $this->assertTrue($user->is_verified);
        $this->assertEquals('3201234567890001', $user->nim_nik);
    }

    public function test_admin_can_reject_contributor_verification_with_notes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create([
            'name' => 'Rian Mahasiswa',
            'is_verified' => false,
        ]);

        $verification = ContributorVerification::create([
            'user_id' => $user->id,
            'id_type' => 'ktm',
            'id_number' => '22105030045',
            'campus_name' => 'UIN Sunan Kalijaga',
            'document_path' => 'verifications/ktm_blur.jpg',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.verification.reject', $verification->id), [
            'admin_notes' => 'Foto KTM terlalu buram sehingga nomor identitas tidak dapat terbaca dengan jelas.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $verification->refresh();
        $this->assertEquals('rejected', $verification->status);
        $this->assertEquals('Foto KTM terlalu buram sehingga nomor identitas tidak dapat terbaca dengan jelas.', $verification->admin_notes);

        $user->refresh();
        $this->assertFalse($user->is_verified);
    }

    public function test_rejection_fails_if_admin_notes_are_missing(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $verification = ContributorVerification::create([
            'user_id' => $user->id,
            'id_type' => 'ktp',
            'id_number' => '3201234567890002',
            'document_path' => 'verifications/ktp.jpg',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.verification.reject', $verification->id), [
            'admin_notes' => '',
        ]);

        $response->assertSessionHasErrors(['admin_notes']);
        $verification->refresh();
        $this->assertEquals('pending', $verification->status);
    }

    public function test_verification_queue_can_be_filtered_by_status_and_type(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $u1 = User::factory()->create(['name' => 'Santri 1']);
        $u2 = User::factory()->create(['name' => 'Warga 2']);

        ContributorVerification::create([
            'user_id' => $u1->id,
            'id_type' => 'ktm',
            'id_number' => '11111',
            'document_path' => '1.jpg',
            'status' => 'pending',
        ]);

        ContributorVerification::create([
            'user_id' => $u2->id,
            'id_type' => 'ktp',
            'id_number' => '22222',
            'document_path' => '2.jpg',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.verification.index', ['status' => 'mahasiswa']));

        $response->assertStatus(200);
        $response->assertSee('Santri 1');
        $response->assertDontSee('Warga 2');
    }

    public function test_admin_can_delete_user_account_permanently(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user', 'name' => 'Akun Dihapus']);

        ContributorVerification::create([
            'user_id' => $user->id,
            'id_type' => 'ktm',
            'id_number' => '123456',
            'document_path' => 'verifications/test.jpg',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $user->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('contributor_verifications', ['user_id' => $user->id]);
    }

    public function test_admin_cannot_delete_own_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin->id));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_regular_user_cannot_delete_any_account(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $otherUser = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->delete(route('admin.users.destroy', $otherUser->id));

        $response->assertStatus(403);
        $this->assertDatabaseHas('users', ['id' => $otherUser->id]);
    }
}

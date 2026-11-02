<?php

namespace Tests\Feature\Profile;

use App\Models\BankAccount;
use App\Models\ContributorVerification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_tamu_tidak_bisa_mengakses_halaman_profil(): void
    {
        $response = $this->get(route('profile'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_belum_terverifikasi_melihat_form_verifikasi_dan_status_terkunci(): void
    {
        $user = User::factory()->create([
            'is_verified' => false,
            'user_type' => 'mahasiswa',
        ]);

        $response = $this->actingAs($user)->get(route('profile'));

        $response->assertStatus(200);
        $response->assertSee('Belum Verifikasi');
        $response->assertSee('Terkunci');
        $response->assertSee('Sentuh untuk Mengunggah KTM / KTP');
        $response->assertSee('Kirim Verifikasi');
    }

    public function test_user_dapat_mengirimkan_pengajuan_verifikasi(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'is_verified' => false,
            'user_type' => 'mahasiswa',
        ]);

        $file = UploadedFile::fake()->image('ktm.jpg', 600, 400);

        $response = $this->actingAs($user)->post(route('profile.verify'), [
            'id_type' => 'ktm',
            'id_number' => '065121001',
            'campus_name' => 'Universitas Pakuan',
            'document' => $file,
        ]);

        $response->assertRedirect(route('profile'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contributor_verifications', [
            'user_id' => $user->id,
            'id_type' => 'ktm',
            'id_number' => '065121001',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'nim_nik' => '065121001',
        ]);
    }

    public function test_user_terverifikasi_melihat_rekening_aktif_dan_dapat_menambah_rekening(): void
    {
        $user = User::factory()->create([
            'name' => 'Galih Wiragama',
            'is_verified' => true,
            'user_type' => 'mahasiswa',
        ]);

        $bankAccount = BankAccount::create([
            'user_id' => $user->id,
            'bank_name' => 'Bank Syariah Indonesia (BSI)',
            'account_number' => '7123-4567-8901',
            'account_holder_name' => 'Galih Wiragama',
            'is_primary' => true,
        ]);

        $response = $this->actingAs($user)->get(route('profile'));

        $response->assertStatus(200);
        $response->assertSee('Terverifikasi');
        $response->assertSee('Rekening Penyaluran Aktif');
        $response->assertSee('7123-4567-8901');
        $response->assertSee('Salin');
        $response->assertSee('Total Donasi Terkumpul');
    }

    public function test_user_terverifikasi_dapat_menyimpan_rekening_bank_baru(): void
    {
        $user = User::factory()->create([
            'is_verified' => true,
        ]);

        $response = $this->actingAs($user)->post(route('profile.bank.store'), [
            'bank_name' => 'Bank Syariah Indonesia (BSI)',
            'account_number' => '9988776655',
            'account_holder_name' => 'Fulan bin Fulan',
        ]);

        $response->assertRedirect(route('profile'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('bank_accounts', [
            'user_id' => $user->id,
            'account_number' => '9988776655',
            'is_primary' => true,
        ]);
    }

    public function test_user_belum_verifikasi_tidak_bisa_menyimpan_rekening(): void
    {
        $user = User::factory()->create([
            'is_verified' => false,
        ]);

        $response = $this->actingAs($user)->post(route('profile.bank.store'), [
            'bank_name' => 'Bank Syariah Indonesia (BSI)',
            'account_number' => '9988776655',
            'account_holder_name' => 'Fulan bin Fulan',
        ]);

        $response->assertRedirect(route('profile'));
        $response->assertSessionHas('error');

        $this->assertDatabaseMissing('bank_accounts', [
            'account_number' => '9988776655',
        ]);
    }
}

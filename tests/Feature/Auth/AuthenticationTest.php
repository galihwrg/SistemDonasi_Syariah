<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    /*
    |--------------------------------------------------------------------------
    | Halaman Login
    |--------------------------------------------------------------------------
    */

    public function test_halaman_login_dapat_diakses(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('Masuk Akun');
        $response->assertSee('Umum');
        $response->assertSee('Mahasiswa / Akademisi');
    }

    public function test_pengguna_yang_sudah_login_diarahkan_dari_halaman_login(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('login'));

        $response->assertRedirect(route('home'));
    }

    /*
    |--------------------------------------------------------------------------
    | Login Umum
    |--------------------------------------------------------------------------
    */

    public function test_login_umum_berhasil_dengan_email(): void
    {
        $user = User::factory()->create([
            'email'     => 'budi@gmail.com',
            'password'  => bcrypt('password123'),
            'user_type' => 'umum',
        ]);

        $response = $this->post(route('login.store'), [
            'user_type'  => 'umum',
            'credential' => 'budi@gmail.com',
            'password'   => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_umum_gagal_dengan_password_salah(): void
    {
        User::factory()->create([
            'email'    => 'budi@gmail.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login.store'), [
            'user_type'  => 'umum',
            'credential' => 'budi@gmail.com',
            'password'   => 'salah_password',
        ]);

        $response->assertSessionHasErrors('credential');
        $this->assertGuest();
    }

    public function test_login_gagal_jika_credential_kosong(): void
    {
        $response = $this->post(route('login.store'), [
            'user_type'  => 'umum',
            'credential' => '',
            'password'   => '',
        ]);

        $response->assertSessionHasErrors(['credential', 'password']);
        $this->assertGuest();
    }

    /*
    |--------------------------------------------------------------------------
    | Login Mahasiswa
    |--------------------------------------------------------------------------
    */

    public function test_login_mahasiswa_berhasil_dengan_nim(): void
    {
        $user = User::factory()->create([
            'email'     => 'mahasiswa@unpak.ac.id',
            'nim_nik'   => '065121001',
            'password'  => bcrypt('password123'),
            'user_type' => 'mahasiswa',
        ]);

        $response = $this->post(route('login.store'), [
            'user_type'  => 'mahasiswa',
            'credential' => '065121001',
            'password'   => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_mahasiswa_berhasil_dengan_email(): void
    {
        $user = User::factory()->create([
            'email'     => 'mahasiswa@unpak.ac.id',
            'nim_nik'   => '065121001',
            'password'  => bcrypt('password123'),
            'user_type' => 'mahasiswa',
        ]);

        $response = $this->post(route('login.store'), [
            'user_type'  => 'mahasiswa',
            'credential' => 'mahasiswa@unpak.ac.id',
            'password'   => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function test_pengguna_dapat_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    /*
    |--------------------------------------------------------------------------
    | Halaman Register
    |--------------------------------------------------------------------------
    */

    public function test_halaman_register_dapat_diakses(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertSee('Buat Akun');
        $response->assertSee('Daftar Sekarang');
    }

    /*
    |--------------------------------------------------------------------------
    | Register Umum
    |--------------------------------------------------------------------------
    */

    public function test_register_umum_berhasil(): void
    {
        $response = $this->post(route('register.store'), [
            'user_type'             => 'umum',
            'name'                  => 'Budi Santoso',
            'email'                 => 'budi@gmail.com',
            'phone_number'          => '081234567890',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'agree_tos'             => '1',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email'     => 'budi@gmail.com',
            'user_type' => 'umum',
            'role'      => 'user',
        ]);
    }

    public function test_register_umum_gagal_jika_email_sudah_terdaftar(): void
    {
        User::factory()->create(['email' => 'budi@gmail.com']);

        $response = $this->post(route('register.store'), [
            'user_type'             => 'umum',
            'name'                  => 'Budi Lain',
            'email'                 => 'budi@gmail.com',
            'phone_number'          => '081234567890',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'agree_tos'             => '1',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_register_umum_gagal_jika_password_tidak_cocok(): void
    {
        $response = $this->post(route('register.store'), [
            'user_type'             => 'umum',
            'name'                  => 'Budi Santoso',
            'email'                 => 'budi@gmail.com',
            'phone_number'          => '081234567890',
            'password'              => 'password123',
            'password_confirmation' => 'berbeda456',
            'agree_tos'             => '1',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_register_umum_gagal_tanpa_persetujuan_tos(): void
    {
        $response = $this->post(route('register.store'), [
            'user_type'             => 'umum',
            'name'                  => 'Budi Santoso',
            'email'                 => 'budi@gmail.com',
            'phone_number'          => '081234567890',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('agree_tos');
        $this->assertGuest();
    }

    /*
    |--------------------------------------------------------------------------
    | Register Mahasiswa
    |--------------------------------------------------------------------------
    */

    public function test_register_mahasiswa_berhasil_dengan_data_kampus(): void
    {
        $response = $this->post(route('register.store'), [
            'user_type'             => 'mahasiswa',
            'name'                  => 'Galih Wiragama',
            'campus_name'           => 'Universitas Pakuan',
            'nim_nik'               => '065121001',
            'email'                 => 'galih@unpak.ac.id',
            'phone_number'          => '081234567890',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'agree_tos'             => '1',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email'       => 'galih@unpak.ac.id',
            'user_type'   => 'mahasiswa',
            'campus_name' => 'Universitas Pakuan',
            'nim_nik'     => '065121001',
        ]);
    }

    public function test_register_mahasiswa_gagal_tanpa_nama_kampus(): void
    {
        $response = $this->post(route('register.store'), [
            'user_type'             => 'mahasiswa',
            'name'                  => 'Galih Wiragama',
            'campus_name'           => '',
            'nim_nik'               => '065121001',
            'email'                 => 'galih@unpak.ac.id',
            'phone_number'          => '081234567890',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'agree_tos'             => '1',
        ]);

        $response->assertSessionHasErrors('campus_name');
        $this->assertGuest();
    }

    /*
    |--------------------------------------------------------------------------
    | Protected Routes
    |--------------------------------------------------------------------------
    */

    public function test_logout_memerlukan_autentikasi(): void
    {
        $response = $this->post(route('logout'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_dashboard_memerlukan_autentikasi(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }
}

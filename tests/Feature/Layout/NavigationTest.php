<?php

namespace Tests\Feature\Layout;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavigationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_halaman_beranda_menampilkan_header_dengan_logo_dan_lonceng_notifikasi(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Kuantum Pelopor');
        $response->assertSee('Galeri Visual Islami');
        $response->assertSee('Notifikasi');
        $response->assertSee(asset('images/logo.png'));
    }

    public function test_header_menampilkan_tombol_masuk_untuk_pengunjung_tamu(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee(route('login'));
        $response->assertSee('Masuk');
    }

    public function test_header_menampilkan_avatar_pengguna_saat_terautentikasi(): void
    {
        $user = User::factory()->create([
            'name' => 'Fajar Santri',
        ]);

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee(route('profile'));
        $response->assertSee('F'); // Inisial nama
    }

    public function test_bottom_navbar_memiliki_5_menu_navigasi_lengkap(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee(route('home'));
        $response->assertSee(route('jelajah'));
        $response->assertSee(route('unggah'));
        $response->assertSee(route('koleksi'));
        $response->assertSee(route('waktu-salat'));

        $response->assertSee('Home');
        $response->assertSee('Jelajah');
        $response->assertSee('Unggah');
        $response->assertSee('Koleksi');
        $response->assertSee('Waktu Salat');
    }

    public function test_halaman_jelajah_dapat_diakses_dan_menandai_navbar_aktif(): void
    {
        $response = $this->get(route('jelajah'));

        $response->assertStatus(200);
        $response->assertSee('Jelajah Karya Dakwah');
    }

    public function test_halaman_unggah_dapat_diakses(): void
    {
        Category::create([
            'name' => 'Arsitektur',
            'slug' => 'arsitektur',
        ]);

        $response = $this->get(route('unggah'));

        $response->assertStatus(200);
        $response->assertSee('Unggah Karya Visual');
        $response->assertSee('Arsitektur');
    }

    public function test_halaman_koleksi_dapat_diakses(): void
    {
        $response = $this->get(route('koleksi'));

        $response->assertStatus(200);
        $response->assertSee('Koleksi Saya');
    }

    public function test_halaman_waktu_salat_dapat_diakses(): void
    {
        $response = $this->get(route('waktu-salat'));

        $response->assertStatus(200);
        $response->assertSee('Waktu Salat');
        $response->assertSee('Arah Kiblat');
    }

    public function test_halaman_profil_dapat_diakses_oleh_pengguna_login(): void
    {
        $user = User::factory()->create([
            'name'  => 'Galih Wiragama',
            'email' => 'galih@unpak.ac.id',
        ]);

        $response = $this->actingAs($user)->get(route('profile'));

        $response->assertStatus(200);
        $response->assertSee('Galih Wiragama');
        $response->assertSee('galih@unpak.ac.id');
    }

    public function test_halaman_profil_dialihkan_jika_belum_login(): void
    {
        $response = $this->get(route('profile'));

        $response->assertRedirect(route('login'));
    }
}

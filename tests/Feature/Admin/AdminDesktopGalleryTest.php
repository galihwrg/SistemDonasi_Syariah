<?php

namespace Tests\Feature\Admin;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDesktopGalleryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_guest_cannot_access_admin_gallery(): void
    {
        $response = $this->get(route('admin.gallery.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_access_admin_gallery(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get(route('admin.gallery.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_access_desktop_gallery_page_with_stitch_layout(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'name' => 'Admin Pelopor']);
        $category = Category::create(['name' => 'Arsitektur Masjid', 'slug' => 'arsitektur-masjid']);
        
        $artwork = Artwork::create([
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'title' => 'Kehangatan Subuh di Pelataran Masjid',
            'slug' => 'kehangatan-subuh-masjid',
            'image_path' => 'artworks/masjid.jpg',
            'dimensions' => '4200 x 2800 px',
            'status' => 'approved',
            'download_count' => 1450,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.gallery.index'));

        $response->assertStatus(200);
        // Header & Admin Layout Elements
        $response->assertSee('Kuantum Pelopor Indonesia');
        $response->assertSee('ADMIN');
        $response->assertSee('Lihat Galeri');
        $response->assertSee('Daftar Foto (Moderasi)');
        $response->assertSee('Konfirmasi Akun');

        // Banner Desktop Elements
        $response->assertSee('Galeri Karya &amp; Foto Umat', false);
        $response->assertSee('Karya Aktif');
        $response->assertSee('Infaq Visual');
        $response->assertSee('Unggah Karya Baru (Admin)');

        // Artwork card & preview modal elements
        $response->assertSee('Kehangatan Subuh di Pelataran Masjid');
        $response->assertSee('Pratinjau Cepat');
        $response->assertSee('previewModal');
    }

    public function test_admin_gallery_can_filter_by_category(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $cat1 = Category::create(['name' => 'Kaligrafi', 'slug' => 'kaligrafi']);
        $cat2 = Category::create(['name' => 'Lanskap', 'slug' => 'lanskap']);

        Artwork::create([
            'user_id' => $admin->id,
            'category_id' => $cat1->id,
            'title' => 'Kaligrafi Al-Fatihah Khath Diwani',
            'slug' => 'kaligrafi-al-fatihah',
            'image_path' => 'artworks/kaligrafi.jpg',
            'status' => 'approved',
        ]);

        Artwork::create([
            'user_id' => $admin->id,
            'category_id' => $cat2->id,
            'title' => 'Fajar Menyapa Bukit Menoreh',
            'slug' => 'fajar-bukit-menoreh',
            'image_path' => 'artworks/fajar.jpg',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.gallery.index', ['kategori' => 'kaligrafi']));

        $response->assertStatus(200);
        $response->assertSee('Kaligrafi Al-Fatihah Khath Diwani');
        $response->assertDontSee('Fajar Menyapa Bukit Menoreh');
    }
}

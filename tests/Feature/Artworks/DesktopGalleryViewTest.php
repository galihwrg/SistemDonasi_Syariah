<?php

namespace Tests\Feature\Artworks;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DesktopGalleryViewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_explore_gallery_page_renders_desktop_layout_elements(): void
    {
        $category = Category::create(['name' => 'Arsitektur Masjid', 'slug' => 'arsitektur-masjid']);
        $user = User::factory()->create(['name' => 'Faris Al-Bukhari']);
        
        $artwork = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Kehangatan Subuh di Pelataran Nabawi',
            'slug' => 'kehangatan-subuh-nabawi',
            'image_path' => 'artworks/subuh.jpg',
            'dimensions' => '3840 x 2160 px',
            'status' => 'approved',
            'download_count' => 1450,
        ]);

        $response = $this->get(route('jelajah'));

        $response->assertStatus(200);
        // Assert Banner Desktop elements
        $response->assertSee('Galeri Karya &amp; Foto Umat', false);
        $response->assertSee('Kurasi Dakwah Umat');
        $response->assertSee('Karya Aktif');
        $response->assertSee('Infaq Visual Terhimpun');

        // Assert Artwork card
        $response->assertSee('Kehangatan Subuh di Pelataran Nabawi');
        $response->assertSee('Faris Al-Bukhari');
        $response->assertSee('Arsitektur Masjid');

        // Assert Pratinjau Cepat Modal markup
        $response->assertSee('quickPreviewModal');
        $response->assertSee('Pratinjau Foto');
        $response->assertSee('Pratinjau Cepat');
        $response->assertSee('Unduh Karya');

        // Assert Shortcut Unggah Karya
        $response->assertSee(route('unggah'));
    }

    public function test_explore_gallery_can_be_sorted_by_popularity(): void
    {
        $category = Category::create(['name' => 'Umum', 'slug' => 'umum']);
        $user = User::factory()->create();

        $art1 = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Karya Rendah Unduhan',
            'slug' => 'karya-rendah-unduhan',
            'image_path' => 'artworks/1.jpg',
            'status' => 'approved',
            'download_count' => 10,
        ]);

        $art2 = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Karya Tinggi Unduhan',
            'slug' => 'karya-tinggi-unduhan',
            'image_path' => 'artworks/2.jpg',
            'status' => 'approved',
            'download_count' => 9999,
        ]);

        $response = $this->get(route('jelajah', ['sort' => 'terpopuler']));

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Karya Tinggi Unduhan', 'Karya Rendah Unduhan']);
    }

    public function test_explore_gallery_can_be_sorted_by_highest_donations(): void
    {
        $category = Category::create(['name' => 'Umum', 'slug' => 'umum']);
        $user = User::factory()->create();

        $art1 = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Karya Sedikit Donasi',
            'slug' => 'karya-sedikit-donasi',
            'image_path' => 'artworks/1.jpg',
            'status' => 'approved',
        ]);

        $art2 = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Karya Banyak Donasi',
            'slug' => 'karya-banyak-donasi',
            'image_path' => 'artworks/2.jpg',
            'status' => 'approved',
        ]);

        // Simpan transaksi donasi settlement
        Donation::create([
            'artwork_id' => $art2->id,
            'donor_name' => 'Hamba Allah',
            'donor_email' => 'hamba@example.com',
            'amount' => 5000000,
            'payment_method' => 'qris',
            'payment_status' => 'settlement',
            'order_id' => 'INV-TEST-001',
        ]);

        Donation::create([
            'artwork_id' => $art1->id,
            'donor_name' => 'Hamba Allah 2',
            'donor_email' => 'hamba2@example.com',
            'amount' => 50000,
            'payment_method' => 'qris',
            'payment_status' => 'settlement',
            'order_id' => 'INV-TEST-002',
        ]);

        $response = $this->get(route('jelajah', ['sort' => 'donasi']));

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Karya Banyak Donasi', 'Karya Sedikit Donasi']);
    }

    public function test_explore_gallery_can_be_searched_by_contributor_or_title(): void
    {
        $category = Category::create(['name' => 'Kaligrafi', 'slug' => 'kaligrafi']);
        $user1 = User::factory()->create(['name' => 'Zaidan Khatthath']);
        $user2 = User::factory()->create(['name' => 'Budi Santoso']);

        Artwork::create([
            'user_id' => $user1->id,
            'category_id' => $category->id,
            'title' => 'Khat Diwani Jali',
            'slug' => 'khat-diwani-jali',
            'image_path' => 'artworks/diwani.jpg',
            'status' => 'approved',
        ]);

        Artwork::create([
            'user_id' => $user2->id,
            'category_id' => $category->id,
            'title' => 'Foto Senja Kampung',
            'slug' => 'foto-senja-kampung',
            'image_path' => 'artworks/senja.jpg',
            'status' => 'approved',
        ]);

        $response = $this->get(route('jelajah', ['q' => 'Zaidan']));

        $response->assertStatus(200);
        $response->assertSee('Khat Diwani Jali');
        $response->assertDontSee('Foto Senja Kampung');
    }
}

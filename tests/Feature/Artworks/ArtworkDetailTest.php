<?php

namespace Tests\Feature\Artworks;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtworkDetailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_halaman_detail_foto_dapat_diakses_dengan_slug(): void
    {
        $user = User::factory()->create([
            'name' => 'Fajar Ramadhan',
            'is_verified' => true,
        ]);

        $category = Category::create([
            'name' => 'Arsitektur & Ukhuwah',
            'slug' => 'arsitektur-ukhuwah',
        ]);

        $artwork = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Cahaya Pagi di Pelataran Masjid Nabawi',
            'slug' => 'cahaya-pagi-di-pelataran-masjid-nabawi',
            'narration' => 'Ketika fajar menyingsing di atas pilar-pilar kokoh pelataran Nabawi...',
            'quran_reference' => 'QS. An-Nur: 36',
            'quran_arabic' => 'فِي بُيُوتٍ أَذِنَ اللَّهُ أَن تُرْفَعَ',
            'quran_translation' => 'Di rumah-rumah yang disana telah diperintahkan Allah untuk dimuliakan...',
            'image_path' => 'https://images.unsplash.com/photo-1542816417-0983c9c9ad53',
            'dimensions' => '3840 x 2160 px',
            'status' => 'approved',
            'download_count' => 1240,
        ]);

        Donation::create([
            'artwork_id' => $artwork->id,
            'donor_name' => 'Muhsinin Fulan',
            'amount' => 50000,
            'payment_status' => 'settlement',
        ]);

        $response = $this->get(route('artworks.show', $artwork->slug));

        $response->assertStatus(200);
        $response->assertSee('Cahaya Pagi di Pelataran Masjid Nabawi');
        $response->assertSee('Ultra HD 4K');
        $response->assertSee('Lisensi Bebas Wakaf');
        $response->assertSee('Arsitektur & Ukhuwah');
        $response->assertSee('Fajar Ramadhan');
        $response->assertSee('QS. An-Nur: 36');
        $response->assertSee('Infaq & Donasi Dakwah');
        $response->assertSee('3840 x 2160 px');
    }

    public function test_halaman_detail_foto_404_jika_slug_tidak_ditemukan(): void
    {
        $response = $this->get(route('artworks.show', 'slug-yang-tidak-ada'));

        $response->assertStatus(404);
    }

    public function test_unduh_foto_berhasil_dan_meningkatkan_download_count(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Kaligrafi',
            'slug' => 'kaligrafi',
        ]);

        $artwork = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Kaligrafi Thuluth',
            'slug' => 'kaligrafi-thuluth',
            'image_path' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119',
            'status' => 'approved',
            'download_count' => 10,
        ]);

        $this->assertEquals(10, $artwork->download_count);

        $response = $this->get(route('artworks.download', $artwork->slug));

        $response->assertRedirect($artwork->image_path);
        $this->assertEquals(11, $artwork->fresh()->download_count);
    }
}

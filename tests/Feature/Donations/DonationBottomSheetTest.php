<?php

namespace Tests\Feature\Donations;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonationBottomSheetTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_modal_donasi_memiliki_preset_nominal_dan_metode_syariah(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Arsitektur',
            'slug' => 'arsitektur',
        ]);

        $artwork = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Cahaya Pagi di Pelataran Masjid Nabawi',
            'slug' => 'cahaya-pagi-masjid-nabawi',
            'image_path' => 'https://images.unsplash.com/photo-1542816417-0983c9c9ad53',
            'status' => 'approved',
        ]);

        $response = $this->get(route('artworks.show', $artwork->slug));

        $response->assertStatus(200);
        $response->assertSee('Infaq & Donasi Dakwah');
        $response->assertSee('Rp 10.000');
        $response->assertSee('Rp 25.000');
        $response->assertSee('Rp 50.000');
        $response->assertSee('Rp 100.000');
        $response->assertSee('Rp 250.000');
        $response->assertSee('Rp 500.000');
        $response->assertSee('QRIS (Semua Pembayaran)');
        $response->assertSee('Bank Syariah Indonesia (BSI)');
        $response->assertSee('Lanjutkan Pembayaran Infaq');
    }

    public function test_donasi_dapat_disimpan_dengan_sukses_via_post(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Kaligrafi',
            'slug' => 'kaligrafi',
        ]);

        $artwork = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Mushaf Al-Qur\'an Kuno',
            'slug' => 'mushaf-al-quran-kuno',
            'image_path' => 'https://images.unsplash.com/photo-1564769625905-50e93615e769',
            'status' => 'approved',
        ]);

        $payload = [
            'artwork_id' => $artwork->id,
            'amount' => 50000,
            'donor_name' => 'Hamba Allah Dermawan',
            'donor_contact' => '081299998888',
            'prayer_message' => 'Semoga berkah dan jariyah mengalir terus.',
            'payment_method' => 'qris',
        ];

        $response = $this->post(route('donations.store'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('donations', [
            'artwork_id' => $artwork->id,
            'amount' => 50000,
            'donor_name' => 'Hamba Allah Dermawan',
            'payment_method' => 'qris',
            'payment_status' => 'pending',
        ]);
    }

    public function test_donasi_dapat_disimpan_via_json_request(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Alam',
            'slug' => 'alam',
        ]);

        $artwork = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Tadabbur Alam Semesta',
            'slug' => 'tadabbur-alam-semesta',
            'image_path' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb',
            'status' => 'approved',
        ]);

        $payload = [
            'artwork_id' => $artwork->id,
            'amount' => 100000,
            'donor_name' => 'Ahmad Fulan',
            'donor_contact' => 'ahmad@gmail.com',
            'prayer_message' => 'Berkah selalu untuk dakwah',
            'payment_method' => 'bsi_va',
        ];

        $response = $this->postJson(route('donations.store'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('donations', [
            'artwork_id' => $artwork->id,
            'amount' => 100000,
            'payment_method' => 'bsi_va',
            'payment_status' => 'pending',
        ]);
    }

    public function test_donasi_gagal_jika_nominal_kurang_dari_lima_ribu(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Umum',
            'slug' => 'umum',
        ]);

        $artwork = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Karya Test',
            'slug' => 'karya-test',
            'image_path' => 'https://images.unsplash.com/test.jpg',
            'status' => 'approved',
        ]);

        $payload = [
            'artwork_id' => $artwork->id,
            'amount' => 1000, // Di bawah batas minimal 5.000
            'payment_method' => 'qris',
        ];

        $response = $this->postJson(route('donations.store'), $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['amount']);
    }
}

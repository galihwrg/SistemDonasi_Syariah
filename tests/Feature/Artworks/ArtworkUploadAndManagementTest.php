<?php

namespace Tests\Feature\Artworks;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArtworkUploadAndManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        Storage::fake('public');
    }

    public function test_guest_cannot_access_upload_page_and_is_redirected_to_login(): void
    {
        $response = $this->get(route('unggah'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_access_upload_page(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Arsitektur', 'slug' => 'arsitektur']);

        $response = $this->actingAs($user)->get(route('unggah'));

        $response->assertStatus(200);
        $response->assertSee('Unggah Karya Visual');
        $response->assertSee('Arsitektur');
        $response->assertSee('Kurasi Syariah');
    }

    public function test_authenticated_contributor_can_upload_artwork_successfully(): void
    {
        $user = User::factory()->create(['name' => 'Ahmad Fauzi']);
        $category = Category::create(['name' => 'Arsitektur Masjid', 'slug' => 'arsitektur-masjid']);

        $fakeImage = UploadedFile::fake()->image('masjid_krapyak.jpg', 1920, 1080)->size(2048);

        $response = $this->actingAs($user)->post(route('artworks.store'), [
            'title' => 'Keindahan Fajar Masjid Krapyak',
            'category_id' => $category->id,
            'image' => $fakeImage,
            'narration' => 'Refleksi ketenangan saat subuh tiba di serambi masjid.',
            'quran_reference' => 'QS. An-Nur: 36',
            'quran_arabic' => 'فِي بُيُوتٍ أَذِنَ اللَّهُ أَن تُرْفَعَ',
            'quran_translation' => 'Bertasbihlah kepada Allah di masjid-masjid yang telah diperintahkan untuk dimuliakan.',
        ]);

        $response->assertRedirect(route('artworks.my'));
        $response->assertSessionHas('success');

        // Pastikan record tersimpan di database dengan status awal 'pending'
        $this->assertDatabaseHas('artworks', [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Keindahan Fajar Masjid Krapyak',
            'slug' => 'keindahan-fajar-masjid-krapyak',
            'status' => 'pending',
            'download_count' => 0,
            'quran_reference' => 'QS. An-Nur: 36',
        ]);

        $artwork = Artwork::first();
        $this->assertNotNull($artwork->image_path);
        Storage::disk('public')->assertExists($artwork->image_path);
    }

    public function test_artwork_upload_validation_fails_when_required_fields_are_missing(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('artworks.store'), []);

        $response->assertSessionHasErrors(['title', 'category_id', 'image']);
    }

    public function test_contributor_can_view_my_artworks_page_with_stats_and_saldo(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Kaligrafi', 'slug' => 'kaligrafi']);

        $artworkApproved = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Khat Kufi Al-Ikhlas',
            'slug' => 'khat-kufi-al-ikhlas',
            'image_path' => 'artworks/kufi.jpg',
            'status' => 'approved',
            'download_count' => 125,
        ]);

        $artworkPending = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Khat Naskhi Basmalah',
            'slug' => 'khat-naskhi-basmalah',
            'image_path' => 'artworks/basmalah.jpg',
            'status' => 'pending',
            'download_count' => 0,
        ]);

        // Tambah donasi terkumpul pada karya yang disetujui
        Donation::create([
            'artwork_id' => $artworkApproved->id,
            'donor_name' => 'Muhsinin Peduli',
            'amount' => 750000,
            'payment_method' => 'qris',
            'payment_status' => 'settlement',
            'order_id' => 'INV-TEST-MY-001',
        ]);

        $response = $this->actingAs($user)->get(route('artworks.my'));

        $response->assertStatus(200);
        $response->assertSee('Postingan Saya');
        $response->assertSee('Khat Kufi Al-Ikhlas');
        $response->assertSee('Khat Naskhi Basmalah');
        $response->assertSee('Tayang');
        $response->assertSee('Review');
        $response->assertSee('Rp 750.000');
        $response->assertSee('125');
    }

    public function test_contributor_can_delete_own_artwork(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Alam', 'slug' => 'alam']);

        $artwork = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Senja Danau Menoreh',
            'slug' => 'senja-danau-menoreh',
            'image_path' => 'artworks/senja.jpg',
            'status' => 'pending',
        ]);

        Storage::disk('public')->put('artworks/senja.jpg', 'fake content');

        $response = $this->actingAs($user)->delete(route('artworks.destroy', $artwork->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('artworks', ['id' => $artwork->id]);
        Storage::disk('public')->assertMissing('artworks/senja.jpg');
    }

    public function test_user_cannot_delete_other_users_artwork(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $category = Category::create(['name' => 'Alam', 'slug' => 'alam']);

        $artwork = Artwork::create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'title' => 'Karya Milik Orang Lain',
            'slug' => 'karya-milik-orang-lain',
            'image_path' => 'artworks/other.jpg',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($otherUser)->delete(route('artworks.destroy', $artwork->id));

        $response->assertStatus(403);
        $this->assertDatabaseHas('artworks', ['id' => $artwork->id]);
    }
}

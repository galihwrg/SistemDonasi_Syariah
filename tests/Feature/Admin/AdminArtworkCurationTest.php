<?php

namespace Tests\Feature\Admin;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminArtworkCurationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_guest_cannot_access_admin_curation_and_is_redirected_to_login(): void
    {
        $response = $this->get(route('admin.curation.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_user_cannot_access_curation_page_and_receives_403(): void
    {
        $regularUser = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($regularUser)->get(route('admin.curation.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_access_curation_queue_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'name' => 'Admin Pelopor',
        ]);

        $category = Category::create([
            'name' => 'Arsitektur Masjid',
            'slug' => 'arsitektur-masjid',
        ]);

        $artwork = Artwork::create([
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'title' => 'Kehangatan Subuh di Pelataran Masjid',
            'slug' => 'kehangatan-subuh-di-pelataran-masjid',
            'image_path' => 'artworks/subuh.jpg',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.curation.index'));

        $response->assertStatus(200);
        $response->assertSee('Kurasi &amp; Antrean Foto Umat', false);
        $response->assertSee('Menunggu Review');
        $response->assertSee('Disetujui / Tayang');
        $response->assertSee('Ditolak');
        $response->assertSee('Kehangatan Subuh di Pelataran Masjid');
        $response->assertSee('Setujui');
        $response->assertSee('Tolak');
    }

    public function test_admin_can_approve_pending_artwork(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $contributor = User::factory()->create(['name' => 'Faris Santri']);
        $category = Category::create(['name' => 'Kaligrafi', 'slug' => 'kaligrafi']);

        $artwork = Artwork::create([
            'user_id' => $contributor->id,
            'category_id' => $category->id,
            'title' => 'Khat Diwani Surat Yasin',
            'slug' => 'khat-diwani-surat-yasin',
            'image_path' => 'artworks/yasin.jpg',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.curation.approve', $artwork->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $artwork->refresh();
        $this->assertEquals('approved', $artwork->status);
        $this->assertNull($artwork->rejection_reason);

        // Pastikan sekarang tampil di galeri publik /jelajah
        $publicGalleryResponse = $this->get(route('jelajah'));
        $publicGalleryResponse->assertSee('Khat Diwani Surat Yasin');
    }

    public function test_admin_can_reject_artwork_with_reason(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $contributor = User::factory()->create(['name' => 'Budi User']);
        $category = Category::create(['name' => 'Kegiatan', 'slug' => 'kegiatan']);

        $artwork = Artwork::create([
            'user_id' => $contributor->id,
            'category_id' => $category->id,
            'title' => 'Karya Tidak Fokus Blur',
            'slug' => 'karya-tidak-fokus-blur',
            'image_path' => 'artworks/blur.jpg',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.curation.reject', $artwork->id), [
            'rejection_reason' => 'Foto memiliki resolusi terlalu rendah dan tidak memenuhi standar etika syariah galeri.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $artwork->refresh();
        $this->assertEquals('rejected', $artwork->status);
        $this->assertEquals('Foto memiliki resolusi terlalu rendah dan tidak memenuhi standar etika syariah galeri.', $artwork->rejection_reason);

        // Pastikan tidak tampil di galeri publik /jelajah
        $publicGalleryResponse = $this->get(route('jelajah'));
        $publicGalleryResponse->assertDontSee('Karya Tidak Fokus Blur');
    }

    public function test_rejection_fails_if_reason_is_empty(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $contributor = User::factory()->create();
        $category = Category::create(['name' => 'Kegiatan', 'slug' => 'kegiatan']);

        $artwork = Artwork::create([
            'user_id' => $contributor->id,
            'category_id' => $category->id,
            'title' => 'Karya Test',
            'slug' => 'karya-test',
            'image_path' => 'artworks/test.jpg',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.curation.reject', $artwork->id), [
            'rejection_reason' => '',
        ]);

        $response->assertSessionHasErrors(['rejection_reason']);
        $artwork->refresh();
        $this->assertEquals('pending', $artwork->status);
    }

    public function test_curation_queue_can_be_filtered_by_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::create(['name' => 'Umum', 'slug' => 'umum']);

        $artPending = Artwork::create([
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'title' => 'Foto Menunggu',
            'slug' => 'foto-menunggu',
            'image_path' => 'artworks/menunggu.jpg',
            'status' => 'pending',
        ]);

        $artApproved = Artwork::create([
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'title' => 'Foto Sudah Tayang',
            'slug' => 'foto-sudah-tayang',
            'image_path' => 'artworks/tayang.jpg',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.curation.index', ['status' => 'pending']));

        $response->assertStatus(200);
        $response->assertSee('Foto Menunggu');
        $response->assertDontSee('Foto Sudah Tayang');
    }
}

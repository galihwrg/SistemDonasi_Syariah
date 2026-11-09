<?php

namespace Tests\Feature\Collections;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\SavedCollection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollectionManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_guest_can_access_collections_page_and_sees_empty_state_prompt(): void
    {
        $response = $this->get(route('koleksi'));

        $response->assertStatus(200);
        $response->assertSee('Koleksi Saya');
        $response->assertSee('Belum Ada Karya Tersimpan');
        $response->assertSee('Masuk untuk Melihat Koleksi');
    }

    public function test_guest_cannot_toggle_bookmark_and_receives_401_json(): void
    {
        $category = Category::create(['name' => 'Fotografi Masjid', 'slug' => 'fotografi-masjid']);
        $user = User::factory()->create();
        $artwork = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Mihrab Keheningan Fajar',
            'slug' => 'mihrab-keheningan-fajar',
            'image_path' => 'artworks/test.jpg',
            'status' => 'approved',
        ]);

        $response = $this->postJson(route('collections.toggle'), [
            'artwork_id' => $artwork->id,
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
        ]);
        $this->assertDatabaseMissing('saved_collections', [
            'artwork_id' => $artwork->id,
        ]);
    }

    public function test_authenticated_user_can_toggle_bookmark_to_save_and_unsave(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Kaligrafi', 'slug' => 'kaligrafi']);
        $artwork = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Asmaul Husna Emas',
            'slug' => 'asmaul-husna-emas',
            'image_path' => 'artworks/asmaul-husna.jpg',
            'status' => 'approved',
        ]);

        // 1. Simpan ke koleksi
        $saveResponse = $this->actingAs($user)->postJson(route('collections.toggle'), [
            'artwork_id' => $artwork->id,
        ]);

        $saveResponse->assertStatus(200);
        $saveResponse->assertJson([
            'success' => true,
            'saved' => true,
            'total_saved' => 1,
            'artwork_id' => $artwork->id,
        ]);
        $this->assertDatabaseHas('saved_collections', [
            'user_id' => $user->id,
            'artwork_id' => $artwork->id,
        ]);

        // 2. Unsave / Hapus dari koleksi
        $unsaveResponse = $this->actingAs($user)->postJson(route('collections.toggle'), [
            'artwork_id' => $artwork->id,
        ]);

        $unsaveResponse->assertStatus(200);
        $unsaveResponse->assertJson([
            'success' => true,
            'saved' => false,
            'total_saved' => 0,
            'artwork_id' => $artwork->id,
        ]);
        $this->assertDatabaseMissing('saved_collections', [
            'user_id' => $user->id,
            'artwork_id' => $artwork->id,
        ]);
    }

    public function test_saved_artworks_display_on_collections_page_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Arsitektur', 'slug' => 'arsitektur']);
        $artwork = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Pilar Kemegahan Nabawi',
            'slug' => 'pilar-kemegahan-nabawi',
            'image_path' => 'artworks/nabawi.jpg',
            'status' => 'approved',
        ]);

        SavedCollection::create([
            'user_id' => $user->id,
            'artwork_id' => $artwork->id,
        ]);

        $response = $this->actingAs($user)->get(route('koleksi'));

        $response->assertStatus(200);
        $response->assertSee('Pilar Kemegahan Nabawi');
        $response->assertSee('Semua (1)');
        $response->assertDontSee('Belum Ada Karya Tersimpan');
    }

    public function test_collections_can_be_filtered_by_category(): void
    {
        $user = User::factory()->create();
        $cat1 = Category::create(['name' => 'Arsitektur', 'slug' => 'arsitektur']);
        $cat2 = Category::create(['name' => 'Kaligrafi', 'slug' => 'kaligrafi']);

        $art1 = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $cat1->id,
            'title' => 'Menara Indah',
            'slug' => 'menara-indah',
            'image_path' => 'artworks/menara.jpg',
            'status' => 'approved',
        ]);

        $art2 = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $cat2->id,
            'title' => 'Kaligrafi Kufi',
            'slug' => 'kaligrafi-kufi',
            'image_path' => 'artworks/kufi.jpg',
            'status' => 'approved',
        ]);

        SavedCollection::create(['user_id' => $user->id, 'artwork_id' => $art1->id]);
        SavedCollection::create(['user_id' => $user->id, 'artwork_id' => $art2->id]);

        $response = $this->actingAs($user)->get(route('koleksi', ['kategori' => 'kaligrafi']));

        $response->assertStatus(200);
        $response->assertSee('Kaligrafi Kufi');
        $response->assertDontSee('Menara Indah');
    }

    public function test_toggle_validation_fails_for_non_existent_artwork(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('collections.toggle'), [
            'artwork_id' => 999999,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['artwork_id']);
    }
}

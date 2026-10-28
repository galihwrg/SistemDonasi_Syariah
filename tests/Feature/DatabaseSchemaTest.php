<?php

namespace Tests\Feature;

use App\Models\Artwork;
use App\Models\BankAccount;
use App\Models\Category;
use App\Models\ContributorVerification;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSchemaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that categories seeder creates the expected categories.
     */
    public function test_categories_can_be_seeded(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);

        $this->assertDatabaseHas('categories', ['slug' => 'arsitektur']);
        $this->assertDatabaseHas('categories', ['slug' => 'alam-tadabbur']);
        $this->assertDatabaseHas('categories', ['slug' => 'kaligrafi']);
        $this->assertDatabaseHas('categories', ['slug' => 'kegiatan-umat']);
        $this->assertDatabaseHas('categories', ['slug' => 'ramadhan']);
    }

    /**
     * Test user creation and relationships.
     */
    public function test_user_and_related_entities_can_be_persisted(): void
    {
        $user = User::create([
            'name' => 'Fajar Santri',
            'email' => 'fajar@santri.ac.id',
            'password' => bcrypt('secret123'),
            'role' => 'user',
            'user_type' => 'mahasiswa',
            'is_verified' => true,
            'campus_name' => 'Institut Ilmu Al-Quran',
            'nim_nik' => '20261001',
        ]);

        $category = Category::create([
            'name' => 'Arsitektur',
            'slug' => 'arsitektur',
            'icon' => 'mosque',
        ]);

        $bankAccount = BankAccount::create([
            'user_id' => $user->id,
            'bank_name' => 'Bank Syariah Indonesia (BSI)',
            'account_number' => '718293841029',
            'account_holder_name' => 'FAJAR SANTRI',
            'is_primary' => true,
        ]);

        $verification = ContributorVerification::create([
            'user_id' => $user->id,
            'id_type' => 'ktm',
            'id_number' => '20261001',
            'campus_name' => 'Institut Ilmu Al-Quran',
            'document_path' => 'verifications/ktm_sample.jpg',
            'status' => 'approved',
        ]);

        $artwork = Artwork::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Kehangatan Subuh di Nabawi',
            'slug' => 'kehangatan-subuh-di-nabawi',
            'narration' => 'Refleksi ketenangan fajar...',
            'quran_reference' => 'QS. An-Nur: 36',
            'quran_arabic' => 'فِي بُيُوتٍ أَذِنَ اللَّهُ أَن تُرْفَعَ',
            'quran_translation' => 'Di masjid-masjid yang telah diperintahkan...',
            'image_path' => 'artworks/nabawi.jpg',
            'dimensions' => '3840x2160',
            'status' => 'approved',
        ]);

        $donation = Donation::create([
            'artwork_id' => $artwork->id,
            'donor_name' => 'Hamba Allah',
            'donor_contact' => '081299998888',
            'prayer_message' => 'Semoga berkah untuk dakwah',
            'amount' => 50000.00,
            'midtrans_order_id' => 'INV-20261028-001',
            'payment_method' => 'qris',
            'payment_status' => 'settlement',
        ]);

        // Assertions
        $this->assertDatabaseHas('users', ['email' => 'fajar@santri.ac.id']);
        $this->assertDatabaseHas('bank_accounts', ['account_number' => '718293841029']);
        $this->assertDatabaseHas('contributor_verifications', ['id_number' => '20261001']);
        $this->assertDatabaseHas('artworks', ['slug' => 'kehangatan-subuh-di-nabawi']);
        $this->assertDatabaseHas('donations', ['midtrans_order_id' => 'INV-20261028-001']);

        // Relationships check
        $this->assertTrue($user->isMahasiswa());
        $this->assertFalse($user->isAdmin());
        $this->assertCount(1, $user->bankAccounts);
        $this->assertCount(1, $user->artworks);
        $this->assertEquals('Arsitektur', $artwork->category->name);
        $this->assertCount(1, $artwork->donations);
    }
}

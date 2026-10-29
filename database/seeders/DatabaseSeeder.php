<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Categories
        $this->call(CategorySeeder::class);

        // 2. Admin Account
        $admin = User::updateOrCreate(
            ['email' => 'admin@kuantumpelopor.id'],
            [
                'name' => 'Admin Pelopor',
                'password' => Hash::make('password123'),
                'phone_number' => '081234567890',
                'role' => 'admin',
                'user_type' => 'umum',
                'is_verified' => true,
                'address' => 'Ciomas, Kab. Bogor',
            ]
        );

        // 3. Sample Verified Mahasiswa Contributor
        $mahasiswa = User::updateOrCreate(
            ['email' => 'galih.wiragama@unpak.ac.id'],
            [
                'name' => 'Galih Wiragama',
                'password' => Hash::make('password123'),
                'phone_number' => '081211491093',
                'role' => 'user',
                'user_type' => 'mahasiswa',
                'is_verified' => true,
                'campus_name' => 'Universitas Pakuan',
                'nim_nik' => '065123176',
                'address' => 'Kec. Caringin, Kab. Bogor',
            ]
        );

        // 4. Sample Active Bank Account for Mahasiswa
        BankAccount::updateOrCreate(
            [
                'user_id' => $mahasiswa->id,
                'account_number' => '718293841029',
            ],
            [
                'bank_name' => 'Bank Syariah Indonesia (BSI)',
                'account_holder_name' => 'GALIH WIRAGAMA',
                'is_primary' => true,
            ]
        );

        // 5. Sample Unverified Umum Contributor
        User::updateOrCreate(
            ['email' => 'fajar.shadiq@gmail.com'],
            [
                'name' => 'Fajar Shadiq Pratama',
                'password' => Hash::make('password123'),
                'phone_number' => '081249821102',
                'role' => 'user',
                'user_type' => 'umum',
                'is_verified' => false,
                'address' => 'Kota Yogyakarta',
            ]
        );
    }
}

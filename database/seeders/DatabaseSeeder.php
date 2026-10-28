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
                'address' => 'Jl. Dakwah Nusantara No. 14, Jakarta Selatan',
            ]
        );

        // 3. Sample Verified Mahasiswa Contributor
        $mahasiswa = User::updateOrCreate(
            ['email' => 'galih.wiragama@mail.ugm.ac.id'],
            [
                'name' => 'Galih Wiragama',
                'password' => Hash::make('password123'),
                'phone_number' => '081298765432',
                'role' => 'user',
                'user_type' => 'mahasiswa',
                'is_verified' => true,
                'campus_name' => 'Universitas Gadjah Mada',
                'nim_nik' => '21/478921/TK/52109',
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

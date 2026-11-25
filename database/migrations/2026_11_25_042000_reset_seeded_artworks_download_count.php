<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Reset angka unduhan sample dummy awal menjadi 0, menyisakan karya riil yang diunduh (seperti Masjid Nabawi)
        DB::table('artworks')
            ->whereIn('slug', [
                'kebersamaan-subuh-ukhuwah-pelataran-masjid',
                'simetri-keagungan-lengkung-pilar-masjid-nabawi',
                'kabut-pagi-tadabbur-ciptaan-lembah-bromo',
                'lafaz-basmalah-kaligrafi-thuluth-tradisional',
                'lentera-berkah-manisnya-waktu-berbuka',
                'semangat-pemuda-pelopor-dalam-halaqah-ilmu',
            ])
            ->update(['download_count' => 0]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

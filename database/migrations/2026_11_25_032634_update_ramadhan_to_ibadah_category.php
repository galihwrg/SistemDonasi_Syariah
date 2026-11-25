<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update kategori ramadhan menjadi ibadah
        DB::table('categories')
            ->where('slug', 'ramadhan')
            ->update([
                'name' => 'Ibadah',
                'slug' => 'ibadah',
                'icon' => 'mosque',
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('categories')
            ->where('slug', 'ibadah')
            ->update([
                'name' => 'Ramadhan',
                'slug' => 'ramadhan',
                'icon' => 'bedtime',
            ]);
    }
};

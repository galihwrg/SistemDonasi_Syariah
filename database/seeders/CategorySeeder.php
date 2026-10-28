<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Arsitektur',
                'slug' => 'arsitektur',
                'icon' => 'mosque',
            ],
            [
                'name' => 'Alam & Tadabbur',
                'slug' => 'alam-tadabbur',
                'icon' => 'nature',
            ],
            [
                'name' => 'Kaligrafi',
                'slug' => 'kaligrafi',
                'icon' => 'draw',
            ],
            [
                'name' => 'Kegiatan Umat',
                'slug' => 'kegiatan-umat',
                'icon' => 'groups',
            ],
            [
                'name' => 'Ramadhan',
                'slug' => 'ramadhan',
                'icon' => 'bedtime',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}

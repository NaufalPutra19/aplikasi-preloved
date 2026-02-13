<?php

namespace Database\Seeders;

use App\Models\categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik', 'slug' => 'elektronik'],
            ['name' => 'Fashion & Pakaian', 'slug' => 'fashion-pakaian'],
            ['name' => 'Sepatu', 'slug' => 'sepatu'],
            ['name' => 'Tas & Dompet', 'slug' => 'tas-dompet'],
            ['name' => 'Aksesori', 'slug' => 'aksesori'],
            ['name' => 'Furnitur', 'slug' => 'furnitur'],
            ['name' => 'Rumah Tangga', 'slug' => 'rumah-tangga'],
            ['name' => 'Olahraga', 'slug' => 'olahraga'],
            ['name' => 'Buku & Media', 'slug' => 'buku-media'],
            ['name' => 'Mainan & Game', 'slug' => 'mainan-game'],
            ['name' => 'Kecantikan & Perawatan', 'slug' => 'kecantikan-perawatan'],
            ['name' => 'Makanan & Minuman', 'slug' => 'makanan-minuman'],
        ];

        foreach ($categories as $category) {
            categories::create($category);
        }
    }
}

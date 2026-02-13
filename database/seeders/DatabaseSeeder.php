<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\categories;
use App\Models\Unit;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Call seeders
        $this->call([
            UnitSeeder::class,
            CategoriesSeeder::class,
            ItemSeeder::class,
        ]);

        $this->command->info('Database seeded successfully with complete dummy data!');
        $this->command->info('Categories: 12');
        $this->command->info('Units: 8');
        $this->command->info('Products: 48');
    }
}
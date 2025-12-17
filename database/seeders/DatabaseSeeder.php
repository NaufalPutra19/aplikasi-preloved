<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\categories;
use App\Models\unit;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@prelovex.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Staff User
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@prelovex.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'email_verified_at' => now(),
        ]);

        // Create Customer User
        User::create([
            'name' => 'John Customer',
            'email' => 'customer@prelovex.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // Create Categories
        $categories = [
            'Fashion & Accessories',
            'Electronics',
            'Home & Living',
            'Books & Media',
            'Sports & Outdoors',
            'Toys & Games',
            'Beauty & Health',
            'Automotive'
        ];

        foreach ($categories as $category) {
            categories::create([
                'name' => $category,
                'slug' => Str::slug($category)
            ]);
        }

        // Create Units
        $units = ['Pcs', 'Set', 'Pack', 'Box', 'Kg', 'Liter'];

        foreach ($units as $unit) {
            unit::create(['name' => $unit]);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin credentials: admin@prelovex.com / password');
        $this->command->info('Staff credentials: staff@prelovex.com / password');
        $this->command->info('Customer credentials: customer@prelovex.com / password');
    }
}
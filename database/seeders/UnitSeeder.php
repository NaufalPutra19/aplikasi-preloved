<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $unit = [
            [
                'name' => 'Piece',
                'symbol' => 'pcs',
                'description' => 'Individual piece or item',
                'is_active' => true
            ],
            [
                'name' => 'Kilogram',
                'symbol' => 'kg',
                'description' => 'Weight measurement in kilograms',
                'is_active' => true
            ],
            [
                'name' => 'Gram',
                'symbol' => 'g',
                'description' => 'Weight measurement in grams',
                'is_active' => true
            ],
            [
                'name' => 'Liter',
                'symbol' => 'L',
                'description' => 'Volume measurement in liters',
                'is_active' => true
            ],
            [
                'name' => 'Milliliter',
                'symbol' => 'ml',
                'description' => 'Volume measurement in milliliters',
                'is_active' => true
            ],
            [
                'name' => 'Box',
                'symbol' => 'box',
                'description' => 'Package or box unit',
                'is_active' => true
            ],
            [
                'name' => 'Pack',
                'symbol' => 'pack',
                'description' => 'Package or pack unit',
                'is_active' => true
            ],
            [
                'name' => 'Dozen',
                'symbol' => 'dz',
                'description' => '12 pieces',
                'is_active' => true
            ],
            [
                'name' => 'Meter',
                'symbol' => 'm',
                'description' => 'Length measurement in meters',
                'is_active' => true
            ],
            [
                'name' => 'Set',
                'symbol' => 'set',
                'description' => 'Set of items',
                'is_active' => true
            ]
        ];

        foreach ($unit as $unit) {
            Unit::create($unit);
        }
    }
}
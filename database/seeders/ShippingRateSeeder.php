<?php

namespace Database\Seeders;

use App\Models\ShippingRate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rates = [
            // Same Province (Short distances)
            ['origin_city' => 'Jakarta', 'origin_province' => 'DKI Jakarta', 'destination_city' => 'Jakarta', 'destination_province' => 'DKI Jakarta', 'distance_km' => 10, 'base_rate' => 5000, 'rate_per_km' => 500],
            ['origin_city' => 'Jakarta', 'origin_province' => 'DKI Jakarta', 'destination_city' => 'Bogor', 'destination_province' => 'Jawa Barat', 'distance_km' => 60, 'base_rate' => 10000, 'rate_per_km' => 800],
            ['origin_city' => 'Jakarta', 'origin_province' => 'DKI Jakarta', 'destination_city' => 'Bandung', 'destination_province' => 'Jawa Barat', 'distance_km' => 180, 'base_rate' => 15000, 'rate_per_km' => 800],
            ['origin_city' => 'Jakarta', 'origin_province' => 'DKI Jakarta', 'destination_city' => 'Tangerang', 'destination_province' => 'Banten', 'distance_km' => 30, 'base_rate' => 8000, 'rate_per_km' => 600],
            ['origin_city' => 'Jakarta', 'origin_province' => 'DKI Jakarta', 'destination_city' => 'Serang', 'destination_province' => 'Banten', 'distance_km' => 100, 'base_rate' => 12000, 'rate_per_km' => 700],
            
            // Jakarta to Central Java
            ['origin_city' => 'Jakarta', 'origin_province' => 'DKI Jakarta', 'destination_city' => 'Semarang', 'destination_province' => 'Jawa Tengah', 'distance_km' => 450, 'base_rate' => 25000, 'rate_per_km' => 1000],
            ['origin_city' => 'Jakarta', 'origin_province' => 'DKI Jakarta', 'destination_city' => 'Yogyakarta', 'destination_province' => 'Jawa Tengah', 'distance_km' => 550, 'base_rate' => 25000, 'rate_per_km' => 1000],
            
            // Jakarta to East Java
            ['origin_city' => 'Jakarta', 'origin_province' => 'DKI Jakarta', 'destination_city' => 'Surabaya', 'destination_province' => 'Jawa Timur', 'distance_km' => 800, 'base_rate' => 35000, 'rate_per_km' => 1200],
            ['origin_city' => 'Jakarta', 'origin_province' => 'DKI Jakarta', 'destination_city' => 'Malang', 'destination_province' => 'Jawa Timur', 'distance_km' => 850, 'base_rate' => 35000, 'rate_per_km' => 1200],
            
            // Jakarta to Bali
            ['origin_city' => 'Jakarta', 'origin_province' => 'DKI Jakarta', 'destination_city' => 'Denpasar', 'destination_province' => 'Bali', 'distance_km' => 1200, 'base_rate' => 40000, 'rate_per_km' => 1500],
            
            // Jakarta to Sumatra
            ['origin_city' => 'Jakarta', 'origin_province' => 'DKI Jakarta', 'destination_city' => 'Medan', 'destination_province' => 'Sumatera Utara', 'distance_km' => 1400, 'base_rate' => 50000, 'rate_per_km' => 1500],
            ['origin_city' => 'Jakarta', 'origin_province' => 'DKI Jakarta', 'destination_city' => 'Palembang', 'destination_province' => 'Sumatera Selatan', 'distance_km' => 1000, 'base_rate' => 45000, 'rate_per_km' => 1300],
            
            // Jakarta to Sulawesi
            ['origin_city' => 'Jakarta', 'origin_province' => 'DKI Jakarta', 'destination_city' => 'Makassar', 'destination_province' => 'Sulawesi Selatan', 'distance_km' => 1800, 'base_rate' => 60000, 'rate_per_km' => 1800],
            
            // Jakarta to Kalimantan
            ['origin_city' => 'Jakarta', 'origin_province' => 'DKI Jakarta', 'destination_city' => 'Samarinda', 'destination_province' => 'Kalimantan Timur', 'distance_km' => 1500, 'base_rate' => 55000, 'rate_per_km' => 1500],
        ];

        foreach ($rates as $rate) {
            ShippingRate::updateOrCreate(
                [
                    'origin_city' => $rate['origin_city'],
                    'origin_province' => $rate['origin_province'],
                    'destination_city' => $rate['destination_city'],
                    'destination_province' => $rate['destination_province'],
                ],
                $rate
            );
        }
    }
}

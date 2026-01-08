<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    use HasFactory;

    protected $table = 'shipping_rates';

    protected $fillable = [
        'origin_city',
        'origin_province',
        'destination_city',
        'destination_province',
        'distance_km',
        'base_rate',
        'rate_per_km',
    ];

    protected $casts = [
        'distance_km' => 'integer',
        'base_rate' => 'decimal:2',
        'rate_per_km' => 'decimal:2',
    ];

    /**
     * Calculate shipping cost based on distance
     */
    public function calculateCost(): float
    {
        return (float) ($this->base_rate + ($this->distance_km * $this->rate_per_km));
    }

    /**
     * Find shipping rate by cities
     */
    public static function findByCities(string $originCity, string $originProvince, string $destCity, string $destProvince)
    {
        return self::where(function ($query) use ($originCity, $originProvince, $destCity, $destProvince) {
            $query->where('origin_city', $originCity)
                  ->where('origin_province', $originProvince)
                  ->where('destination_city', $destCity)
                  ->where('destination_province', $destProvince);
        })->first();
    }
}

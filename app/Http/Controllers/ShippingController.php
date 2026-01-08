<?php

namespace App\Http\Controllers;

use App\Models\ShippingRate;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    /**
     * Calculate shipping cost based on destination city and province
     */
    public function calculateCost(Request $request)
    {
        try {
            $validated = $request->validate([
                'destination_city' => 'required|string|max:100',
                'destination_province' => 'required|string|max:100',
            ]);

            // Default origin (warehouse location)
            $originCity = 'Jakarta';
            $originProvince = 'DKI Jakarta';

            $destCity = $validated['destination_city'];
            $destProvince = $validated['destination_province'];

            // Try to find existing shipping rate
            $shippingRate = ShippingRate::findByCities($originCity, $originProvince, $destCity, $destProvince);

            if ($shippingRate) {
                $cost = $shippingRate->calculateCost();
                $distance = $shippingRate->distance_km . ' km';
            } else {
                // Default calculation if route not found
                $cost = $this->calculateDefaultCost($destProvince);
                $distance = 'N/A';
            }

            return response()->json([
                'success' => true,
                'cost' => (float) $cost,
                'cost_formatted' => 'Rp ' . number_format($cost, 0, ',', '.'),
                'distance' => $distance,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Shipping calculation error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error calculating shipping cost',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Calculate default shipping cost based on province
     */
    private function calculateDefaultCost(string $destProvince): float
    {
        $provincePrices = [
            'DKI Jakarta' => 10000,
            'Jawa Barat' => 15000,
            'Jawa Tengah' => 25000,
            'Jawa Timur' => 35000,
            'Banten' => 13000,
            'Bali' => 40000,
            'Sumatera Utara' => 50000,
            'Sumatera Selatan' => 45000,
            'Sulawesi Selatan' => 60000,
            'Kalimantan Timur' => 55000,
        ];

        return $provincePrices[$destProvince] ?? 30000; // Default if not found
    }
}

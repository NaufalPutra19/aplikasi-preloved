<?php

/**
 * Format number as Indonesian Rupiah currency
 */
if (!function_exists('formatRupiah')) {
    function formatRupiah($amount, $decimals = 0): string
    {
        return 'Rp ' . number_format($amount, $decimals, ',', '.');
    }
}

/**
 * Format number for display only (no currency symbol)
 */
if (!function_exists('formatCurrency')) {
    function formatCurrency($amount, $decimals = 0): string
    {
        return number_format($amount, $decimals, ',', '.');
    }
}

/**
 * Calculate shipping cost from origin to destination
 */
if (!function_exists('calculateShippingCost')) {
    function calculateShippingCost(string $destCity, string $destProvince): float
    {
        $originCity = 'Jakarta';
        $originProvince = 'DKI Jakarta';

        $shippingRate = \App\Models\ShippingRate::findByCities($originCity, $originProvince, $destCity, $destProvince);

        if ($shippingRate) {
            return (float) $shippingRate->calculateCost();
        }

        // Fallback to default calculation
        $shippingRates = [
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

        return $shippingRates[$destProvince] ?? 30000;
    }
}

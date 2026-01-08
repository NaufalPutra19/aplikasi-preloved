<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShippingRate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingRateController extends Controller
{
    /**
     * Display a listing of shipping rates
     */
    public function index()
    {
        $rates = ShippingRate::orderBy('origin_province')
            ->orderBy('destination_province')
            ->paginate(20);

        return view('admin.shipping-rates.index', compact('rates'));
    }

    /**
     * Show the form for creating a new shipping rate
     */
    public function create()
    {
        return view('admin.shipping-rates.create');
    }

    /**
     * Store a newly created shipping rate in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin_city' => 'required|string|max:100',
            'origin_province' => 'required|string|max:100',
            'destination_city' => 'required|string|max:100',
            'destination_province' => 'required|string|max:100',
            'distance_km' => 'required|integer|min:1',
            'base_rate' => 'required|numeric|min:0',
            'rate_per_km' => 'required|numeric|min:0',
        ]);

        ShippingRate::create($validated);

        return redirect()->route('admin.shipping-rates.index')
            ->with('success', 'Shipping rate created successfully');
    }

    /**
     * Show the form for editing the specified shipping rate
     */
    public function edit(ShippingRate $shippingRate)
    {
        return view('admin.shipping-rates.edit', compact('shippingRate'));
    }

    /**
     * Update the specified shipping rate in storage
     */
    public function update(Request $request, ShippingRate $shippingRate)
    {
        $validated = $request->validate([
            'origin_city' => 'required|string|max:100',
            'origin_province' => 'required|string|max:100',
            'destination_city' => 'required|string|max:100',
            'destination_province' => 'required|string|max:100',
            'distance_km' => 'required|integer|min:1',
            'base_rate' => 'required|numeric|min:0',
            'rate_per_km' => 'required|numeric|min:0',
        ]);

        $shippingRate->update($validated);

        return redirect()->route('admin.shipping-rates.index')
            ->with('success', 'Shipping rate updated successfully');
    }

    /**
     * Remove the specified shipping rate from storage
     */
    public function destroy(ShippingRate $shippingRate)
    {
        $shippingRate->delete();

        return redirect()->route('admin.shipping-rates.index')
            ->with('success', 'Shipping rate deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::latest()->paginate(10);
        return view('admin.units.index', compact('units'));
    }

    public function create()
    {
        return view('admin.units.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:units,name',
            'symbol' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean'
        ]);

        $validated['is_active'] = (bool) $request->input('is_active');

        Unit::create($validated);

        return redirect()->route('admin.units.index')
            ->with('success', 'Unit created successfully!');
    }

    public function edit(Unit $unit)
    {
        return view('admin.units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:units,name,' . $unit->id,
            'symbol' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean'
        ]);

        $validated['is_active'] = (bool) $request->input('is_active');

        $unit->update($validated);

        return redirect()->route('admin.units.index')
            ->with('success', 'Unit updated successfully!');
    }

    public function destroy(Unit $unit)
    {
        // Check if unit is being used
        if ($unit->products()->count() > 0) {
            return redirect()->route('admin.units.index')
                ->with('error', 'Cannot delete unit. It is being used by ' . $unit->products()->count() . ' product(s).');
        }

        $unit->delete();

        return redirect()->route('admin.units.index')
            ->with('success', 'Unit deleted successfully!');
    }
}
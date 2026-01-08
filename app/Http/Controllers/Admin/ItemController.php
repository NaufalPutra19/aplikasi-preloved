<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\item;
use App\Models\categories;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $items = item::with(['category', 'unit'])->latest()->paginate(20);
        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        $categories = categories::all();
        $units = Unit::all();
        return view('admin.items.create', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:items',
            'name' => 'required|max:200',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'nullable|exists:units,id',
            'stock' => 'required|integer|min:0',
            'stock_min' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable',
            'condition' => 'required|in:New,Like New,Good,Fair',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'required|boolean'
        ]);

        if($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        $validated['is_active'] = (bool) $request->input('is_active');

        item::create($validated);

        return redirect()->route('admin.items.index')->with('success', 'Item berhasil ditambahkan');
    }

    public function edit(item $item)
    {
        $categories = categories::all();
        $units = Unit::all();
        return view('admin.items.edit', compact('item', 'categories', 'units'));
    }

    public function update(Request $request, item $item)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:items,sku,' . $item->id,
            'name' => 'required|max:200',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'nullable|exists:units,id',
            'stock' => 'required|integer|min:0',
            'stock_min' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable',
            'condition' => 'required|in:New,Like New,Good,Fair',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'required|boolean'
        ]);

        if($request->hasFile('image')) {
            if($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        $validated['is_active'] = (bool) $request->input('is_active');

        $item->update($validated);

        return redirect()->route('admin.items.index')->with('success', 'Item berhasil diupdate');
    }

    public function destroy(item $item)
    {
        if($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        
        $item->delete();
        
        return redirect()->route('admin.items.index')->with('success', 'Item berhasil dihapus');
    }
}
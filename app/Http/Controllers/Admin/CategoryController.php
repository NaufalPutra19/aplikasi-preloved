<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = categories::withCount('items')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:150|unique:categories,name',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        categories::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully');
    }

    public function edit(categories $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, categories $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:150|unique:categories,name,' . $category->id,
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy(categories $category)
    {
        // Check if category has items
        if($category->items()->count() > 0) {
            return back()->with('error', 'Cannot delete category with existing products');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully');
    }
}

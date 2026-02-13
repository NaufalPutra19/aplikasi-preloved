<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\item;
use App\Models\categories;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = item::where('is_active', true)
            ->where('stock', '>', 0)
            ->with('category'); // Eager load category
        
        // Search by product name
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }
        
        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $categoryId = (int) $request->category;
            // Verify category exists
            if (categories::find($categoryId)) {
                $query->where('category_id', $categoryId);
            }
        }
        
        $products = $query->latest()->paginate(12);
        
        // Get all categories that have active items with stock
        // Using distinct to avoid duplicates
        $categories = categories::select('categories.*')
            ->distinct()
            ->join('items', 'categories.id', '=', 'items.category_id')
            ->where('items.is_active', true)
            ->where('items.stock', '>', 0)
            ->orderBy('categories.name')
            ->get();
        
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product.
     */
    public function show(item $product)
    {
        // Ensure product is active
        if (!$product->is_active) {
            abort(404);
        }
        
        return view('products.show', compact('product'));
    }
}


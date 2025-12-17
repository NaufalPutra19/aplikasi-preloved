<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\item;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = item::where('is_active', true)
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);
            
        return view('products.index', compact('products'));
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


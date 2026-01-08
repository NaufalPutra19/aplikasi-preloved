<?php

namespace App\Http\Controllers;

use App\Models\item;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $details) {
            $product = item::find($id);
            if ($product) {
                $cartItems[$id] = [
                    'product' => $product,
                    'quantity' => $details['quantity'] ?? $details['qty'] ?? 1,
                    'subtotal' => $product->price * ($details['quantity'] ?? $details['qty'] ?? 1)
                ];
                $total += $cartItems[$id]['subtotal'];
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = item::findOrFail($request->product_id);
        
        // Check stock
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Insufficient stock available');
        }

        $cart = session()->get('cart', []);
        
        // If product already in cart, increase quantity
        if (isset($cart[$product->id])) {
            $newQty = $cart[$product->id]['quantity'] + $request->quantity;
            
            if ($newQty > $product->stock) {
                return back()->with('error', 'Cannot add more items. Stock limit reached.');
            }
            
            $cart[$product->id]['quantity'] = $newQty;
        } else {
            // Add new product to cart
            $cart[$product->id] = [
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = item::findOrFail($request->product_id);

        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Quantity exceeds available stock');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return back()->with('success', 'Cart updated successfully!');
        }

        return back()->with('error', 'Product not found in cart');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
            return back()->with('success', 'Product removed from cart');
        }

        return back()->with('error', 'Product not found in cart');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared successfully');
    }
}
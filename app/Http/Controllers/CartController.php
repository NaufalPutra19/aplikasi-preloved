<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = session('cart', []);
        return view('cart.index', compact('items'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'qty' => 'required|integer|min:1'
        ]);

        $item = item::findOrFail($request->item_id);
        
        if($request->qty > $item->stock) {
            return back()->with('error', 'Stock tidak mencukupi');
        }

        $cart = session('cart', []);
        
        if(isset($cart[$item->id])) {
            $cart[$item->id]['quantity'] += $request->qty;
        } else {
            $cart[$item->id] = [
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $request->qty,
                'image' => $item->image
            ];
        }
        
        session(['cart' => $cart]);
        return back()->with('success', 'Item berhasil ditambahkan ke cart');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session('cart', []);
        
        if(isset($cart[$request->id])) {
            $item = item::find($request->id);
            if($request->quantity > $item->stock) {
                return back()->with('error', 'Stock tidak mencukupi');
            }
            $cart[$request->id]['quantity'] = $request->quantity;
            session(['cart' => $cart]);
            return back()->with('success', 'Cart berhasil diupdate');
        }
        
        return back()->with('error', 'Item tidak ditemukan');
    }

    public function remove(Request $request)
    {
        $cart = session('cart', []);
        
        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session(['cart' => $cart]);
            return back()->with('success', 'Item berhasil dihapus dari cart');
        }
        
        return back()->with('error', 'Item tidak ditemukan');
    }
}

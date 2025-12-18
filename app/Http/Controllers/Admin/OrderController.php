<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = order::with(['user', 'orderItems.item'])
            ->latest()
            ->paginate(20);
            
        return view('admin.orders.index', compact('orders'));
    }

    public function show(order $order)
    {
        $order->load(['user', 'orderItems.item']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Order status updated successfully');
    }
}


<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->withCount('orders')
            ->latest()
            ->paginate(20);
            
        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        // Ensure it's a customer
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $customer->load(['orders.orderItems.item']);
        $totalOrders = $customer->orders()->count();
        $totalSpent = $customer->orders()->sum('total');
        
        return view('admin.customers.show', compact('customer', 'totalOrders', 'totalSpent'));
    }

    public function edit(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            'password' => 'nullable|string|min:8',
        ]);

        $customer->name = $validated['name'];
        $customer->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $customer->password = Hash::make($validated['password']);
        }
        
        $customer->save();

        return redirect()->route('admin.customers.show', $customer)->with('success', 'Customer updated successfully');
    }

    public function destroy(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully');
    }
}


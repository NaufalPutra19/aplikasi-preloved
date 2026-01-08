<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\order_item;
use App\Models\item;
use App\Models\ShippingRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|min:10|max:15',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_province' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|size:5',
            'notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:bank_transfer,cod,e_wallet',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        DB::beginTransaction();

        try {
            // Calculate subtotal
            $subtotal = 0;
            foreach ($cart as $productId => $details) {
                $product = item::findOrFail($productId);
                $quantity = $details['quantity'] ?? $details['qty'] ?? 1;
                $subtotal += $product->price * $quantity;
            }

            // Calculate shipping cost
            $shippingCost = $this->calculateShippingCost(
                $validated['shipping_city'],
                $validated['shipping_province']
            );

            $tax = 0;
            $totalAmount = $subtotal + $shippingCost + $tax;

            // Generate order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $orderNumber,
                'total_amount' => $totalAmount,
                'shipping_cost' => $shippingCost,
                'tax' => $tax,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => $validated['payment_method'],
                'shipping_name' => $validated['shipping_name'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_province' => $validated['shipping_province'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'shipping_phone' => $validated['shipping_phone'],
                'notes' => $validated['notes'],
            ]);

            // Create order items
            foreach ($cart as $productId => $details) {
                $product = item::findOrFail($productId);
                $quantity = $details['quantity'] ?? $details['qty'] ?? 1;
                
                order_item::create([
                    'order_id' => $order->id,
                    'item_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);

                // Update stock
                $product->decrement('stock', $quantity);
            }

            // Clear cart
            session()->forget('cart');

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully! Order number: ' . $orderNumber);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order. Please try again. Error: ' . $e->getMessage());
        }
    }

    /**
     * Calculate shipping cost based on destination
     */
    private function calculateShippingCost(string $destCity, string $destProvince): float
    {
        // Default origin (warehouse location)
        $originCity = 'Jakarta';
        $originProvince = 'DKI Jakarta';

        // Try to find shipping rate in database
        $shippingRate = ShippingRate::findByCities($originCity, $originProvince, $destCity, $destProvince);

        if ($shippingRate) {
            return (float) $shippingRate->calculateCost();
        }

        // Fallback to default calculation
        return $this->getDefaultShippingCost($destProvince);
    }

    /**
     * Get default shipping cost based on province
     */
    private function getDefaultShippingCost(string $destProvince): float
    {
        $shippingRates = [
            'DKI Jakarta' => 10000,
            'Jawa Barat' => 15000,
            'Jawa Tengah' => 25000,
            'Jawa Timur' => 35000,
            'Banten' => 13000,
            'Bali' => 40000,
            'Sumatera Utara' => 50000,
            'Sumatera Selatan' => 45000,
            'Sulawesi Selatan' => 60000,
            'Kalimantan Timur' => 55000,
        ];

        return $shippingRates[$destProvince] ?? 30000; // Default if not found
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = order::with(['orderItems.item'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['orderItems.item']);

        return view('orders.show', compact('order'));
    }

    public function confirmPayment(Request $request, order $order)
    {
        // Validasi ownership
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Validasi status pembayaran
        if ($order->payment_status === 'paid') {
            return redirect()->back()->with('error', 'Pembayaran sudah dikonfirmasi sebelumnya');
        }

        // Validasi payment method
        if ($order->payment_method === 'cod') {
            return redirect()->back()->with('error', 'COD tidak memerlukan konfirmasi pembayaran');
        }

        // Validasi input
        $validated = $request->validate([
            'reference_number' => 'required|string|max:255',
            'agree' => 'required|accepted'
        ], [
            'reference_number.required' => 'Nomor referensi harus diisi',
            'agree.required' => 'Anda harus menyetujui konfirmasi pembayaran'
        ]);

        // Update payment status
        $order->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
            'payment_reference' => $validated['reference_number'],
        ]);

        // Update escrow status jika metode e_wallet (rekening bersama)
        if ($order->payment_method === 'e_wallet') {
            $order->update([
                'escrow_status' => 'received',
                'escrow_confirmed_at' => now(),
            ]);
        }

        // Update order status menjadi processing
        if ($order->status === 'pending') {
            $order->update(['status' => 'processing']);
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi! Pesanan Anda akan segera diproses.');
    }

    public function confirmEscrowReceipt(Request $request, order $order)
    {
        // Validasi ownership
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Validasi metode pembayaran
        if ($order->payment_method !== 'e_wallet') {
            return redirect()->back()->with('error', 'Hanya berlaku untuk metode rekening bersama');
        }

        // Validasi status escrow
        if ($order->escrow_status === 'completed') {
            return redirect()->back()->with('error', 'Barang sudah dikonfirmasi diterima');
        }

        if ($order->escrow_status !== 'received') {
            return redirect()->back()->with('error', 'Dana belum dikonfirmasi diterima');
        }

        // Validasi input
        $validated = $request->validate([
            'receipt_confirmation' => 'required|accepted'
        ]);

        // Update escrow status ke completed (dana siap dirilis)
        $order->update([
            'escrow_status' => 'completed',
            'escrow_released_at' => now(),
            'escrow_notes' => 'Pembeli mengkonfirmasi barang diterima',
        ]);

        // Update order status ke delivered
        $order->update(['status' => 'delivered']);

        return redirect()->back()->with('success', 'Terima kasih! Barang dikonfirmasi diterima. Dana akan dilepaskan ke penjual.');
    }
}

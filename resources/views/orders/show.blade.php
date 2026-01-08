@extends('layouts.app')

@section('title', 'Order #'.$order->id.' - PreloveX')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i>Back to Orders
            </a>
            <h2 class="fw-bold mb-1">Order #{{ $order->id }}</h2>
            <p class="text-muted mb-0">Placed on {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
        @php
            $status = $order->status;
            $badge = match($status) {
                'pending' => 'bg-warning text-dark',
                'processing' => 'bg-info text-dark',
                'shipped' => 'bg-primary',
                'delivered' => 'bg-success',
                'cancelled' => 'bg-danger',
                default => 'bg-secondary',
            };
        @endphp
        <span class="badge {{ $badge }} px-3 py-2">{{ ucfirst($status) }}</span>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    @php $subtotal = $item->price * $item->quantity; @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->item->image ? asset('storage/'.$item->item->image) : 'https://via.placeholder.com/60' }}"
                                                     class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;" alt="">
                                                <div>
                                                    <div class="fw-semibold">{{ $item->item->name }}</div>
                                                    <small class="text-muted">SKU: {{ $item->item->sku }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp {{ number_format($item->price,0,',','.') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end fw-semibold">Rp {{ number_format($subtotal,0,',','.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-light">
                                    <th colspan="3" class="text-end">Total</th>
                                    <th class="text-end text-primary">Rp {{ number_format($order->total_amount,0,',','.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-bold">Order Info</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <div class="text-muted small">Order ID</div>
                        <div class="fw-semibold">#{{ $order->id }}</div>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted small">Date</div>
                        <div class="fw-semibold">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="mb-2">
                        <div class="text-muted small">Total</div>
                        <div class="fw-bold text-primary fs-5">Rp {{ number_format($order->total_amount,0,',','.') }}</div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-bold">Shipping</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <div class="text-muted small">Address</div>
                        <div class="fw-semibold">{{ $order->shipping_address }}</div>
                    </div>
                    @if($order->phone)
                        <div class="mb-2">
                            <div class="text-muted small">Phone</div>
                            <div>{{ $order->phone }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

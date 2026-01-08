@extends('layouts.app')
@section('title', 'Order Details')
@section('content')
<div class="container py-5">
    <!-- Success Alert -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Order Success Card -->
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm text-center py-5">
                <div class="card-body">
                    <div class="mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Order Placed Successfully!</h2>
                    <p class="text-muted mb-4">Thank you for your order. We'll process it shortly.</p>
                    
                    <div class="bg-light rounded p-4 d-inline-block">
                        <p class="text-muted small mb-2">Order Number</p>
                        <h3 class="fw-bold text-primary mb-0">{{ $order->order_number }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-lg-8 mb-4">
            <!-- Order Items -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-bag-check me-2"></i>Order Items
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : 'https://via.placeholder.com/60' }}" 
                                                 class="rounded me-3" 
                                                 style="width: 60px; height: 60px; object-fit: cover;"
                                                 alt="{{ $item->product_name }}">
                                            <div>
                                                <h6 class="mb-0">{{ $item->product_name }}</h6>
                                                <small class="text-muted">{{ $item->product->condition ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="align-middle text-center">
                                        <span class="badge bg-secondary">{{ $item->quantity }}</span>
                                    </td>
                                    <td class="align-middle text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Shipping Details -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-truck me-2"></i>Shipping Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted small text-uppercase mb-2">Recipient Name</h6>
                            <p class="mb-0 fw-semibold">{{ $order->shipping_name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted small text-uppercase mb-2">Phone Number</h6>
                            <p class="mb-0 fw-semibold">
                                <i class="bi bi-telephone me-1"></i>{{ $order->shipping_phone }}
                            </p>
                        </div>
                        <div class="col-12 mb-3">
                            <h6 class="text-muted small text-uppercase mb-2">Shipping Address</h6>
                            <p class="mb-0">
                                {{ $order->shipping_address }}<br>
                                {{ $order->shipping_city }}, {{ $order->shipping_province }}<br>
                                {{ $order->shipping_postal_code }}
                            </p>
                        </div>
                        @if($order->notes)
                        <div class="col-12">
                            <h6 class="text-muted small text-uppercase mb-2">Order Notes</h6>
                            <p class="mb-0 text-muted">{{ $order->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span>Rp {{ number_format($order->total_amount - $order->shipping_cost - $order->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        <span class="text-success">{{ $order->shipping_cost > 0 ? 'Rp ' . number_format($order->shipping_cost, 0, ',', '.') : 'Free' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Tax</span>
                        <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 fw-bold">Total</h5>
                        <h4 class="mb-0 text-primary fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h4>
                    </div>
                    
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Payment Method</span>
                            <span class="badge bg-info">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Payment Status</span>
                            <span class="badge bg-warning">{{ ucfirst($order->payment_status) }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Order Status</span>
                            <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-grid gap-2">
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                </a>
                <a href="{{ route('orders.index') }}" class="btn btn-primary">
                    <i class="bi bi-list-ul me-2"></i>View All Orders
                </a>
            </div>

            <!-- Payment Instructions -->
            @if($order->payment_method == 'bank_transfer' && $order->payment_status == 'unpaid')
            <div class="card border-warning mt-3">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-info-circle text-warning me-2"></i>Payment Instructions
                    </h6>
                    <p class="small mb-2">Please transfer to:</p>
                    <div class="bg-light p-3 rounded mb-2">
                        <p class="mb-1 small text-muted">Bank BCA</p>
                        <p class="mb-1 fw-bold">1234567890</p>
                        <p class="mb-0 small">a/n PreLoveX</p>
                    </div>
                    <p class="small text-muted mb-0">
                        <i class="bi bi-clock me-1"></i>Complete payment within 24 hours
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
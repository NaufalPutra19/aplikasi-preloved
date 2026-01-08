@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left me-2"></i>Back to Orders
    </a>
    <h2 class="fw-bold">Order Details #{{ $order->id }}</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Order Items</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item->item->image ? asset('storage/'.$item->item->image) : 'https://via.placeholder.com/50' }}" 
                                             class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                                        <div>
                                            <div class="fw-semibold">{{ $item->item->name }}</div>
                                            <small class="text-muted">SKU: {{ $item->item->sku }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="fw-semibold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <th colspan="3" class="text-end">Total:</th>
                                <th class="text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Order Information -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Order Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Order ID</label>
                    <div class="fw-semibold">#{{ $order->id }}</div>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Order Date</label>
                    <div class="fw-semibold">{{ $order->created_at->format('d M Y, H:i') }}</div>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Status</label>
                    <div>
                        @if($order->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($order->status == 'processing')
                            <span class="badge bg-info">Processing</span>
                        @elseif($order->status == 'shipped')
                            <span class="badge bg-primary">Shipped</span>
                        @elseif($order->status == 'delivered')
                            <span class="badge bg-success">Delivered</span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                        @endif
                    </div>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Total Amount</label>
                    <div class="fw-bold text-primary fs-5">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Customer Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Name</label>
                    <div class="fw-semibold">{{ $order->user->name }}</div>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Email</label>
                    <div>{{ $order->user->email }}</div>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Shipping Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Address</label>
                    <div class="fw-semibold">{{ $order->shipping_address }}</div>
                </div>
                @if($order->phone)
                <div class="mb-3">
                    <label class="text-muted small">Phone</label>
                    <div>{{ $order->phone }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Update Status -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Update Status</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle me-2"></i>Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


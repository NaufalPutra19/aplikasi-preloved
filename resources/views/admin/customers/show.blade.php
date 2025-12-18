@extends('layouts.admin')

@section('title', 'Customer Details')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left me-2"></i>Back to Customers
    </a>
    <h2 class="fw-bold">Customer Details</h2>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Customer Info -->
        <div class="card mb-4">
            <div class="card-body text-center">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="bi bi-person fs-1"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $customer->name }}</h4>
                <p class="text-muted mb-3">{{ $customer->email }}</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Customer
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Statistics</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Total Orders</label>
                    <div class="fw-bold fs-4 text-primary">{{ $totalOrders }}</div>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Total Spent</label>
                    <div class="fw-bold fs-4 text-success">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
                </div>
                <div>
                    <label class="text-muted small">Member Since</label>
                    <div class="fw-semibold">{{ $customer->created_at->format('d M Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Order History -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Order History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customer->orders as $order)
                            <tr>
                                <td><code>#{{ $order->id }}</code></td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>{{ $order->orderItems->count() }} item(s)</td>
                                <td class="fw-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td>
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
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No orders yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


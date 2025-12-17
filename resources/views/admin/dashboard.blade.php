@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Dashboard</h2>
    <div class="text-muted">
        <i class="bi bi-calendar3 me-2"></i>{{ now()->format('l, d F Y') }}
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Products</p>
                        <h3 class="fw-bold mb-0">{{ $totalProducts }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                        <i class="bi bi-box-seam fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Orders</p>
                        <h3 class="fw-bold mb-0">{{ $totalOrders }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                        <i class="bi bi-cart-check fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Customers</p>
                        <h3 class="fw-bold mb-0">{{ $totalUsers }}</h3>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info rounded-3 p-3">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Pending Orders</p>
                        <h3 class="fw-bold mb-0">{{ $pendingOrders }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                        <i class="bi bi-clock-history fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Orders -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-receipt me-2"></i>Recent Orders</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td class="fw-semibold">#{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td class="text-primary fw-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $order->created_at->diffForHumans() }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No orders yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0 text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>Low Stock Alert
                </h5>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @forelse($lowStockItems as $item)
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                    <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://via.placeholder.com/50' }}" 
                         class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                    <div class="flex-grow-1">
                        <p class="mb-1 fw-semibold">{{ Str::limit($item->name, 30) }}</p>
                        <small class="text-danger">
                            <i class="bi bi-box me-1"></i>Stock: {{ $item->stock }}
                        </small>
                    </div>
                </div>
                @empty
                <p class="text-center text-muted py-4">All items are well stocked!</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
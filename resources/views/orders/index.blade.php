@extends('layouts.app')

@section('title', 'My Orders - PreloveX')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold mb-1">My Orders</h2>
            <p class="text-muted mb-0">Track your recent purchases</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">Continue Shopping</a>
    </div>

    @include('partials.flash')

    @if($orders->isEmpty())
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-bag-x fs-1 text-muted"></i>
                </div>
                <h5 class="fw-bold">No orders yet</h5>
                <p class="text-muted mb-3">Start shopping to place your first order.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Browse Products</a>
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach($orders as $order)
                <div class="col-12">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-light text-dark me-2">#{{ $order->id }}</span>
                                    <strong>Rp {{ number_format($order->total_amount,0,',','.') }}</strong>
                                </div>
                                <div class="text-muted small mb-1">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </div>
                                <div class="text-muted small">
                                    {{ $order->orderItems->count() }} item(s)
                                </div>
                            </div>
                            <div class="text-end">
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
                                <span class="badge {{ $badge }} mb-2">{{ ucfirst($status) }}</span>
                                <div>
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection

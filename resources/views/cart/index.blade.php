@extends('layouts.app')
@section('title', 'Shopping Cart')
@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">
        <i class="bi bi-cart3 me-2"></i>Shopping Cart
    </h2>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(!empty($cartItems))
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Subtotal</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $id => $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item['product']->image ? asset('storage/'.$item['product']->image) : 'https://via.placeholder.com/80' }}" 
                                                 class="rounded me-3" 
                                                 style="width: 80px; height: 80px; object-fit: cover;"
                                                 alt="{{ $item['product']->name }}">
                                            <div>
                                                <h6 class="mb-1">{{ $item['product']->name }}</h6>
                                                <small class="text-muted">{{ $item['product']->condition }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="price-display">
                                            <div style="font-size: 0.85rem; color: #0066cc; font-weight: 600;">Rp</div>
                                            <div style="font-size: 1rem; color: #0066cc; font-weight: 700;">{{ number_format($item['product']->price, 0, ',', '.') }}</div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $id }}">
                                            <div class="input-group input-group-sm" style="width: 120px; margin: 0 auto;">
                                                <button type="button" class="btn btn-outline-secondary btn-minus" data-id="{{ $id }}">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" 
                                                       name="quantity" 
                                                       class="form-control text-center quantity-input" 
                                                       value="{{ $item['quantity'] }}" 
                                                       min="1" 
                                                       max="{{ $item['product']->stock }}"
                                                       data-id="{{ $id }}">
                                                <button type="button" class="btn btn-outline-secondary btn-plus" data-id="{{ $id }}">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="align-middle text-center fw-bold">
                                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </td>
                                    <td class="align-middle text-center">
                                        <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $id }}">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remove this item?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                </a>
                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Clear all items from cart?')">
                        <i class="bi bi-x-circle me-2"></i>Clear Cart
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fw-bold">Cart Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span class="text-success">Free</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax</span>
                        <span>Rp 0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Total</h5>
                        <h4 class="mb-0 text-primary fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</h4>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 btn-lg">
                        <i class="bi bi-check-circle me-2"></i>Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-cart-x" style="font-size: 5rem; color: #ddd;"></i>
        <h3 class="mt-3">Your cart is empty</h3>
        <p class="text-muted">Add some products to your cart to continue shopping</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
            <i class="bi bi-bag me-2"></i>Start Shopping
        </a>
    </div>
    @endif
</div>

@push('scripts')
<script>
    // Update quantity with plus/minus buttons
    document.querySelectorAll('.btn-plus').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
            const max = parseInt(input.max);
            const current = parseInt(input.value);
            
            if (current < max) {
                input.value = current + 1;
                input.form.submit();
            }
        });
    });

    document.querySelectorAll('.btn-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
            const current = parseInt(input.value);
            
            if (current > 1) {
                input.value = current - 1;
                input.form.submit();
            }
        });
    });

    // Update on input change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>
@endpush
@endsection
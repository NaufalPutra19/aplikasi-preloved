@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Left Side - Shipping Details -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-truck text-primary me-2"></i>Shipping Details
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('checkout.store') }}" id="checkoutForm">
                        @csrf

                        <!-- Contact Information -->
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted mb-3 fw-semibold">
                                <i class="bi bi-person-circle me-2"></i>Contact Information
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="shipping_name" class="form-label fw-semibold">
                                        Full Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg @error('shipping_name') is-invalid @enderror" 
                                           id="shipping_name" 
                                           name="shipping_name" 
                                           value="{{ old('shipping_name', auth()->user()->name ?? '') }}"
                                           placeholder="John Doe"
                                           required>
                                    @error('shipping_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="shipping_phone" class="form-label fw-semibold">
                                        Phone Number <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="tel" 
                                               class="form-control @error('shipping_phone') is-invalid @enderror" 
                                               id="shipping_phone" 
                                               name="shipping_phone" 
                                               value="{{ old('shipping_phone') }}"
                                               placeholder="08xxxxxxxxxx"
                                               required>
                                        @error('shipping_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Shipping Address -->
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted mb-3 fw-semibold">
                                <i class="bi bi-geo-alt me-2"></i>Shipping Address
                            </h6>
                            
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label fw-semibold">
                                    Street Address <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control form-control-lg @error('shipping_address') is-invalid @enderror" 
                                          id="shipping_address" 
                                          name="shipping_address" 
                                          rows="3"
                                          placeholder="Street name, building number, apartment/unit..."
                                          required>{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="shipping_city" class="form-label fw-semibold">
                                        City <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg @error('shipping_city') is-invalid @enderror" 
                                           id="shipping_city" 
                                           name="shipping_city" 
                                           value="{{ old('shipping_city') }}"
                                           placeholder="e.g., Jakarta"
                                           required>
                                    @error('shipping_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="shipping_province" class="form-label fw-semibold">
                                        Province <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-select-lg @error('shipping_province') is-invalid @enderror" 
                                            id="shipping_province" 
                                            name="shipping_province"
                                            required>
                                        <option value="">Select Province</option>
                                        <option value="DKI Jakarta" {{ old('shipping_province') == 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                                        <option value="Jawa Barat" {{ old('shipping_province') == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                                        <option value="Jawa Tengah" {{ old('shipping_province') == 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                                        <option value="Jawa Timur" {{ old('shipping_province') == 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                                        <option value="Banten" {{ old('shipping_province') == 'Banten' ? 'selected' : '' }}>Banten</option>
                                        <option value="Bali" {{ old('shipping_province') == 'Bali' ? 'selected' : '' }}>Bali</option>
                                        <option value="Sumatera Utara" {{ old('shipping_province') == 'Sumatera Utara' ? 'selected' : '' }}>Sumatera Utara</option>
                                        <option value="Sumatera Selatan" {{ old('shipping_province') == 'Sumatera Selatan' ? 'selected' : '' }}>Sumatera Selatan</option>
                                        <option value="Sulawesi Selatan" {{ old('shipping_province') == 'Sulawesi Selatan' ? 'selected' : '' }}>Sulawesi Selatan</option>
                                        <option value="Kalimantan Timur" {{ old('shipping_province') == 'Kalimantan Timur' ? 'selected' : '' }}>Kalimantan Timur</option>
                                    </select>
                                    @error('shipping_province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="shipping_postal_code" class="form-label fw-semibold">
                                        Postal Code <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg @error('shipping_postal_code') is-invalid @enderror" 
                                           id="shipping_postal_code" 
                                           name="shipping_postal_code" 
                                           value="{{ old('shipping_postal_code') }}"
                                           placeholder="12345"
                                           maxlength="5"
                                           required>
                                    @error('shipping_postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Additional Notes -->
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted mb-3 fw-semibold">
                                <i class="bi bi-chat-left-text me-2"></i>Additional Information
                            </h6>
                            
                            <div class="mb-3">
                                <label for="notes" class="form-label fw-semibold">
                                    Order Notes <span class="text-muted small">(Optional)</span>
                                </label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" 
                                          name="notes" 
                                          rows="3"
                                          placeholder="Any special instructions for your order?">{{ old('notes') }}</textarea>
                                @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted mb-3 fw-semibold">
                                <i class="bi bi-credit-card me-2"></i>Payment Method
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check border rounded p-3 h-100">
                                        <input class="form-check-input" type="radio" name="payment_method" id="payment_transfer" value="bank_transfer" checked>
                                        <label class="form-check-label w-100" for="payment_transfer">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-bank fs-4 text-primary me-3"></i>
                                                <div>
                                                    <strong>Bank Transfer</strong>
                                                    <p class="text-muted small mb-0">Pay via bank transfer</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check border rounded p-3 h-100">
                                        <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" value="cod">
                                        <label class="form-check-label w-100" for="payment_cod">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-cash-coin fs-4 text-success me-3"></i>
                                                <div>
                                                    <strong>Cash on Delivery</strong>
                                                    <p class="text-muted small mb-0">Pay when received</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button (Mobile) -->
                        <div class="d-lg-none">
                            <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                                <i class="bi bi-check-circle me-2"></i>Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Side - Order Summary -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-receipt me-2"></i>Order Summary
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Cart Items -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted mb-3 fw-semibold">Items in Cart</h6>
                        
                        @php
                            $cart = session('cart', []);
                            $subtotal = 0;
                        @endphp

                        @forelse($cart as $productId => $details)
                            @php
                                $product = \App\Models\item::find($productId);
                                if (!$product) continue;
                                
                                $quantity = $details['quantity'] ?? $details['qty'] ?? 1;
                                $itemTotal = $product->price * $quantity;
                                $subtotal += $itemTotal;
                            @endphp
                            
                            <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/60' }}" 
                                     class="rounded me-3" 
                                     alt="{{ $product->name }}"
                                     style="width: 60px; height: 60px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $product->name }}</h6>
                                    <p class="text-muted small mb-0">
                                        {{ $quantity }}x @ Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <strong>Rp {{ number_format($itemTotal, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-3">
                                <i class="bi bi-cart-x fs-1 d-block mb-2"></i>
                                <p>Your cart is empty</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Order Calculation -->
                    @if(count($cart) > 0)
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Items Subtotal</span>
                            <span id="subtotalDisplay">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            <input type="hidden" id="subtotalValue" value="{{ $subtotal }}">
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping Cost</span>
                            <div>
                                <span id="shippingDisplay" class="text-success">Calculating...</span>
                                <input type="hidden" id="shippingValue" value="0">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tax</span>
                            <span>Rp 0</span>
                        </div>
                        <hr class="my-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Grand Total</h5>
                            <h4 class="mb-0 text-primary fw-bold" id="totalDisplay">Rp {{ number_format($subtotal, 0, ',', '.') }}</h4>
                            <input type="hidden" id="totalValue" value="{{ $subtotal }}">
                        </div>
                    </div>

                    <!-- Place Order Button (Desktop) -->
                    <div class="d-none d-lg-block mt-4">
                        <button type="submit" form="checkoutForm" class="btn btn-primary btn-lg w-100 shadow-sm">
                            <i class="bi bi-check-circle me-2"></i>Place Order
                        </button>
                    </div>

                    <!-- Security Badge -->
                    <div class="mt-3 p-3 bg-light rounded text-center">
                        <i class="bi bi-shield-check text-success fs-4"></i>
                        <p class="small text-muted mb-0 mt-2">
                            Your payment information is secure and encrypted
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Return to Cart -->
            <div class="text-center mt-3">
                <a href="{{ route('cart.index') }}" class="text-muted text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Return to Cart
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .form-check:has(input:checked) {
        border-color: #0d6efd !important;
        background-color: #f8f9ff;
    }

    @media (max-width: 991px) {
        .sticky-top {
            position: relative !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const subtotal = parseFloat(document.getElementById('subtotalValue').value);
    const cityInput = document.getElementById('shipping_city');
    const provinceInput = document.getElementById('shipping_province');

    /**
     * Calculate shipping cost based on city and province
     */
    async function calculateShipping() {
        const city = cityInput.value.trim();
        const province = provinceInput.value.trim();

        if (!city || !province) {
            document.getElementById('shippingDisplay').textContent = 'Enter city & province';
            document.getElementById('shippingValue').value = 0;
            updateTotal();
            return;
        }

        try {
            document.getElementById('shippingDisplay').textContent = 'Calculating...';
            
            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
                console.error('CSRF token not found');
                document.getElementById('shippingDisplay').textContent = 'Error: Security token missing';
                return;
            }
            
            const response = await fetch('/api/shipping/calculate-cost', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    destination_city: city,
                    destination_province: province,
                })
            });

            // Check if response is ok
            if (!response.ok) {
                console.error(`HTTP Error: ${response.status}`);
                
                // Try to get error from response
                const errorData = await response.json().catch(() => ({}));
                console.error('Error response:', errorData);
                
                // Use fallback calculation
                await useFallbackShipping(city, province);
                return;
            }

            const data = await response.json();

            if (data.success) {
                document.getElementById('shippingValue').value = data.cost;
                document.getElementById('shippingDisplay').innerHTML = 
                    `<span class="text-success">${data.cost_formatted}</span><br><small class="text-muted">${data.distance}</small>`;
                updateTotal();
            } else {
                console.error('API returned success:false', data);
                // Try fallback
                await useFallbackShipping(city, province);
            }
        } catch (error) {
            console.error('Error calculating shipping:', error);
            console.error('Error message:', error.message);
            console.error('Error stack:', error.stack);
            
            // Try fallback calculation
            await useFallbackShipping(city, province);
        }
    }

    /**
     * Fallback shipping calculation using province-based rates
     */
    async function useFallbackShipping(city, province) {
        const provincePrices = {
            'DKI Jakarta': 10000,
            'Jawa Barat': 15000,
            'Jawa Tengah': 25000,
            'Jawa Timur': 35000,
            'Banten': 13000,
            'Bali': 40000,
            'Sumatera Utara': 50000,
            'Sumatera Selatan': 45000,
            'Sulawesi Selatan': 60000,
            'Kalimantan Timur': 55000,
        };

        const cost = provincePrices[province] || 30000;
        
        document.getElementById('shippingValue').value = cost;
        document.getElementById('shippingDisplay').innerHTML = 
            `<span class="text-success">Rp ${formatCurrency(cost)}</span><br><small class="text-muted">Standard rate</small>`;
        updateTotal();
        
        console.log(`Using fallback rate: Rp ${cost} for ${city}, ${province}`);
    }

    /**
     * Update total amount
     */
    function updateTotal() {
        const shipping = parseFloat(document.getElementById('shippingValue').value) || 0;
        const total = subtotal + shipping;
        
        document.getElementById('totalValue').value = total;
        document.getElementById('totalDisplay').textContent = 'Rp ' + formatCurrency(total);
    }

    /**
     * Format number as currency
     */
    function formatCurrency(num) {
        return new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }).format(num);
    }

    // Add event listeners for shipping calculation
    cityInput.addEventListener('change', calculateShipping);
    provinceInput.addEventListener('change', calculateShipping);
    cityInput.addEventListener('blur', calculateShipping);

    // Auto-format phone number
    document.getElementById('shipping_phone').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 13) value = value.substr(0, 13);
        e.target.value = value;
    });

    // Auto-format postal code
    document.getElementById('shipping_postal_code').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 5) value = value.substr(0, 5);
        e.target.value = value;
    });

    // Form validation
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const phone = document.getElementById('shipping_phone').value;
        const postal = document.getElementById('shipping_postal_code').value;

        if (phone.length < 10) {
            e.preventDefault();
            alert('Please enter a valid phone number (min 10 digits)');
            return false;
        }

        if (postal.length !== 5) {
            e.preventDefault();
            alert('Postal code must be 5 digits');
            return false;
        }
    });

    // Calculate shipping on page load if city/province already set
    window.addEventListener('load', function() {
        if (cityInput.value && provinceInput.value) {
            calculateShipping();
        }
    });
</script>
@endpush
@endsection
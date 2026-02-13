@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col-md-6">
    <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/600' }}" class="img-fluid rounded">
  </div>
  <div class="col-md-6">
    <h2>{{ $product->name }}</h2>
    <div class="currency mb-3">
      <span class="currency-label">Rp</span>
      <span class="currency-amount">{{ number_format($product->price,0,',','.') }}</span>
      @if($product->unit)
      <span class="text-muted h6">/ {{ $product->unit->symbol ?? $product->unit->name }}</span>
      @endif
    </div>
    <p class="text-muted">Condition: {{ $product->condition }}</p>
    @if($product->unit)
    <p class="text-muted">
      <i class="bi bi-box-seam"></i> <strong>Unit:</strong> {{ $product->unit->name }}
      @if($product->unit->symbol)
      ({{ $product->unit->symbol }})
      @endif
    </p>
    @endif
    <p>{{ $product->description }}</p>
    <form action="{{ route('cart.add') }}" method="POST" id="addToCartForm">
      @csrf
      <input type="hidden" name="product_id" value="{{ $product->id }}">
      <div class="mb-3">
        <label>Quantity @if($product->unit)({{ $product->unit->symbol ?? $product->unit->name }})@endif</label>
        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control w-25">
        <small class="text-muted">Stock: {{ $product->stock }} @if($product->unit){{ $product->unit->symbol ?? $product->unit->name }}@endif</small>
      </div>
      <button type="button" class="btn btn-primary" onclick="handleAddToCart(event)">Add to Cart</button>
    </form>

    <!-- Login Required Modal -->
    <div class="modal fade" id="loginRequiredModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-xl" style="border-radius: 1.5rem; overflow: hidden;">
          <!-- Header with gradient -->
          <div class="modal-header border-0" style="background: linear-gradient(135deg, #fd7e14 0%, #fc6c26 100%); padding: 2rem 2rem 1.5rem;">
            <div class="d-flex align-items-center w-100">
              <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                <i class="bi bi-exclamation-triangle-fill text-white" style="font-size: 1.5rem;"></i>
              </div>
              <h5 class="modal-title fw-bold text-white mb-0">Login Required</h5>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="opacity: 0.8;"></button>
          </div>

          <!-- Body with animation -->
          <div class="modal-body text-center py-5" style="animation: slideUp 0.5s ease-out;">
            <div style="margin-bottom: 2rem; animation: bounceIn 0.7s ease-out;">
              <svg width="120" height="120" viewBox="0 0 120 120" style="margin: 0 auto; display: block;">
                <rect x="35" y="50" width="50" height="60" rx="8" fill="none" stroke="#fd7e14" stroke-width="3"/>
                <path d="M 50 50 Q 50 30 60 30 Q 70 30 70 50" fill="none" stroke="#fd7e14" stroke-width="3"/>
                <circle cx="60" cy="72" r="4" fill="#fd7e14"/>
              </svg>
            </div>

            <h4 class="fw-bold mb-2" style="color: #212529; font-size: 1.5rem;">Harus Login dahulu ketika mau checkout</h4>
            <p class="text-muted" style="font-size: 0.95rem; margin-bottom: 0;">Silahkan login terlebih dahulu untuk melanjutkan berbelanja dan checkout</p>
          </div>

          <!-- Footer -->
          <div class="modal-footer border-top border-light-subtle bg-light bg-opacity-50" style="padding: 1.5rem;">
            <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 0.5rem; border: none; background-color: #6c757d; font-weight: 500; transition: all 0.3s ease;">
              <i class="bi bi-x-lg me-2"></i>Cancel
            </button>
            <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2" style="border-radius: 0.5rem; border: none; background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); font-weight: 500; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);">
              <i class="bi bi-box-arrow-in-right me-2"></i>Go to Login
            </a>
          </div>
        </div>
      </div>
    </div>

    <style>
      @keyframes slideUp {
        from {
          transform: translateY(20px);
          opacity: 0;
        }
        to {
          transform: translateY(0);
          opacity: 1;
        }
      }

      @keyframes bounceIn {
        0% {
          transform: scale(0.3);
          opacity: 0;
        }
        50% {
          opacity: 1;
        }
        70% {
          transform: scale(1.05);
        }
        100% {
          transform: scale(1);
        }
      }

      #loginRequiredModal .btn-secondary:hover {
        background-color: #5c636a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3) !important;
      }

      #loginRequiredModal .btn-primary:hover {
        background: linear-gradient(135deg, #0a58ca 0%, #084298 100%) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4) !important;
      }

      #loginRequiredModal .modal-content {
        animation: modalSlideIn 0.4s ease-out;
      }

      @keyframes modalSlideIn {
        from {
          transform: scale(0.95);
          opacity: 0;
        }
        to {
          transform: scale(1);
          opacity: 1;
        }
      }
    </style>

    <script>
      function handleAddToCart(event) {
        event.preventDefault();
        
        @if(auth()->check())
          // User is logged in, submit the form
          document.getElementById('addToCartForm').submit();
        @else
          // User is not logged in, show modal
          const modal = new bootstrap.Modal(document.getElementById('loginRequiredModal'));
          modal.show();
        @endif
      }
    </script>
  </div>
</div>
@endsection
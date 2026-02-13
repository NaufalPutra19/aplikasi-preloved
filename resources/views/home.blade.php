@extends('layouts.app')

@section('content')
<style>
    .hero-content {
        animation: slideInLeft 0.6s ease-out;
    }

    .hero-image {
        animation: slideInRight 0.6s ease-out;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }
    }

    @media (max-width: 576px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
    }

    .section-title {
        position: relative;
        margin-top: 3rem;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
    }

    .section-title h3 {
        font-weight: 700;
        font-size: 1.75rem;
        color: #212529;
        animation: slideInLeft 0.6s ease-out;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 4px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border-radius: 2px;
    }

    .product-card {
        animation: fadeIn 0.6s ease-out;
        animation-fill-mode: both;
    }

    .product-card:nth-child(1) { animation-delay: 0.1s; }
    .product-card:nth-child(2) { animation-delay: 0.2s; }
    .product-card:nth-child(3) { animation-delay: 0.3s; }
    .product-card:nth-child(4) { animation-delay: 0.4s; }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        animation: slideInUp 0.6s ease-out;
    }

    .empty-state-icon {
        font-size: 3rem;
        opacity: 0.3;
        margin-bottom: 1rem;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }
</style>

<!-- Hero Section -->
<div class="row align-items-center hero-section">
    <div class="col-md-6 hero-content">
        <h1 class="mb-3" style="font-weight: 700; font-size: 2.5rem;">Find Your Next Treasure</h1>
        <p class="lead mb-4" style="opacity: 0.9;">Premium preloved items curated with care for the conscious shopper.</p>
        <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
            <i class="bi bi-search me-2"></i>Shop Now
        </a>
    </div>
</div>

<!-- New Arrivals Section -->
<div class="section-title">
    <h3><i class="bi bi-star me-2"></i>New Arrivals</h3>
</div>

@forelse($products as $p)
    @if($loop->first)
        <div class="product-grid">
    @endif
    
    <div class="card product-card h-100 hover-lift">
        <div style="position: relative; overflow: hidden; height: 250px;">
            <img src="{{ $p->image ? asset('storage/'.$p->image) : 'https://via.placeholder.com/400x250?text=Product' }}" 
                 class="card-img-top" alt="{{ $p->name }}" style="transition: transform 0.3s ease; height: 100%; object-fit: cover;">
            @if($p->condition)
                <span class="badge badge-condition position-absolute top-2 end-2" style="background-color: var(--primary); color: white;">
                    {{ $p->condition }}
                </span>
            @endif
        </div>
        <div class="card-body">
            <h5 class="card-title" style="font-weight: 600; color: #212529;">{{ Str::limit($p->name, 40) }}</h5>
            <div class="currency mb-3">
                <span class="currency-label">Rp</span>
                <span class="currency-amount">{{ number_format($p->price, 0, ',', '.') }}</span>
            </div>
            @if($p->category)
                <span class="badge bg-light text-dark mb-3">{{ $p->category->name }}</span>
            @endif
            <a href="{{ route('products.show', $p) }}" class="btn btn-primary btn-sm w-100">
                <i class="bi bi-eye me-1"></i>View Details
            </a>
        </div>
    </div>

    @if($loop->last)
        </div>
    @endif
@empty
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="bi bi-inbox"></i>
        </div>
        <p class="text-muted" style="font-size: 1.1rem; margin-top: 1rem;">No products available at the moment.</p>
        <p class="text-muted" style="font-size: 0.95rem;">Check back soon for more treasures!</p>
    </div>
@endforelse
@endsection

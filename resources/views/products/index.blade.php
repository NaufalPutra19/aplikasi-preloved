@extends('layouts.app')
@section('title','Catalog')
@section('content')
<h2 class="mb-4 fw-bold">Product Catalog</h2>

<!-- Search and Filter Section -->
<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('products.index') }}" class="row g-3">
      <!-- Search Bar -->
      <div class="col-md-6">
        <label for="search" class="form-label">Search Product</label>
        <input type="text" name="search" id="search" class="form-control" 
               placeholder="Search by product name..." value="{{ request('search') }}">
      </div>
      
      <!-- Category Filter -->
      <div class="col-md-6">
        <label for="category" class="form-label">Filter by Category</label>
        <select name="category" id="category" class="form-select">
          <option value="">All Categories</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>
              {{ $cat->name }}
            </option>
          @endforeach
        </select>
      </div>
      
      <!-- Buttons -->
      <div class="col-12">
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-search"></i> Search
        </button>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-clockwise"></i> Reset
        </a>
      </div>
    </form>
  </div>
</div>

<!-- Results Info -->
@if(request('search') || request('category'))
  <div class="alert alert-info mb-3">
    <strong>Hasil Pencarian:</strong><br>
    @if(request('search'))
      🔍 Produk dengan nama "<strong>{{ request('search') }}</strong>"
    @endif
    @if(request('search') && request('category'))
      dan 
    @endif
    @if(request('category'))
      dari kategori "<strong>
      @php
        $selectedCat = $categories->firstWhere('id', request('category'));
        echo $selectedCat?->name ?? 'Kategori tidak ditemukan';
      @endphp
      </strong>"
    @endif
    <br>
    <span class="text-muted small">Total: <strong>{{ $products->total() }}</strong> produk ditemukan</span>
  </div>
@endif

<div class="row">
  @forelse($products as $p)
  <div class="col-md-3 mb-4">
    <div class="card h-100">
      <img src="{{ $p->image ? asset('storage/'.$p->image) : 'https://via.placeholder.com/400' }}" class="card-img-top" alt="">
      <div class="card-body">
        <h5 class="card-title">{{ $p->name }}</h5>
        <div class="currency-small mb-2">
          <span class="currency-label">Rp</span>
          <span class="currency-amount">{{ number_format($p->price,0,',','.') }}</span>
          @if($p->unit)
          <span class="text-muted small">/ {{ $p->unit->symbol ?? $p->unit->name }}</span>
          @endif
        </div>
        <p class="text-muted small">Condition: {{ $p->condition }}</p>
        @if($p->unit)
        <p class="text-muted small">
          <i class="bi bi-box"></i> Unit: {{ $p->unit->name }}
        </p>
        @endif
        <a href="{{ route('products.show',$p) }}" class="btn btn-outline-primary btn-sm">View</a>
      </div>
    </div>
  </div>
  @empty
    <div class="col-12">
      <div class="alert alert-warning">
        <i class="bi bi-info-circle"></i> No products found. Try adjusting your search or filter.
      </div>
    </div>
  @endforelse
</div>

<div class="d-flex justify-content-between align-items-center mt-4">
    <!-- Previous Button -->
    @if($products->onFirstPage())
        <button class="btn btn-sm btn-outline-secondary" disabled>
            <i class="bi bi-chevron-left"></i> Previous
        </button>
    @else
        <a href="{{ $products->previousPageUrl() }}&search={{ request('search') }}&category={{ request('category') }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-chevron-left"></i> Previous
        </a>
    @endif

    <!-- Page Info -->
    <div class="text-muted small">
        Page {{ $products->currentPage() }} of {{ $products->lastPage() }} 
        <span class="ms-2">({{ $products->total() }} items)</span>
    </div>

    <!-- Next Button -->
    @if($products->hasMorePages())
        <a href="{{ $products->nextPageUrl() }}&search={{ request('search') }}&category={{ request('category') }}" class="btn btn-sm btn-outline-primary">
            Next <i class="bi bi-chevron-right"></i>
        </a>
    @else
        <button class="btn btn-sm btn-outline-secondary" disabled>
            Next <i class="bi bi-chevron-right"></i>
        </button>
    @endif
</div>

@endsection
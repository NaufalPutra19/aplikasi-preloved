@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col-md-6">
    <h1>Find Your Next Treasure</h1>
    <p>Premium preloved items curated with care.</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary">Shop Now</a>
  </div>
  <div class="col-md-6">
    <img src="https://i.ibb.co/4p3pGYR/minimal-bag.jpg" class="img-fluid rounded">
  </div>
</div>
<hr>
<h3>New Arrivals</h3>
<div class="row">
  @forelse($products as $p)
  <div class="col-md-3 mb-4">
    <div class="card h-100">
      <img src="{{ $p->image ? asset('storage/'.$p->image) : 'https://via.placeholder.com/400' }}" class="card-img-top" alt="">
      <div class="card-body">
        <h5 class="card-title">{{ $p->name }}</h5>
        <p class="text-primary fw-bold">Rp {{ number_format($p->price,0,',','.') }}</p>
        <a href="{{ route('products.show',$p) }}" class="btn btn-outline-primary btn-sm">View</a>
      </div>
    </div>
  </div>
  @empty
  <div class="col-12">
    <p class="text-muted">No products available at the moment.</p>
  </div>
  @endforelse
</div>
@endsection

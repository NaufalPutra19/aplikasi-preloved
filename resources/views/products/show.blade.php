@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col-md-6">
    <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/600' }}" class="img-fluid rounded">
  </div>
  <div class="col-md-6">
    <h2>{{ $product->name }}</h2>
    <p class="text-primary h4">
      Rp {{ number_format($product->price,0,',','.') }}
      @if($product->unit)
      <span class="text-muted h6">/ {{ $product->unit->symbol ?? $product->unit->name }}</span>
      @endif
    </p>
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
    <form action="{{ route('cart.add') }}" method="POST">
      @csrf
      <input type="hidden" name="product_id" value="{{ $product->id }}">
      <div class="mb-3">
        <label>Quantity @if($product->unit)({{ $product->unit->symbol ?? $product->unit->name }})@endif</label>
        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control w-25">
        <small class="text-muted">Stock: {{ $product->stock }} @if($product->unit){{ $product->unit->symbol ?? $product->unit->name }}@endif</small>
      </div>
      <button class="btn btn-primary">Add to Cart</button>
    </form>
  </div>
</div>
@endsection
@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col-md-6">
    <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/600' }}" class="img-fluid rounded">
  </div>
  <div class="col-md-6">
    <h2>{{ $product->name }}</h2>
    <p class="text-primary h4">Rp {{ number_format($product->price,0,',','.') }}</p>
    <p class="text-muted">Condition: {{ $product->condition }}</p>
    <p>{{ $product->description }}</p>
    <form action="{{ route('cart.add') }}" method="POST">
      @csrf
      <input type="hidden" name="item_id" value="{{ $product->id }}">
      <div class="mb-3">
        <label>Quantity</label>
        <input type="number" name="qty" value="1" min="1" max="{{ $product->stock }}" class="form-control w-25">
      </div>
      <button class="btn btn-primary">Add to Cart</button>
    </form>
  </div>
</div>
@endsection

@extends('layouts.app')
@section('content')
<h3>Checkout</h3>
<form method="post" action="{{ route('checkout.store') }}">
  @csrf
  <div class="mb-3">
    <label>Shipping Address</label>
    <textarea name="shipping_address" class="form-control" required></textarea>
  </div>
  <div class="mb-3">
    <label>Phone</label>
    <input type="text" name="phone" class="form-control" required>
  </div>
  <button class="btn btn-primary">Place Order</button>
</form>
@endsection

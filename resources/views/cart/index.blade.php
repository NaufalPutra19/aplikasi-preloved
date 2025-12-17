@extends('layouts.app')
@section('content')
<h3>Your Cart</h3>
@if($items->isEmpty())
  <p>Keranjang kosong.</p>
@else
<table class="table">
  <thead><tr><th>Item</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr></thead>
  <tbody>
    @foreach($items as $k=>$i)
    <tr>
      <td>{{ $i['name'] }}</td>
      <td>Rp {{ number_format($i['price'],0,',','.') }}</td>
      <td>
        <form method="post" action="{{ route('cart.update') }}">
          @csrf
          <input type="hidden" name="id" value="{{ $k }}">
          <input type="number" name="quantity" value="{{ $i['quantity'] }}" min="1" class="form-control w-50 d-inline">
          <button class="btn btn-sm btn-secondary">Update</button>
        </form>
      </td>
      <td>Rp {{ number_format($i['price']*$i['quantity'],0,',','.') }}</td>
      <td>
        <form action="{{ route('cart.remove') }}" method="post">@csrf
          <input type="hidden" name="id" value="{{ $k }}">
          <button class="btn btn-sm btn-danger">Remove</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
<a href="{{ route('checkout.index') }}" class="btn btn-success">Proceed to Checkout</a>
@endif
@endsection

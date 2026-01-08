@extends('layouts.app')
@section('title','Catalog')
@section('content')
<div class="row">
  @foreach($products as $p)
  <div class="col-md-3 mb-4">
    <div class="card h-100">
      <img src="{{ $p->image ? asset('storage/'.$p->image) : 'https://via.placeholder.com/400' }}" class="card-img-top" alt="">
      <div class="card-body">
        <h5 class="card-title">{{ $p->name }}</h5>
        <p class="text-primary fw-bold">
          Rp {{ number_format($p->price,0,',','.') }}
          @if($p->unit)
          <span class="text-muted small">/ {{ $p->unit->symbol ?? $p->unit->name }}</span>
          @endif
        </p>
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
  @endforeach
</div>
{{ $products->links() }}
@endsection
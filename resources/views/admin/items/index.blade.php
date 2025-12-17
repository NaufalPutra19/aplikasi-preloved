@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold"><i class="bi bi-box-seam me-2"></i>Products</h2>
    <a href="{{ route('admin.items.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New Product
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>SKU</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Condition</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>
                            <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://via.placeholder.com/50' }}" 
                                 class="rounded" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                        </td>
                        <td><code>{{ $item->sku }}</code></td>
                        <td>
                            <div class="fw-semibold">{{ Str::limit($item->name, 40) }}</div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $item->category->name ?? '-' }}</span>
                        </td>
                        <td class="text-primary fw-semibold">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>
                            @if($item->stock <= $item->stock_min && $item->stock > 0)
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-exclamation-triangle me-1"></i>{{ $item->stock }}
                                </span>
                            @elseif($item->stock == 0)
                                <span class="badge bg-danger">Out of Stock</span>
                            @else
                                <span class="badge bg-success">{{ $item->stock }}</span>
                            @endif
                        </td>
                        <td><span class="badge bg-info">{{ $item->condition }}</span></td>
                        <td>
                            @if($item->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger" 
                                        onclick="if(confirm('Are you sure?')) document.getElementById('delete-{{ $item->id }}').submit();">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <form id="delete-{{ $item->id }}" action="{{ route('admin.items.destroy', $item) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                            No products found. Add your first product!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $items->links() }}
    </div>
</div>
@endsection
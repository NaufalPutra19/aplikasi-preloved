@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold"><i class="bi bi-tags me-2"></i>Categories</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New Category
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Products Count</th>
                        <th>Created At</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>
                            <div class="fw-semibold">{{ $category->name }}</div>
                        </td>
                        <td>
                            <code>{{ $category->slug }}</code>
                        </td>
                        <td>
                            @if($category->items_count > 0)
                                <span class="badge bg-primary">{{ $category->items_count }} products</span>
                            @else
                                <span class="badge bg-secondary">No products</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $category->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="btn btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger" 
                                        title="Delete"
                                        onclick="if(confirm('Are you sure? This will delete the category.')) document.getElementById('delete-{{ $category->id }}').submit();">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <form id="delete-{{ $category->id }}" 
                                  action="{{ route('admin.categories.destroy', $category) }}" 
                                  method="POST" class="d-none">
                                @csrf 
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                            No categories found. Create your first category!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $categories->links() }}
    </div>
</div>
@endsection
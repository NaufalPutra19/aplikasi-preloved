@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left me-2"></i>Back to Categories
    </a>
    <h2 class="fw-bold">Edit Category</h2>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-tag me-2"></i>Category Information
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               class="form-control form-control-lg @error('name') is-invalid @enderror" 
                               value="{{ old('name', $category->name) }}" 
                               required 
                               placeholder="e.g. Electronics, Fashion, Books"
                               autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Current slug: <code>{{ $category->slug }}</code>
                        </small>
                    </div>

                    <div class="alert alert-warning border-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Note:</strong> This category is used by {{ $category->items()->count() }} product(s).
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save me-2"></i>Update Category
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-graph-up me-2"></i>Category Statistics
                </h6>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border rounded p-3">
                            <div class="h3 fw-bold text-primary mb-0">{{ $category->items()->count() }}</div>
                            <small class="text-muted">Total Products</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-3">
                            <div class="h3 fw-bold text-success mb-0">{{ $category->items()->where('is_active', true)->count() }}</div>
                            <small class="text-muted">Active Products</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Live preview
document.querySelector('input[name="name"]').addEventListener('input', function(e) {
    // You can add live preview logic here if needed
});
</script>
@endpush
@endsection
@extends('layouts.admin')

@section('title', 'Add New Category')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left me-2"></i>Back to Categories
    </a>
    <h2 class="fw-bold">Add New Category</h2>
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
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               class="form-control form-control-lg @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" 
                               required 
                               placeholder="e.g. Electronics, Fashion, Books"
                               autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Slug will be generated automatically from the name
                        </small>
                    </div>

                    <div class="alert alert-info border-0">
                        <i class="bi bi-lightbulb me-2"></i>
                        <strong>Tip:</strong> Choose descriptive names that clearly represent the product type.
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save me-2"></i>Create Category
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-eye me-2"></i>Category Preview
                </h6>
                <p class="text-muted small mb-2">How it will appear:</p>
                <div class="border rounded p-3 bg-light">
                    <span class="badge bg-primary">
                        <i class="bi bi-tag me-1"></i>
                        <span id="preview-name">Your Category Name</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Live preview
document.querySelector('input[name="name"]').addEventListener('input', function(e) {
    const previewName = document.getElementById('preview-name');
    previewName.textContent = e.target.value || 'Your Category Name';
});
</script>
@endpush
@endsection
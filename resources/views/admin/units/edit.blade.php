@extends('layouts.admin')

@section('title', 'Edit Unit')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Unit</h1>
        <p class="text-muted mb-0">Update measurement unit</p>
    </div>
    <a href="{{ route('admin.units.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.units.update', $unit) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $unit->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Symbol</label>
                <input type="text" name="symbol" class="form-control @error('symbol') is-invalid @enderror"
                       value="{{ old('symbol', $unit->symbol) }}" placeholder="e.g. pcs, kg, L">
                @error('symbol')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                          rows="3" placeholder="Optional">{{ old('description', $unit->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check mb-4">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $unit->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">
                    Active
                </label>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.units.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

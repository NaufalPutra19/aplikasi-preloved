@extends('layouts.admin')

@section('title', 'Units')

@section('content')
<style>
    .units-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
    }

    .units-header h1 {
        font-weight: 700;
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }

    .units-header p {
        opacity: 0.9;
        margin-bottom: 0;
    }

    .table-card {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
        border-radius: 12px;
        overflow: hidden;
    }

    .table-card tbody tr {
        transition: background-color 0.2s ease, box-shadow 0.2s ease;
        border-bottom: 1px solid #f1f3f5;
    }

    .table-card tbody tr:hover {
        background-color: #f8f9ff;
        box-shadow: inset 0 0 0 1px rgba(102, 126, 234, 0.1);
    }

    .table-card thead {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    .table-card th {
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1rem;
    }

    .table-card td {
        padding: 1rem;
    }

    .unit-name {
        font-weight: 600;
        color: #212529;
    }

    .status-badge {
        display: inline-block;
        padding: 0.5rem 0.875rem;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.875rem;
        text-transform: capitalize;
    }

    .status-badge.active {
        background-color: #d1f3d1;
        color: #155724;
    }

    .status-badge.inactive {
        background-color: #e8eae8;
        color: #6c757d;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 6px;
        transition: all 0.2s ease;
        border: 1px solid #dee2e6;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-edit {
        color: #667eea;
    }

    .btn-edit:hover {
        background-color: #f0f4ff;
        border-color: #667eea;
    }

    .btn-delete {
        color: #dc3545;
    }

    .btn-delete:hover {
        background-color: #fff5f5;
        border-color: #dc3545;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state-icon {
        font-size: 3rem;
        opacity: 0.3;
        margin-bottom: 1rem;
    }

    .empty-state-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .empty-state-text {
        color: #6c757d;
        margin-bottom: 1.5rem;
    }

    .pagination-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e9ecef;
    }

    .pagination-info {
        color: #6c757d;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .pagination-controls {
        display: flex;
        gap: 0.5rem;
    }

    .btn-pagination {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        border: 1px solid #dee2e6;
        background-color: white;
        color: #667eea;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }

    .btn-pagination:not(:disabled):hover {
        background-color: #667eea;
        color: white;
        border-color: #667eea;
    }

    .btn-pagination:disabled {
        background-color: #f8f9fa;
        color: #adb5bd;
        cursor: not-allowed;
        border-color: #dee2e6;
    }
</style>

<div class="units-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="mb-0">
            <i class="bi bi-rulers me-2"></i>Units Management
        </h1>
        <p class="mb-0">Manage measurement units for products</p>
    </div>
    <a href="{{ route('admin.units.create') }}" class="btn btn-light">
        <i class="bi bi-plus-lg me-2"></i>Add New Unit
    </a>
</div>

@include('partials.flash')

<div class="table-card card">
    <div class="card-body p-0">
        @if($units->count() > 0)
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Name</th>
                            <th style="width: 15%;">Symbol</th>
                            <th style="width: 40%;">Description</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 10%; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($units as $unit)
                        <tr>
                            <td>
                                <span class="unit-name">{{ $unit->name }}</span>
                            </td>
                            <td>
                                <code style="background-color: #f8f9fa; padding: 0.25rem 0.5rem; border-radius: 4px;">{{ $unit->symbol ?: '-' }}</code>
                            </td>
                            <td>
                                <span class="text-muted">{{ $unit->description ?: '-' }}</span>
                            </td>
                            <td>
                                <span class="status-badge {{ $unit->is_active ? 'active' : 'inactive' }}">
                                    <i class="bi {{ $unit->is_active ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                                    {{ $unit->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.units.edit', $unit) }}" class="btn-action btn-edit" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.units.destroy', $unit) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this unit?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Delete">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-body pagination-section border-top">
                <div class="pagination-controls">
                    @if($units->onFirstPage())
                        <button class="btn-pagination" disabled>
                            <i class="bi bi-chevron-left me-1"></i>Previous
                        </button>
                    @else
                        <a href="{{ $units->previousPageUrl() }}" class="btn-pagination">
                            <i class="bi bi-chevron-left me-1"></i>Previous
                        </a>
                    @endif

                    @if($units->hasMorePages())
                        <a href="{{ $units->nextPageUrl() }}" class="btn-pagination">
                            Next<i class="bi bi-chevron-right ms-1"></i>
                        </a>
                    @else
                        <button class="btn-pagination" disabled>
                            Next<i class="bi bi-chevron-right ms-1"></i>
                        </button>
                    @endif
                </div>

                <div class="pagination-info">
                    Page <strong>{{ $units->currentPage() }}</strong> of <strong>{{ $units->lastPage() }}</strong>
                    <span class="ms-3" style="opacity: 0.7;">{{ $units->total() }} total items</span>
                </div>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-inbox"></i>
                </div>
                <div class="empty-state-title">No Units Found</div>
                <p class="empty-state-text">There are no measurement units yet. Create your first unit to get started.</p>
                <a href="{{ route('admin.units.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i>Create First Unit
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

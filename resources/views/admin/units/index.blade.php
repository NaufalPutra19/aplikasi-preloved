@extends('layouts.admin')

@section('title', 'Units')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Units</h1>
        <p class="text-muted mb-0">Manage measurement units for products</p>
    </div>
    <a href="{{ route('admin.units.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Add Unit
    </a>
</div>

@include('partials.flash')

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Symbol</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($units as $unit)
                        <tr>
                            <td class="fw-semibold">{{ $unit->name }}</td>
                            <td>{{ $unit->symbol ?: '-' }}</td>
                            <td class="text-muted" style="max-width: 320px;">{{ $unit->description ?: '-' }}</td>
                            <td>
                                <span class="badge {{ $unit->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $unit->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.units.edit', $unit) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.units.destroy', $unit) }}" method="POST" onsubmit="return confirm('Delete this unit?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No units found. <a href="{{ route('admin.units.create') }}">Create one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $units->links() }}
        </div>
    </div>
</div>
@endsection

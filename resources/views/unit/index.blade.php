@extends('layouts.app')
@section('title', 'Manage Units')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Product Units</h2>
        <a href="{{ route('units.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Unit
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="25%">Name</th>
                            <th width="15%">Symbol</th>
                            <th width="30%">Description</th>
                            <th width="10%">Status</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($units as $unit)
                        <tr>
                            <td>{{ $loop->iteration + ($units->currentPage() - 1) * $units->perPage() }}</td>
                            <td><strong>{{ $unit->name }}</strong></td>
                            <td>
                                @if($unit->symbol)
                                <span class="badge bg-secondary">{{ $unit->symbol }}</span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($unit->description, 50) ?? '-' }}</td>
                            <td>
                                @if($unit->is_active)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('units.edit', $unit) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('units.destroy', $unit) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this unit?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No units found. <a href="{{ route('units.create') }}">Create one now</a>
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
</div>
@endsection
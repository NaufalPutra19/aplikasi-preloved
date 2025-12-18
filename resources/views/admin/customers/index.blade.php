@extends('layouts.admin')

@section('title', 'Customers Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold"><i class="bi bi-people me-2"></i>Customers</h2>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Total Orders</th>
                        <th>Registered</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 40px; height: 40px;">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="fw-semibold">{{ $customer->name }}</div>
                            </div>
                        </td>
                        <td>{{ $customer->email }}</td>
                        <td>
                            <span class="badge bg-info">{{ $customer->orders_count }} order(s)</span>
                        </td>
                        <td class="text-muted">
                            <small>{{ $customer->created_at->format('d M Y') }}</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger" 
                                        onclick="if(confirm('Are you sure you want to delete this customer?')) document.getElementById('delete-{{ $customer->id }}').submit();">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <form id="delete-{{ $customer->id }}" action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                            No customers found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $customers->links() }}
    </div>
</div>
@endsection


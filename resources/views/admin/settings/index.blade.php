@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold"><i class="bi bi-gear me-2"></i>Settings</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- General Settings -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">General Settings</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Application settings and configuration will be available here.</p>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Settings feature coming soon!
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">System Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted" width="200">Application Name</td>
                        <td class="fw-semibold">PreloveX</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Laravel Version</td>
                        <td class="fw-semibold">{{ app()->version() }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">PHP Version</td>
                        <td class="fw-semibold">{{ PHP_VERSION }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Environment</td>
                        <td>
                            <span class="badge bg-{{ app()->environment() == 'production' ? 'success' : 'warning' }}">
                                {{ ucfirst(app()->environment()) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.items.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-box-seam me-2"></i>Manage Products
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-receipt me-2"></i>View Orders
                    </a>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-people me-2"></i>Manage Customers
                    </a>
                </div>
            </div>
        </div>

        <!-- Account Info -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Your Account</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-person fs-3"></i>
                    </div>
                    <h6 class="fw-bold mb-0">{{ auth()->user()->name }}</h6>
                    <small class="text-muted">{{ auth()->user()->email }}</small>
                </div>
                <div class="d-grid">
                    <a href="{{ route('logout') }}" class="btn btn-outline-danger" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Admin Dashboard') - The Order</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
:root {
    --sidebar-width: 260px;
    --primary: #093FB4;
    --primary-dark: #072A80;
}

body {
    font-family: 'Inter', sans-serif;
    background-color: #f8f9fa;
}

.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: var(--sidebar-width);
    background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    overflow-y: auto;
    z-index: 1000;
    transition: transform 0.3s ease;
}

.sidebar-brand {
    padding: 1.5rem;
    font-size: 1.5rem;
    font-weight: 700;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
}

.sidebar-brand img {
    filter: brightness(0) invert(1);
}

.sidebar-nav {
    padding: 1rem 0;
}

.sidebar-nav .nav-link {
    color: rgba(255,255,255,0.8);
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
}

.sidebar-nav .nav-link:hover {
    background-color: rgba(255,255,255,0.1);
    color: white;
}

.sidebar-nav .nav-link.active {
    background-color: rgba(255,255,255,0.15);
    color: white;
    border-left-color: white;
}

.main-content {
    margin-left: var(--sidebar-width);
    min-height: 100vh;
    padding: 2rem;
}

.topbar {
    background: white;
    padding: 1rem 2rem;
    margin: -2rem -2rem 2rem -2rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
    }
    
    .sidebar.show {
        transform: translateX(0);
    }
    
    .main-content {
        margin-left: 0;
    }
    
    .sidebar-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 999;
    }
}

.card {
    border: none;
    border-radius: 0.75rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand d-flex align-items-center">
        @if(file_exists(public_path('images/logo.png')))
            <img src="{{ asset('images/logo.png') }}" alt="The ORDER" height="35" style="max-height: 35px; margin-right: 10px;">
        @else
            <i class="bi bi-shop me-2"></i>
        @endif
        <span>Admin</span>
    </div>
    
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-3"></i>Dashboard
        </a>
        <a href="{{ route('admin.items.index') }}" class="nav-link {{ request()->routeIs('admin.items.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam me-3"></i>Products
        </a>
        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="bi bi-receipt me-3"></i>Orders
        </a>
        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags me-3"></i>Categories
        </a>
        <a href="{{ route('admin.units.index') }}" class="nav-link {{ request()->routeIs('admin.units.*') ? 'active' : '' }}">
            <i class="bi bi-rulers me-3"></i>Units
        </a>
        <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
            <i class="bi bi-people me-3"></i>Customers
        </a>
        <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="bi bi-gear me-3"></i>Settings
        </a>
        
        <div class="mt-4 pt-4 border-top border-secondary">
            <a href="{{ route('home') }}" class="nav-link">
                <i class="bi bi-house me-3"></i>Back to Website
            </a>
            <a href="{{ route('logout') }}" class="nav-link" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right me-3"></i>Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Topbar -->
    <div class="topbar d-flex justify-content-between align-items-center">
        <button class="btn btn-link d-md-none" id="sidebarToggle">
            <i class="bi bi-list fs-4"></i>
        </button>
        
        <div class="flex-grow-1"></div>
        
        <div class="d-flex align-items-center">
            <div class="me-3">
                <small class="text-muted d-block">Welcome back,</small>
                <strong>{{ auth()->user()->name }}</strong>
            </div>
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                 style="width: 40px; height: 40px;">
                <i class="bi bi-person"></i>
            </div>
        </div>
    </div>

    @include('partials.flash')
    @yield('content')
</div>

<div class="sidebar-backdrop d-none" id="sidebarBackdrop"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Sidebar toggle for mobile
const sidebar = document.getElementById('sidebar');
const backdrop = document.getElementById('sidebarBackdrop');
const toggle = document.getElementById('sidebarToggle');

toggle?.addEventListener('click', function() {
    sidebar.classList.toggle('show');
    backdrop.classList.toggle('d-none');
});

backdrop?.addEventListener('click', function() {
    sidebar.classList.remove('show');
    backdrop.classList.add('d-none');
});
</script>
@stack('scripts')
</body>
</html>
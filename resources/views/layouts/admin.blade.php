<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Admin Dashboard') - The Order</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('css/global-animations.css') }}">
<style>
:root {
    --sidebar-width: 260px;
    --primary: #093FB4;
    --primary-dark: #072A80;
    --secondary: #0A4FA8;
    --success: #10b981;
    --danger: #ef4444;
    --warning: #f59e0b;
    --info: #3b82f6;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background-color: #f8f9fa;
    overflow-x: hidden;
}

/* ============================================
   SIDEBAR STYLES
   ============================================ */

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
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 3px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.4);
}

.sidebar-brand {
    padding: 1.5rem;
    font-size: 1.25rem;
    font-weight: 700;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    animation: slideInLeft 0.5s ease-out;
}

.sidebar-brand img {
    filter: brightness(0) invert(1);
    transition: transform 0.3s ease;
}

.sidebar-brand img:hover {
    transform: scale(1.05);
}

.sidebar-nav {
    padding: 1rem 0;
}

.sidebar-nav .nav-link {
    color: rgba(255, 255, 255, 0.8);
    padding: 0.875rem 1.5rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-left: 3px solid transparent;
    margin: 0.25rem 0;
    position: relative;
}

.sidebar-nav .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: white;
    padding-left: 1.75rem;
}

.sidebar-nav .nav-link.active {
    background-color: rgba(255, 255, 255, 0.15);
    color: white;
    border-left-color: white;
    font-weight: 600;
    animation: slideInLeft 0.3s ease-out;
}

.sidebar-nav .nav-link i {
    transition: transform 0.3s ease;
}

.sidebar-nav .nav-link:hover i {
    transform: translateX(4px);
}

/* ============================================
   MAIN CONTENT
   ============================================ */

.main-content {
    margin-left: var(--sidebar-width);
    min-height: 100vh;
    padding: 2rem;
    animation: fadeIn 0.5s ease-out;
}

.topbar {
    background: white;
    padding: 1.5rem 2rem;
    margin: -2rem -2rem 2rem -2rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border-radius: 0 0 1rem 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    animation: slideInDown 0.4s ease-out;
}

.topbar-user {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.topbar-user-info small {
    color: #6c757d;
    display: block;
    font-size: 0.8rem;
    font-weight: 500;
}

.topbar-user-info strong {
    color: #212529;
    display: block;
    font-weight: 600;
}

.topbar-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
    animation: scaleIn 0.4s ease-out 0.1s backwards;
}

.topbar-avatar:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(9, 63, 180, 0.3);
}

/* ============================================
   CARDS
   ============================================ */

.card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    animation: fadeIn 0.6s ease-out;
}

.card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: none;
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.card-body {
    padding: 1.5rem;
}

.card-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #e9ecef;
    padding: 1rem 1.5rem;
}

/* ============================================
   TABLES
   ============================================ */

.table {
    margin-bottom: 0;
}

.table thead th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #495057;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    padding: 1rem;
    transition: all 0.3s ease;
}

.table tbody td {
    padding: 1rem;
    border-bottom: 1px solid #f1f3f5;
    transition: all 0.2s ease;
}

.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background-color: #f8f9ff;
    box-shadow: inset 0 0 0 1px rgba(9, 63, 180, 0.1);
}

.table tbody tr:hover td {
    color: #212529;
}

/* ============================================
   BADGES & STATUS
   ============================================ */

.badge {
    padding: 0.5rem 0.875rem;
    border-radius: 50px;
    font-weight: 500;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    animation: scaleIn 0.4s ease-out;
}

.badge-success {
    background-color: rgba(16, 185, 129, 0.15);
    color: #065f46;
}

.badge-danger {
    background-color: rgba(239, 68, 68, 0.15);
    color: #7f1d1d;
}

.badge-warning {
    background-color: rgba(245, 158, 11, 0.15);
    color: #78350f;
}

.badge-info {
    background-color: rgba(59, 130, 246, 0.15);
    color: #1e3a8a;
}

.badge-secondary {
    background-color: rgba(107, 114, 128, 0.15);
    color: #374151;
}

/* ============================================
   BUTTONS
   ============================================ */

.btn {
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    box-shadow: 0 4px 12px rgba(9, 63, 180, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(9, 63, 180, 0.4);
    color: white;
}

.btn-primary:active {
    transform: translateY(0);
}

.btn-outline-primary {
    color: var(--primary);
    border: 2px solid var(--primary);
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background-color: var(--primary);
    color: white;
    transform: translateY(-2px);
}

.btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.btn-sm {
    padding: 0.4rem 0.8rem;
    font-size: 0.875rem;
}

/* ============================================
   FORMS
   ============================================ */

.form-control,
.form-select {
    border-radius: 0.5rem;
    border: 2px solid #e5e7eb;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    font-size: 1rem;
    background-color: white;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(9, 63, 180, 0.1);
}

.form-label {
    color: #374151;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

/* ============================================
   ALERTS
   ============================================ */

.alert {
    border: none;
    border-radius: 0.75rem;
    padding: 1rem 1.5rem;
    animation: slideInDown 0.4s ease-out;
    border-left: 4px solid;
    backdrop-filter: blur(10px);
    margin-bottom: 1.5rem;
}

.alert-success {
    background-color: rgba(16, 185, 129, 0.1);
    border-left-color: #10b981;
    color: #065f46;
}

.alert-danger {
    background-color: rgba(239, 68, 68, 0.1);
    border-left-color: #ef4444;
    color: #7f1d1d;
}

.alert-warning {
    background-color: rgba(245, 158, 11, 0.1);
    border-left-color: #f59e0b;
    color: #78350f;
}

.alert-info {
    background-color: rgba(59, 130, 246, 0.1);
    border-left-color: #3b82f6;
    color: #1e3a8a;
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

@media (max-width: 992px) {
    :root {
        --sidebar-width: 220px;
    }

    .sidebar {
        width: var(--sidebar-width);
    }

    .main-content {
        padding: 1.5rem;
    }

    .topbar {
        margin: -1.5rem -1.5rem 1.5rem -1.5rem;
        padding: 1rem 1.5rem;
    }
}

@media (max-width: 768px) {
    :root {
        --sidebar-width: 0;
    }

    .sidebar {
        transform: translateX(-100%);
        width: 260px;
        box-shadow: 8px 0 32px rgba(0, 0, 0, 0.2);
    }

    .sidebar.show {
        transform: translateX(0);
    }

    .main-content {
        margin-left: 0;
        padding: 1rem;
    }

    .topbar {
        margin: -1rem -1rem 1.5rem -1rem;
        padding: 1rem;
        gap: 1rem;
    }

    .topbar-user-info {
        display: none;
    }

    .sidebar-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        animation: fadeIn 0.3s ease-out;
    }

    .table {
        font-size: 0.875rem;
    }

    .btn-sm {
        padding: 0.35rem 0.6rem;
        font-size: 0.8rem;
    }
}

@media (max-width: 576px) {
    .main-content {
        padding: 0.75rem;
    }

    .card {
        margin-bottom: 1rem;
    }

    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
}

/* ============================================
   CONTENT ANIMATIONS
   ============================================ */

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
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
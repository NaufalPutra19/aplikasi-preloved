<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','PreloveX - Premium Preloved Marketplace')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
:root {
    --primary: #093FB4;
    --primary-dark: #072A80;
    --secondary: #0A4FA8;
    --success: #10b981;
    --danger: #ef4444;
    --warning: #f59e0b;
    --dark: #1f2937;
    --light: #F4F4F4;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background-color: var(--light);
}

.navbar {
    backdrop-filter: blur(10px);
    background-color: rgba(255, 255, 255, 0.95) !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.navbar-brand {
    font-weight: 700;
    font-size: 1.5rem;
    color: var(--primary) !important;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border: none;
    padding: 0.6rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
}

.card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    overflow: hidden;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.1);
}

.card-img-top {
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.card:hover .card-img-top {
    transform: scale(1.05);
}

.hero-section {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    padding: 4rem 0;
    border-radius: 1rem;
    margin-bottom: 3rem;
}

.badge-condition {
    padding: 0.4rem 0.8rem;
    border-radius: 0.5rem;
    font-weight: 500;
    font-size: 0.75rem;
}

.form-control, .form-select {
    border-radius: 0.5rem;
    border: 2px solid #e5e7eb;
    padding: 0.7rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}

.footer {
    background-color: var(--dark);
    color: white;
    padding: 3rem 0 1rem;
    margin-top: 5rem;
}

.cart-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: var(--danger);
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: 600;
}

.dropdown-menu {
    border: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border-radius: 0.5rem;
}

@media (max-width: 768px) {
    .hero-section {
        padding: 2rem 0;
    }
    
    .card-img-top {
        height: 200px;
    }
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
</head>
<body>
@include('partials.navbar')

<div class="container mt-4 mb-5 animate-fade-in">
    @include('partials.flash')
    @yield('content')
</div>

@include('partials.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Auto dismiss alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
@stack('scripts')
</body>
</html>
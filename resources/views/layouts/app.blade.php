<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','PreloveX - Premium Preloved Marketplace')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('css/global-animations.css') }}">
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

* {
    scroll-behavior: smooth;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background-color: var(--light);
    overflow-x: hidden;
}

/* ============================================
   NAVBAR
   ============================================ */

.navbar {
    backdrop-filter: blur(10px);
    background-color: rgba(255, 255, 255, 0.95) !important;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
    padding: 0.75rem 0;
    animation: slideInDown 0.5s ease-out;
    position: sticky;
    top: 0;
    z-index: 100;
}

.navbar-brand {
    font-weight: 700;
    font-size: 1.5rem;
    color: var(--primary) !important;
    transition: all 0.3s ease;
}

.navbar-brand:hover {
    transform: scale(1.05);
}

.navbar-brand img {
    transition: transform 0.3s ease;
    max-height: 40px;
}

.navbar-brand:hover img {
    transform: rotate(-5deg);
}

.nav-link {
    position: relative;
    color: #495057 !important;
    font-weight: 500;
    margin: 0 0.5rem;
    transition: all 0.3s ease;
}

.nav-link::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    transition: width 0.3s ease;
}

.nav-link:hover {
    color: var(--primary) !important;
}

.nav-link:hover::after {
    width: 100%;
}

/* ============================================
   BUTTONS
   ============================================ */

.btn {
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    overflow: hidden;
    position: relative;
}

.btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
    z-index: 0;
}

.btn:hover::before {
    width: 300px;
    height: 300px;
}

.btn > * {
    position: relative;
    z-index: 1;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    box-shadow: 0 4px 12px rgba(9, 63, 180, 0.3);
    padding: 0.6rem 1.5rem;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(9, 63, 180, 0.4);
    color: white;
}

.btn-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
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
   CARDS & PRODUCTS
   ============================================ */

.card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    animation: fadeIn 0.6s ease-out;
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
}

.card-img-top {
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    animation: fadeIn 0.6s ease-out;
}

.card:hover .card-img-top {
    transform: scale(1.08);
}

.card-body {
    padding: 1.25rem;
}

.card-title {
    font-weight: 600;
    color: #212529;
    margin-bottom: 0.75rem;
    transition: color 0.3s ease;
}

.card:hover .card-title {
    color: var(--primary);
}

.card-text {
    color: #6c757d;
    font-size: 0.95rem;
}

/* ============================================
   HERO SECTION
   ============================================ */

.hero-section {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: white;
    padding: 4rem 2rem;
    border-radius: 1rem;
    margin-bottom: 3rem;
    position: relative;
    overflow: hidden;
    animation: slideInUp 0.6s ease-out;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.05)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,144C960,149,1056,139,1152,128C1248,117,1344,107,1392,101.3L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat;
    background-size: cover;
    animation: float 4s ease-in-out infinite;
}

.hero-section h1 {
    font-weight: 700;
    font-size: 2.5rem;
    position: relative;
    z-index: 1;
    animation: slideInUp 0.6s ease-out;
}

.hero-section p {
    font-size: 1.1rem;
    opacity: 0.9;
    position: relative;
    z-index: 1;
    animation: slideInUp 0.6s ease-out 0.1s backwards;
}

/* ============================================
   BADGES
   ============================================ */

.badge {
    padding: 0.5rem 0.875rem;
    border-radius: 50px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    animation: scaleIn 0.4s ease-out;
}

.badge-condition {
    padding: 0.4rem 0.8rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
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
    transform: scale(1.01);
}

.form-label {
    color: #374151;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.input-group-text {
    background-color: white;
    border: 2px solid #e5e7eb;
    color: #6c757d;
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
   FOOTER
   ============================================ */

.footer {
    background-color: var(--dark);
    color: white;
    padding: 3rem 0 1rem;
    margin-top: 5rem;
    animation: slideInUp 0.6s ease-out;
}

.footer-link {
    color: #d1d5db;
    text-decoration: none;
    transition: all 0.3s ease;
}

.footer-link:hover {
    color: white;
    padding-left: 4px;
}

/* ============================================
   CART BADGE
   ============================================ */

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
    animation: scaleIn 0.3s ease-out, pulse 2s ease-in-out 0.5s infinite;
}

/* ============================================
   DROPDOWN MENU
   ============================================ */

.dropdown-menu {
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    border-radius: 0.75rem;
    animation: slideInDown 0.3s ease-out;
    border: 1px solid #e9ecef;
}

.dropdown-item {
    padding: 0.75rem 1.25rem;
    transition: all 0.2s ease;
    color: #495057;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    color: var(--primary);
    padding-left: 1.5rem;
}

.dropdown-item.active {
    background-color: rgba(9, 63, 180, 0.1);
    color: var(--primary);
}

/* ============================================
   SPINNER / LOADER
   ============================================ */

.spinner-border {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

/* ============================================
   ANIMATIONS
   ============================================ */

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

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
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

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

@media (max-width: 992px) {
    .navbar-brand {
        font-size: 1.25rem;
    }

    .nav-link {
        margin: 0.25rem 0;
    }
}

@media (max-width: 768px) {
    .hero-section {
        padding: 2rem 1rem;
    }

    .hero-section h1 {
        font-size: 1.75rem;
    }

    .hero-section p {
        font-size: 1rem;
    }

    .card-img-top {
        height: 200px;
    }

    .container {
        padding: 0 1rem;
    }
}

@media (max-width: 576px) {
    .navbar {
        padding: 0.5rem 0;
    }

    .navbar-brand {
        font-size: 1.1rem;
    }

    .navbar-brand img {
        max-height: 32px;
    }

    .hero-section {
        padding: 1.5rem 1rem;
        margin-bottom: 2rem;
    }

    .hero-section h1 {
        font-size: 1.5rem;
    }

    .hero-section p {
        font-size: 0.95rem;
    }

    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }

    .btn-sm {
        width: auto;
    }

    .card-img-top {
        height: 180px;
    }

    .footer {
        padding: 2rem 0 1rem;
    }

    .container {
        padding: 0 0.75rem;
    }
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-in;
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
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        // PERBAIKAN: Hanya tutup alert yang memiliki class 'alert-dismissible'
        // Sebelumnya: document.querySelectorAll('.alert') -> ini menutup SEMUA alert termasuk instruksi pembayaran
        var alerts = document.querySelectorAll('.alert.alert-dismissible');
        
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
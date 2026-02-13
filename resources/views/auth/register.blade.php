@extends('layouts.app')

@section('title', 'Register - The Order')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-10 col-lg-9">
        <div class="card shadow-lg border-0" style="border-radius: 1rem; overflow: hidden;">
            <div class="row g-0">
                <!-- Left Side - Form -->
                <div class="col-md-6">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold text-primary mb-2">
                                <i class="bi bi-bag-heart me-2"></i>The Order
                            </h3>
                            <h4 class="fw-bold mb-2">Create Your Account</h4>
                            <p class="text-muted">Join our premium preloved marketplace</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="bi bi-person me-2 text-primary"></i>Full Name
                                </label>
                                <input id="name" type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" 
                                       required autocomplete="name" autofocus
                                       placeholder="Enter your full name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-2 text-primary"></i>Email Address
                                </label>
                                <input id="email" type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" 
                                       required autocomplete="email"
                                       placeholder="your@email.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="bi bi-lock me-2 text-primary"></i>Password
                                </label>
                                <input id="password" type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password"
                                       placeholder="Min. 8 characters">
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-1" style="font-size: 0.85rem;">
                                    <i class="bi bi-info-circle me-1"></i>Minimum 8 characters required
                                </small>
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="form-label fw-semibold">
                                    <i class="bi bi-lock-fill me-2 text-primary"></i>Confirm Password
                                </label>
                                <input id="password-confirm" type="password" 
                                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       name="password_confirmation" required autocomplete="new-password"
                                       placeholder="Re-enter password">
                                @error('password_confirmation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="role" class="form-label fw-semibold">
                                    <i class="bi bi-briefcase me-2 text-primary"></i>Choose Your Role
                                </label>
                                <select id="role" class="form-select @error('role') is-invalid @enderror" 
                                        name="role" required>
                                    <option value="">-- Select Your Role --</option>
                                    <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>
                                        👤 Customer (Pembeli)
                                    </option>
                                    <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>
                                        🏪 Penjual (Seller)
                                    </option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="row mt-3 gx-2">
                                    <div class="col-6">
                                        <small class="d-block p-2 rounded" style="background-color: #f0f6ff; border-left: 3px solid #0d6efd;">
                                            <strong class="text-primary d-block mb-1">👤 Customer</strong>
                                            <span style="font-size: 0.8rem;">Belanja barang preloved</span>
                                        </small>
                                    </div>
                                    <div class="col-6">
                                        <small class="d-block p-2 rounded" style="background-color: #fff8f0; border-left: 3px solid #fd7e14;">
                                            <strong class="text-warning d-block mb-1">🏪 Penjual</strong>
                                            <span style="font-size: 0.8rem;">Jual barang Anda</span>
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mt-4 mb-3">
                                <button type="submit" class="btn btn-primary btn-lg fw-semibold" style="padding: 0.75rem 1.5rem;">
                                    <i class="bi bi-person-plus me-2"></i>Create Account
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <!-- Google Register -->
                        <div class="d-grid mb-3">
                            <a href="{{ route('auth.google') }}" class="btn btn-outline-secondary btn-lg fw-semibold" style="padding: 0.75rem 1.5rem;">
                                <i class="fab fa-google me-2"></i>Sign up with Google
                            </a>
                        </div>

                        <div class="text-center">
                            <p class="text-muted mb-0">
                                Already have an account? 
                                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-primary">Sign In</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Image & Features -->
                <div class="col-md-6 d-none d-md-block" style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);">
                    <div class="h-100 d-flex flex-column justify-content-center align-items-center text-white p-5">
                        <div class="mb-4">
                            <i class="bi bi-bag-heart" style="font-size: 4rem; opacity: 0.9;"></i>
                        </div>
                        <h3 class="fw-bold mb-3 text-center">Join Our Community</h3>
                        <p class="text-center mb-4" style="opacity: 0.9;">Start shopping premium preloved items today</p>
                        <ul class="list-unstyled mt-3 text-start w-100" style="max-width: 300px;">
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <strong>Quality Guaranteed</strong>
                                <p class="small mb-0" style="opacity: 0.8;">All items carefully inspected</p>
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <strong>Secure Payments</strong>
                                <p class="small mb-0" style="opacity: 0.8;">Safe and encrypted transactions</p>
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <strong>Fast Shipping</strong>
                                <p class="small mb-0" style="opacity: 0.8;">Quick delivery to your doorstep</p>
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <strong>Easy Returns</strong>
                                <p class="small mb-0" style="opacity: 0.8;">Hassle-free return process</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

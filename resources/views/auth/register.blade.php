@extends('layouts.app')

@section('title', 'Register - PreloveX')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="card shadow-lg border-0">
            <div class="row g-0">
                <!-- Left Side - Form -->
                <div class="col-md-6">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold">Create Account</h4>
                            <p class="text-muted">Join PreloveX today!</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="bi bi-person me-2"></i>Full Name
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
                                    <i class="bi bi-envelope me-2"></i>Email Address
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
                                    <i class="bi bi-lock me-2"></i>Password
                                </label>
                                <input id="password" type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password"
                                       placeholder="Min. 8 characters">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimum 8 characters</small>
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="form-label fw-semibold">
                                    <i class="bi bi-lock-fill me-2"></i>Confirm Password
                                </label>
                                <input id="password-confirm" type="password" 
                                       class="form-control" 
                                       name="password_confirmation" required autocomplete="new-password"
                                       placeholder="Re-enter password">
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-person-plus me-2"></i>Create Account
                                </button>
                            </div>

                            <hr class="my-4">

                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    Already have an account? 
                                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Sign In</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Side - Image -->
                <div class="col-md-6 d-none d-md-block" style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);">
                    <div class="h-100 d-flex flex-column justify-content-center align-items-center text-white p-5">
                        <i class="bi bi-bag-heart fs-1 mb-3"></i>
                        <h3 class="fw-bold mb-3">Join Our Community</h3>
                        <p class="text-center">Start shopping premium preloved items today</p>
                        <ul class="list-unstyled mt-4 text-start">
                            <li class="mb-2"><i class="bi bi-check-circle me-2"></i>Quality Guaranteed</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2"></i>Secure Payments</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2"></i>Fast Shipping</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2"></i>Easy Returns</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
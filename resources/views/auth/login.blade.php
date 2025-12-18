@extends('layouts.app')

@section('title', 'Login - PreloveX')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-10 col-lg-9">
        <div class="card shadow-lg border-0" style="border-radius: 1rem; overflow: hidden;">
            <div class="row g-0">
                <!-- Left Side - Image & Welcome -->
                <div class="col-md-6 d-none d-md-block" style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);">
                    <div class="h-100 d-flex flex-column justify-content-center align-items-center text-white p-5">
                        <div class="mb-4">
                            <i class="bi bi-bag-heart" style="font-size: 4rem; opacity: 0.9;"></i>
                        </div>
                        <h3 class="fw-bold mb-3 text-center">Welcome Back!</h3>
                        <p class="text-center mb-4" style="opacity: 0.9;">Sign in to continue shopping premium preloved items</p>
                        <div class="w-100" style="max-width: 300px;">
                            <div class="mb-3 p-3 rounded" style="background: rgba(255,255,255,0.1);">
                                <i class="bi bi-star-fill me-2"></i>
                                <strong>Premium Quality</strong>
                            </div>
                            <div class="mb-3 p-3 rounded" style="background: rgba(255,255,255,0.1);">
                                <i class="bi bi-shield-check me-2"></i>
                                <strong>Secure Shopping</strong>
                            </div>
                            <div class="mb-3 p-3 rounded" style="background: rgba(255,255,255,0.1);">
                                <i class="bi bi-truck me-2"></i>
                                <strong>Fast Delivery</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Form -->
                <div class="col-md-6">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold text-primary mb-2">
                                <i class="bi bi-bag-heart me-2"></i>PreloveX
                            </h3>
                            <h4 class="fw-bold mb-2">Sign In</h4>
                            <p class="text-muted">Enter your credentials to access your account</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-2 text-primary"></i>Email Address
                                </label>
                                <input id="email" type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" 
                                       required autocomplete="email" autofocus
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
                                       name="password" required autocomplete="current-password"
                                       placeholder="Enter your password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-decoration-none text-primary small fw-semibold">
                                        Forgot Password?
                                    </a>
                                @endif
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                                </button>
                            </div>

                            <hr class="my-4">

                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    Don't have an account? 
                                    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold text-primary">Create Account</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

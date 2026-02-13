@extends('layouts.app')

@section('content')
<style>
    .profile-header {
        background: linear-gradient(135deg, #093FB4 0%, #0A4FA8 100%);
        color: white;
        padding: 3rem 2rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        animation: slideInUp 0.6s ease-out;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin-bottom: 1rem;
        border: 4px solid rgba(255, 255, 255, 0.5);
        overflow: hidden;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-info {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .profile-details h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .profile-role {
        display: inline-block;
        background: rgba(255, 255, 255, 0.25);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .profile-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
        animation: fadeIn 0.6s ease-out;
    }

    .profile-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #495057;
        min-width: 150px;
    }

    .info-value {
        color: #6c757d;
    }

    .info-value.text-primary {
        color: #093FB4;
    }

    @media (max-width: 768px) {
        .profile-info {
            flex-direction: column;
            text-align: center;
        }

        .profile-header {
            padding: 2rem 1rem;
        }

        .profile-details h1 {
            font-size: 1.5rem;
        }

        .info-row {
            flex-direction: column;
            gap: 0.5rem;
        }

        .info-label {
            min-width: auto;
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

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>

<div class="profile-header">
    <div class="profile-info">
        <div class="profile-avatar">
            @if($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}">
            @else
                <i class="bi bi-person"></i>
            @endif
        </div>
        <div class="profile-details">
            <h1>{{ $user->name }}</h1>
            <span class="profile-role">
                <i class="bi {{ $user->role === 'seller' ? 'bi-shop' : 'bi-bag' }} me-2"></i>
                {{ ucfirst($user->role) }}
            </span>
            @if($user->bio)
                <p class="mt-2 mb-0">{{ $user->bio }}</p>
            @endif
        </div>
    </div>
</div>

@include('partials.flash')

<div class="row">
    <div class="col-md-8">
        <!-- Contact Information -->
        <div class="profile-card">
            <h2 class="profile-section-title">
                <i class="bi bi-envelope me-2"></i>Contact Information
            </h2>

            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value text-primary">{{ $user->email }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Phone</span>
                <span class="info-value">{{ $user->phone ?? 'Not provided' }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">City</span>
                <span class="info-value">{{ $user->city ?? 'Not provided' }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Province</span>
                <span class="info-value">{{ $user->province ?? 'Not provided' }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Postal Code</span>
                <span class="info-value">{{ $user->postal_code ?? 'Not provided' }}</span>
            </div>
        </div>

        <!-- Address Information -->
        @if($user->address)
            <div class="profile-card">
                <h2 class="profile-section-title">
                    <i class="bi bi-geo-alt me-2"></i>Address
                </h2>
                <p class="text-muted">{{ $user->address }}</p>
            </div>
        @endif

        <!-- Bio -->
        @if($user->bio)
            <div class="profile-card">
                <h2 class="profile-section-title">
                    <i class="bi bi-chat-square-text me-2"></i>About
                </h2>
                <p class="text-muted">{{ $user->bio }}</p>
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <!-- Quick Actions -->
        <div class="profile-card">
            <h2 class="profile-section-title">
                <i class="bi bi-gear me-2"></i>Settings
            </h2>

            <a href="{{ route('profile.edit') }}" class="btn btn-primary w-100 mb-2">
                <i class="bi bi-pencil-square me-2"></i>Edit Profile
            </a>

            @if($user->photo)
                <form action="{{ route('profile.deletePhoto') }}" method="POST" onsubmit="return confirm('Are you sure?');" class="mb-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash me-2"></i>Delete Photo
                    </button>
                </form>
            @endif

            <a href="{{ route('logout') }}" class="btn btn-outline-secondary w-100"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>

        <!-- Account Type -->
        <div class="profile-card">
            <h2 class="profile-section-title">
                <i class="bi bi-shield-check me-2"></i>Account Type
            </h2>

            @if($user->role === 'seller')
                <p class="text-success mb-0">
                    <i class="bi bi-check-circle me-2"></i>
                    <strong>Seller Account</strong>
                </p>
                <small class="text-muted">You can list and sell products</small>
            @else
                <p class="text-info mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Customer Account</strong>
                </p>
                <small class="text-muted">You can browse and buy products</small>
            @endif
        </div>
    </div>
</div>

@endsection

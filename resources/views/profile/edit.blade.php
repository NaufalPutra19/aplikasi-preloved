@extends('layouts.app')

@section('content')
<style>
    .edit-header {
        background: linear-gradient(135deg, #093FB4 0%, #0A4FA8 100%);
        color: white;
        padding: 2rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
        animation: slideInDown 0.6s ease-out;
    }

    .edit-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
    }

    .form-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
        animation: fadeIn 0.6s ease-out;
    }

    .form-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .photo-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 0.75rem;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .photo-upload-area:hover {
        border-color: #093FB4;
        background-color: #f8f9ff;
    }

    .photo-upload-area.has-file {
        border-color: #10b981;
        background-color: #f0fdf4;
    }

    .photo-preview {
        width: 150px;
        height: 150px;
        border-radius: 0.75rem;
        object-fit: cover;
        margin: 1rem auto;
    }

    .photo-input {
        display: none;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border-radius: 0.5rem;
        border: 2px solid #e5e7eb;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #093FB4;
        box-shadow: 0 0 0 4px rgba(9, 63, 180, 0.1);
    }

    .role-selector {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .role-option {
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .role-option:hover {
        border-color: #093FB4;
        background-color: #f8f9ff;
    }

    .role-option input[type="radio"] {
        display: none;
    }

    .role-option input[type="radio"]:checked + label {
        color: #093FB4;
        font-weight: 600;
    }

    .role-option input[type="radio"]:checked ~ .role-option {
        border-color: #093FB4;
        background-color: #f8f9ff;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .button-group .btn {
        flex: 1;
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 1.5rem;
        }

        .button-group {
            flex-direction: column;
        }

        .button-group .btn {
            width: 100%;
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

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>

<div class="edit-header">
    <h1>
        <i class="bi bi-pencil-square me-2"></i>Edit Your Profile
    </h1>
</div>

@include('partials.flash')

<div class="row">
    <div class="col-lg-8 mx-auto">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Photo Upload Section -->
            <div class="form-card">
                <h2 class="form-section-title">
                    <i class="bi bi-image me-2"></i>Profile Photo
                </h2>

                <div class="photo-upload-area {{ $user->photo ? 'has-file' : '' }}" onclick="document.getElementById('photoInput').click();">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="photo-preview">
                        <p class="text-success mb-0">
                            <i class="bi bi-check-circle me-1"></i>
                            <strong>Photo Uploaded</strong>
                        </p>
                        <small class="text-muted">Click to change photo</small>
                    @else
                        <i class="bi bi-cloud-upload" style="font-size: 2.5rem; color: #093FB4; display: block; margin-bottom: 1rem;"></i>
                        <p class="mb-2"><strong>Click to upload photo</strong></p>
                        <small class="text-muted">PNG, JPG, GIF up to 2MB</small>
                    @endif
                </div>

                <input type="file" id="photoInput" name="photo" class="photo-input" accept="image/*">

                @error('photo')
                    <div class="alert alert-danger mt-2 mb-0">{{ $message }}</div>
                @enderror
            </div>

            <!-- Personal Information -->
            <div class="form-card">
                <h2 class="form-section-title">
                    <i class="bi bi-person me-2"></i>Personal Information
                </h2>

                <div class="form-group">
                    <label for="name" class="form-label">Full Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g., +62812345678">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror" 
                              id="bio" name="bio" rows="4" placeholder="Tell us about yourself..." maxlength="500">{{ old('bio', $user->bio) }}</textarea>
                    <small class="text-muted">{{ strlen($user->bio ?? '') }}/500 characters</small>
                    @error('bio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Address Information -->
            <div class="form-card">
                <h2 class="form-section-title">
                    <i class="bi bi-geo-alt me-2"></i>Address Information
                </h2>

                <div class="form-group">
                    <label for="address" class="form-label">Street Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                           id="address" name="address" value="{{ old('address', $user->address) }}" placeholder="123 Main St">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                   id="city" name="city" value="{{ old('city', $user->city) }}" placeholder="Jakarta">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="province" class="form-label">Province</label>
                            <input type="text" class="form-control @error('province') is-invalid @enderror" 
                                   id="province" name="province" value="{{ old('province', $user->province) }}" placeholder="DKI Jakarta">
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="postal_code" class="form-label">Postal Code</label>
                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror" 
                           id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" placeholder="12345">
                    @error('postal_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="button-group">
                <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Photo preview
    document.getElementById('photoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const uploadArea = document.querySelector('.photo-upload-area');
                uploadArea.innerHTML = `
                    <img src="${event.target.result}" alt="Preview" class="photo-preview">
                    <p class="text-success mb-0">
                        <i class="bi bi-check-circle me-1"></i>
                        <strong>Photo Selected</strong>
                    </p>
                    <small class="text-muted">Click to change photo</small>
                `;
                uploadArea.classList.add('has-file');
            };
            reader.readAsDataURL(file);
        }
    });

    // Bio character counter
    const bioTextarea = document.getElementById('bio');
    bioTextarea.addEventListener('input', function() {
        const parent = this.parentElement;
        const counter = parent.querySelector('small');
        counter.textContent = this.value.length + '/500 characters';
    });
</script>

@endsection

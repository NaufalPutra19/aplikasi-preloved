@extends('layouts.app')

@section('title', 'Verify Email - The Order')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <i class="bi bi-envelope-check" style="font-size: 4rem; color: var(--primary);"></i>
                    </div>

                    <h3 class="fw-bold mb-3">Verifikasi Email Anda</h3>
                    <p class="text-muted mb-4">
                        Kami telah mengirimkan link verifikasi ke email Anda. 
                        Silahkan cek email dan klik link untuk memverifikasi akun Anda.
                    </p>

                    @if (session('resent'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Link verifikasi baru telah dikirim ke email Anda!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <p class="text-muted mb-3">Belum menerima email?</p>

                    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-arrow-repeat me-2"></i>Kirim Ulang Link Verifikasi
                        </button>
                    </form>

                    <hr class="my-4">

                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted text-decoration-none">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

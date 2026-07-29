@extends('layouts.app')

@section('title', 'Login - POS System')

@section('content')

<div class="container min-vh-100 d-flex justify-content-center align-items-center py-4">

    <div class="card glass-card border-0 p-4 p-md-5 login-card">

        <!-- Header Card -->
        <div class="text-center mb-4">
            <div class="brand-logo mb-3 mx-auto d-flex align-items-center justify-content-center">
                <i class="bi bi-shop fs-2 text-primary"></i>
            </div>
            <h3 class="fw-bold text-white mb-1">Welcome Back 👋</h3>
            <p class="text-secondary small mb-0">Silakan login untuk mengakses sistem POS</p>
        </div>

        <!-- Form Login -->
        <form action="{{ route('auth') }}" method="POST">
            @csrf

            <!-- Input Email -->
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary small">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text form-dark-input border-end-0">
                        <i class="bi bi-envelope text-secondary"></i>
                    </span>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control form-dark-input border-start-0 ps-0 @error('email') is-invalid @enderror"
                        placeholder="nama@email.com"
                        required 
                        autofocus>
                </div>
                @error('email')
                    <div class="text-danger small mt-1">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Input Password -->
            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary small">Password</label>
                <div class="input-group">
                    <span class="input-group-text form-dark-input border-end-0">
                        <i class="bi bi-lock text-secondary"></i>
                    </span>
                    <input
                        type="password"
                        name="password"
                        class="form-control form-dark-input border-start-0 ps-0 @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        required>
                </div>
                @error('password')
                    <div class="text-danger small mt-1">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-neon-primary w-100 rounded-3 py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2">
                <span>Login ke Sistem</span>
                <i class="bi bi-arrow-right-short fs-5"></i>
            </button>
        </form>

    </div>

</div>

<!-- Style Khusus Tema Dark Glassmorphism -->
<style>
    .login-card {
        width: 100%;
        max-width: 420px;
    }

    .glass-card {
        background: rgba(30, 41, 59, 0.75) !important;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 24px !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3) !important;
    }

    .brand-logo {
        width: 60px;
        height: 60px;
        background: rgba(99, 102, 241, 0.15);
        border: 1px solid rgba(99, 102, 241, 0.3);
        border-radius: 16px;
    }

    .form-dark-input {
        background: rgba(15, 23, 42, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #f8fafc !important;
    }

    .form-dark-input::placeholder {
        color: #64748b !important;
    }

    .form-dark-input:focus {
        border-color: #6366f1 !important;
        box-shadow: 0 0 10px rgba(99, 102, 241, 0.3) !important;
    }

    .input-group-text.form-dark-input {
        border-top-left-radius: 10px !important;
        border-bottom-left-radius: 10px !important;
    }

    .form-control.form-dark-input {
        border-top-right-radius: 10px !important;
        border-bottom-right-radius: 10px !important;
    }

    .btn-neon-primary {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        border: none;
        color: #fff;
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        transition: all 0.2s ease;
    }

    .btn-neon-primary:hover {
        opacity: 0.9;
        color: #fff;
        transform: translateY(-1px);
    }
</style>

@endsection
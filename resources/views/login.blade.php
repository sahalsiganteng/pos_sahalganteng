@extends('layouts.app')

@section('title', 'Login - POS System')

@section('content')

<div class="bg-glow-container">
    <div class="glow-blob blob-1"></div>
    <div class="glow-blob blob-2"></div>
</div>

<div class="login-wrapper d-flex justify-content-center align-items-center min-vh-100 py-4">

    <div class="card-entrance-wrapper d-flex flex-column align-items-center">

        <div class="brand-logo mb-3 d-flex align-items-center justify-content-center layer-3d-high @if($errors->any()) border-danger animate-shake @else animate-logo @endif">
            <i class="bi bi-person-circle fs-1 @if($errors->any()) text-danger @else text-primary @endif"></i>
        </div>
        
        <div class="card glass-card border-0 p-4 p-md-5 login-card" id="tiltCard">

            <div class="text-center mb-4">
                <h3 class="fw-bold text-white mb-1 animate-item delay-1 layer-3d-mid">Welcome Back 👋</h3>
                <p class="text-secondary small mb-0 animate-item delay-2 layer-3d-low">Silakan login untuk mengakses sistem POS</p>
            </div>

            <form action="{{ route('auth') }}" method="POST">
                @csrf

                <div class="mb-3 animate-item delay-3 layer-3d-mid">
                    <label class="form-label fw-semibold text-secondary small">Email Address</label>
                    <div class="input-group animated-input-group">
                        <span class="input-group-text form-dark-input border-end-0">
                            <i class="bi bi-envelope @error('email') text-danger @else text-secondary @enderror"></i>
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

                <div class="mb-4 animate-item delay-4 layer-3d-mid">
                    <label class="form-label fw-semibold text-secondary small">Password</label>
                    <div class="input-group animated-input-group">
                        <span class="input-group-text form-dark-input border-end-0">
                            <i class="bi bi-lock @error('password') text-danger @else text-secondary @enderror"></i>
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

                <div class="animate-item delay-5 layer-3d-high">
                    <button type="submit" class="btn btn-neon-primary w-100 rounded-3 py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2">
                        <span>Login ke Sistem</span>
                        <i class="bi bi-arrow-right-short fs-5 btn-icon"></i>
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.1/vanilla-tilt.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const card = document.getElementById("tiltCard");
        if (card && typeof VanillaTilt !== "undefined") {
            VanillaTilt.init(card, {
                max: 18,
                speed: 1000,
                glare: true,
                "max-glare": 0.25,
                gyroscope: true,
                perspective: 1000
            });
        }
    });
</script>

<style>
    /* Background Ambient 3D Blobs */
    .bg-glow-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        overflow: hidden;
        z-index: 0;
        pointer-events: none;
    }
    .glow-blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(90px);
        opacity: 0.35;
        animation: floatGlow 10s infinite alternate ease-in-out;
    }
    .blob-1 {
        top: 20%;
        left: 30%;
        width: 300px;
        height: 300px;
        background: #6366f1;
    }
    .blob-2 {
        bottom: 20%;
        right: 30%;
        width: 350px;
        height: 350px;
        background: #a855f7;
        animation-delay: -5s;
    }

    /* Layout & Perspective */
    .login-wrapper {
        position: relative;
        z-index: 1;
        perspective: 1000px;
    }

    .card-entrance-wrapper {
        width: 100%;
        max-width: 420px;
        animation: cardAppear 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .login-card {
        width: 100%;
        transform-style: preserve-3d !important;
        will-change: transform;
    }

    .glass-card {
        background: rgba(30, 41, 59, 0.7) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-radius: 24px !important;
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.5), 
                    0 0 30px rgba(99, 102, 241, 0.15) !important;
    }

    /* Logo Style di luar Card */
    .brand-logo {
        width: 70px;
        height: 70px;
        background: rgba(30, 41, 59, 0.85);
        border: 2px solid rgba(99, 102, 241, 0.4);
        border-radius: 20px;
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3),
                    0 0 15px rgba(99, 102, 241, 0.2);
        z-index: 2;
    }

    .border-danger {
        border-color: #ef4444 !important;
        box-shadow: 0 0 20px rgba(239, 68, 68, 0.4) !important;
    }

    /* Animasi Shake (Bergetar saat error) */
    .animate-shake {
        animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
    }

    @keyframes shake {
        10%, 90% { transform: translate3d(-2px, 0, 0); }
        20%, 80% { transform: translate3d(4px, 0, 0); }
        30%, 50%, 70% { transform: translate3d(-6px, 0, 0); }
        40%, 60% { transform: translate3d(6px, 0, 0); }
    }

    /* Depth Layer Effects */
    .layer-3d-low { transform: translateZ(15px); display: block; }
    .layer-3d-mid { transform: translateZ(30px); display: block; }
    .layer-3d-high { transform: translateZ(50px); display: block; }

    .form-dark-input {
        background: rgba(15, 23, 42, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #f8fafc !important;
        transition: all 0.3s ease !important;
    }

    .form-dark-input::placeholder {
        color: #64748b !important;
    }

    .animated-input-group:focus-within {
        transform: translateZ(40px);
    }

    .animated-input-group:focus-within .form-dark-input {
        border-color: #6366f1 !important;
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.4) !important;
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
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.35);
        transition: all 0.3s ease;
    }

    .btn-neon-primary:hover {
        opacity: 0.95;
        color: #fff;
        box-shadow: 0 12px 28px rgba(168, 85, 247, 0.5);
    }

    .btn-neon-primary .btn-icon {
        transition: transform 0.3s ease;
    }

    .btn-neon-primary:hover .btn-icon {
        transform: translateX(5px);
    }

    /* Keyframes */
    .animate-logo {
        animation: logoFloat 3.5s ease-in-out infinite;
    }

    .animate-item {
        opacity: 0;
        animation: itemFadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .delay-1 { animation-delay: 0.15s; }
    .delay-2 { animation-delay: 0.25s; }
    .delay-3 { animation-delay: 0.35s; }
    .delay-4 { animation-delay: 0.45s; }
    .delay-5 { animation-delay: 0.55s; }

    @keyframes cardAppear {
        0% {
            opacity: 0;
            transform: scale(0.9) translateY(40px);
        }
        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    @keyframes itemFadeUp {
        0% {
            opacity: 0;
            transform: translateY(15px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes logoFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    @keyframes floatGlow {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(30px, -30px) scale(1.15); }
    }
</style>

@endsection
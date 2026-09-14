@extends('layouts.app')

@section('title', 'Masuk - Kasir POS')

@section('content')

    <style>
        :root {
            --bg-main: #f9fafb;
            --card-bg: #ffffff;
            --card-border: #e5e7eb;
            --btn-black: #000000;
            --btn-black-hover: #1f2937;
        }

        body {
            background-color: var(--bg-main) !important;
            color: #111827 !important;
            font-family: 'Inter', 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .anim-fade {
            animation: fadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .card-monochrome {
            background: var(--card-bg) !important;
            border: 1px solid var(--card-border);
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        }

        .form-control {
            background-color: #ffffff !important;
            border: 1px solid var(--card-border) !important;
            color: #111827 !important;
            border-radius: 0.5rem !important;
            padding: 0.7rem 1rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #000000 !important;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05) !important;
            outline: none;
        }

        .btn-black {
            background-color: var(--btn-black);
            color: #ffffff;
            border: 1px solid var(--btn-black);
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.75rem;
            width: 100%;
            transition: all 0.2s ease;
        }

        .btn-black:hover {
            background-color: var(--btn-black-hover);
            color: #ffffff;
            border-color: var(--btn-black-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>

    <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
        <div class="row justify-content-center w-100">
            <div class="col-md-5 col-lg-4">

                {{-- Header / Logo Brand --}}
                <div class="text-center mb-4 anim-fade">
                    <div class="d-inline-flex align-items-center justify-content-center bg-black text-white rounded-3 mb-3"
                        style="width: 48px; height: 48px;">
                        <i class="bi bi-calculator fs-5"></i>
                    </div>
                    <h1 class="fw-bold fs-4 text-dark mb-1" style="letter-spacing: -0.02em;">Kasir POS</h1>
                    <p class="text-muted small">Silakan masuk menggunakan akun Anda</p>
                </div>

                {{-- Form Login Card --}}
                <div class="card card-monochrome p-4 p-md-4 anim-fade" style="animation-delay: 0.1s;">

                    @if (session('status'))
                        <div class="alert alert-success py-2 small rounded-3 mb-3" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('auth') }}">
                        @csrf

                        {{-- Email / Username --}}
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-semibold text-dark">Email / Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"
                                    style="border-radius: 0.5rem 0 0 0.5rem; border-color: #e5e7eb;">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="email" id="email"
                                    class="form-control border-start-0 @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="nama@domain.com" required autofocus
                                    style="border-radius: 0 0.5rem 0.5rem 0 !important;">
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="form-label small fw-semibold text-dark mb-0">Kata Sandi</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                        class="text-muted small text-decoration-none">Lupa sandi?</a>
                                @endif
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"
                                    style="border-radius: 0.5rem 0 0 0.5rem; border-color: #e5e7eb;">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" name="password" id="password"
                                    class="form-control border-start-0 @error('password') is-invalid @enderror"
                                    placeholder="••••••••" required style="border-radius: 0 0.5rem 0.5rem 0 !important;">
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Remember Me --}}
                        <div class="mb-4 form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input"
                                {{ old('remember') ? 'checked' : '' }} style="border-color: #d1d5db;">
                            <label class="form-check-label small text-muted" for="remember">
                                Ingat saya di perangkat ini
                            </label>
                        </div>

                        {{-- Tombol Submit --}}
                        <button type="submit" class="btn btn-black">
                            Masuk ke Sistem <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </form>

                </div>

                {{-- Footer Note --}}
                <div class="text-center mt-4 text-muted small">
                    &copy; {{ date('Y') }} Kasir POS &bull; Hak Cipta Dilindungi
                </div>

            </div>
        </div>
    </div>

@endsection
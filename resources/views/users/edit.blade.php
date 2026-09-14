@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

    @include('layouts.navbar')

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
            border-radius: 0.875rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .form-control,
        .form-select {
            background-color: #ffffff !important;
            border: 1px solid var(--card-border) !important;
            color: #111827 !important;
            border-radius: 0.5rem !important;
            padding: 0.6rem 0.9rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #000000 !important;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05) !important;
            outline: none;
        }

        .btn-black {
            background-color: var(--btn-black);
            color: #ffffff;
            border: 1px solid var(--btn-black);
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.85rem;
            padding: 0.6rem 1.25rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-black:hover {
            background-color: var(--btn-black-hover);
            color: #ffffff;
            border-color: var(--btn-black-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-outline-mono {
            background-color: #ffffff;
            color: #374151;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.85rem;
            padding: 0.6rem 1.25rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-mono:hover {
            background-color: #f3f4f6;
            color: #000000;
            border-color: #9ca3af;
        }
    </style>

    <div class="container py-4 anim-fade" style="max-width: 800px;">

        <div class="pb-3 mb-4 border-bottom border-secondary border-opacity-10">
            <h1 class="fw-bold mb-1" style="font-size: 1.5rem; letter-spacing: -0.02em; color: #111827;">
                Edit Data User
            </h1>
            <p class="text-muted mb-0 small">Perbarui informasi akun, email, atau hak akses pengguna sistem.</p>
        </div>

        <div class="card card-monochrome">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $user->name) }}" required
                            placeholder="Masukkan nama lengkap">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $user->email) }}" required placeholder="nama@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div class="mb-3">
                        <label for="role" class="form-label">Peran (Role)</label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            @php
                                $currentRole = old('role', $user->role->name ?? ($user->role ?? ''));
                            @endphp
                            <option value="admin" {{ strtolower($currentRole) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ strtolower($currentRole) == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4 border-secondary opacity-10">

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru 
                            <span class="text-muted fw-normal font-monospace" style="font-size: 0.7rem;">(Opsional)</span>
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                        <div class="form-text text-muted" style="font-size: 0.75rem;">Minimal 8 karakter jika ingin diubah.</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            placeholder="Ulangi password baru">
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-between align-items-center pt-2">
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-mono">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-black">
                            <i class="bi bi-check-lg"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection
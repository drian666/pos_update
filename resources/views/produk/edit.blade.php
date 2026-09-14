@extends('layouts.app')

@section('title', 'Edit Produk')

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

        /* Animasi Masuk */
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

        /* Card Minimalis */
        .card-monochrome {
            background: var(--card-bg) !important;
            border: 1px solid var(--card-border);
            border-radius: 0.875rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }

        /* Form Controls */
        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.35rem;
        }

        .form-control,
        .form-select {
            background-color: #ffffff !important;
            border: 1px solid var(--card-border) !important;
            color: #111827 !important;
            border-radius: 0.5rem !important;
            padding: 0.6rem 0.875rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #000000 !important;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05) !important;
            outline: none;
        }

        /* Preview Thumbnail */
        .product-img-preview {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
        }

        /* Tombol Outline & Hitam */
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
    </style>

    <div class="container py-4 anim-fade" style="max-width: 800px;">

        {{-- HEADER HALAMAN --}}
        <div class="pb-3 mb-4 border-bottom border-secondary border-opacity-10">
            <h1 class="fw-bold mb-1" style="font-size: 1.5rem; letter-spacing: -0.02em; color: #111827;">
                Edit Produk
            </h1>
            <p class="text-muted mb-0 small">Perbarui informasi, harga, stok, atau foto produk di bawah ini.</p>
        </div>

        {{-- KARTU FORMULIR --}}
        <div class="card card-monochrome">
            <div class="card-body p-4 p-md-5">

                {{-- Alert Error Validation --}}
                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 small mb-4"
                        style="background-color: #fee2e2; color: #991b1b;">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3"><label for="jenis_id" class="form-label">Jenis Produk</label><select id="jenis_id" name="jenis_id" class="form-select"><option value="">Belum dipilih</option>@foreach($jenis as $item)<option value="{{ $item->id }}" @selected(old('jenis_id', $produk->jenis_id) == $item->id)>{{ $item->nama_jenis }}</option>@endforeach</select>@error('jenis_id')<div class="text-danger small">{{ $message }}</div>@enderror</div>


                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" value="{{ old('nama', $produk->nama) }}"
                            placeholder="Contoh: Kemeja Flanel Hitam" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="harga_beli" class="form-label">Harga Pokok (Rp) <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('harga_beli') is-invalid @enderror"
                                id="harga_beli" name="harga_beli" value="{{ old('harga_beli', $produk->harga_beli) }}"
                                placeholder="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="harga_jual" class="form-label">Harga Jual (Rp) <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('harga_jual') is-invalid @enderror"
                                id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $produk->harga_jual) }}"
                                placeholder="0" required>
                        </div>
                    </div>

                    <div class="row align-items-center mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="stok" class="form-label">Stok Produk <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok"
                                name="stok" value="{{ old('stok', $produk->stok) }}" placeholder="0" required>
                        </div>
                        <div class="col-md-6">
                            <label for="foto" class="form-label">Foto Produk Baru (Opsional)</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto"
                                name="foto" accept="image/*">
                            <div class="form-text text-muted" style="font-size: 0.75rem;">Biarkan kosong jika tidak ingin mengubah foto.</div>
                        </div>
                    </div>

                    {{-- PREVIEW FOTO SAAT INI --}}
                    @if ($produk->foto)
                        <div class="mb-4 d-flex align-items-center gap-3 p-3 rounded-3"
                            style="background-color: #f9fafb; border: 1px solid #e5e7eb;">
                            <div>
                                <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}"
                                    class="product-img-preview">
                            </div>
                            <div>
                                <span class="d-block fw-semibold text-dark small">Foto Saat Ini</span>
                                <span class="text-muted" style="font-size: 0.75rem;">Foto akan diganti jika Anda mengunggah file baru di atas.</span>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-10">
                        <a href="{{ route('produk.index') }}" class="btn btn-outline-mono">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-black">
                            <i class="bi bi-check-lg"></i> Perbarui Produk
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

@endsection
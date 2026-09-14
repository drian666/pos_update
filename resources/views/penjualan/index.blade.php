@extends('layouts.app')

@section('title', 'Manajemen Penjualan')

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

        /* Search & Filter Input */
        .input-search-mono {
            background-color: #ffffff !important;
            border: 1px solid var(--card-border) !important;
            color: #111827 !important;
            border-radius: 0.5rem 0 0 0.5rem !important;
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .input-search-mono:focus {
            border-color: #000000 !important;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05) !important;
            outline: none;
        }

        .btn-search-mono {
            background-color: #000000 !important;
            color: #ffffff !important;
            border-radius: 0 0.5rem 0.5rem 0 !important;
            padding: 0.5rem 1rem;
            font-weight: 500;
            font-size: 0.85rem;
            border: none;
            transition: all 0.2s;
        }

        .btn-search-mono:hover {
            background-color: #1f2937 !important;
        }

        /* Tombol Hitam Utama */
        .btn-black {
            background-color: var(--btn-black);
            color: #ffffff;
            border: 1px solid var(--btn-black);
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
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

        /* Table Styling */
        .table-monochrome {
            margin-bottom: 0;
            --bs-table-bg: transparent !important;
        }

        .table-monochrome th {
            background-color: #f9fafb !important;
            color: #4b5563 !important;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #d1d5db !important;
            padding: 1rem;
        }

        .table-monochrome td {
            border-bottom: 1px solid #f3f4f6 !important;
            padding: 1rem;
            vertical-align: middle;
            font-size: 0.85rem;
            color: #111827 !important;
        }

        .table-monochrome tbody tr {
            transition: background-color 0.2s ease;
        }

        .table-monochrome tbody tr:hover td {
            background-color: #f3f4f6 !important;
        }

        /* Action Buttons */
        .btn-action {
            padding: 0.35rem 0.65rem;
            font-size: 0.75rem;
            border-radius: 0.4rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            transition: all 0.2s ease;
            text-decoration: none;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #374151;
        }

        .btn-action:hover {
            background: #f3f4f6;
            color: #000000;
            border-color: #9ca3af;
        }

        .btn-action-danger {
            background: #ffffff;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .btn-action-danger:hover {
            background: #fee2e2;
            color: #b91c1c;
            border-color: #f87171;
        }
    </style>

    <div class="container py-4 anim-fade" style="max-width: 1400px;">

        {{-- HEADER PAGE --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-3 mb-4 border-bottom border-secondary border-opacity-10">
            <div>
                <h1 class="fw-bold mb-1" style="font-size: 1.5rem; letter-spacing: -0.02em; color: #111827;">
                    Daftar Penjualan
                </h1>
                <p class="text-muted mb-0 small">Kelola riwayat transaksi penjualan barang dan kasir.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="{{ route('penjualan.create') }}" class="btn btn-black">
                    <i class="bi bi-plus-lg fs-6"></i> Tambah Transaksi
                </a>
            </div>
        </div>

        {{-- NOTIFIKASI ALERT FLASH MESSAGE --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3" role="alert" style="border-radius: 0.5rem; font-size: 0.85rem;">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-3" role="alert" style="border-radius: 0.5rem; font-size: 0.85rem;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- FORM SEARCH / FILTER --}}
        <div class="row mb-3">
            <div class="col-12 col-md-6 col-lg-4">
                <form action="{{ route('penjualan.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control input-search-mono"
                            placeholder="Cari nota / kasir..." value="{{ request('search') }}">
                        <button class="btn btn-search-mono" type="submit">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABLE CARD CONTAINER --}}
        <div class="card card-monochrome">
            <div class="table-responsive">
                <table class="table table-monochrome align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>No. Nota / Invoice</th>
                            <th>Kasir / User</th>
                            <th>Tanggal Transaksi</th>
                            <th class="text-end">Total Item</th>
                            <th class="text-end">Total Harga</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $dataPenjualan = $penjualans ?? ($penjualan ?? []);
                        @endphp

                        @forelse ($dataPenjualan as $index => $item)
                            <tr>
                                <td class="text-center text-muted font-monospace">
                                    {{ method_exists($dataPenjualan, 'firstItem') ? $dataPenjualan->firstItem() + $index : $index + 1 }}
                                </td>
                                <td class="fw-semibold text-dark font-monospace">
                                    {{ $item->no_nota ?? ($item->invoice ?? 'INV-' . $item->id) }}
                                </td>
                                <td>
                                    <span class="badge rounded-pill border px-2 py-1"
                                        style="background: #f3f4f6; border-color: #d1d5db !important; color: #374151; font-size: 0.75rem;">
                                        <i class="bi bi-person-circle me-1"></i>
                                        {{ $item->user->name ?? ($item->kasir ?? 'Admin') }}
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    {{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="text-end font-monospace">
                                    {{ $item->itemPenjualan ? $item->itemPenjualan->sum('kuantitas') : 0 }}
                                </td>
                                <td class="text-end fw-bold font-monospace text-dark">
                                    Rp {{ number_format($item->total_pembayaran ?? 0, 0, ',', '.') }}
                                </td>

                                {{-- KOLOM STATUS HASIL TAMBAHAN --}}
                                <td class="text-center">
                                    @php $status = strtolower($item->status ?? 'completed'); @endphp
                                    @if ($status === 'completed')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1" style="font-size: 0.75rem;">
                                            <i class="bi bi-check-circle-fill me-1"></i> Completed
                                        </span>
                                    @elseif ($status === 'pending')
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-2 py-1" style="font-size: 0.75rem;">
                                            <i class="bi bi-clock-fill me-1"></i> Pending
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-2 py-1" style="font-size: 0.75rem;">
                                            {{ ucfirst($status) }}
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI DENGAN KONDISI TOMBOL HAPUS --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('penjualan.show', $item->id) }}" class="btn btn-action" title="Detail">
                                            <i class="bi bi-eye-fill"></i> Detail
                                        </a>

                                        @can('update', $item)
                                        <a href="{{ route('penjualan.edit', $item->id) }}" class="btn btn-action" title="Edit transaksi OPEN"><i class="bi bi-pencil-fill"></i> Edit</a>
                                        @endcan
                                        @php $isCompleted = strtolower($item->status ?? 'completed') === 'completed'; @endphp

                                        @if (!$isCompleted && auth()->user()->can('delete', $item))
                                            <form action="{{ route('penjualan.destroy', $item->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini? Stok produk akan dikembalikan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-action btn-action-danger" title="Hapus">
                                                    <i class="bi bi-trash-fill"></i> Hapus
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-action text-muted" style="opacity: 0.5; cursor: not-allowed;" title="Transaksi Completed tidak dapat dihapus" disabled>
                                                <i class="bi bi-lock-fill"></i> Locked
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-receipt fs-4 d-block mb-2 text-muted"></i>
                                    Belum ada data transaksi penjualan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        {{-- FOOTER TABEL (HANYA MENAMPILKAN INFORMASI JUMLAH DATA) --}}
<div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3">
    <div class="text-muted small">
        Menampilkan {{ $penjualans->count() }} data terbaru
    </div>
</div>
        </div>
    </div>



    <style>
    /* Menyembunyikan teks 'Showing x to y of z results' bawaan Laravel */
    div.pagination nav > div:first-child,
    div.pagination p.text-sm {
        display: none !important;
    }
</style>

@endsection
<?php $__env->startSection('title', 'Manajemen Produk'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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

        /* Search Input & Button */
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

        /* Thumbnail Foto */
        .product-img-thumb {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            transition: transform 0.2s ease;
        }

        .product-img-thumb:hover {
            transform: scale(1.1);
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

        
        <?php if(session('error')): ?>
            <div class="alert alert-dismissible fade show d-flex align-items-center justify-content-between mb-4" role="alert"
                style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; border-radius: 0.5rem; padding: 0.85rem 1.25rem; font-size: 0.875rem; font-weight: 500;">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <span><?php echo e(session('error')); ?></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: invert(15%) sepia(80%) saturate(5000%) hue-rotate(350deg);"></button>
            </div>
        <?php endif; ?>

        
        <?php if(session('success')): ?>
            <div class="alert alert-dismissible fade show d-flex align-items-center justify-content-between mb-4" role="alert"
                style="background-color: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; border-radius: 0.5rem; padding: 0.85rem 1.25rem; font-size: 0.875rem; font-weight: 500;">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <span><?php echo e(session('success')); ?></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: invert(20%) sepia(60%) saturate(3000%) hue-rotate(120deg);"></button>
            </div>
        <?php endif; ?>

        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-3 mb-4 border-bottom border-secondary border-opacity-10">
            <div>
                <h1 class="fw-bold mb-1" style="font-size: 1.5rem; letter-spacing: -0.02em; color: #111827;">
                    Daftar Produk
                </h1>
                <p class="text-muted mb-0 small">Kelola informasi stok, harga pokok, dan harga jual barang.</p>
            </div>
            <div class="mt-3 mt-md-0">
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\Produk::class)): ?>
                <a href="<?php echo e(route('produk.create')); ?>" class="btn btn-black">
                    <i class="bi bi-plus-lg fs-6"></i> Tambah Produk
                </a>
<?php endif; ?>
            </div>
        </div>

        
        <div class="row mb-3">
            <div class="col-12 col-md-6 col-lg-4">
                <form action="<?php echo e(route('produk.index')); ?>" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control input-search-mono"
                            placeholder="Cari nama produk..." value="<?php echo e(request('search')); ?>">
                        <button class="btn btn-search-mono" type="submit">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="card card-monochrome">
            <div class="table-responsive">
                <table class="table table-monochrome align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>User</th>
                            <th class="text-center" style="width: 70px;">Foto</th>
                            <th>Nama Produk</th>
                            <th>Harga Pokok</th>
                            <th>Harga Jual</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $dataProduk = $produks ?? ($produk ?? []);
                        ?>

                        <?php $__empty_1 = true; $__currentLoopData = $dataProduk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center text-muted font-monospace">
                                    <?php echo e(method_exists($dataProduk, 'firstItem') ? $dataProduk->firstItem() + $index : $index + 1); ?>

                                </td>
                                <td>
                                    <span class="badge rounded-pill border px-2 py-1"
                                        style="background: #f3f4f6; border-color: #d1d5db !important; color: #374151; font-size: 0.75rem;">
                                        <i class="bi bi-person-circle me-1"></i> <?php echo e($item->user->name ?? 'kude'); ?>

                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if($item->foto): ?>
                                        <img src="<?php echo e(asset('storage/' . $item->foto)); ?>" alt="<?php echo e($item->nama); ?>"
                                            class="product-img-thumb">
                                    <?php else: ?>
                                        <div class="product-img-thumb d-flex align-items-center justify-content-center mx-auto"
                                            style="background: #f3f4f6; color: #9ca3af;">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-semibold text-dark">
                                    <?php echo e($item->nama); ?>

                                </td>
                                <td class="font-monospace text-muted small">
                                    Rp <?php echo e(number_format($item->harga_beli ?? 0, 0, ',', '.')); ?>

                                </td>
                                <td class="fw-bold font-monospace text-dark small">
                                    Rp <?php echo e(number_format($item->harga_jual ?? 0, 0, ',', '.')); ?>

                                </td>
                                <td class="text-center">
                                    <?php if(($item->stok ?? 0) <= 0): ?>
                                        <span class="badge px-2.5 py-1 rounded-pill fw-bold"
                                            style="background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; font-size: 0.7rem;">Habis</span>
                                    <?php elseif(($item->stok ?? 0) <= 5): ?>
                                        <span class="badge px-2.5 py-1 rounded-pill fw-bold"
                                            style="background: #fef3c7; color: #d97706; border: 1px solid #fde68a; font-size: 0.7rem;"><?php echo e($item->stok); ?></span>
                                    <?php else: ?>
                                        <span class="badge px-2.5 py-1 rounded-pill fw-bold"
                                            style="background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; font-size: 0.7rem;"><?php echo e($item->stok); ?></span>
                                    <?php endif; ?>
                                </td>

                                
                                <td class="text-center">
                                    <?php if($item->status ?? true): ?>
                                        <span class="badge px-2.5 py-1 rounded-pill fw-semibold"
                                            style="background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; font-size: 0.7rem;">
                                            <i class="bi bi-check-circle-fill me-1"></i> Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="badge px-2.5 py-1 rounded-pill fw-semibold"
                                            style="background: #f3f4f6; color: #6b7280; border: 1px solid #e5e7eb; font-size: 0.7rem;">
                                            <i class="bi bi-x-circle-fill me-1"></i> Nonaktif
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?php echo e(route('produk.show', $item->id)); ?>" class="btn btn-action"
                                            title="Detail">
                                            <i class="bi bi-eye-fill"></i> Detail
                                        </a>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $item)): ?>
                                        <a href="<?php echo e(route('produk.edit', $item->id)); ?>" class="btn btn-action"
                                            title="Edit">
                                            <i class="bi bi-pencil-fill"></i> Edit
                                        </a>
                                        <form action="<?php echo e(route('produk.destroy', $item->id)); ?>" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-action btn-action-danger" title="Hapus">
                                                <i class="bi bi-trash-fill"></i> Hapus
                                            </button>
                                        </form>
<?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-4 d-block mb-2 text-muted"></i>
                                    Belum ada data produk tersedia.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

<div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3">
    <div class="text-muted small">
        Menampilkan <?php echo e($produks->count()); ?> data terbaru
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\apk_posbaru\resources\views/produk/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Dashboard - Analytics'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <style>
        :root {
            --bg-main: #f9fafb;
            --card-bg: #ffffff;
            --card-border: #e5e7eb;
            --card-hover-border: #000000;
        }

        body {
            background-color: var(--bg-main) !important;
            color: #111827 !important;
            font-family: 'Inter', 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            letter-spacing: -0.01em;
        }

        /* Smooth Fade In */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .anim-item {
            animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .delay-1 {
            animation-delay: 0.04s;
        }

        .delay-2 {
            animation-delay: 0.08s;
        }

        .delay-3 {
            animation-delay: 0.12s;
        }

        .delay-4 {
            animation-delay: 0.16s;
        }

        /* Ultra Modern Monochrome Cards */
        .card-modern {
            background: var(--card-bg) !important;
            border: 1px solid var(--card-border);
            border-radius: 0.875rem;
            transition: all 0.25s ease;
            position: relative;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02);
        }

        .card-modern:hover {
            border-color: var(--card-hover-border);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        /* Clean Icon Box */
        .icon-wrapper {
            width: 42px;
            height: 42px;
            border-radius: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            background: #f3f4f6;
            color: #000000;
            border: 1px solid #e5e7eb;
        }

        /* Live Pulse */
        .pulse-dot {
            width: 6px;
            height: 6px;
            background-color: #000000;
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.5);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(0, 0, 0, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);
            }
        }

        /* Minimalist Tables */
        .table-modern {
            color: #374151 !important;
            margin-bottom: 0;
            --bs-table-bg: transparent !important;
        }

        .table-modern th {
            background-color: #f9fafb !important;
            color: #6b7280 !important;
            font-size: 0.68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-bottom: 1px solid var(--card-border) !important;
            padding: 0.75rem 1rem;
        }

        .table-modern td {
            border-bottom: 1px solid #f3f4f6 !important;
            padding: 0.75rem 1rem;
            vertical-align: middle;
            font-size: 0.85rem;
            color: #1f2937 !important;
        }

        .table-modern tbody tr:hover td {
            background-color: #f9fafb !important;
        }

        /* Badge Ranks */
        .badge-rank {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.7rem;
        }

        .rank-1 {
            background: #000000;
            color: #ffffff;
        }

        .rank-2 {
            background: #e5e7eb;
            color: #1f2937;
        }

        .rank-3 {
            background: #f3f4f6;
            color: #4b5563;
            border: 1px solid #d1d5db;
        }
    </style>

    <div class="container py-4" style="max-width: 1400px;">

        
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-3 mb-4 border-bottom border-secondary border-opacity-10 anim-item delay-1">
            <div>
                <div class="d-flex align-items-center gap-2 small mb-1 text-muted" style="font-weight: 500;">
                    <i class="bi bi-calendar-event"></i>
                    <span><?php echo e($tanggalHariIni->translatedFormat('l, d F Y')); ?></span>
                </div>
                <h1 class="fw-bold mb-0" style="font-size: 1.6rem; letter-spacing: -0.02em; color: #111827;">
                    Ringkasan Bisnis
                </h1>
            </div>
            <div class="mt-2 mt-md-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill"
                    style="background: #ffffff; border: 1px solid var(--card-border); box-shadow: 0 1px 2px 0 rgba(0,0,0,0.02);">
                    <span class="pulse-dot"></span>
                    <span style="font-size: 0.72rem; color: #4b5563; font-weight: 500;">Live Analytics</span>
                </div>
            </div>
        </div>

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewAny', App\Models\User::class)): ?>
            <div class="mb-4">
                <div class="row g-3">
                    
                    <div class="col-12 col-sm-6 col-xl-3 anim-item delay-1">
                        <div class="card card-modern p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="d-block text-uppercase text-muted fw-semibold mb-1"
                                        style="font-size: 0.62rem; letter-spacing: 0.08em;">Total Penjualan</span>
                                    <h3 class="fw-bold mb-0" style="font-size: 1.15rem; color: #111827;">
                                        Rp <?php echo e(number_format($ringkasan['total_penjualan'])); ?>

                                    </h3>
                                </div>
                                <div class="icon-wrapper">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-12 col-sm-6 col-xl-3 anim-item delay-2">
                        <div class="card card-modern p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="d-block text-uppercase text-muted fw-semibold mb-1"
                                        style="font-size: 0.62rem; letter-spacing: 0.08em;">Jumlah Transaksi</span>
                                    <h3 class="fw-bold mb-0" style="font-size: 1.15rem; color: #111827;">
                                        <?php echo e(number_format($ringkasan['total_transaksi'])); ?> <span
                                            class="fs-6 fw-normal text-muted">trx</span>
                                    </h3>
                                </div>
                                <div class="icon-wrapper">
                                    <i class="bi bi-receipt"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-12 col-sm-6 col-xl-3 anim-item delay-3">
                        <div class="card card-modern p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="d-block text-uppercase text-muted fw-semibold mb-1"
                                        style="font-size: 0.62rem; letter-spacing: 0.08em;">Pembayaran Tunai</span>
                                    <h3 class="fw-bold mb-0" style="color: #111827; font-size: 1.15rem;">
                                        Rp <?php echo e(number_format($ringkasan['total_cash'])); ?>

                                    </h3>
                                </div>
                                <div class="icon-wrapper">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-12 col-sm-6 col-xl-3 anim-item delay-4">
                        <div class="card card-modern p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="d-block text-uppercase text-muted fw-semibold mb-1"
                                        style="font-size: 0.62rem; letter-spacing: 0.08em;">Non-Tunai / QRIS</span>
                                    <h3 class="fw-bold mb-0" style="color: #111827; font-size: 1.15rem;">
                                        Rp <?php echo e(number_format($ringkasan['total_non_tunai'])); ?>

                                    </h3>
                                </div>
                                <div class="icon-wrapper">
                                    <i class="bi bi-qr-code-scan"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        
        <div class="mb-4 anim-item delay-2">
            <h6 class="fw-bold text-dark mb-2.5 d-flex align-items-center gap-2" style="font-size: 0.9rem;">
                <i class="bi bi-shield-exclamation text-dark"></i>
                Status Inventaris Kritis
            </h6>

            <div class="row g-3">
                
                <div class="col-12 col-lg-6">
                    <div class="card card-modern h-100">
                        <div class="p-3 d-flex justify-content-between align-items-center border-bottom border-light"
                            style="background: #ffffff;">
                            <span class="fw-semibold text-dark d-flex align-items-center gap-1.5"
                                style="font-size: 0.8rem;">
                                <i class="bi bi-exclamation-triangle"></i> Stok Menipis
                            </span>
                            <span class="badge rounded-pill px-2.5 py-0.5"
                                style="background: #f3f4f6; color: #374151; font-size: 0.68rem; font-weight: 500; border: 1px solid #e5e7eb;">Perlu
                                Restock</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-modern align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 45px;">#</th>
                                        <th>Nama Produk</th>
                                        <th class="text-center" style="width: 80px;">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $produkStokRendah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $produk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td class="text-center text-muted font-monospace" style="font-size: 0.75rem;">
                                                <?php echo e($produkStokRendah->firstItem() + $index); ?>

                                            </td>
                                            <td class="fw-medium text-dark"><?php echo e($produk->nama); ?></td>
                                            <td class="text-center">
                                                <span class="badge px-2 py-0.5 rounded-pill fw-bold"
                                                    style="background: #f3f4f6; color: #111827; font-size: 0.75rem; border: 1px solid #e5e7eb;">
                                                    <?php echo e($produk->stok); ?>

                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted"
                                                style="font-size: 0.8rem;">
                                                <i class="bi bi-check2-circle fs-5 d-block mb-1 text-dark"></i>
                                                Seluruh stok produk dalam batas aman.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if($produkStokRendah->hasPages()): ?>
                            <div class="card-footer bg-transparent border-0 d-flex justify-content-center py-2">
                                <?php echo e($produkStokRendah->links()); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="col-12 col-lg-6">
                    <div class="card card-modern h-100">
                        <div class="p-3 d-flex justify-content-between align-items-center border-bottom border-light"
                            style="background: #ffffff;">
                            <span class="fw-semibold text-dark d-flex align-items-center gap-1.5"
                                style="font-size: 0.8rem;">
                                <i class="bi bi-x-circle"></i> Stok Habis
                            </span>
                            <span class="badge rounded-pill px-2.5 py-0.5"
                                style="background: #000000; color: #ffffff; font-size: 0.68rem; font-weight: 500;">Kosong</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-modern align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 45px;">#</th>
                                        <th>Nama Produk</th>
                                        <th class="text-center" style="width: 80px;">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $produkStokHabis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $produk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td class="text-center text-muted font-monospace" style="font-size: 0.75rem;">
                                                <?php echo e($produkStokHabis->firstItem() + $index); ?>

                                            </td>
                                            <td class="fw-medium text-dark"><?php echo e($produk->nama); ?></td>
                                            <td class="text-center">
                                                <span class="badge px-2 py-0.5 rounded-pill fw-bold"
                                                    style="background: #000000; color: #ffffff; font-size: 0.75rem;">
                                                    <?php echo e($produk->stok); ?>

                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted"
                                                style="font-size: 0.8rem;">
                                                <i class="bi bi-box-seam fs-5 text-muted d-block mb-1"></i>
                                                Tidak ada produk yang kehabisan stok.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if($produkStokHabis->hasPages()): ?>
                            <div class="card-footer bg-transparent border-0 d-flex justify-content-center py-2">
                                <?php echo e($produkStokHabis->links()); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="mb-3 anim-item delay-3">
            <h6 class="fw-bold text-dark mb-2.5 d-flex align-items-center gap-2" style="font-size: 0.9rem;">
                <i class="bi bi-trophy-fill text-dark"></i>
                Produk Terlaris
            </h6>

            <div class="card card-modern overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-modern align-middle">
                        <thead>
                            <tr>
                                <th class="ps-3" style="width: 65px;">Peringkat</th>
                                <th>Nama Produk</th>
                                <th class="text-center">Sisa Stok</th>
                                <th class="text-end pe-3">Total Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $produkTerlaris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $produk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="ps-3">
                                        <?php if($index == 0): ?>
                                            <span class="badge-rank rank-1">1</span>
                                        <?php elseif($index == 1): ?>
                                            <span class="badge-rank rank-2">2</span>
                                        <?php elseif($index == 2): ?>
                                            <span class="badge-rank rank-3">3</span>
                                        <?php else: ?>
                                            <span class="text-muted fw-semibold ps-1"
                                                style="font-size: 0.8rem;"><?php echo e($index + 1); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-medium text-dark">
                                        <?php echo e($produk->nama); ?>

                                    </td>
                                    <td class="text-center text-muted font-monospace" style="font-size: 0.8rem;">
                                        <?php echo e($produk->stok); ?></td>
                                    <td class="text-end pe-3">
                                        <span class="badge fw-semibold px-2.5 py-1 rounded-pill"
                                            style="background: #f3f4f6; color: #111827; border: 1px solid #e5e7eb; font-size: 0.75rem;">
                                            <?php echo e(number_format($produk->total_terjual)); ?> unit
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted" style="font-size: 0.8rem;">
                                        <i class="bi bi-bar-chart-line fs-5 text-muted d-block mb-1"></i>
                                        Belum ada data penjualan tercatat.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\apk_posbaru\resources\views/dashboard.blade.php ENDPATH**/ ?>
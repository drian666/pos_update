<?php $__env->startSection('title', 'Detail Transaksi Penjualan'); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<style>
    body {
        background-color: #f9fafb !important;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .card-mono {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 0.875rem;
    }

    .btn-outline-mono {
        background: #fff;
        color: #374151;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: 0.85rem;
        padding: 0.6rem 1.25rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-outline-mono:hover {
        background: #f3f4f6;
        color: #000;
    }

    .table-mono th {
        background: #f9fafb !important;
        color: #4b5563 !important;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #d1d5db !important;
        padding: 1rem;
    }

    .table-mono td {
        border-bottom: 1px solid #f3f4f6 !important;
        padding: 1rem;
        vertical-align: middle;
        font-size: 0.85rem;
    }
</style>

<div class="container py-4" style="max-width: 900px;">

    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-3 mb-4 border-bottom">
        <div>
            <h1 class="fw-bold mb-1" style="font-size: 1.5rem;">Detail Transaksi</h1>
            <p class="text-muted mb-0 small font-monospace">
                Nota: <?php echo e($penjualan->kode_transaksi ?? 'INV-' . $penjualan->id); ?>

            </p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="<?php echo e(route('penjualan.index')); ?>" class="btn btn-outline-mono">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card card-mono p-3 h-100">
                <span class="text-muted small d-block mb-1">Kasir / Operator</span>
                <span class="fw-semibold">
                    <i class="bi bi-person-circle me-1"></i>
                    <?php echo e($penjualan->user->name ?? 'Admin'); ?>

                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-mono p-3 h-100">
                <span class="text-muted small d-block mb-1">Tanggal Transaksi</span>
                <span class="fw-semibold font-monospace">
                    <?php echo e($penjualan->created_at?->format('d M Y, H:i') ?? '-'); ?>

                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-mono p-3 h-100">
                <span class="text-muted small d-block mb-1">Metode Pembayaran</span>
                <span class="badge rounded-pill border px-2 py-1 mt-1"
                    style="background:#f3f4f6; color:#374151; font-size:0.75rem;">
                    <?php echo e(strtoupper($penjualan->metode_pembayaran ?? 'CASH')); ?>

                </span>
            </div>
        </div>
    </div>

    
    <div class="card card-mono mb-4">
        <div class="card-header bg-white py-3 px-4 border-bottom">
            <h6 class="fw-bold mb-0">
                <i class="bi bi-box-seam me-1"></i> Daftar Barang Dibeli
            </h6>
        </div>

        <div class="table-responsive">
            <table class="table table-mono align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width:50px;">#</th>
                        <th>Nama Produk</th>
                        <th class="text-center">Harga Satuan</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $penjualan->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center text-muted font-monospace"><?php echo e($index + 1); ?></td>
                            <td class="fw-semibold">
                                <?php echo e($detail->produk->nama ?? 'Produk Dihapus'); ?>

                            </td>
                            <td class="text-center font-monospace text-muted">
                                Rp <?php echo e(number_format($detail->harga_satuan, 0, ',', '.')); ?>

                            </td>
                            <td class="text-center font-monospace">
                                <?php echo e($detail->kuantitas); ?>

                            </td>
                            <td class="text-end font-monospace fw-bold">
                                Rp <?php echo e(number_format($detail->subtotal, 0, ',', '.')); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Tidak ada detail produk.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr style="background:#f9fafb;">
                        <td colspan="4" class="text-end fw-bold py-3">Total Keseluruhan:</td>
                        <td class="text-end fw-bold font-monospace py-3" style="font-size:1.05rem;">
                            Rp <?php echo e(number_format($penjualan->total_pembayaran, 0, ',', '.')); ?>

                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\apk_posbaru\resources\views/penjualan/show.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Jenis Produk'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <style>
        .page-header {
            margin-bottom: 1.75rem;
        }

        .btn-black {
            background-color: #000;
            border-color: #000;
            color: #fff;
        }

        .btn-black:hover {
            background-color: #222;
            border-color: #222;
            color: #fff;
        }

        .btn-outline-black {
            color: #000;
            border-color: #d1d5db;
        }

        .btn-outline-black:hover {
            background-color: #f3f4f6;
            border-color: #000;
            color: #000;
        }

        .table thead th {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            font-weight: 600;
            color: #6b7280;
            border-bottom-width: 1px;
        }

        .empty-state {
            padding: 3.5rem 1rem;
            text-align: center;
            color: #9ca3af;
        }
    </style>

    <div class="container my-4" style="max-width: 1100px;">

        
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 page-header">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">Daftar Jenis</h1>
                <p class="text-muted mb-0 small">Kelola kategori / jenis produk</p>
            </div>
            <div>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\Jenis::class)): ?>
                <a href="<?php echo e(route('jenis.create')); ?>"
                    class="btn btn-black d-inline-flex align-items-center gap-2 px-3 shadow-sm">
                    <i class="bi bi-plus-lg"></i>
                    <span>Tambah Jenis</span>
                </a>
<?php endif; ?>
            </div>
        </div>

        
        <div class="card border-0 shadow-sm mb-4 rounded-3">
            <div class="card-body p-3">
                <form action="<?php echo e(route('jenis.index')); ?>" method="GET">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                            class="form-control border-start-0" placeholder="Cari berdasarkan nama jenis...">
                        <button class="btn btn-black px-4" type="submit">Cari</button>
                        <?php if(request('search')): ?>
                            <a href="<?php echo e(route('jenis.index')); ?>" class="btn btn-outline-secondary">Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4" style="width: 80px;">#</th>
                            <th>Nama Jenis</th>
                            <th class="text-center pe-4" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $jenis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="ps-4 text-muted">
                                    <?php echo e($jenis->firstItem() + $loop->index); ?>

                                </td>
                                <td class="fw-semibold text-dark">
                                    <?php echo e($item->nama_jenis); ?>

                                </td>
                                <td class="text-center pe-4">
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $item)): ?>
                                    <div class="d-inline-flex gap-2">
                                        <a href="<?php echo e(route('jenis.edit', $item)); ?>" class="btn btn-sm btn-outline-black">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>

                                        <form action="<?php echo e(route('jenis.destroy', $item)); ?>" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus jenis ini?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
<?php else: ?> <span class="text-muted">—</span> <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3">
                                    <div class="empty-state">
                                        <i class="bi bi-tags fs-1 d-block mb-3 opacity-50"></i>
                                        <p class="fs-5 fw-semibold text-secondary mb-1">Belum ada data jenis</p>
                                        <p class="small mb-0">Tambahkan jenis produk pertama Anda atau ubah kata kunci
                                            pencarian.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($jenis->hasPages()): ?>
                <div class="card-footer bg-white border-top py-3 px-4">
                    <?php echo e($jenis->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\apk_posbaru\resources\views/jenis/index.blade.php ENDPATH**/ ?>
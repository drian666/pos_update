<?php $__env->startSection('title', 'Manajemen Users'); ?>

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
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
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

    /* Action Buttons */
    .btn-action {
        padding: 0.35rem 0.75rem;
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

    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-3 mb-4 border-bottom border-secondary border-opacity-10">
        <div>
            <h1 class="fw-bold mb-1" style="font-size: 1.5rem; letter-spacing: -0.02em; color: #111827;">
                Manajemen Users
            </h1>
            <p class="text-muted mb-0 small">Kelola daftar pengguna, peranan (role), dan hak akses sistem.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-black">
                <i class="bi bi-person-plus-fill fs-6"></i> Tambah User Baru
            </a>
        </div>
    </div>

    
    <div class="row mb-3">
        <div class="col-12 col-md-6 col-lg-4">
            <form action="<?php echo e(route('admin.users')); ?>" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control input-search-mono" placeholder="Cari nama atau email..." value="<?php echo e(request('search')); ?>">
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
                        <th>Nama</th>
                        <th>Email</th>
                        <th class="text-center">Role</th>
                        <th class="text-center" style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $listUsers = $users ?? $user ?? [];
                    ?>

                    <?php $__empty_1 = true; $__currentLoopData = $listUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-center text-muted font-monospace">
                            <?php echo e(method_exists($listUsers, 'firstItem') ? $listUsers->firstItem() + $index : $index + 1); ?>

                        </td>
                        <td class="fw-medium text-dark">
                            <i class="bi bi-person-circle me-1.5 text-muted"></i> <?php echo e($item->name); ?>

                        </td>
                        <td class="text-muted font-monospace small">
                            <?php echo e($item->email); ?>

                        </td>
                        <td class="text-center">
                            <?php if(strtolower($item->role->name ?? $item->role ?? 'kasir') == 'admin'): ?>
                                <span class="badge px-2.5 py-1 rounded-pill fw-bold" style="background: #000000; color: #ffffff; font-size: 0.7rem;">
                                    <i class="bi bi-shield-lock-fill me-1"></i> Admin
                                </span>
                            <?php else: ?>
                                <span class="badge px-2.5 py-1 rounded-pill fw-semibold" style="background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; font-size: 0.7rem;">
                                    <i class="bi bi-person-badge-fill me-1"></i> Kasir
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="<?php echo e(route('admin.users.edit', $item->id)); ?>" class="btn btn-action" title="Edit Akun">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                
                                <form action="<?php echo e(route('admin.users.destroy', $item->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-action btn-action-danger" title="Hapus User">
                                        <i class="bi bi-trash-fill"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-4 d-block mb-2 text-muted"></i>
                            Belum ada data user.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if(is_object($listUsers) && method_exists($listUsers, 'hasPages') && $listUsers->hasPages()): ?>
        <div class="card-footer bg-white border-top d-flex justify-content-center py-3" style="font-size: 0.85rem;">
            <?php echo e($listUsers->links()); ?>

        </div>
        <?php endif; ?>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\apk_posbaru\resources\views/users/index.blade.php ENDPATH**/ ?>
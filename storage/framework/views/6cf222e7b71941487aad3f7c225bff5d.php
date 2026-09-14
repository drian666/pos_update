<?php $__env->startSection('title', 'Profil Pembuat • POS Adrian'); ?>
<?php $__env->startSection('styles'); ?>
<style>
body{background:#f5f6f8;color:#18202c}.profile-shell{max-width:1080px}.profile-banner{background:#111827;color:white;padding:44px 32px 72px;border-radius:24px 24px 0 0}.profile-card{border:1px solid #e5e7eb;border-radius:24px;background:white;overflow:hidden}.profile-avatar{width:128px;height:128px;object-fit:cover;border:6px solid white;border-radius:50%;background:#e5e7eb;display:flex;align-items:center;justify-content:center;font-size:40px;font-weight:700;margin-top:-64px;position:relative}.profile-label{letter-spacing:.15em;font-size:11px;text-transform:uppercase;font-weight:700}.profile-panel{background:#f8fafc;border:1px solid #e5e7eb;border-radius:16px;padding:24px;height:100%}.bio-text{white-space:pre-line;overflow-wrap:anywhere;line-height:1.9}.skill-pill{border:1px solid #dce1e7;border-radius:999px;padding:7px 13px;font-size:13px;background:white}.profile-links a{overflow-wrap:anywhere}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<main class="container profile-shell py-4 py-lg-5">
    <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
        <div><p class="profile-label text-secondary mb-2">Di balik aplikasi</p><h1 class="h3 fw-bold mb-0">Tentang Pembuat</h1></div>
        <?php if(auth()->user()->hasRole('admin')): ?>
        <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-dark rounded-3 text-nowrap"><i class="bi bi-pencil-square me-1"></i> Edit Profil</a>
        <?php endif; ?>
    </div>
    <?php if(session('success')): ?><div class="alert alert-success" role="status"><?php echo e(session('success')); ?></div><?php endif; ?>
    <article class="profile-card shadow-sm">
        <div class="profile-banner"><p class="profile-label text-white-50 mb-2">POS Adrian / Developer Profile</p><h2 class="h4 mb-0"></h2></div>
        <div class="px-4 px-lg-5 pb-4 pb-lg-5">
            <?php if($profile->photo): ?>
            <img src="<?php echo e(asset('storage/' . $profile->photo)); ?>" class="profile-avatar" alt="Foto <?php echo e($profile->name); ?>">
            <?php else: ?>
            <div class="profile-avatar" aria-label="Inisial pembuat"><?php echo e(mb_strtoupper(mb_substr($profile->name, 0, 1))); ?></div>
            <?php endif; ?>
            <div class="mt-3 mb-4"><h2 class="h2 fw-bold mb-1"><?php echo e($profile->name); ?></h2><p class="text-secondary mb-0"><?php echo e($profile->headline ?: 'Pengembang aplikasi Point of Sale'); ?></p></div>
            <div class="row g-4">
                <div class="col-lg-7"><section class="profile-panel"><h3 class="h6 fw-bold mb-3"><i class="bi bi-person-lines-fill me-2"></i>Tentang Saya</h3><p class="bio-text mb-4"><?php echo e($profile->bio ?: 'Biodata belum ditambahkan.'); ?></p><h3 class="h6 fw-bold mb-3">Keahlian & Teknologi</h3><div class="d-flex flex-wrap gap-2">
                    <?php $__empty_1 = true; $__currentLoopData = array_filter(array_map('trim', explode(',', $profile->skills ?? ''))); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <span class="skill-pill"><?php echo e($skill); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><span class="text-secondary small">Keahlian belum ditambahkan.</span><?php endif; ?>
                </div></section></div>
                <div class="col-lg-5"><section class="profile-panel profile-links"><h3 class="h6 fw-bold mb-4">Informasi Pembuat</h3>
                    <p class="small text-secondary mb-1">Sekolah / Instansi</p><p class="fw-semibold"><?php echo e($profile->school ?: 'Belum diisi'); ?></p>
                    <p class="small text-secondary mb-1">Jurusan / Bidang</p><p class="fw-semibold"><?php echo e($profile->major ?: 'Belum diisi'); ?></p>
                    <p class="small text-secondary mb-1">Email</p><p><?php echo e($profile->email ?: 'Belum diisi'); ?></p>
                    <div class="d-flex flex-wrap gap-2 mt-4">
                    <?php if($profile->github_url): ?><a href="<?php echo e($profile->github_url); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-dark btn-sm"><i class="bi bi-github me-1"></i> GitHub</a><?php endif; ?>
                    <?php if($profile->website_url): ?><a href="<?php echo e($profile->website_url); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-dark btn-sm"><i class="bi bi-globe me-1"></i> Website / Project</a><?php endif; ?>
                    </div>
                </section></div>
            </div>
        </div>
    </article>
    <p class="text-secondary small text-center mt-4">Dibangun untuk mempermudah pengelolaan produk dan transaksi penjualan.</p>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\apk_posbaru\resources\views/profile/index.blade.php ENDPATH**/ ?>
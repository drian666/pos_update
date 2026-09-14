<style>
    /* Custom Navbar Styling - Clean Monochrome (Black & White) */
    .navbar-custom {
        background: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-bottom: 1px solid #e5e7eb;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03);
        padding: 0.75rem 1.5rem;
    }

    .navbar-custom .navbar-brand {
        color: #000000 !important;
        font-weight: 800;
        font-size: 1.2rem;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .navbar-custom .brand-icon {
        width: 36px;
        height: 36px;
        background: #ffffff;
        /* ← diubah jadi putih */
        border: 1px solid #e5e7eb;
        /* garis tipis biar kelihatan */
        border-radius: 0.625rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #000000;
        font-size: 1.05rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .navbar-custom .nav-link {
        color: #4b5563 !important;
        font-weight: 500;
        font-size: 0.875rem;
        padding: 0.5rem 0.9rem !important;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .navbar-custom .nav-link:hover {
        color: #000000 !important;
        background: #f3f4f6;
    }

    .navbar-custom .nav-link.active {
        background: #000000 !important;
        color: #ffffff !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    /* Style Widget Jam Live */
    .navbar-custom .live-clock-pill {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        padding: 0.35rem 0.85rem;
        border-radius: 50rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.825rem;
        color: #111827;
        transition: all 0.2s ease;
    }

    .navbar-custom .live-clock-pill:hover {
        border-color: #000000;
        background: #f3f4f6;
    }

    /* Profile / User Dropdown Pill */
    .navbar-custom .user-pill {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        padding: 0.3rem 0.8rem 0.3rem 0.35rem;
        border-radius: 50rem;
        color: #111827;
        transition: all 0.2s ease;
    }

    .navbar-custom .user-pill:hover {
        border-color: #000000;
        background: #f3f4f6;
    }

    .navbar-custom .avatar-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #000000;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .navbar-custom .dropdown-menu {
        background-color: #ffffff !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 0.75rem;
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
        margin-top: 0.6rem;
        padding: 0.4rem !important;
    }

    .navbar-custom .dropdown-item {
        color: #374151 !important;
        font-weight: 500;
        font-size: 0.85rem;
        padding: 0.55rem 0.9rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .navbar-custom .dropdown-item:hover {
        background-color: #f3f4f6 !important;
        color: #000000 !important;
    }

    .navbar-custom .dropdown-item.text-danger:hover {
        background-color: #fee2e2 !important;
        color: #dc2626 !important;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container" style="max-width: 1400px;">
        
        <a class="navbar-brand" href="<?php echo e(url('/dashboard')); ?>">
            <div class="brand-icon">
                <img src="<?php echo e(asset('images/smkn4baru.png')); ?>" alt="Logo Sekolah"
                    style="width: 28px; height: 28px; object-fit: contain;">
            </div>
            <span><span style="color: #000000;">POS Adrian</span></span>
        </a>

        
        <button class="navbar-toggler border-0 text-dark shadow-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="bi bi-list fs-3"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
        
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-1">
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->is('dashboard') ? 'active' : ''); ?>" href="<?php echo e(url('/dashboard')); ?>">
                    <i class="bi bi-grid-fill"></i> Dashboard
                </a>
            </li>
            <?php if(auth()->user()->hasRole('admin')): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->is('admin/users*') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.users')); ?>">
                    <i class="bi bi-people-fill"></i> Users
                </a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->is('produk*') ? 'active' : ''); ?>" href="<?php echo e(url('/produk')); ?>">
                    <i class="bi bi-box-fill"></i> Produk
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->is('jenis*') ? 'active' : ''); ?>" href="<?php echo e(url('/jenis')); ?>">
                    <i class="bi bi-tags-fill"></i> Jenis
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->is('penjualan*') ? 'active' : ''); ?>" href="<?php echo e(url('/penjualan')); ?>">
                    <i class="bi bi-file-earmark-bar-graph-fill"></i> Penjualan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>" href="<?php echo e(route('profile.index')); ?>">
                    <i class="bi bi-person-badge"></i> Profil
                </a>
            </li>
        </ul>

        
        <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">

            
            <div class="live-clock-pill">
                <i class="bi bi-clock-history text-muted"></i>
                <span id="nav-live-date" class="text-muted small d-none d-md-inline"></span>
                <span id="nav-live-clock" class="fw-bold font-monospace text-dark">00:00:00 WIB</span>
            </div>

            <form action="<?php echo e(route('logout')); ?>" method="POST" class="m-0">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-outline-dark btn-sm text-nowrap">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>
    </div>
</nav>

<script>
    function updateNavbarClock() {
        const now = new Date();

        // Format Waktu (HH:MM:SS)
        const parts = new Intl.DateTimeFormat('en-GB', {timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false}).format(now).split(':');
        const hours = parts[0];
        const minutes = parts[1];
        const seconds = parts[2];

        const clockElem = document.getElementById('nav-live-clock');
        if (clockElem) {
            clockElem.innerText = `${hours}:${minutes}:${seconds} WIB`;
        }

        // Format Tanggal Indonesia (Contoh: Jum, 31 Jul)
        const options = {
            timeZone: 'Asia/Jakarta',
            weekday: 'short',
            day: 'numeric',
            month: 'short'
        };
        const formattedDate = now.toLocaleDateString('id-ID', options);

        const dateElem = document.getElementById('nav-live-date');
        if (dateElem) {
            dateElem.innerText = formattedDate + ' •';
        }
    }

    // Jalankan pertama kali & perbarui setiap detik
    updateNavbarClock();
    setInterval(updateNavbarClock, 1000);
</script>
<?php /**PATH C:\laragon\www\apk_posbaru\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>
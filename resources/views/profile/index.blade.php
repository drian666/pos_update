@extends('layouts.app')
@section('title', 'Profil Pembuat • POS Adrian')
@section('styles')
<style>
body{background:#f5f6f8;color:#18202c}.profile-shell{max-width:1080px}.profile-banner{background:#111827;color:white;padding:44px 32px 72px;border-radius:24px 24px 0 0}.profile-card{border:1px solid #e5e7eb;border-radius:24px;background:white;overflow:hidden}.profile-avatar{width:128px;height:128px;object-fit:cover;border:6px solid white;border-radius:50%;background:#e5e7eb;display:flex;align-items:center;justify-content:center;font-size:40px;font-weight:700;margin-top:-64px;position:relative}.profile-label{letter-spacing:.15em;font-size:11px;text-transform:uppercase;font-weight:700}.profile-panel{background:#f8fafc;border:1px solid #e5e7eb;border-radius:16px;padding:24px;height:100%}.bio-text{white-space:pre-line;overflow-wrap:anywhere;line-height:1.9}.skill-pill{border:1px solid #dce1e7;border-radius:999px;padding:7px 13px;font-size:13px;background:white}.profile-links a{overflow-wrap:anywhere}
</style>
@endsection
@section('content')
@include('layouts.navbar')
<main class="container profile-shell py-4 py-lg-5">
    <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
        <div><p class="profile-label text-secondary mb-2">Di balik aplikasi</p><h1 class="h3 fw-bold mb-0">Tentang Pembuat</h1></div>
        @if(auth()->user()->hasRole('admin'))
        <a href="{{ route('profile.edit') }}" class="btn btn-dark rounded-3 text-nowrap"><i class="bi bi-pencil-square me-1"></i> Edit Profil</a>
        @endif
    </div>
    @if(session('success'))<div class="alert alert-success" role="status">{{ session('success') }}</div>@endif
    <article class="profile-card shadow-sm">
        <div class="profile-banner"><p class="profile-label text-white-50 mb-2">POS Adrian / Developer Profile</p><h2 class="h4 mb-0"></h2></div>
        <div class="px-4 px-lg-5 pb-4 pb-lg-5">
            @if($profile->photo)
            <img src="{{ asset('storage/' . $profile->photo) }}" class="profile-avatar" alt="Foto {{ $profile->name }}">
            @else
            <div class="profile-avatar" aria-label="Inisial pembuat">{{ mb_strtoupper(mb_substr($profile->name, 0, 1)) }}</div>
            @endif
            <div class="mt-3 mb-4"><h2 class="h2 fw-bold mb-1">{{ $profile->name }}</h2><p class="text-secondary mb-0">{{ $profile->headline ?: 'Pengembang aplikasi Point of Sale' }}</p></div>
            <div class="row g-4">
                <div class="col-lg-7"><section class="profile-panel"><h3 class="h6 fw-bold mb-3"><i class="bi bi-person-lines-fill me-2"></i>Tentang Saya</h3><p class="bio-text mb-4">{{ $profile->bio ?: 'Biodata belum ditambahkan.' }}</p><h3 class="h6 fw-bold mb-3">Keahlian & Teknologi</h3><div class="d-flex flex-wrap gap-2">
                    @forelse(array_filter(array_map('trim', explode(',', $profile->skills ?? ''))) as $skill)
                    <span class="skill-pill">{{ $skill }}</span>
                    @empty<span class="text-secondary small">Keahlian belum ditambahkan.</span>@endforelse
                </div></section></div>
                <div class="col-lg-5"><section class="profile-panel profile-links"><h3 class="h6 fw-bold mb-4">Informasi Pembuat</h3>
                    <p class="small text-secondary mb-1">Sekolah / Instansi</p><p class="fw-semibold">{{ $profile->school ?: 'Belum diisi' }}</p>
                    <p class="small text-secondary mb-1">Jurusan / Bidang</p><p class="fw-semibold">{{ $profile->major ?: 'Belum diisi' }}</p>
                    <p class="small text-secondary mb-1">Email</p><p>{{ $profile->email ?: 'Belum diisi' }}</p>
                    <div class="d-flex flex-wrap gap-2 mt-4">
                    @if($profile->github_url)<a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-dark btn-sm"><i class="bi bi-github me-1"></i> GitHub</a>@endif
                    @if($profile->website_url)<a href="{{ $profile->website_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-dark btn-sm"><i class="bi bi-globe me-1"></i> Website / Project</a>@endif
                    </div>
                </section></div>
            </div>
        </div>
    </article>
    <p class="text-secondary small text-center mt-4">Dibangun untuk mempermudah pengelolaan produk dan transaksi penjualan.</p>
</main>
@endsection

@extends('layouts.app')
@section('title', 'Edit Profil Pembuat')
@section('styles')<style>body{background:#f5f6f8}.form-control:focus{border-color:#495057;box-shadow:0 0 0 .2rem #11182715}</style>@endsection
@section('content')
@include('layouts.navbar')
<main class="container py-4 py-lg-5" style="max-width:900px">
    <a href="{{ route('profile.index') }}" class="text-secondary text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Kembali ke Profil</a>
    <h1 class="h3 fw-bold mt-3">Edit Profil Pembuat</h1><p class="text-secondary mb-4">Ceritakan tentang diri dan project yang kamu buat.</p>
    @if($errors->any())<div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white border rounded-4 p-4 p-lg-5 shadow-sm">
        @csrf @method('PUT')
        <h2 class="h6 fw-bold mb-3">Foto Profil</h2>
        <div class="d-flex flex-wrap align-items-center gap-4 mb-4 pb-4 border-bottom">
            <img id="photo-preview" src="{{ $profile->photo ? asset('storage/' . $profile->photo) : asset('images/profile-placeholder.svg') }}" alt="Pratinjau foto profil" style="width:96px;height:96px;object-fit:cover;border-radius:50%;background:#f3f4f6">
            <div class="flex-grow-1"><label for="photo" class="form-label">Pilih foto baru</label><input type="file" id="photo" name="photo" class="form-control" accept="image/jpeg,image/png,image/webp"><div class="form-text">JPG, PNG, atau WEBP. Maksimal 2 MB.</div>
                @if($profile->photo)<div class="form-check mt-2"><input class="form-check-input" id="remove_photo" name="remove_photo" type="checkbox" value="1" @checked(old('remove_photo'))><label for="remove_photo" class="form-check-label small">Hapus foto saat ini</label></div>@endif
            </div>
        </div><div class="row g-3">
<div class="col-md-6"><label for="name" class="form-label fw-semibold small">Nama lengkap *</label><input id="name" name="name" type="text" maxlength="255" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $profile->name) }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label for="headline" class="form-label fw-semibold small">Judul singkat / Peran</label><input id="headline" name="headline" type="text" maxlength="255" class="form-control @error('headline') is-invalid @enderror" value="{{ old('headline', $profile->headline) }}" >@error('headline')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label for="school" class="form-label fw-semibold small">Sekolah / Instansi</label><input id="school" name="school" type="text" maxlength="255" class="form-control @error('school') is-invalid @enderror" value="{{ old('school', $profile->school) }}" >@error('school')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label for="major" class="form-label fw-semibold small">Jurusan / Bidang</label><input id="major" name="major" type="text" maxlength="255" class="form-control @error('major') is-invalid @enderror" value="{{ old('major', $profile->major) }}" >@error('major')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label for="email" class="form-label fw-semibold small">Email kontak</label><input id="email" name="email" type="email" maxlength="255" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $profile->email) }}" >@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label for="skills" class="form-label fw-semibold small">Keahlian (pisahkan dengan koma)</label><input id="skills" name="skills" type="text" maxlength="500" class="form-control @error('skills') is-invalid @enderror" value="{{ old('skills', $profile->skills) }}" >@error('skills')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label for="github_url" class="form-label fw-semibold small">Tautan GitHub</label><input id="github_url" name="github_url" type="url" maxlength="500" class="form-control @error('github_url') is-invalid @enderror" value="{{ old('github_url', $profile->github_url) }}" >@error('github_url')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label for="website_url" class="form-label fw-semibold small">Tautan Website / Project</label><input id="website_url" name="website_url" type="url" maxlength="500" class="form-control @error('website_url') is-invalid @enderror" value="{{ old('website_url', $profile->website_url) }}" >@error('website_url')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-12"><label for="bio" class="form-label fw-semibold small">Tentang Saya</label><textarea name="bio" id="bio" rows="6" maxlength="5000" class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $profile->bio) }}</textarea>@error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
        <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top"><a href="{{ route('profile.index') }}" class="btn btn-outline-secondary">Batal</a><button type="submit" class="btn btn-dark"><i class="bi bi-check2 me-1"></i> Simpan Perubahan</button></div>
    </form>
</main>
@endsection
@section('scripts')
<script>
const photoInput = document.getElementById('photo');
const preview = document.getElementById('photo-preview');
const originalPhoto = preview.src;
let previewUrl;
photoInput.addEventListener('change', () => {
    if (previewUrl) URL.revokeObjectURL(previewUrl);
    const file = photoInput.files[0];
    if (!file) { preview.src = originalPhoto; return; }
    if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type) || file.size > 2 * 1024 * 1024) {
        photoInput.value = ''; preview.src = originalPhoto;
        alert('Pilih JPG, PNG, atau WEBP maksimal 2 MB.'); return;
    }
    previewUrl = URL.createObjectURL(file); preview.src = previewUrl;
    const remove = document.getElementById('remove_photo'); if (remove) remove.checked = false;
});
</script>
@endsection

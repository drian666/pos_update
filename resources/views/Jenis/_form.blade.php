@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center mb-1">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Terjadi kesalahan:</strong>
        </div>
        <ul class="mb-0 ps-3 small">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="mb-4">
    <label for="nama_jenis" class="form-label fw-semibold">Nama Jenis</label>
    <input type="text" id="nama_jenis" name="nama_jenis"
        class="form-control form-control-lg @error('nama_jenis') is-invalid @enderror"
        placeholder="Contoh: Minuman, Makanan, Snack..." value="{{ old('nama_jenis', $jenis->nama_jenis ?? '') }}"
        required autofocus>
    @error('nama_jenis')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex justify-content-end gap-2 pt-2">
    <a href="{{ route('jenis.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
    <button type="submit" class="btn btn-black px-4 fw-semibold">
        <i class="bi bi-check-lg me-1"></i> Simpan
    </button>
</div>

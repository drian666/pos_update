@extends('layouts.app')
@section('title', 'Edit Transaksi OPEN')
@section('content')
@include('layouts.navbar')
<main class="container py-4" style="max-width:1000px">
    <a href="{{ route('penjualan.index') }}" class="text-secondary text-decoration-none"><i class="bi bi-arrow-left"></i> Kembali</a>
    <h1 class="h3 fw-bold mt-3">Edit Transaksi #{{ $penjualan->id }}</h1>
    <p class="text-secondary">Sesuaikan isi transaksi OPEN. Stok dan total dihitung kembali saat disimpan.</p>
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST" class="card p-4 shadow-sm">
        @csrf @method('PUT')
        <div class="d-flex flex-wrap gap-2 mb-3">
            <select id="new-product" class="form-select flex-grow-1" style="width:auto" aria-label="Produk tambahan">
                <option value="">Pilih produk tambahan</option>
                @foreach($produks as $produk)<option value="{{ $produk->id }}">{{ $produk->nama }} — Stok {{ $produk->stok }}</option>@endforeach
            </select>
            <button type="button" id="add-product" class="btn btn-outline-dark">Tambah Produk</button>
        </div>
        <div class="table-responsive"><table class="table align-middle"><thead><tr><th>Produk</th><th style="width:140px">Jumlah</th><th style="width:90px">Aksi</th></tr></thead><tbody id="sale-items">
        @php
            $ids = old('produk_id', $penjualan->details->pluck('produk_id')->all());
            $quantities = old('jumlah', $penjualan->details->pluck('kuantitas')->all());
            $names = $produks->pluck('nama', 'id');
            foreach ($penjualan->details as $detail) { $names[$detail->produk_id] = $detail->produk?->nama ?? 'Produk dihapus'; }
        @endphp
        @foreach($ids as $index => $productId)
            <tr data-product-id="{{ $productId }}"><td>{{ $names[$productId] ?? 'Produk tidak tersedia' }}<input type="hidden" name="produk_id[]" value="{{ $productId }}"></td><td><input class="form-control" name="jumlah[]" type="number" min="1" step="1" required value="{{ $quantities[$index] ?? 1 }}" aria-label="Jumlah produk"></td><td><button type="button" class="btn btn-outline-danger btn-sm remove-item">Hapus</button></td></tr>
        @endforeach
        </tbody></table></div>
        <div class="row g-3 mt-2">
            <div class="col-md-6"><label for="payment" class="form-label">Metode Pembayaran</label><select id="payment" name="metode_pembayaran" class="form-select">@foreach(['CASH', 'TRANSFER', 'QRIS'] as $method)<option value="{{ $method }}" @selected(old('metode_pembayaran', $penjualan->metode_pembayaran) === $method)>{{ $method }}</option>@endforeach</select></div>
            <div class="col-md-6"><label for="status" class="form-label">Status</label><select id="status" name="status" class="form-select"><option value="OPEN" @selected(old('status', 'OPEN') === 'OPEN')>Simpan OPEN</option><option value="COMPLETED" @selected(old('status') === 'COMPLETED')>Selesaikan (COMPLETED)</option></select></div>
        </div>
        <p class="small text-secondary mt-3">Pilih COMPLETED setelah pembayaran dikonfirmasi. Transaksi yang sudah selesai tidak dapat diedit atau dihapus.</p>
        <div class="text-end"><button type="submit" class="btn btn-dark">Simpan Perubahan</button></div>
    </form>
</main>
@endsection
@section('scripts')
<script>
const rows = document.getElementById('sale-items');
rows.addEventListener('click', event => { if (event.target.closest('.remove-item')) event.target.closest('tr').remove(); });
document.getElementById('add-product').addEventListener('click', () => {
    const select = document.getElementById('new-product');
    if (!select.value) return;
    const existing = Array.from(rows.rows).find(row => row.dataset.productId === select.value);
    if (existing) { const qty = existing.querySelector('input[type="number"]'); qty.value = Number(qty.value) + 1; return; }
    const row = document.createElement('tr'); row.dataset.productId = select.value;
    const nameCell = row.insertCell(); nameCell.textContent = select.selectedOptions[0].textContent;
    const hidden = document.createElement('input'); hidden.type = 'hidden'; hidden.name = 'produk_id[]'; hidden.value = select.value; nameCell.appendChild(hidden);
    const qty = document.createElement('input'); qty.type = 'number'; qty.name = 'jumlah[]'; qty.value = '1'; qty.min = '1'; qty.step = '1'; qty.required = true; qty.className = 'form-control'; qty.setAttribute('aria-label','Jumlah produk'); row.insertCell().appendChild(qty);
    const button = document.createElement('button'); button.type = 'button'; button.className = 'btn btn-outline-danger btn-sm remove-item'; button.textContent = 'Hapus'; row.insertCell().appendChild(button);
    rows.appendChild(row);
});
</script>
@endsection

@extends('layouts.app')

@section('title', 'Transaksi Baru - Kasir POS')

@section('content')

    @include('layouts.navbar')

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
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .anim-fade {
            animation: fadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Card Minimalis */
        .card-pro {
            background: var(--card-bg) !important;
            border: 1px solid var(--card-border);
            border-radius: 0.875rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02);
        }

        .card-header-pro {
            background: #f9fafb !important;
            border-bottom: 1px solid #e5e7eb !important;
            padding: 1rem 1.25rem;
            border-radius: 0.875rem 0.875rem 0 0;
        }

        /* Product Grid Card */
        .product-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 0.875rem;
            transition: all 0.2s ease;
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-card:hover {
            border-color: #000000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .product-img {
            width: 100%;
            height: 110px;
            object-fit: cover;
            border-radius: 0.5rem;
            margin-bottom: 0.65rem;
            border: 1px solid #f3f4f6;
        }

        /* Form Controls */
        .form-control,
        .form-select {
            background-color: #ffffff !important;
            border: 1px solid var(--card-border) !important;
            color: #111827 !important;
            border-radius: 0.5rem !important;
            padding: 0.6rem 0.875rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #000000 !important;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05) !important;
            outline: none;
        }

        /* Table Cart */
        .table-cart {
            color: #111827 !important;
            margin-bottom: 0;
        }

        .table-cart th {
            background-color: #f9fafb !important;
            color: #4b5563 !important;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #d1d5db !important;
            padding: 0.75rem;
        }

        .table-cart td {
            border-bottom: 1px solid #f3f4f6 !important;
            padding: 0.75rem;
            vertical-align: middle;
            font-size: 0.85rem;
        }

        /* Checkout & Action Buttons */
        .btn-checkout {
            background: #000000;
            color: #ffffff;
            font-weight: 600;
            border-radius: 0.5rem;
            padding: 0.75rem;
            border: none;
            width: 100%;
            transition: all 0.2s ease;
        }

        .btn-checkout:hover {
            background: #1f2937;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-back-pro {
            background: #ffffff;
            color: #374151;
            border: 1px solid #d1d5db;
            font-weight: 500;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .btn-back-pro:hover {
            background: #f3f4f6;
            color: #000000;
            border-color: #9ca3af;
        }
    </style>

    <div class="container-fluid px-4 py-4 anim-fade" style="max-width: 1400px;">

        {{-- HEADER PAGE --}}
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-10">
            <div>
                <h1 class="fw-bold mb-1" style="font-size: 1.5rem; letter-spacing: -0.02em; color: #111827;">
                    Kasir Transaksi Baru
                </h1>
                <p class="text-muted mb-0 small">Pilih produk dari katalog untuk ditambahkan ke keranjang belanja.</p>
            </div>
            <a href="{{ route('penjualan.index') }}" class="btn-back-pro">
                <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
            </a>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <form action="{{ route('penjualan.store') }}" method="POST" id="formKasir">
            @csrf
            <div class="row g-4">

                {{-- SEKSI KIRI: KATALOG PRODUK --}}
                <div class="col-12 col-lg-7 col-xl-8">
                    <div class="card card-pro p-3 mb-3">
                        <div class="input-group">
                            <span class="input-group-text border-0 text-muted bg-white"
                                style="border-radius: 0.5rem 0 0 0.5rem; border: 1px solid #e5e7eb; border-right: none;">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="searchProduk" class="form-control border-start-0"
                                placeholder="Cari nama produk..." style="border-radius: 0 0.5rem 0.5rem 0 !important;">
                        </div>
                    </div>

                    {{-- DAFTAR PRODUK --}}
                    <div class="row g-3" id="daftarProduk">
                        @forelse($produks as $item)
                            <div class="col-6 col-md-4 col-xl-3 item-produk-wrapper"
                                data-nama="{{ strtolower($item->nama) }}">
                                <div class="product-card"
                                    onclick="addToCart({{ $item->id }}, {{ \Illuminate\Support\Js::from($item->nama) }}, {{ $item->harga_jual }}, {{ $item->stok }})">
                                    <div>
                                        @if ($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}"
                                                class="product-img">
                                        @else
                                            <div class="product-img d-flex align-items-center justify-content-center bg-light text-muted">
                                                <i class="bi bi-image fs-4"></i>
                                            </div>
                                        @endif
                                        <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 0.85rem;"
                                            title="{{ $item->nama }}">{{ $item->nama }}</h6>
                                        <div class="text-muted" style="font-size: 0.75rem;">Stok: <span
                                                class="fw-semibold text-dark">{{ $item->stok }}</span></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-secondary border-opacity-10">
                                        <span class="fw-bold font-monospace text-dark" style="font-size: 0.85rem;">Rp
                                            {{ number_format($item->harga_jual, 0, ',', '.') }}</span>
                                        <button type="button"
                                            class="btn btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center"
                                            style="width: 26px; height: 26px; background: #000000; color: white;">
                                            <i class="bi bi-plus-lg" style="font-size: 0.75rem;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5 text-muted">
                                <i class="bi bi-box-seam fs-4 d-block mb-2"></i>
                                Belum ada data produk berstok yang tersedia.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- SEKSI KANAN: KERANJANG & CHECKOUT --}}
                <div class="col-12 col-lg-5 col-xl-4">
                    <div class="card card-pro">
                        <div class="card-header-pro d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">
                                <i class="bi bi-cart3 me-1 text-dark"></i> Keranjang Belanja
                            </h6>
                            <button type="button"
                                class="btn btn-sm text-danger p-0 border-0 bg-transparent small fw-medium"
                                onclick="clearCart()">
                                <i class="bi bi-trash me-1"></i> Kosongkan
                            </button>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive" style="max-height: 320px; overflow-y: auto;">
                                <table class="table table-cart align-middle">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th class="text-center" style="width: 75px;">Qty</th>
                                            <th class="text-end">Subtotal</th>
                                            <th style="width: 35px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="cartTableBody">
                                        <tr id="emptyCartRow">
                                            <td colspan="4" class="text-center py-4 text-muted small">
                                                Keranjang masih kosong.<br>Klik produk di sebelah kiri.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- TOTAL & METODE BAYAR --}}
                        <div class="card-footer p-3 bg-white border-top" style="border-radius: 0 0 0.875rem 0.875rem;">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">Metode Pembayaran</label>
                                <select name="metode_pembayaran" id="metodePembayaran" class="form-select" required onchange="toggleMetodePay()">
                                    <option value="QRIS">QRIS</option>
                                    <option value="CASH">CASH / TUNAI</option>
                                    <option value="TRANSFER">TRANSFER BANK</option>
                                </select>
                            </div>

                            {{-- PANEL WIDGET SCAN QRIS RINGKAS --}}
                            <div id="qrisMiniWidget" class="p-3 mb-3 border rounded-3 bg-light text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2 mb-2 text-dark fw-semibold small">
                                    <i class="bi bi-qr-code-scan fs-5 text-primary"></i> Scan Pembayaran QRIS
                                </div>
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=QRIS_POS_PAYMENT" 
                                     alt="QRIS Code" 
                                     class="img-fluid rounded border bg-white p-2 shadow-sm" style="max-width: 140px;">
                                <p class="text-muted extra-small mb-0 mt-2">Mendukung GoPay, OVO, Dana, ShopeePay & M-Banking</p>
                            </div>

                            {{-- INPUT uang tunai (Khusus Cash) --}}
                            <div id="cashInputWidget" class="d-none mb-3">
                                <label class="form-label small fw-semibold text-muted">Uang Diterima (Rp)</label>
                                <input type="number" id="bayarCash" name="bayar_cash" class="form-control" placeholder="0" oninput="hitungKembalian()">
                                <div class="mt-2 text-end small">
                                    <span class="text-muted">Kembalian: </span>
                                    <span class="fw-bold font-monospace text-dark" id="displayKembalian">Rp 0</span>
                                </div>
                            </div>

                            <div class="p-3 mb-3 rounded-3" style="background: #f9fafb; border: 1px solid #e5e7eb;">
                                <div class="text-muted" style="font-size: 0.75rem;">Total Pembayaran</div>
                                <div class="fs-4 font-monospace fw-bold text-dark" id="displayTotal">Rp 0</div>
                            </div>

                            <button type="button"
                                class="btn btn-checkout fw-bold d-flex align-items-center justify-content-center gap-2"
                                id="btnSubmit" onclick="handleCheckoutProcess()" disabled>
                                <i class="bi bi-check-circle-fill"></i> Selesaikan Transaksi
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>

    {{-- MODAL POPUP QRIS --}}
    <div class="modal fade" id="modalQris" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Pembayaran QRIS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <p class="text-muted small mb-1">Total Tagihan:</p>
                    <h3 class="fw-bold font-monospace text-dark mb-3" id="modalQrisTotal">Rp 0</h3>
                    
                    <div class="bg-light p-3 rounded-3 d-inline-block border mb-3">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=QRIS_POS_PAYMENT" 
                             alt="QRIS Full" class="img-fluid rounded shadow-sm" style="max-width: 220px;">
                    </div>
                    
                    <div class="alert alert-info py-2 small mb-0">
                        <i class="bi bi-info-circle me-1"></i> Tunjukkan QRIS ini kepada pelanggan untuk dipindai.
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light w-100 fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-dark w-100 fw-semibold" onclick="submitFormKasir()">
                        <i class="bi bi-check-lg me-1"></i> Konfirmasi Sudah Bayar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT KASIR / KERANJANG --}}
    <script>
        function escapeHtml(value) {
            const span = document.createElement('span'); span.textContent = value; return span.innerHTML;
        }
        let cart = [];
        let grandTotal = 0;

        // Filter Produk Live
        document.getElementById('searchProduk').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.item-produk-wrapper');
            items.forEach(item => {
                const nama = item.getAttribute('data-nama');
                if (nama.includes(query)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Toggle Widget Tampilan Metode Pembayaran
        function toggleMetodePay() {
            const metode = document.getElementById('metodePembayaran').value;
            const qrisWidget = document.getElementById('qrisMiniWidget');
            const cashWidget = document.getElementById('cashInputWidget');

            if (metode === 'QRIS') {
                qrisWidget.classList.remove('d-none');
                cashWidget.classList.add('d-none');
            } else if (metode === 'CASH') {
                qrisWidget.classList.add('d-none');
                cashWidget.classList.remove('d-none');
            } else {
                qrisWidget.classList.add('d-none');
                cashWidget.classList.add('d-none');
            }
        }

        // Tambah Produk ke Keranjang
        function addToCart(id, nama, harga, stok) {
            const existing = cart.find(item => item.id === id);
            if (existing) {
                if (existing.qty < stok) {
                    existing.qty += 1;
                } else {
                    alert('Jumlah melebihi stok yang tersedia!');
                }
            } else {
                cart.push({
                    id,
                    nama,
                    harga,
                    stok,
                    qty: 1
                });
            }
            renderCart();
        }

        // Update Qty Item
        function updateQty(id, newQty) {
            const item = cart.find(i => i.id === id);
            if (item) {
                if (newQty > item.stok) {
                    alert('Jumlah melebihi stok tersedia!');
                    item.qty = item.stok;
                } else if (newQty <= 0) {
                    removeFromCart(id);
                    return;
                } else {
                    item.qty = parseInt(newQty);
                }
            }
            renderCart();
        }

        // Hitung Kembalian
        function hitungKembalian() {
            const bayar = parseFloat(document.getElementById('bayarCash').value) || 0;
            const kembalian = bayar - grandTotal;
            const display = document.getElementById('displayKembalian');
            
            if (kembalian >= 0) {
                display.innerText = 'Rp ' + kembalian.toLocaleString('id-ID');
                display.className = 'fw-bold font-monospace text-success';
            } else {
                display.innerText = 'Rp ' + kembalian.toLocaleString('id-ID');
                display.className = 'fw-bold font-monospace text-danger';
            }
        }

        // Hapus Item
        function removeFromCart(id) {
            cart = cart.filter(item => item.id !== id);
            renderCart();
        }

        // Kosongkan Keranjang
        function clearCart() {
            cart = [];
            renderCart();
        }

        // Render Tabel & Input Hidden yang SesuaI dengan Validation Controller (produk_id[] & jumlah[])
        function renderCart() {
            const tbody = document.getElementById('cartTableBody');
            tbody.innerHTML = '';

            if (cart.length === 0) {
                tbody.innerHTML = `
                <tr id="emptyCartRow">
                    <td colspan="4" class="text-center py-4 text-muted small">
                        Keranjang masih kosong.<br>Klik produk di sebelah kiri.
                    </td>
                </tr>`;
                document.getElementById('displayTotal').innerText = 'Rp 0';
                document.getElementById('btnSubmit').disabled = true;
                grandTotal = 0;
                return;
            }

            grandTotal = 0;

            cart.forEach((item) => {
                const subtotal = item.harga * item.qty;
                grandTotal += subtotal;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                <td>
                    <span class="fw-semibold text-dark d-block text-truncate" style="max-width: 110px;">${escapeHtml(item.nama)}</span>
                    <small class="text-muted" style="font-size: 0.7rem;">@ Rp ${item.harga.toLocaleString('id-ID')}</small>
                    <input type="hidden" name="produk_id[]" value="${item.id}">
                </td>
                <td class="text-center">
                    <input type="number" name="jumlah[]" class="form-control form-control-sm text-center px-1" value="${item.qty}" min="1" max="${item.stok}" onchange="updateQty(${item.id}, this.value)">
                </td>
                <td class="text-end font-monospace fw-semibold text-dark" style="font-size: 0.8rem;">
                    Rp ${subtotal.toLocaleString('id-ID')}
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm text-danger p-0 border-0 bg-transparent" onclick="removeFromCart(${item.id})">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </td>
            `;
                tbody.appendChild(tr);
            });

            document.getElementById('displayTotal').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
            document.getElementById('btnSubmit').disabled = false;
            hitungKembalian();
        }

        // Proses Checkout
        function handleCheckoutProcess() {
            const metode = document.getElementById('metodePembayaran').value;

            if (metode === 'QRIS') {
                document.getElementById('modalQrisTotal').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
                const modalQris = new bootstrap.Modal(document.getElementById('modalQris'));
                modalQris.show();
            } else if (metode === 'CASH') {
                const bayar = parseFloat(document.getElementById('bayarCash').value) || 0;
                if (bayar < grandTotal) {
                    alert('Uang pembayaran masih kurang!');
                    return;
                }
                submitFormKasir();
            } else {
                submitFormKasir();
            }
        }

        // Submit Form
        function submitFormKasir() {
            document.getElementById('formKasir').submit();
        }
    </script>

@endsection
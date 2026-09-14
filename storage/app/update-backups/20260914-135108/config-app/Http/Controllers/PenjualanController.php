<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\itemPenjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    /**
     * Menampilkan daftar transaksi penjualan.
     */
    public function index(Request $request)
    {
        $query = Penjualan::with(['user', 'itemPenjualan.produk'])->latest();

        if ($request->filled('search')) {
            $query->where('kode_transaksi', 'like', '%' . $request->search . '%');
        }

        $penjualans = $query->latest()->take(10)->get();
        return view('penjualan.index', compact('penjualans'));
    }

    /**
     * Menampilkan form untuk membuat transaksi baru (Kasir POS).
     */
    public function create()
    {
        $produks = Produk::where('stok', '>', 0)->get();
        return view('penjualan.create', compact('produks'));
    }

    /**
     * Menyimpan data transaksi penjualan baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'produk_id'         => 'required|array',
            'produk_id.*'       => 'required|exists:produk,id',
            'jumlah'            => 'required|array',
            'jumlah.*'          => 'required|numeric|min:1',
            'metode_pembayaran' => 'required|string',
        ]);

        // 2. Hitung Total Pembayaran & Kumpulkan Item
        $totalPembayaran = 0;
        $items = [];

        foreach ($request->produk_id as $index => $id) {
            $produk = \App\Models\Produk::findOrFail($id);
            $qty = $request->jumlah[$index];

            $subtotal = $produk->harga_jual * $qty;
            $totalPembayaran += $subtotal;

            $items[] = [
                'produk_id'    => $id,
                'kuantitas'    => $qty,
                'harga_satuan' => $produk->harga_jual,
                'subtotal'     => $subtotal,
            ];
        }

        // 3. Simpan Penjualan Utama (Perhatikan penulisan 'user_id')
        $penjualan = Penjualan::create([
            'user_id'           => \Illuminate\Support\Facades\Auth::id(),
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_pembayaran'  => $totalPembayaran,
            'status'            => 'completed',
        ]);

        // 4. Simpan Detail & Kurangi Stok
        foreach ($items as $item) {
            $penjualan->details()->create([
                'produk_id'    => $item['produk_id'],
                'kuantitas'    => $item['kuantitas'],
                'harga_satuan' => $item['harga_satuan'],
                'subtotal'     => $item['subtotal'],
            ]);

            \App\Models\Produk::where('id', $item['produk_id'])->decrement('stok', $item['kuantitas']);
        }

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    /**
     * Menampilkan detail transaksi penjualan.
     */
    public function show($id)
    {
        $penjualan = Penjualan::with(['user', 'itemPenjualan.produk'])->findOrFail($id);

        if (request()->expectsJson() || request()->ajax()) {
            return response()->json($penjualan);
        }

        return view('penjualan.show', compact('penjualan'));
    }

    /**
     * Menghapus transaksi penjualan dan mengembalian stok barang.
     */


    public function destroy($id)
    {
        // 1. Cari data penjualan beserta relasi detail barangnya
        $penjualan = Penjualan::with('itemPenjualan')->findOrFail($id);

        // 2. Proteksi: Cegah transaksi berstatus 'completed' dihapus
        if (strtolower($penjualan->status ?? 'completed') === 'completed') {
            return redirect()->back()->with('error', 'Gagal! Transaksi yang sudah Completed tidak dapat dihapus.');
        }

        // 3. Kembalikan stok produk jika transaksi dibatalkan/dihapus
        if ($penjualan->itemPenjualan) {
            foreach ($penjualan->itemPenjualan as $item) {
                \App\Models\Produk::where('id', $item->produk_id)
                    ->increment('stok', $item->kuantitas);
            }
        }

        // 4. Hapus detail item & data transaksi utama
        $penjualan->itemPenjualan()->delete();
        $penjualan->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus dan stok telah dikembalikan.');
    }
}

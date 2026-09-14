<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjualan::with(['user', 'details.produk'])->latest();

        if ($request->filled('search')) {
            $search = trim((string) $request->search);
            $id = preg_replace('/^(INV-|TRX-)/i', '', $search);
            $query->where(function ($q) use ($search, $id) {
                $q->where('id', ctype_digit($id) ? (int) $id : 0)
                    ->orWhereHas('user', fn ($user) => $user->where('name', 'like', '%' . $search . '%'));
            });
        }

        $penjualans = $query->take(10)->get();

        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        $produks = Produk::where('stok', '>', 0)->get();
        return view('penjualan.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'produk_id' => 'required|array|min:1',
            'produk_id.*' => 'required|integer|distinct|exists:produk,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'metode_pembayaran' => 'required|in:CASH,TRANSFER,QRIS',
        ]);
        if (array_keys($data['produk_id']) !== array_keys($data['jumlah'])) {
            return back()->withInput()->withErrors(['jumlah' => 'Jumlah produk tidak sesuai dengan keranjang.']);
        }
        DB::transaction(function () use ($data) {
            $products = Produk::whereIn('id', $data['produk_id'])->orderBy('id')->lockForUpdate()->get()->keyBy('id');
            $items = [];
            $total = 0;
            foreach ($data['produk_id'] as $index => $id) {
                $produk = $products->get($id);
                $qty = (int) $data['jumlah'][$index];
                if (!$produk || $produk->stok < $qty) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'jumlah' => 'Stok ' . ($produk?->nama ?? 'produk') . ' tidak mencukupi. Periksa kembali keranjang.',
                    ]);
                }
                $subtotal = $produk->harga_jual * $qty;
                $total += $subtotal;
                $items[] = ['produk_id' => $id, 'kuantitas' => $qty, 'harga_satuan' => $produk->harga_jual, 'subtotal' => $subtotal];
                $produk->decrement('stok', $qty);
            }
            $penjualan = Penjualan::create([
                'user_id' => Auth::id(), 'metode_pembayaran' => $data['metode_pembayaran'],
                'total_pembayaran' => $total, 'status' => 'COMPLETED',
            ]);
            $penjualan->details()->createMany($items);
        });
        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function show($id)
    {
        $penjualan = Penjualan::with(['user', 'details.produk'])->findOrFail($id);

        return view('penjualan.show', compact('penjualan'));
    }

    public function edit($id)
    {
        $penjualan = Penjualan::with('details.produk')->findOrFail($id);
        $this->authorize('update', $penjualan);
        $produks = Produk::orderBy('nama')->get();
        return view('penjualan.edit', compact('penjualan', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', Penjualan::findOrFail($id));
        $data = $request->validate([
            'produk_id' => 'required|array|min:1',
            'produk_id.*' => 'required|integer|distinct|exists:produk,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'metode_pembayaran' => 'required|in:CASH,TRANSFER,QRIS',
            'status' => 'required|in:OPEN,COMPLETED',
        ]);
        if (array_keys($data['produk_id']) !== array_keys($data['jumlah'])) {
            return back()->withInput()->withErrors(['jumlah' => 'Data keranjang tidak sesuai.']);
        }
        DB::transaction(function () use ($data, $id) {
            $sale = Penjualan::lockForUpdate()->findOrFail($id);
            $this->authorize('update', $sale);
            $oldItems = $sale->details()->lockForUpdate()->get();
            $ids = $oldItems->pluck('produk_id')->merge($data['produk_id'])->unique()->sort()->values();
            $products = Produk::withTrashed()->whereIn('id', $ids)->orderBy('id')->lockForUpdate()->get()->keyBy('id');
            $oldQuantities = $oldItems->groupBy('produk_id')->map(fn ($items) => $items->sum('kuantitas'));
            $oldPrices = $oldItems->keyBy('produk_id');
            $newQuantities = [];
            $items = [];
            $total = 0;
            foreach ($data['produk_id'] as $index => $productId) {
                $product = $products->get($productId);
                $qty = (int) $data['jumlah'][$index];
                $reserved = (int) $oldQuantities->get($productId, 0);
                if (!$product || ($product->trashed() && $qty > $reserved) || $qty > $product->stok + $reserved) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'jumlah' => 'Stok ' . ($product?->nama ?? 'produk') . ' tidak mencukupi atau produk telah dihapus.',
                    ]);
                }
                $price = $oldPrices->get($productId)?->harga_satuan ?? $product->harga_jual;
                $newQuantities[$productId] = $qty;
                $items[] = ['produk_id' => $productId, 'kuantitas' => $qty, 'harga_satuan' => $price, 'subtotal' => $price * $qty];
                $total += $price * $qty;
            }
            foreach ($products as $productId => $product) {
                $product->stok += (int) $oldQuantities->get($productId, 0) - ($newQuantities[$productId] ?? 0);
                $product->save();
            }
            $sale->details()->delete();
            $sale->details()->createMany($items);
            $sale->update(['total_pembayaran' => $total, 'metode_pembayaran' => $data['metode_pembayaran'], 'status' => $data['status']]);
        });
        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $sale = Penjualan::lockForUpdate()->findOrFail($id);
            $this->authorize('delete', $sale);
            $items = $sale->details()->lockForUpdate()->get();
            $products = Produk::withTrashed()->whereIn('id', $items->pluck('produk_id'))->orderBy('id')->lockForUpdate()->get()->keyBy('id');
            foreach ($items as $item) {
                $product = $products->get($item->produk_id);
                if ($product) { $product->increment('stok', $item->kuantitas); }
            }
            $sale->details()->delete();
            $sale->delete();
        });
        return back()->with('success', 'Transaksi OPEN dihapus dan stok dikembalikan.');
    }
}

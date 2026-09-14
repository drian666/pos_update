<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Models\Jenis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar produk
     */
    public function index(Request $request)
    {
        $query = Produk::query();

        // Pencarian produk (hanya berdasarkan nama)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('nama', 'like', "%{$search}%");
        }

        // Ambil maksimal 10 produk terbaru
        $produks = $query
            ->latest()
            ->take(10)
            ->get();

        return view('produk.index', compact('produks'));
    }

    /**
     * Menampilkan form tambah produk
     */

    public function create()
    {
        $this->authorize('create', Produk::class);

        $jenis = Jenis::orderBy('nama_jenis')->get();
        return view('produk.create', compact('jenis'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Produk::class);
        $request->validate([
            'nama'       => 'required|string|max:255',
            'jenis_id'   => 'required|exists:jenis,id',      // ← tambah validasi
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'stok'       => 'required|integer|min:0',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $produk = new Produk();

        $produk->user_id    = Auth::id();
        $produk->jenis_id   = $request->jenis_id;           // ← simpan jenis
        $produk->nama       = $request->nama;
        $produk->harga_beli = $request->harga_beli;
        $produk->harga_jual = $request->harga_jual;
        $produk->stok       = $request->stok;

        if ($request->hasFile('foto')) {
            $produk->foto = $request->file('foto')->store('produk', 'public');
        }

        $produk->save();

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }


    /**
     * Menampilkan detail produk
     */
    public function show($id)
    {
        $produk = Produk::findOrFail($id);

        return view('produk.show', compact('produk'));
    }


    /**
     * Menampilkan form edit produk
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $this->authorize('update', $produk);

        $jenis = Jenis::orderBy('nama_jenis')->get();
        return view('produk.edit', compact('produk', 'jenis'));
    }


    /**
     * Memperbarui produk
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $this->authorize('update', $produk);

        $request->validate([
            'nama'       => 'required|string|max:255',
            'jenis_id' => 'nullable|exists:jenis,id',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'stok'       => 'required|integer|min:0',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $produk->jenis_id = $request->jenis_id;
        $produk->nama       = $request->nama;
        $produk->harga_beli = $request->harga_beli;
        $produk->harga_jual = $request->harga_jual;
        $produk->stok       = $request->stok;

        if ($request->hasFile('foto')) {

            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }

            $produk->foto = $request->file('foto')->store('produk', 'public');
        }

        $produk->save();

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }


    /**
     * Menghapus produk
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $this->authorize('delete', $produk);

        try {

            $produk->delete();

            return redirect()
                ->route('produk.index')
                ->with('success', 'Produk berhasil dihapus!');
        } catch (QueryException $e) {

            return redirect()
                ->route('produk.index')
                ->with('error', 'Produk tidak bisa dihapus karena sudah memiliki riwayat transaksi.');
        }
    }
}

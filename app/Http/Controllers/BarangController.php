<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;


class BarangController extends Controller
{
    public function index()
    {
        $warungId = session('warung_id');

        $barang = Barang::with(['kategori', 'hargaAktif', 'pembelianTerakhir'])
            ->where('id_warung', $warungId)
            ->get()
            ->map(function ($item) {
                $item->stok = DB::table('pembelian')->where('id_barang', $item->id)->sum('jml_beli')
                            - DB::table('penjualan')->where('id_barang', $item->id)->sum('jml_beli');
                return $item;
            });

        $kategori = Kategori::where('id_warung', $warungId)->get();

        return view('admin.barang.barang', compact('barang', 'kategori'));
    }

    public function create()
    {
        $warungId = session('warung_id');
        $kategori = Kategori::where('id_warung', $warungId)->get();

        return view('admin.barang.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kategori'   => 'required|exists:kategori,id',
            'nama_barang'   => 'required|string|max:255',
            'satuan'        => 'required|string|max:50',
        ]);

        $validated['kd_barang'] = $this->generateKodeBarang($validated['nama_barang']);
        $validated['id_warung'] = session('warung_id');

        Barang::create($validated);

        return redirect()->route('admin.barang')->with('success', 'Data Barang berhasil ditambahkan!');
    }

    public function show(Request $request)
    {
        $warungId = session('warung_id');
        $cari = $request->cari;

        $kategori = Kategori::where('id_warung', $warungId)->get();

        $barang = Barang::with('kategori', 'hargaAktif')
            ->where('id_kategori', $cari)
            ->where('id_warung', $warungId)
            ->get();

        return view('admin.barang.barang', compact('barang', 'kategori'));
    }

    public function edit($id)
    {
        $warungId = session('warung_id');

        $barang = Barang::where('id', $id)
            ->where('id_warung', $warungId)
            ->with('hargaAktif')
            ->firstOrFail();

        $kategori = Kategori::where('id_warung', $warungId)->get();

        return view('admin.barang.edit', compact('barang', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $warungId = session('warung_id');

        $validated = $request->validate([
            'id_kategori'   => 'required|exists:kategori,id',
            'kd_barang'     => 'required|string|max:10',
            'nama_barang'   => 'required|string|max:255',
            'satuan'        => 'required|string|max:50',
            'harga_beli'    => 'nullable|numeric|min:0',
            'harga_jual'    => 'nullable|numeric|min:0',
        ]);

        $barang = Barang::where('id', $id)
            ->where('id_warung', $warungId)
            ->firstOrFail();

        $barang->update([
            'id_kategori'   => $validated['id_kategori'],
            'kd_barang'     => $validated['kd_barang'],
            'nama_barang'   => $validated['nama_barang'],
            'satuan'        => $validated['satuan'],
        ]);

        // Harga Aktif
        $harga = $barang->hargaAktif;

        if ($harga) {
            $harga->update([
                'harga_beli' => $validated['harga_beli'],
                'harga_jual' => $validated['harga_jual'],
            ]);
        } else {
            $barang->harga()->create([
                'harga_beli' => $validated['harga_beli'],
                'harga_jual' => $validated['harga_jual'],
                'status'     => 'active',
            ]);
        }

        return redirect()->route('admin.barang')->with('success', 'Data Barang berhasil diperbarui!');
    }

    private function generateKodeBarang($namaBarang)
    {
        $words = explode(' ', strtoupper(trim($namaBarang)));

        if (count($words) >= 2) {
            $prefix = substr($words[0], 0, 3) . '-' . substr($words[1], 0, 3);
        } else {
            $prefix = substr($words[0], 0, 3);
        }

        $last = Barang::where('kd_barang', 'LIKE', "$prefix%")
            ->orderBy('kd_barang', 'desc')
            ->first();

        $lastNumber = 0;
        if ($last && preg_match('/(\d+)$/', $last->kd_barang, $match)) {
            $lastNumber = (int)$match[1];
        }

        return $prefix . '-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }

    public function destroy($id)
    {
        $warungId = session('warung_id');

        $barang = Barang::where('id', $id)
            ->where('id_warung', $warungId)
            ->firstOrFail();

        $barang->delete();

        return redirect()->route('admin.barang')->with('success', 'Data Barang berhasil dihapus.');
    }
}


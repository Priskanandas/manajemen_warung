<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harga;
use App\Models\Pembelian;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class HargaController extends Controller
{
    public function index()
        {
            $warungId = session('warung_id');

            $harga = Harga::with(['barang', 'pembelian']) // ← tambahkan relasi
                ->whereHas('barang', fn ($q) => $q->where('id_warung', $warungId))
                ->orderBy('created_at', 'desc')
                ->get();

            return view('admin.harga.harga', compact('harga'));
        }


    public function create()
    {
        $warungId = session('warung_id');

        $barang = Barang::where('id_warung', $warungId)->get();
        $pembelian = Pembelian::where('id_warung', $warungId)->get();
        $harga = Harga::whereIn('id_barang', $barang->pluck('id'))->get();

        return view('admin.harga.create', compact('barang', 'pembelian', 'harga'));
    }

    public function ajax($id)
    {
        $warungId = session('warung_id');

        $pembelian = Pembelian::whereHas('barang', function ($query) use ($warungId, $id) {
            $query->where('id_warung', $warungId)->where('id', $id);
        })
        ->orderBy('created_at', 'desc')
        ->select('harga_beli', 'id')
        ->first();

        if (!$pembelian) {
            return response()->json([
                'harga_beli' => 0,
                'id_pembelian' => null
            ]);
        }

        return response()->json([
            'harga_beli' => $pembelian->harga_beli,
            'id_pembelian' => $pembelian->id
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'id_pembelian' => 'required|exists:pembelian,id',
            'harga_jual' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $warungId = session('warung_id');

        $barang = Barang::where('id', $request->id_barang)
            ->where('id_warung', $warungId)
            ->firstOrFail();

        $pembelian = Pembelian::where('id', $request->id_pembelian)
            ->where('id_warung', $warungId)
            ->firstOrFail();

        Harga::create([
            'id_barang' => $barang->id,
            'id_pembelian' => $pembelian->id,
            'harga_jual' => $request->harga_jual,
            'status' => $request->status,
            'id_warung' => $warungId,
        ]);

        return redirect()->route('admin.harga')->with('success', 'Harga berhasil ditambahkan');
    }

    public function edit($id)
    {
        $warungId = session('warung_id');

        $harga = Harga::findOrFail($id);
        $barang = Barang::where('id_warung', $warungId)->get();
        $pembelian = Pembelian::where('id_warung', $warungId)->get();

        if (!in_array($harga->id_barang, $barang->pluck('id')->toArray())) {
            abort(403, 'Anda tidak berhak mengedit data ini.');
        }

        return view('admin.harga.edit', compact('harga', 'barang', 'pembelian'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'harga_jual' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $warungId = session('warung_id');

        $harga = Harga::findOrFail($id);

        $barang = Barang::where('id', $harga->id_barang)
            ->where('id_warung', $warungId)
            ->first();

        if (!$barang) {
            abort(403, 'Anda tidak berhak mengubah data ini.');
        }

        $harga->update([
            'harga_jual' => $request->harga_jual,
            'status' => $request->status
        ]);

        return redirect()->route('admin.harga')->with('success', 'Harga berhasil diperbarui');
    }

    public function delete($id)
    {
        $warungId = session('warung_id');

        $harga = Harga::findOrFail($id);
        $barang = Barang::where('id', $harga->id_barang)
            ->where('id_warung', $warungId)
            ->first();

        if (!$barang) {
            abort(403, 'Anda tidak berhak menghapus data ini.');
        }

        $harga->delete();

        return redirect()->route('admin.harga')->with('success', 'Harga berhasil dihapus');
    }
}

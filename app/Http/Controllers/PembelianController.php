<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\Harga;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index()
    {
        $warungId = session('warung_id');

        $pembelian = Pembelian::with(['barang'])
            ->where('id_warung', $warungId)
            ->latest()
            ->get();

        return view('admin.pembelian.pembelian', compact('pembelian'));
    }

    public function tambah()
    {
        $warungId = session('warung_id');
        $barang = Barang::where('id_warung', $warungId)->get();

        return view('admin.pembelian.tambah', compact('barang'));
    }

    public function store(Request $request)
    {
        $warungId = session('warung_id');

        $request->validate([
            'id_barang'   => 'required|exists:barang,id',
            'jml_beli'    => 'required|integer|min:1',
            'harga_beli'  => 'required|integer|min:0',
        ]);

        $barang = Barang::where('id', $request->id_barang)
            ->where('id_warung', $warungId)
            ->firstOrFail();

        // Hitung subtotal
        $subtotal = $request->jml_beli * $request->harga_beli;

        $pembelian = Pembelian::create([
            'id_warung'   => $warungId,
            'id_barang'   => $barang->id,
            'jml_beli'    => $request->jml_beli,
            'harga_beli'  => $request->harga_beli,
            'subtotal'    => $subtotal,
            'tanggal'     => now(),
        ]);

        // Nonaktifkan harga aktif lama
        Harga::where('id_barang', $barang->id)
            ->where('status', 'active')
            ->update(['status' => 'non-active']);

        // Tambahkan harga baru
        Harga::create([
            'id_warung'      => $warungId,
            'id_barang'      => $barang->id,
            'id_pembelian'   => $pembelian->id,
            'harga_beli'     => $request->harga_beli,
            'harga_jual'     => 0,
            'status'         => 'active',
        ]);

        return redirect()->route('admin.pembelian')->with('success', 'Pembelian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $warungId = session('warung_id');

        $pembelian = Pembelian::with('barang')
            ->where('id', $id)
            ->where('id_warung', $warungId)
            ->firstOrFail();

        $barang = Barang::where('id_warung', $warungId)->get();

        return view('admin.pembelian.edit', compact('pembelian', 'barang'));
    }

    public function update(Request $request, $id)
{
    $warungId = session('warung_id');

    $request->validate([
        'id_barang'   => 'required|exists:barang,id',
        'jml_beli'    => 'required|integer|min:1',
        'harga_beli'  => 'required|integer|min:0',
    ]);

    $pembelian = Pembelian::where('id', $id)
        ->where('id_warung', $warungId)
        ->firstOrFail();

    $barang = Barang::where('id', $request->id_barang)
        ->where('id_warung', $warungId)
        ->firstOrFail();

    $subtotal = $request->jml_beli * $request->harga_beli;

    $pembelian->update([
        'id_barang'   => $barang->id,
        'jml_beli'    => $request->jml_beli,
        'harga_beli'  => $request->harga_beli,
        'subtotal'    => $subtotal,
        'tanggal'     => now(),
    ]);

    Harga::where('id_barang', $barang->id)
        ->where('status', 'active')
        ->update(['status' => 'non-active']);

    Harga::create([
        'id_warung'      => $warungId,
        'id_barang'      => $barang->id,
        'id_pembelian'   => $pembelian->id,
        'harga'          => $request->harga_beli,
        'harga_jual'     => 0,
        'status'         => 'active',
    ]);

    return redirect()->route('admin.pembelian')->with('success', 'Pembelian berhasil diperbarui.');
}


    public function delete($id)
    {
        $warungId = session('warung_id');

        $pembelian = Pembelian::where('id', $id)
            ->where('id_warung', $warungId)
            ->firstOrFail();

        $pembelian->delete();

        return redirect()->route('admin.pembelian')->with('success', 'Pembelian berhasil dihapus.');
    }

    public function ajax($id)
    {
        $warungId = session('warung_id');

        $barang = DB::table('barang')
            ->where('id', $id)
            ->where('id_warung', $warungId)
            ->select('nama_barang', 'satuan')
            ->first();

        return response()->json($barang);
    }
}

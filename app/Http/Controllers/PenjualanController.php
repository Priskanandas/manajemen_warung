<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Barang;
use App\Models\Warung;
use App\Models\User;
use App\Models\Pembayaran;

class PenjualanController extends Controller
{
    public function index()
    {
        $warungId = session('warung_id');

        $barang = Barang::where('id_warung', $warungId)->get();
        $penjualan = Penjualan::with('barang', 'pembayaran')
            ->whereHas('barang', function ($q) use ($warungId) {
                $q->where('id_warung', $warungId);
            })
            ->latest()
            ->get();

        $pembayaran = Pembayaran::where('id_warung', $warungId)->latest()->get();

        return view('admin.penjualan.penjualan', compact('barang', 'penjualan', 'pembayaran'));
    }

    public function store(Request $request)
    {
        $warungId = session('warung_id');

        $request->validate([
            'id_barang.*'     => 'required|exists:barang,id',
            'satuan.*'        => 'nullable|string|max:50',
            'jml_beli.*'      => 'required|integer|min:1',
            'harga_jual.*'    => 'required|numeric|min:0',
            'total_harga.*'   => 'required|numeric|min:0',
            'total_uang'      => 'nullable|numeric|min:0',
        ]);

        // Pastikan semua barang milik warung aktif
        $validBarangIds = Barang::where('id_warung', $warungId)->pluck('id')->toArray();
        foreach ($request->id_barang as $idBarang) {
            if (!in_array($idBarang, $validBarangIds)) {
                abort(403, 'Barang tidak sesuai dengan warung aktif.');
            }
        }

        // Hitung total bayar
        $totalBayar = collect($request->total_harga)->sum();
        $totalUang  = $request->total_uang ?? $totalBayar;
        $uangKembali = $totalUang - $totalBayar;

        // Simpan data pembayaran utama
        $pembayaran = Pembayaran::create([
            'id_warung'      => $warungId,
            'id_pelayan'     => auth()->id(),
            'tanggal_bayar'  => now(),
            'total_bayar'    => $totalBayar,
            'total_uang'     => $totalUang,
            'uang_kembali'   => $uangKembali,
        ]);

        // Simpan detail penjualan untuk setiap barang
        foreach ($request->id_barang as $i => $barangId) {
            Penjualan::create([
                'id_barang'     => $barangId,
                'id_pembayaran' => $pembayaran->id,
                'satuan'        => $request->satuan[$i] ?? 'pcs',
                'tanggal'       => now(),
                'jml_beli'      => $request->jml_beli[$i],
                'harga_jual'    => $request->harga_jual[$i],
                'total_harga'   => $request->total_harga[$i],
                'id_warung'     => $warungId,
            ]);
        }

        return redirect()->route('admin.penjualan')->with('success', 'Transaksi berhasil disimpan.');
    }
    public function edit($id)
{
    $warungId = session('warung_id');
    $penjualan = Penjualan::where('id', $id)->where('id_warung', $warungId)->firstOrFail();
    $barang = Barang::where('id_warung', $warungId)->get();

    return view('admin.penjualan.edit', compact('penjualan', 'barang'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'id_barang' => 'required|exists:barang,id',
        'satuan' => 'required|string',
        'jml_beli' => 'required|integer|min:1',
        'harga_jual' => 'required|numeric|min:0',
        'total_harga' => 'required|numeric|min:0',
    ]);

    $warungId = session('warung_id');

    $penjualan = Penjualan::where('id', $id)->where('id_warung', $warungId)->firstOrFail();

    $penjualan->update([
        'id_barang' => $request->id_barang,
        'satuan' => $request->satuan,
        'jml_beli' => $request->jml_beli,
        'harga_jual' => $request->harga_jual,
        'total_harga' => $request->total_harga,
    ]);

    return redirect()->route('admin.penjualan')->with('success', 'Data penjualan berhasil diperbarui.');
}
public function rekap(Request $request)
{
    $warungId = session('warung_id');

    $penjualan = Penjualan::with(['barang', 'pembayaran.pelayan'])
        ->where('id_warung', $warungId)
        ->when($request->tanggal_awal && $request->tanggal_akhir, function ($query) use ($request) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        })
        ->orderBy('tanggal', 'desc')
        ->get();

    $total = $penjualan->sum('total_harga');

    return view('admin.penjualan.rekap', [
    'penjualan' => $penjualan,
    'total' => $total,
    'warung' => auth()->user()->warungs()->where('id', session('warung_id'))->first(),
]);

}


}

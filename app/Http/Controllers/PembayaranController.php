<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Penjualan;
use App\Models\Barang;
use App\Models\Harga;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
        public function index()
    {
        $warungId = session('warung_id');

        $barang = Barang::where('id_warung', $warungId)->get();

        return view('admin.pembayaran.index', compact('barang'));
    }
    public function store(Request $request)
{

    $request->validate([
        'id_barang'   => 'required|array',
        'jml_beli'    => 'required|array',
        'total_bayar' => 'required|numeric|min:1',
        'total_uang'  => 'required|numeric|min:1',
    ]);

    $warungId = session('warung_id');

    foreach ($request->id_barang as $index => $id_barang) {
        $jumlah = $request->jml_beli[$index];

        $stok = DB::table('pembelian')->where('id_barang', $id_barang)->sum('jml_beli') -
                DB::table('penjualan')->where('id_barang', $id_barang)->sum('jml_beli');

        if ($jumlah > $stok) {
            $barang = Barang::find($id_barang);
            return back()->withErrors(['stok' => "Stok barang '{$barang->nama_barang}' tidak mencukupi. Sisa: $stok"]);
        }
    }
\Log::info('DATA MASUK:', $request->all());
\Log::info('ISI REQUEST:', $request->all());
    $request->validate([
        'id_barang.*'    => 'required|exists:barang,id',
        'jml_beli.*'     => 'required|integer|min:1',
        'harga_jual.*'   => 'required|numeric|min:0',
        'total_harga.*'  => 'required|numeric|min:0',
        'total_bayar'    => 'required|numeric|min:0',
        'total_uang'     => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();
    try {
        // Simpan pembayaran
        $pembayaran = Pembayaran::create([
            'id_warung'     => $warungId,
            'id_pelayan'    => auth()->id(),
            'tanggal_bayar' => now(),
            'total_bayar'   => $request->total_bayar,
            'total_uang'    => $request->total_uang,
            'uang_kembali'  => $request->total_uang - $request->total_bayar,
        ]);

        foreach ($request->id_barang as $i => $id_barang) {
            // Simpan ke tabel penjualan
            Penjualan::create([
                'id_barang'     => $id_barang,
                'id_pembayaran' => $pembayaran->id,
                'jml_beli'      => $request->jml_beli[$i],
                'harga_jual'    => $request->harga_jual[$i],
                'total_harga'   => $request->total_harga[$i],
                'tanggal'       => now(),
                'satuan'        => 'pcs',
                'id_warung'     => $warungId,
            ]);

            // Update stok di tabel barang
            $barang = Barang::where('id', $id_barang)
                ->where('id_warung', $warungId)
                ->first();

            if ($barang) {
                $barang->stok -= $request->jml_beli[$i];
                $barang->save();
            }
        }

        DB::commit();
        // Redirect ke halaman cetak nota
        return redirect()->route('admin.pembayaran.nota', $pembayaran->id);
    } catch (\Throwable $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Gagal menyimpan transaksi.'. $e->getMessage()
    ])->withInput();
    }
}

    public function listBarang($id)
    {
        $warungId = session('warung_id');

        $barang = Barang::with(['harga' => fn($q) => $q->where('status', 'active')])
            ->where('id_warung', $warungId)
            ->findOrFail($id);

        return response()->json([
            'id'           => $barang->id,
            'nama_barang'  => $barang->nama_barang,
            'kd_barang'  => $barang->kd_barang,
            'harga_jual'   => $barang->harga->harga_jual ?? 0,
        ]);
    }

public function cariBarang(Request $request)
{
    $warungId = session('warung_id');
    $keyword = $request->get('keyword');

    $barang = Barang::with('hargaAktif')
        ->where('id_warung', $warungId)
        ->where(function ($query) use ($keyword) {
            $query->where('nama_barang', 'like', "%$keyword%")
                  ->orWhere('kd_barang', 'like', "%$keyword%");
        })
        ->limit(10)
        ->get();

    $data = $barang->map(function ($item) {
    $stok = DB::table('pembelian')->where('id_barang', $item->id)->sum('jml_beli') -
            DB::table('penjualan')->where('id_barang', $item->id)->sum('jml_beli');

    return [
        'id'           => $item->id,
        'nama_barang'  => $item->nama_barang,
        'kd_barang'    => $item->kd_barang,
        'harga_jual'   => $item->hargaAktif->harga_jual ?? 0, // ✅ ambil dari relasi hargaAktif
        'stok'         => $stok,
    ];
    });

    return response()->json($data);
}

    public function nota($id)
{
    $warungId = session('warung_id');

    $pembayaran = Pembayaran::with([
            'penjualan.barang', // untuk ambil data barang dalam setiap item penjualan
            'pelayan',           // untuk menampilkan nama user/pelayan
            'warung'
        ])
        ->where('id', $id)
        ->where('id_warung', $warungId)
        ->firstOrFail();

    return view('admin.pembayaran.nota', compact('pembayaran'));
}

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use App\Http\Requests\SettingRequest;
use Carbon\Carbon;
use App\Models\Pembelian;
use App\Models\Barang;
use DB;

class PembelianController extends Controller
{
    /**
    * Show pembelian
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $pembelian = Pembelian::select(DB::raw("pembelian.id, nama_barang, tanggal_beli, jml_beli"))                                    
        ->join('barang', 'pembelian.id_barang', '=', 'barang.id')
        ->get();
  
  return view('admin.pembelian.pembelian',['pembelian'=>$pembelian]);

    }

    public function create($id)
    {
        $pembelian = new Pembelian();
        $pembelian->id_barang = $id;
        $pembelian->tanggal_beli  = 0;
        $pembelian->jml_beli = 0;
        $pembelian->save();

        session(['id_pembelian' => $pembelian->id_pembelian]);
        session(['id_barang' => $pembelian->id_barang]);

        return redirect()->route('admin.pembelian.pembelian');
    }

    public function store(Request $request)
    {
       
    }

    public function update(Request $request, $id)
    {
       
    }

    public function destroy($id)
    {
       
    }

    public function loadForm($diskon, $total)
    {
     
    }
}
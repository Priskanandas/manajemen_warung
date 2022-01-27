<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use App\Http\Requests\SettingRequest;
use Carbon\Carbon;
use App\Models\Harga;
use App\Models\Pembelian;
use App\Models\Barang;
use DB;

class HargaController extends Controller
{
    /**
    * Show harga
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {

        $harga = DB::table('harga')
            ->join('barang', 'harga.id_barang', '=', 'barang.id')
            ->join('pembelian', 'harga.id_pembelian', '=', 'pembelian.id')
            ->select('harga.*', 'barang.nama_barang', 'pembelian.tanggal_beli')
            ->get();
  
  return view('admin.harga.harga',['harga'=>$harga]);
    }

    public function create()
    { 
        $harga = Harga::all();
        $barang = Barang::all();
        $pembelian = Pembelian::all();
        return view ('admin.harga.create',compact('barang'));
    }
    
    public function store(Request $request)
    {
        $request->validate([

            'Harga Ecer' => 'required',
            'Harga Grosir' => 'required',
            'Harga Jual' => 'required',
            'Status' => 'required'
        ]);
        
        Harga::create($request->all());
      
        return redirect()->route('admin.harga')
                        ->with('success','Harga created successfully');
    }
    
    public function edit($id)
    {
        $harga = Harga::find($id);
        $barang = Barang::all();
        $pembelian = Pembelian::all();

        return view('admin.harga.edit',compact('harga','barang','pembelian'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_beli' => 'required',
            'jml_beli' => 'required'

        ]);
        $input=$request->all();
        $pembelian = Pembelian::find($id);
        $pembelian ->update {$input};
      
    
        return redirect()->route('admin.pembelian')
                        ->with('success','Pembelian updated successfully');
    }
    
    public function delete($id)
    {
        Pembelian::find($id)->delete();
        return redirect()->route('admin.pembelian')
                        ->with('success','Pembelian deleted successfully');
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;
use App\Models\Harga;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';
    protected $primaryKey = 'id';
    protected $fillable = ['id_barang', 'id_warung', 'harga_beli', 'tanggal_beli', 'jml_beli','subtotal','tanggal'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

 //   public function harga()
   // {
     //   return $this->hasMany(Harga::class, 'id_pembelian');
   // }
     public function warung()
{
    return $this->belongsTo(Warung::class, 'id_warung');
}
}

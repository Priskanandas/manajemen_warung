<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;

    protected $table = 'harga';
    protected $primaryKey = 'id';
    protected $fillable = ['id_barang', 'tanggal_beli', 'id_pembelian', 'harga_ecer','harga_grosir', 'harga_jual', 'status'];
    public function barang()
    {
        return $this->belongsTo (Barang::class, 'id_barang', 'id_barang');
    }
    public function pembelian()
    {
        return $this->belongsTo (Barang::class, 'id_pembelian', 'id_pembelian');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id';
    protected $fillable = ['id_kategori', 'nama_barang', 'satuan', 'kategori', 'kd_barang', 'stok', 'total_barang', 'Barang_ecer', 'Barang grosir'];

    public function pembelian()
    {
    return $this->hasMany (Pembelian::class, 'id', 'id');
    }
    public function harga()
    {
    return $this->hasMany (Harga::class, 'id', 'id');
    }
}

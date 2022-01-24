<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $primaryKey = 'id';
    protected $fillable = [  'id_barang', 'id_pelayan', 'id_pembayaran', 'satuan', 'tanggal', 'harga_barang', 'jml_beli', 'total_harga'
];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}

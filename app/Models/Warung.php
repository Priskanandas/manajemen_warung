<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warung extends Model
{
    use HasFactory;

    protected $table = 'warung';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'nama_warung', 'alamat'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategori()
    {
        return $this->hasMany(Kategori::class, 'id_warung');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_warung');
    }
    public function barang()
{
    return $this->hasMany(Barang::class, 'id_warung');
}

public function harga()
{
    return $this->hasMany(Harga::class, 'id_warung');
}

public function penjualan()
{
    return $this->hasMany(Penjualan::class, 'id_warung');
}

public function pembelian()
{
    return $this->hasMany(Pembelian::class, 'id_warung');
}

}

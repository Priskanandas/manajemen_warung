<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;
use App\Models\Pembelian;

class Harga extends Model
{
    use HasFactory;

    protected $table = 'harga';
    protected $primaryKey = 'id';
    protected $fillable = ['id_barang','id_pembelian','id_warung', 'harga_jual', 'status'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
    public function pembelian()
{
    return $this->belongsTo(Pembelian::class, 'id_pembelian');
}

    public function warung()
{
    return $this->belongsTo(Warung::class, 'id_warung');
}

}

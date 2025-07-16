<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;
use App\Models\Pembayaran;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_barang',
        'id_pembayaran',
        'id_warung',
        'satuan',
        'tanggal',
        'jml_beli',
        'harga_jual',
        'total_harga',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'id_pembayaran');
    }
    public function warung()
{
    return $this->belongsTo(Warung::class, 'id_warung');
}

}

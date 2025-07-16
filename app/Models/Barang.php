<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pembelian;
use App\Models\Kategori;
use App\Models\Harga;
use App\Models\Penjualan;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id';
    protected $fillable = ['id_kategori','id_warung', 'nama_barang', 'satuan', 'kd_barang', 'stok'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function harga()
    {
        return $this->hasMany(Harga::class, 'id_barang');
    }
    public function hargaAktif()
    {
        return $this->hasOne(Harga::class, 'id_barang')->where('status', 'active');
    }
    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'id_barang');
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_barang');
    }

    public function warung()
    {
        return $this->belongsTo(Warung::class, 'id_warung');
    }
    // Harga beli terakhir dari pembelian terakhir
public function pembelianTerakhir()
{
    return $this->hasOne(Pembelian::class, 'id_barang')->latestOfMany();
}

public function getHargaBeliTerakhirAttribute()
{
    return $this->pembelianTerakhir?->harga_beli;
}

// Total stok dari semua pembelian

public function getStokAttribute()
{
    $totalMasuk = $this->pembelian()->sum('jml_beli');
    $totalKeluar = $this->penjualan()->sum('jml_beli');
    return $totalMasuk - $totalKeluar;
}

}

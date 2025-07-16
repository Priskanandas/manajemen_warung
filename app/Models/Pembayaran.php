<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Penjualan;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id';
    protected $fillable = ['id_pelayan', 'id_warung', 'tanggal_bayar', 'total_bayar', 'total_uang', 'uang_kembali'];

    public function pelayan()
    {
        return $this->belongsTo(User::class, 'id_pelayan');
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_pembayaran');
    }
     public function warung()
{
    return $this->belongsTo(Warung::class, 'id_warung');
}
}

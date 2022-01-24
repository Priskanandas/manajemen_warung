<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id';
    protected $fillable = ['tanggal_bayar', 'total_bayar', 'total_uang', 'uang_kembali'];


}

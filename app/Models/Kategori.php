<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Warung;
use App\Models\Barang;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id';
    protected $fillable = ['id_warung', 'nama_kategori'];

    public function warung()
    {
        return $this->belongsTo(Warung::class, 'id_warung');
    }

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_kategori');
    }
}

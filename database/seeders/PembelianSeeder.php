<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pembelian;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('pembelian')->insert([
            [
                'id_barang' => 1,
                'id_warung' => 1,
                'jml_beli' => 3,
                'tanggal' => Carbon::now(),
                'harga_beli' => 60000,
                'subtotal' => 180000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}

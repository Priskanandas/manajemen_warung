<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('penjualan')->insert([
            [
                'id_pembayaran' => 1,
                'id_barang' => 1,
                'id_warung' => 1,
                'satuan' => 'kg',
                'tanggal' => Carbon::now(),
                'jml_beli' => 1,
                'harga_jual' => 70000,
                'total_harga' => 70000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}

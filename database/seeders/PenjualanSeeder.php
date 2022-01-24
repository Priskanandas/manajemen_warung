<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penjualan;
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
        $penjualan = Penjualan::create([
            'id_barang'=> '1', 
            'id_pelayan'=> '2', 
            'id_pembayaran'=> '1', 
            'satuan'=> 'pcs', 
            'tanggal'=> Carbon::parse('2022-01-21'), 
            'harga_barang'=> 4000, 
            'jml_beli'=> 1, 
            'total_harga'=> 4000

        ]);
    }
}

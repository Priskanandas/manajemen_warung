<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Harga;
use Carbon\Carbon;

class HargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $harga = Harga::create([
            'id_barang'=> 1, 
            'tanggal_beli'=>  Carbon::create('2022', '01', '20'), 
            'id_pembelian'=> 1,
             'harga_ecer'=> 3500,
             'harga_grosir'=> 70000, 
             'harga_jual'=> 4000, 
             'status'=> 'active'

        ]);
    }
}

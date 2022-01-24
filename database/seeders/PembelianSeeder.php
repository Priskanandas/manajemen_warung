<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pembelian;
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
        $pembelian = Pembelian::create([
            'id_barang'=> '1',
            'tanggal_beli'=>  Carbon::create('2022', '01', '20'), 
            'jml_beli'=> '1',
        ]);
    }
}

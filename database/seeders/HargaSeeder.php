<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Harga;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class HargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('harga')->insert([
            [
                'id_barang' => 1,
                'id_warung' => 1,
                'id_pembelian' => 2,
                'harga_jual' => 70000,
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}

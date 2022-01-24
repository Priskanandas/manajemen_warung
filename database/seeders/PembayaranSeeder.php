<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pembayaran;
use Carbon\Carbon;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pembayaran = Pembayaran::create([
            'tanggal_bayar'=>  Carbon::parse('2022-01-21'),
            'total_bayar'=> 4000,
            'total_uang'=> 5000,
            'uang_kembali'=> 1000
        ]);
    }
}

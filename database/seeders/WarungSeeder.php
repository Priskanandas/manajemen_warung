<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warung;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class WarungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $warung = Warung::create([
            'user_id' => 2,
            'nama_warung' => 'Surya Grosir',
            'alamat' => 'Krendetan, Bagelen, Purworejo',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}

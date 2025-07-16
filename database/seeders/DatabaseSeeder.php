<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(CreateAdminUserSeeder::class);
        $this->call(WarungSeeder::class);
        $this->call(KategoriSeeder::class);
        $this->call(BarangSeeder::class);
        $this->call(HargaSeeder::class);
        $this->call(PembayaranSeeder::class);
        $this->call(PembelianSeeder::class);
        $this->call(PenjualanSeeder::class);


    }
}

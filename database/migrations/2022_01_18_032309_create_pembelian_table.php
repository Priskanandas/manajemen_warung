<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('pembelian', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_barang');
        $table->unsignedBigInteger('id_warung');
        $table->integer('jml_beli');
        $table->date('tanggal');
        $table->integer('harga_beli');
        $table->integer('subtotal'); // ⬅️ Harga beli disimpan di sini
        $table->timestamps();

                    // Foreign key ke barang
            $table->foreign('id_barang')->references('id')->on('barang')->onDelete('cascade');

            // Foreign key ke warung
            $table->foreign('id_warung')->references('id')->on('warung')->onDelete('cascade');

    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian');
    }
}

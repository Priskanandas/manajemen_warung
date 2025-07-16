<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('penjualan', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('id_pembayaran'); // foreign key ke header
    $table->unsignedBigInteger('id_barang');
    $table->unsignedBigInteger('id_warung');
    $table->string('satuan')->nullable();
    $table->date('tanggal');
    $table->integer('jml_beli');
    $table->integer('harga_jual');
    $table->integer('total_harga');
    $table->timestamps();

    $table->foreign('id_pembayaran')->references('id')->on('pembayaran')->onDelete('cascade');
    $table->foreign('id_barang')->references('id')->on('barang')->onDelete('restrict');
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
        Schema::dropIfExists('penjualan');
    }
}

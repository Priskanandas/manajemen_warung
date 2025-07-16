<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('harga', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('id_barang');
    $table->unsignedBigInteger('id_warung');
    $table->unsignedBigInteger('id_pembelian')->nullable();
    $table->integer('harga_jual'); // harga jual grosir
    $table->enum('status', ['active', 'non-active'])->default('active');
    $table->timestamps();

    $table->foreign('id_barang')->references('id')->on('barang')->onDelete('cascade');
    $table->foreign('id_warung')->references('id')->on('warung')->onDelete('cascade');
    $table->foreign('id_pembelian')->references('id')->on('pembelian')->onDelete('cascade');

});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('harga');
    }
}

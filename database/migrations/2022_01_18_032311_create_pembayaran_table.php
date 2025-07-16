<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('id_warung');
    $table->unsignedBigInteger('id_pelayan')->nullable(); // user yang melakukan transaksi
    $table->dateTime('tanggal_bayar');
    $table->integer('total_bayar');
    $table->integer('total_uang');
    $table->integer('uang_kembali');
    $table->timestamps();

    $table->foreign('id_warung')->references('id')->on('warung')->onDelete('cascade');
    $table->foreign('id_pelayan')->references('id')->on('users')->onDelete('set null');
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
}

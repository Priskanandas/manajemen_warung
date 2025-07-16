<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('barang', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('id_warung'); // ← penting
    $table->unsignedBigInteger('id_kategori')->nullable();
    $table->string('kd_barang');
    $table->string('nama_barang');
    $table->string('satuan')->nullable();
    $table->integer('stok')->default(0);
    $table->timestamps();

    $table->foreign('id_warung')->references('id')->on('warung')->onDelete('cascade');
    $table->foreign('id_kategori')->references('id')->on('kategori')->onDelete('set null');
});

       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}

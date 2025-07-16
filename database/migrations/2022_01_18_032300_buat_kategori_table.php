<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BuatKategoriTable extends Migration
{
    public function up()
    {
        Schema::create('kategori', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('id_warung');
    $table->string('nama_kategori');
    $table->timestamps();

    $table->foreign('id_warung')->references('id')->on('warung')->onDelete('cascade');
});

    }

    public function down()
    {
        Schema::dropIfExists('kategori');
    }
}

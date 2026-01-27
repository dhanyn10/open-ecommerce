<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pembelian extends Migration
{
    public function up()
    {
        Schema::create('pembelian', function(Blueprint $table){
            $table->string('id', 50)->primary();
            $table->string('waktu', 17);
            $table->integer('jumlah');
            $table->string('idbarang', 50);
            $table->foreign('idbarang')->references('id')->on('barang')->onDelete('cascade');
            $table->string('barang', 30);
            $table->foreignId('user_id')->constrained('pengguna')->onDelete('cascade');
        });
    }
   public function down()
    {
        Schema::dropIfExists('pembelian');
    }
}

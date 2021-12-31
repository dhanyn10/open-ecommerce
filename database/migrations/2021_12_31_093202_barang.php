<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Barang extends Migration
{
    public function up()
    {
        Schema::create('barang', function(Blueprint $table){
            $table->string('id', 50)->primary();
            $table->string('nama', 30);
            $table->string('penjual',30);
            $table->integer("harga");
            $table->integer('jumlah');
            $table->integer('berat');
            $table->text('keterangan',10000);
        });
    }
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}

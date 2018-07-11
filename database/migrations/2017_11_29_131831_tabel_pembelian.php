<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TabelPembelian extends Migration
{
    public function up()
    {
        Schema::create('pembelian', function(Blueprint $table){
            $table->string('id', 50)->primary();
            $table->string('waktu', 17);
            $table->integer('jumlah');
            $table->string('idbarang',50);
            $table->string('barang', 30);
            $table->string('pembeli',30);
        });
    }
   public function down()
    {
        Schema::dropIfExists('pembelian');
    }
}

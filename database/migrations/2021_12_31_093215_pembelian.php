<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pembelian extends Migration
{
    public function up()
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('waktu', 17);
            $table->integer('jumlah');
            $table->string('product_id', 50);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('product_name', 30);
            $table->foreignId('user_id')->constrained('pengguna')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembelian');
    }
}

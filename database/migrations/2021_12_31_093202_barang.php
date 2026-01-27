<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Barang extends Migration
{
    public function up()
    {
        Schema::create('products', function(Blueprint $table){
            $table->string('id', 50)->primary();
            $table->string('name');
            $table->foreignId('user_id')->constrained('pengguna')->onDelete('cascade');
            $table->integer("price");
            $table->integer('stock');
            $table->integer('weight');
            $table->text('description',10000);
        });
    }
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

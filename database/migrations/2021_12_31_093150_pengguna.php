<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pengguna extends Migration
{
    public function up()
    {
        Schema::create('pengguna', function(Blueprint $table){
            $table->string("email", 30)->primary();
            $table->string("nama", 20);
            $table->string('telepon', 12)->nullable();
            $table->string('alamat',255)->nullable();
            $table->string('kota', 255)->nullable();
            $table->string('provinsi', 255)->nullable();
            $table->string("sandi",30);
            $table->integer("peran");
            $table->integer("konfirmasi");
            $table->string("token", 40)->nullable();
        });
    }
    public function down()
    {
        Schema::dropIfExists('pengguna');
    }
}

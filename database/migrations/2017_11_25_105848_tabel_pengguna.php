<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TabelPengguna extends Migration
{
    public function up()
    {
        Schema::create('pengguna', function(Blueprint $table){
            $table->string("email", 30)->primary();
            $table->string("nama", 20);
            $table->string('telepon', 12)->nullable();
            $table->string('alamat',255)->nullable();
            $table->string("sandi",60);
            $table->integer("peran");
            $table->integer("konfirmasi");
            $table->string("token", 40);
        });
    }
    public function down()
    {
        Schema::dropIfExists('pengguna');
    }
}

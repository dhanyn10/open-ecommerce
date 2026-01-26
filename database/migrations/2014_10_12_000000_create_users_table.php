<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('telepon', 15)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('kota', 255)->nullable();
            $table->string('provinsi', 255)->nullable();
            $table->string('password');
            $table->integer('peran');
            $table->integer('konfirmasi');
            $table->string('token', 40)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

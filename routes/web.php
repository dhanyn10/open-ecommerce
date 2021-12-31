<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\MasukController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PenggunaController;

use App\Http\Controllers\Admin\DasborController as AdminDasbor;
use App\Http\Controllers\Admin\ProfilController as AdminProfil;

use App\Http\Controllers\Barang\BarangController as BarangBarang;
use App\Http\Controllers\Barang\BeliController as BarangBeli;

use App\Http\Controllers\Penjual\BarangController as PenjualBarang;
use App\Http\Controllers\Penjual\HapusController as PenjualHapus;
use App\Http\Controllers\Penjual\TambahController as PenjualTambah;
use App\Http\Controllers\Penjual\UbahController as PenjualUbah;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('masuk', [MasukController::class, 'index'])->name('masuk');
Route::get('daftar', [DaftarController::class, 'index'])->name('daftar');
Route::get('konfirmasi/{token}', [DaftarController::class, 'konfirmasi'])->name('konfirmasi');
Route::get('form_konfirmasi', [DaftarController::class, 'formulirkonfirmasi'])->name('formkonfirmasi');
Route::get('reset_sandi', [MasukController::class, 'resetsandi'])->name('reset-sandi');
Route::get('keluar', function(){
    return view('keluar');
})->name('keluar');

Route::post('daftar', [DaftarController::class, 'daftar']);
Route::post('form_konfirmasi', [DaftarController::class, 'data_konfirmasi']);
Route::post('masuk', [MasukController::class, 'masuk']);
Route::post('reset_sandi', [MasukController::class, 'formresetsandi']);

Route::group([
    'middleware'    => 'penjual',
    'prefix'        => 'penjual',
    'as'            => 'penjual-'
], function(){
    Route::get('/',function() {
        return redirect()->route('penjual-tambah');
    });
    Route::get('tambah', [PenjualTambah::class, 'index'])->name('tambah');
    Route::get('lihat', [PenjualBarang::class, 'index'])->name('lihat');
    Route::get('ubah/{id}', [PenjualUbah::class, 'index'])->name('ubah');
    Route::get('profil', [ProfilController::class, 'index'])->name('profil');
    Route::post('profil', [PenggunaController::class, 'profil']);
    Route::post('tambah', [PenjualTambah::class, 'formtambah']);
    Route::post('lihat', [PenjualHapus::class, 'formhapus']);
    Route::post('ubah/{id}', [PenjualUbah::class, 'formubah']);
    Route::post('akun', [PenggunaController::class, 'profil']);
});

Route::group([
    'middleware'    => 'pembeli',
    'prefix'        => 'pembeli'
], function(){
    Route::get('profil', [ProfilController::class, 'index'])->name('pembeli-profil');
    Route::post('profil', [PenggunaController::class, 'profil']);
});

Route::group([
    'middleware'    => 'pengguna',
    'prefix'        => 'barang'
], function(){
    Route::get('beli', [BarangBeli::class, 'beli'])->name('data-belanja');
    Route::get('bayar',[BarangBeli::class. 'bayar'])->name('bayar');
    Route::get('{id}', [BarangBarang::class, 'index'])->name('barang');
    Route::get('tambah/{id}', [BarangBeli::class, 'troliPlus']);
    Route::get('kurang/{id}', [BarangBeli::class, 'troliMinus']);
    Route::get('hapus/{id}', [BarangBeli::class, 'troliDelete']);
    Route::post('{id}', [BarangBarang::class, 'index']);
    Route::post('beli', [BarangBeli::class, 'aturbelanja']);
});

Route::group([
    'middleware'    => 'admin',
    'prefix'        => 'admin',
    'as'            => 'admin-'
], function(){
    Route::get('dasbor', [AdminDasbor::class, 'index'])->name('dasbor');
    Route::get('profil', [AdminProfil::class, 'index'])->name('profil');
});

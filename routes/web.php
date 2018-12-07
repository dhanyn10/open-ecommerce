<?php

Route::get('/', 'BerandaController@index')->name('beranda');
Route::get('masuk', 'MasukController@index')->name('masuk');
Route::get('daftar','DaftarController@index')->name('daftar');
Route::get('konfirmasi/{token}', 'DaftarController@konfirmasi')->name('konfirmasi');
Route::get('form_konfirmasi','DaftarController@formulirkonfirmasi')->name('formkonfirmasi');
Route::get('reset_sandi', 'MasukController@resetsandi')->name('reset-sandi');
Route::get('keluar', function(){
    return view('keluar');
})->name('keluar');

Route::post('daftar', 'DaftarController@daftar');
Route::post('form_konfirmasi', 'DaftarController@data_konfirmasi');
Route::post('masuk', 'MasukController@masuk');
Route::post('reset_sandi', 'MasukController@formresetsandi');

Route::group([
    'middleware'    => 'penjual',
    'prefix'        => 'penjual'
], function(){

    Route::get('/',function() {
        return redirect()->route('penjual-tambah');
    });
    Route::get('tambah', 'Penjual\TambahController@index')->name('penjual-tambah');
    Route::get('lihat', 'Penjual\BarangController@index')->name('penjual-lihat');
    Route::get('ubah/{id}', 'Penjual\UbahController@index')->name('penjual-ubah');
    Route::get('akun', 'Penjual\AkunController@index')->name('akun-penjual');
    Route::post('tambah', 'Penjual\TambahController@formtambah');
    Route::post('lihat', 'Penjual\HapusController@formhapus');
    Route::post('ubah/{id}', 'Penjual\UbahController@formubah');
    Route::post('akun', 'PenggunaController@profil');
});

Route::group([
    'middleware'    => 'pembeli',
    'prefix'        => 'pembeli'
], function(){

    Route::get('profil', 'Pembeli\ProfilController@index')->name('pembeli-profil');
    Route::post('profil', 'PenggunaController@profil');
});

Route::group([
    'middleware'    => 'pengguna',
    'prefix'        => 'barang'
], function(){

    Route::get('beli', 'Barang\BeliController@beli')->name('data-belanja');
    Route::get('bayar','Barang\BeliController@bayar')->name('bayar');
    Route::get('{id}', 'Barang\BarangController@index')->name('barang');
    Route::get('beli/{id}', 'Barang\BeliController@troli')->name('beli');
    Route::post('beli', 'Barang\BeliController@aturbelanja');
    Route::post('beli/{id}', 'Barang\BeliController@aturbelanja');
});

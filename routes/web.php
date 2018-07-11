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

    Route::get('dasbor', 'Penjual\DasborController@index')->name('dasbor-penjual');

    Route::get('barang', 'Penjual\BarangController@index')->name('barang-penjual');

    Route::get('akun', 'Penjual\AkunController@index')->name('akun-penjual');

    Route::post('dasbor', 'Penjual\DasborController@barang');

    Route::post('barang', 'Penjual\BarangController@barang');
    
    Route::post('akun', 'PenggunaController@profil');

});

Route::group([
    'middleware'    => 'pembeli',
    'prefix'        => 'pembeli'
], function(){

    Route::get('dasbor', 'Pembeli\DasborController@index')->name('dasbor-pembeli');

    Route::post('dasbor', 'PenggunaController@profil');
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

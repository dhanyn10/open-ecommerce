<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $primaryKey   = 'id';
    protected $table        = 'barang';
    public $incrementing    = false;
    public $timestamps      = false;
    
    protected $fillable = [
        'id',
        'nama',
        'harga',
        'berat',
        'jumlah',
        'penjual',
        'keterangan'
    ];
}
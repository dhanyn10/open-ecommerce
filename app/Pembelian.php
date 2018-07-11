<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $primaryKey   = 'id';
    protected $table        = 'pembelian';
    public $incrementing    = false;
    public $timestamps      = false;
    
    protected $fillable = [
        'id',
        'waktu',
        'idbarang',
        'barang',
        'jumlah',
        'pembeli'
    ];
}

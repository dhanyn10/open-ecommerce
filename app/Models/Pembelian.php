<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    
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

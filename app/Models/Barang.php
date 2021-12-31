<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    
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

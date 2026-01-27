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
        'user_id',
        'keterangan'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'idbarang');
    }
}

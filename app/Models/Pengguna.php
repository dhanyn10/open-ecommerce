<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;
    
    protected $primaryKey   = 'id';
    protected $table        = 'pengguna';
    public $incrementing    = true;
    public $timestamps      = false;
    
    protected $fillable = [
        'id',
        'email',
        'telepon',
        'alamat',
        'kota',
        'provinsi',
        'nama',
        'sandi',
        'peran',
        'konfirmasi',
        'token'
    ];
    
    protected $hidden = [
        'sandi'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function barang()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'user_id');
    }
}

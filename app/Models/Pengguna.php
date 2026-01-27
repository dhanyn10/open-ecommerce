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
    
    protected $nullable = [
        'telepon',
        'alamat',
        'kota',
        'provinsi'
    ];

    protected $hidden = [
        'sandi'
    ];
}

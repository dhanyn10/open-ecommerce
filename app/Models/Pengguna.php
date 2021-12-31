<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;
    
    protected $primaryKey   = 'email';
    protected $table        = 'pengguna';
    public $incrementing    = false;
    public $timestamps      = false;
    
    protected $fillable = [
        'email',
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

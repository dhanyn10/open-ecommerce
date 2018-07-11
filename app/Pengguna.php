<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
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
        'alamat'
    ];

    protected $hidden = [
        'sandi'
    ];
}

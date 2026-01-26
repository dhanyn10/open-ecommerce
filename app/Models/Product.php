<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $primaryKey   = 'id';
    protected $table        = 'products';
    public $incrementing    = false;
    
    protected $fillable = [
        'id',
        'user_id',
        'nama',
        'harga',
        'berat',
        'jumlah',
        'keterangan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

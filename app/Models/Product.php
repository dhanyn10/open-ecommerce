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
    public $timestamps      = false;
    
    protected $fillable = [
        'id',
        'name',
        'price',
        'weight',
        'stock',
        'user_id',
        'description'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'product_id');
    }

    public function getSoldAttribute()
    {
        return $this->pembelian()->sum('jumlah');
    }

    public function getCurrentStockAttribute()
    {
        return $this->stock - $this->sold;
    }
}

<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Pengguna;

class BarangController extends Controller
{
    public function index()
    {
        $products = Pengguna::find(session('id'))->products;
        return view('penjual.barang',[
            'data_barang'   => $products
        ]);
    }
}

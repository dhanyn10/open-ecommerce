<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;

use App\Models\Barang;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::where('user_id', session('id'))->get();
        return view('penjual.barang',[
            'data_barang'   => $barang
        ]);
    }
}

<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;

use App\Models\Barang;
use App\Models\Pengguna;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Pengguna::find(session('id'))->barang;
        return view('penjual.barang',[
            'data_barang'   => $barang
        ]);
    }
}

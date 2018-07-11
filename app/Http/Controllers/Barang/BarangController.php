<?php

namespace App\Http\Controllers\Barang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Barang;
use App\Pembelian;
use App\Pengguna;

class BarangController extends Controller
{
    public function index($id)
    {
        $barang         = Barang::where('id', $id)->get();
        $emailpenjual   = $barang->pluck('penjual')->first();
        $pengguna       = Pengguna::where('email', $emailpenjual)->get();
        $namapenjual    = $pengguna->pluck('nama')->first();

        //jumlah barang yang tersisa
        $data_barang    = Barang::where('id', $id)->get();
        $batasjml       = $data_barang->pluck('jumlah')->first();
        //data jumlah barang yang dibeli di tabel pembelian
        $jumlahbarang   = Pembelian::where('idbarang', $id)->get();

        $jml_dibeli     = 0;
        for($a = 0; $a < count($jumlahbarang); $a++)
        {
            $jml_dibeli += $jumlahbarang[$a]['jumlah'];
        }

        $sisabarang     = $batasjml - $jml_dibeli;
        return view('barang.index', [
            'data_barang'   => $barang,
            'penjual'       => $namapenjual,
            'sisabarang'   => $sisabarang
        ]);
    }
}

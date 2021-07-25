<?php

namespace App\Http\Controllers\Barang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use App\Barang;
use App\Pembelian;
use App\Pengguna;
use App\Http\Controllers\Barang\RajaOngkir;

class BarangController extends Controller
{
    private function sisaBarang($id)
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

        $sisabarang = $batasjml - $jml_dibeli;
        return array(
            'barang'        => $barang,
            'namapenjual'   => $namapenjual,
            'sisabarang'    => $sisabarang
        );
    }
    public function index(Request $req, $id)
    {
        $arrayBarang = $this->sisaBarang($id);
        $barang = Barang::where('id', $id)->get();

        //penjual
        $emailpenjual = $barang->pluck('penjual')->first();
        $userPenjual = Pengguna::where('email', $emailpenjual)->get();
        $provUserPenjual = $userPenjual->pluck('provinsi')->first();
        $kotaUserPenjual = $userPenjual->pluck('kota')->first();

        if($provUserPenjual != null)
        {
            $provUserPenjual = explode('-', $provUserPenjual);
        }
        if($kotaUserPenjual != null)
        {
            $kotaUserPenjual = explode('-', $kotaUserPenjual);
        }


        //pembeli
        $userPembeli = Pengguna::where('email', session('email'))->get();
        $provUserPembeli = $userPembeli->pluck('provinsi')->first();
        $kotaUserPembeli = $userPembeli->pluck('kota')->first();

        if($provUserPembeli != null)
        {
            $provUserPembeli = explode('-', $provUserPembeli);
        }
        if($kotaUserPembeli != null)
        {
            $kotaUserPembeli = explode('-', $kotaUserPembeli);
        }
        
        return view('barang.index', [
            'provUserPenjual'   => $provUserPenjual,
            'provUserPembeli'   => $provUserPembeli,
            'kotaUserPenjual'   => $kotaUserPenjual,
            'kotaUserPembeli'   => $kotaUserPembeli,
            'data_barang'   => $arrayBarang['barang'],
            'penjual'       => $arrayBarang['namapenjual'],
            'sisabarang'    => $arrayBarang['sisabarang']
        ]);
        //     $harga = RajaOngkir::costRajaOngkir($kotaAsal, $kotaTujuan, $berat*1000); //return array cots
    }
}

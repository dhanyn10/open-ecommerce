<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Pengguna;
use App\Http\Controllers\RajaOngkir;

class BarangController extends Controller
{    
    private function sisaBarang($id)
    {
        $barang         = Barang::find($id);
        $namapenjual    = $barang->pengguna->nama;

        //jumlah barang yang tersisa
        $batasjml       = $barang->jumlah;
        //data jumlah barang yang dibeli di tabel pembelian
        $jumlahbarang   = $barang->pembelian;

        $jml_dibeli     = 0;
        for($a = 0; $a < count($jumlahbarang); $a++)
        {
            $jml_dibeli += $jumlahbarang[$a]['jumlah'];
        }

        $sisabarang = $batasjml - $jml_dibeli;
        return array(
            'barang'        => collect([$barang]),
            'namapenjual'   => $namapenjual,
            'sisabarang'    => $sisabarang
        );
    }
    public function index(Request $req, $id)
    {
        $arrayBarang = $this->sisaBarang($id);
        $barangObj = $arrayBarang['barang']->first();
        $berat = $barangObj->berat;

        //penjual
        $userPenjual = $barangObj->pengguna;
        $provUserPenjual = $userPenjual ? $userPenjual->provinsi : null;
        $kotaUserPenjual = $userPenjual ? $userPenjual->kota : null;

        if($provUserPenjual != null)
        {
            $provUserPenjual = explode('-', $provUserPenjual);
        }
        if($kotaUserPenjual != null)
        {
            $kotaUserPenjual = explode('-', $kotaUserPenjual);
        }

        //pembeli
        $userPembeli = Pengguna::find(session('id'));
        $provUserPembeli = $userPembeli ? $userPembeli->provinsi : null;
        $kotaUserPembeli = $userPembeli ? $userPembeli->kota : null;

        if($provUserPembeli != null)
        {
            $provUserPembeli = explode('-', $provUserPembeli);
        }
        if($kotaUserPembeli != null)
        {
            $kotaUserPembeli = explode('-', $kotaUserPembeli);
        }
        

        $idkotaAsal = null;
        if($kotaUserPenjual != null)
        {
            $idkotaAsal = $kotaUserPenjual;
        }
        $idkotaTujuan = null;
        if($kotaUserPembeli != null)
        {
            $idkotaTujuan = $kotaUserPembeli;
        }

        $harga = RajaOngkir::costRajaOngkir($idkotaAsal, $idkotaTujuan, $berat*1000); //return array costs

        return view('barang.index', [
            'provUserPenjual'   => $provUserPenjual,
            'provUserPembeli'   => $provUserPembeli,
            'kotaUserPenjual'   => $kotaUserPenjual,
            'kotaUserPembeli'   => $kotaUserPembeli,
            'data_barang'   => $arrayBarang['barang'],
            'penjual'       => $arrayBarang['namapenjual'],
            'sisabarang'    => $arrayBarang['sisabarang'],
            'berat'         => $berat,
            'harga'         => $harga
        ]);
    }
}

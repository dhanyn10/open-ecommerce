<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Pembelian;
use App\Models\Pengguna;
use App\Http\Controllers\RajaOngkir;

class BarangController extends Controller
{    
    private function sisaBarang($id)
    {
        $product        = Product::find($id);
        $namapenjual    = $product->pengguna->nama;

        return array(
            'barang'        => collect([$product]),
            'namapenjual'   => $namapenjual,
            'sisabarang'    => $product->current_stock
        );
    }
    public function index(Request $req, $id)
    {
        $arrayBarang = $this->sisaBarang($id);
        $productObj = $arrayBarang['barang']->first();
        $weight = $productObj->weight;

        $userPenjual = $productObj->pengguna;
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

        $harga = RajaOngkir::costRajaOngkir($idkotaAsal, $idkotaTujuan, $weight*1000);

        return view('barang.index', [
            'provUserPenjual'   => $provUserPenjual,
            'provUserPembeli'   => $provUserPembeli,
            'kotaUserPenjual'   => $kotaUserPenjual,
            'kotaUserPembeli'   => $kotaUserPembeli,
            'data_barang'   => $arrayBarang['barang'],
            'penjual'       => $arrayBarang['namapenjual'],
            'sisabarang'    => $arrayBarang['sisabarang'],
            'berat'         => $weight,
            'ongkir'        => $harga
        ]);
    }
}

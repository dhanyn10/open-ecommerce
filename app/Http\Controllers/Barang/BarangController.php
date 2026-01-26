<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Pembelian;
use App\Http\Controllers\RajaOngkir;

class BarangController extends Controller
{
    private function sisaBarang($id)
    {
        $product = Product::with('user')->findOrFail($id);

        $batasjml = $product->jumlah;
        $jml_dibeli = Pembelian::where('idbarang', $id)->sum('jumlah');
        $sisabarang = $batasjml - $jml_dibeli;

        return [
            'product' => $product,
            'namapenjual' => $product->user->nama,
            'sisabarang' => $sisabarang
        ];
    }

    public function index(Request $req, $id)
    {
        $arrayBarang = $this->sisaBarang($id);
        $product = $arrayBarang['product'];
        $berat = $product->berat;

        // Seller's location
        $userPenjual = $product->user;
        $provUserPenjual = $userPenjual->provinsi ? explode('-', $userPenjual->provinsi) : null;
        $kotaUserPenjual = $userPenjual->kota ? explode('-', $userPenjual->kota) : null;

        // Buyer's location
        $userPembeli = Auth::user();
        $provUserPembeli = $userPembeli->provinsi ? explode('-', $userPembeli->provinsi) : null;
        $kotaUserPembeli = $userPembeli->kota ? explode('-', $userPembeli->kota) : null;

        $idkotaAsal = $kotaUserPenjual[0] ?? null;
        $idkotaTujuan = $kotaUserPembeli[0] ?? null;

        $harga = null;
        if ($idkotaAsal && $idkotaTujuan) {
            $harga = RajaOngkir::costRajaOngkir($idkotaAsal, $idkotaTujuan, $berat * 1000);
        }

        return view('barang.index', [
            'provUserPenjual'   => $provUserPenjual,
            'provUserPembeli'   => $provUserPembeli,
            'kotaUserPenjual'   => $kotaUserPenjual,
            'kotaUserPembeli'   => $kotaUserPembeli,
            'data_barang'   => [$product],
            'penjual'       => $arrayBarang['namapenjual'],
            'sisabarang'    => $arrayBarang['sisabarang'],
            'berat'         => $berat,
            'harga'         => $harga
        ]);
    }
}

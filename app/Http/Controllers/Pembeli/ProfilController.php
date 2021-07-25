<?php

namespace App\Http\Controllers\Pembeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Pengguna;
use App\Http\Controllers\Barang\RajaOngkir;

class ProfilController extends Controller
{
    public function index(Request $req)
    {
        $provinsiAsal = $req->input('provinsiAsal');
        $rajaongkir = RajaOngkir::getApi('https://api.rajaongkir.com/starter/province?key='.env('RAJAONGKIR_API_KEY'));
        $dataKotaAsal = RajaOngkir::getApi('https://api.rajaongkir.com/starter/city?key='.env('RAJAONGKIR_API_KEY').'&province='.$provinsiAsal);
        $dataProvinsi = $rajaongkir->results;
        $pengguna   = Pengguna::where('email', session('email'))->get();
        return view('pembeli.profil',[
            'pengguna'  => $pengguna,
            'dataProvinsi'  => $dataProvinsi,
            'provinsiAsal'  => $provinsiAsal
        ]);
    }
}

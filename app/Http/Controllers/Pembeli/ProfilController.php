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
        $pengguna       = Pengguna::where('email', session('email'))->get();
        $provinsiAsal   = $pengguna->pluck('provinsi')->first();
        $provinsiAsal   = explode("-", $provinsiAsal);
        $kotaAsal       = $pengguna->pluck('kota')->first();
        $roDataProv     = RajaOngkir::getApi('https://api.rajaongkir.com/starter/province?key='.env('RAJAONGKIR_API_KEY'));
        if($roDataProv != null)
            $dataProvinsi = $roDataProv->results;
        else
            $dataProvinsi = null;
        $roKota = RajaOngkir::getApi('https://api.rajaongkir.com/starter/city?key='.env('RAJAONGKIR_API_KEY').'&province='.$provinsiAsal[0]);
        if($roKota != null)
            $dataKota = $roKota->results;
        else
            $kotaAsal = null;
        return view('pembeli.profil',[
            'pengguna'      => $pengguna,
            'dataProvinsi'  => $dataProvinsi,
            'dataKota'      => $dataKota,
            'kotaAsal'      => $kotaAsal
        ]);
    }
}

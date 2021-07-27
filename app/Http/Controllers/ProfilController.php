<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Pengguna;
use App\Http\Controllers\RajaOngkir;

class ProfilController extends Controller
{
    public function index()
    {
        $pengguna       = Pengguna::where('email', session('email'))->get();
        $dataProvinsi   = null;
        $kota           = null;
        $dataKota       = null;

        //rajaongkir get data provinsi
        $roDataProv     = RajaOngkir::getApi('https://api.rajaongkir.com/starter/province?key='.config('app.RajaOngkir'));
        if($roDataProv != null)
            $dataProvinsi = $roDataProv->results;

        $provinsi =
        $provinsiId =
        $provinsiName = null;
        $provinsi = $pengguna->pluck('provinsi')->first();    
        $kota = $pengguna->pluck('kota')->first();    

        if($provinsi != null)
        {
            $provinsi = explode("-", $provinsi);
            $provinsiId = $provinsi[0];
            $provinsiName = $provinsi[1];    
        }
        $roKota = RajaOngkir::getApi('https://api.rajaongkir.com/starter/city?key='.config('app.RajaOngkir').'&province='.$provinsiId);
        if($roKota != null)
        {
            $dataKota = $roKota->results;
        }

        if($kota != null)
        {
            $kota = explode('-', $kota);
            $kota = $kota[1];
        }
        $peran = null;

        if(session('peran') == 2)
        {
            $peran = 'penjual.akun';
        }
        elseif(session('peran') == 3)
        {
            $peran = 'pembeli.profil';
        }
        return view($peran ,[
            'roKota'        => $roKota,
            'pengguna'      => $pengguna,
            'dataProvinsi'  => $dataProvinsi,
            'dataKota'      => $dataKota,
            'provinsi'      => $provinsiName,
            'kotaAsal'      => $kota
        ]);
    }
}

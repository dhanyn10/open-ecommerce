<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Http\Controllers\RajaOngkir;

class ProfilController extends Controller
{
    public function index()
    {
        $pengguna       = Pengguna::where('id', session('id'))->get();
        $dataProvinsi   = RajaOngkir::getProvinces();
        $dataKota       = null;
        $provinsiId     = null;
        $provinsiName   = null;
        $kotaAsal       = null;

        $userProvinsi = $pengguna->pluck('provinsi')->first();
        $userKota     = $pengguna->pluck('kota')->first();

        if ($userProvinsi) {
            $provinsiParts = explode('-', $userProvinsi, 2);
            $provinsiId = $provinsiParts[0];
            $provinsiName = $provinsiParts[1] ?? null;
        }

        if ($userKota) {
            $kotaParts = explode('-', $userKota, 2);
            $kotaAsal = $kotaParts[1] ?? null;
        }

        $peran = null;
        if (session('peran') == 2) {
            $peran = 'penjual.akun';
        } elseif (session('peran') == 3) {
            $peran = 'pembeli.profil';
        }

        return view($peran, [
            'pengguna'      => $pengguna,
            'dataProvinsi'  => $dataProvinsi,
            'dataKota'      => $dataKota,
            'provinsi'      => $provinsiName,
            'kotaAsal'      => $kotaAsal
        ]);
    }

    public function getCitiesByProvinceAjax(Request $request)
    {
        $provinceId = $request->query('province_id');

        if (!$provinceId) {
            return response()->json([]);
        }

        $cities = RajaOngkir::getCitiesByProvince($provinceId);

        return response()->json($cities);
    }
}

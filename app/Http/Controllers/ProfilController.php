<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RajaOngkir;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dataProvinsi = RajaOngkir::getProvinces();
        $dataKota = null;
        $provinsiId = null;
        $provinsiName = null;
        $kotaAsal = null;

        if ($user->provinsi) {
            $provinsiParts = explode('-', $user->provinsi, 2);
            $provinsiId = $provinsiParts[0];
            $provinsiName = $provinsiParts[1] ?? null;
        }

        if ($user->kota) {
            $kotaParts = explode('-', $user->kota, 2);
            $kotaAsal = $kotaParts[1] ?? null;
        }

        $viewName = '';
        if ($user->peran == 2) {
            $viewName = 'penjual.akun';
        } elseif ($user->peran == 3) {
            $viewName = 'pembeli.profil';
        }

        return view($viewName, [
            'pengguna' => $user,
            'dataProvinsi' => $dataProvinsi,
            'dataKota' => $dataKota,
            'provinsi' => $provinsiName,
            'kotaAsal' => $kotaAsal
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

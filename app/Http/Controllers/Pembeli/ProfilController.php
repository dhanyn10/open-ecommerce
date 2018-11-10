<?php

namespace App\Http\Controllers\Pembeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Pengguna;

class ProfilController extends Controller
{
    public function index()
    {
        $pengguna   = Pengguna::where('email', session('email'))->get();
        return view('pembeli.profil',[
            'pengguna'  => $pengguna
        ]);
    }
}

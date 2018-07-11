<?php

namespace App\Http\Controllers\Penjual;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Pengguna;

class AkunController extends Controller
{
    public function index()
    {
        $pengguna   = Pengguna::where('email', session('email'))->get();
        return view('penjual.akun',[
            'pengguna'  => $pengguna
        ]);
    }
}

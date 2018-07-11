<?php

namespace App\Http\Controllers\Pembeli;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Pengguna;

class DasborController extends Controller
{
    public function index()
    {
        $pengguna   = Pengguna::where('email', session('email'))->get();
        return view('pembeli.dasbor',[
            'pengguna'  => $pengguna
        ]);
    }
}

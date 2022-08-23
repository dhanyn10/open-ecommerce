<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengguna;

class DasborController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::all();
        return view('admin.index', [
            'pengguna' => $pengguna
        ]);
    }
}

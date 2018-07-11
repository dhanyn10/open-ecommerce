<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Barang;

class BerandaController extends Controller
{
    protected function connect()
    {
        try
        {
            DB::connection()->getPdo();
        }
        catch(\PDOException $e)
        {
            return "koneksi database gagal";
        }
    }
    public function index()
    {
        if($this->connect() == 'koneksi database gagal')
        {
            flash('terdapat masalah koneksi database');
            return view('beranda');
        }
        else
        {
            $barang = Barang::all();
            return view('beranda',[
                'data_barang'   => $barang
            ]);
        }
    }
}

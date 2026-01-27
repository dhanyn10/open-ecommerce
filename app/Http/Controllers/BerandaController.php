<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Pengguna;

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
            $products = Product::all();
            $penjual = $products->pluck('user_id')->first();
            $pengguna = Pengguna::where('id', $penjual)->get();
            $kota = $pengguna->pluck('kota')->first();
            if($kota != null)
            {
                $kota = explode('-', $kota);
                $kota = $kota[1];
            }
            return view('beranda',[
                'data_barang' => $products,
                'kota' => $kota
            ]);
        }
    }
}

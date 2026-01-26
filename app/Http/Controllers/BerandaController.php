<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;

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
            $products = Product::with('user')->get();
            $kota = null;
            if ($products->isNotEmpty() && $products->first()->user) {
                $kota = $products->first()->user->kota;
                if ($kota) {
                    $kotaParts = explode('-', $kota);
                    $kota = $kotaParts[1] ?? null;
                }
            }

            return view('beranda',[
                'data_barang' => $products,
                'kota' => $kota
            ]);
        }
    }
}

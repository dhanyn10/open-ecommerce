<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;
use Validator;

use App\Models\Product;
use App\Models\Pengguna;

class TambahController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::where('id', session('id'))->get();
        $telp       = $pengguna->pluck('telepon')->first();
        $alamat     = $pengguna->pluck('alamat')->first();
        $kota       = $pengguna->pluck('kota')->first();
        $provinsi   = $pengguna->pluck('provinsi')->first();

        if($telp == null || $alamat == null || $kota == null || $provinsi == null)
        {
            flash('data akun belum lengkap')->error()->important();
            return redirect()->route('penjual-profil');
        }
        else
        {
            return view('penjual.tambah');
        }
    }
    protected function clean($string) {
        $string = str_replace(' ', '_', $string);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        return preg_replace('/-+/', '_', $string);
     }
    public function formtambah(Request $req)
    {
        $validasi = Validator::make($req->all(),[
            'name'          => 'required|max:30',
            'price'         => 'required|numeric|digits_between:1,10',
            'stock'         => 'required|numeric|digits_between:1,10',
            'weight'        => 'required|numeric|digits_between:1,10',
            'description'   => 'required|max:10000'
        ]);
        if($validasi->fails())
        {
            flash('data tidak sesuai format');
        }
        else
        {
            if($req->input('data-gambar') != null)
            {
                $name        = $req->input('name');
                $price       = $req->input('price');
                $stock       = $req->input('stock');
                $weight      = $req->input('weight');
                $description = $req->input('description');

                $getgambar  = $req->input('data-gambar');
                $explode    = explode(',', $getgambar);
                $gambar     = base64_decode($explode[1]);
                $id     = date("ymdhis").Str::random(7).'-'.$this->clean($name);
                $lokasibarang   = public_path().'/img/barangdagang/'.$id.'.png';
                File::put($lokasibarang, $gambar);
                Product::create([
                    'id'            => $id,
                    'name'          => $name,
                    'price'         => $price,
                    'stock'         => $stock,
                    'weight'        => $weight,
                    'user_id'       => session('id'),
                    'description'   => $description
                ]);
                flash('berhasil menambah barang');
            }
            else
            {
                flash('Belum upload gambar')->error();
            }
        }
        return redirect()->route('penjual-tambah');
    }
}

<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use File;

use App\Models\Product;
use App\Models\Pengguna;

class UbahController extends Controller
{
    public function index($id)
    {
        $products = Pengguna::find(session('id'))->products()->where('id', $id)->get();
        return view('penjual.ubah', [
            'barang'  => $products
        ]);
    }
    public function formubah(Request $req)
    {
        $validasi = Validator::make($req->all(),[
            'name'          => 'required|max:30',
            'price'         => 'required|digits_between:1,10',
            'weight'        => 'required|digits_between:1,10',
            'stock'         => 'required|max:10',
            'description'   => 'required|max:1000'
        ]);
        if($validasi->fails())
        {
            flash('data tidak benar')->error();
        }
        else
        {
            $id = $req->input('id');
            $user = Pengguna::find(session('id'));

            $updateData = [
                'name'          => $req->input('name'),
                'price'         => $req->input('price'),
                'weight'        => $req->input('weight'),
                'stock'         => $req->input('stock'),
                'description'   => $req->input('description')
            ];

            if($req->input('data-gambar') != null)
            {
                $getgambar  = $req->input('data-gambar');
                $explode    = explode(',', $getgambar);
                $gambar     = base64_decode($explode[1]);
                $lokasibarang   = public_path().'/img/barangdagang/'.$id.'.png';
                if(File::exists($lokasibarang))
                {
                    File::delete($lokasibarang);
                }
                File::put($lokasibarang, $gambar);
            }

            $update = $user->products()->where('id', $id)->update($updateData);

            if($update == 0)
            {
                flash('gagal memperbarui data')->error();
            }
            else
            {
                flash('berhasil memperbarui data');
            }
        }
        return redirect()->route('penjual-lihat');
    }
}

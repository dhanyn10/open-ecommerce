<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use Validator;

use App\Models\Product;
use App\Models\Pembelian;

class HapusController extends Controller
{
    public function formhapus(Request $req)
    {
        $validasi = Validator::make($req->all(),[
            'product_id' => 'required'
        ]);
        if($validasi->fails())
        {
            flash('id barang tidak ada');
            return redirect()->route('penjual-tambah');
        }
        else
        {
            $id = $req->input('product_id');
            Product::where('user_id', session('id'))->where('id',$id)->delete();
            File::delete(public_path().'/img/barangdagang/'.$id.'.png');
            flash('berhasil menghapus data')->success();
        }
        return redirect()->route('penjual-lihat');
    }
}

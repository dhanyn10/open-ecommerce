<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use File;
use Validator;

use App\Models\Barang;
use App\Models\Pembelian;

class HapusController extends Controller
{
    public function formhapus(Request $req)
    {
        $validasi = Validator::make($req->all(),[
            'id-barang' => 'required'
        ]);
        if($validasi->fails())
        {
            flash('id barang tidak ada');
            return redirect()->route('penjual-tambah');
        }
        else
        {
            $id = $req->input('id-barang');
            //hapus data barang di tabel barang
            Barang::where('penjual', session('email'))->where('id',$id)->delete();
            //hapus barang di tabel pembelian
            Pembelian::where('idbarang', $id)->delete();
            //hapus file gambar barang di public path
            File::delete(public_path().'/img/barangdagang/'.$id.'.png');
            flash('berhasil menghapus data')->success();
        }
        return redirect()->route('penjual-lihat');
    }
}

<?php

namespace App\Http\Controllers\Penjual;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use File;
use Validator;

use App\Barang;
use App\Pembelian;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::where('penjual', session('email'))->get();
        return view('penjual.barang',[
            'data_barang'   => $barang
        ]);
    }
    public function barang(Request $req)
    {
        if($req->input('jenis') == 'hapusdata')
        {
            $validasi = Validator::make($req->all(),[
                'id-barang' => 'required'
            ]);
            if($validasi->fails())
            {
                flash('id barang tidak ada');
                return redirect()->route('dasbor-penjual');
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
                return redirect()->route('barang-penjual');
            }
        }
        else
        {
            flash('terjadi kesalahan');
            return redirect()->route('barang-penjual');
        }
    }
}

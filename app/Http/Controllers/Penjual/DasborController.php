<?php

namespace App\Http\Controllers\Penjual;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Validator;

use App\Barang;
class DasborController extends Controller
{
    public function index()
    {
        $barang = Barang::where('penjual', session('email'))->get();
        return view('penjual.dasbor',[
            'data_barang'   => $barang
        ]);
    }
    //hapus special character dan ubah spasi menjadi underscore
    protected function clean($string) {
        $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     
        return preg_replace('/-+/', '_', $string); // Replaces multiple hyphens with single one.
     }
    public function barang(Request $req)
    {
        if($req->input('jenis') == 'tambahdata')
        {
            $validasi = Validator::make($req->all(),[
                'input-barang'  => 'required',
                'nama'          => 'required|max:30',
                'harga'         => 'required|numeric|digits_between:1,10',
                'jumlah'        => 'required|numeric|digits_between:1,10',
                'keterangan'    => 'required|max:10000'
            ]);
            if($validasi->fails())
            {
                flash('data tidak sesuai format');
                return redirect()->route('dasbor-penjual');
            }
            else
            {
                $nama       = $req->input('nama');
                $harga      = $req->input('harga');
                $jumlah     = $req->input('jumlah');
                $keterangan = $req->input('keterangan');
                 //mengambil kode base64 dari gambar
                $explode    = explode(",", $req->input("input-barang"));
                //mendecode string gambar yang diperoleh
                $barang     = base64_decode($explode[1]);
                //nama barang sekaligus menjadi id
                $id     = date("ymdhis").str_random(7).'-'.$this->clean($nama);
                //lokasi barang
                $lokasibarang   = public_path().'/img/barangdagang/'.$id.'.png';
                //menyimpan file kedalam folder public/img/user
                File::put($lokasibarang, $barang);
                Barang::create([
                    'id'        => $id,
                    'nama'      => $nama,
                    'harga'     => $harga,
                    'jumlah'    => $jumlah,
                    'penjual'   => session('email'),
                    'keterangan'=> $keterangan
                ]);
                flash('berhasil menambah barang');
                return redirect()->route('dasbor-penjual');
            }
        }
        else
        {
            flash('terjadi kesalahan');
            return redirect()->route('dasbor-penjual');
        }
    }
}

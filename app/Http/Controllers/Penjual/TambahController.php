<?php

namespace App\Http\Controllers\Penjual;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use File;
use Validator;

use App\Barang;
class TambahController extends Controller
{
    public function index()
    {
        $barang = Barang::where('penjual', session('email'))->get();
        return view('penjual.tambah',[
            'data_barang'   => $barang
        ]);
    }
    //hapus special character dan ubah spasi menjadi underscore
    protected function clean($string) {
        $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     
        return preg_replace('/-+/', '_', $string); // Replaces multiple hyphens with single one.
     }
    public function formtambah(Request $req)
    {
        $validasi = Validator::make($req->all(),[
            'nama'          => 'required|max:30',
            'harga'         => 'required|numeric|digits_between:1,10',
            'jumlah'        => 'required|numeric|digits_between:1,10',
            'keterangan'    => 'required|max:10000'
        ]);
        if($validasi->fails())
        {
            flash('data tidak sesuai format');
        }
        else
        {
            if($req->input('data-gambar') != null)
            {
                //encode gambar menjadi base64
                $getgambar  = $req->input('data-gambar');
                $explode    = explode(',', $getgambar);
                $nama       = $req->input('nama');
                $harga      = $req->input('harga');
                $jumlah     = $req->input('jumlah');
                $keterangan = $req->input('keterangan');
                //mendecode string gambar yang diperoleh
                $gambar     = base64_decode($explode[1]);
                //nama barang sekaligus menjadi id
                $id     = date("ymdhis").str_random(7).'-'.$this->clean($nama);
                //lokasi gambar
                $lokasibarang   = public_path().'/img/barangdagang/'.$id.'.png';
                //menyimpan file kedalam folder public/img/user
                File::put($lokasibarang, $gambar);
                Barang::create([
                    'id'        => $id,
                    'nama'      => $nama,
                    'harga'     => $harga,
                    'jumlah'    => $jumlah,
                    'penjual'   => session('email'),
                    'keterangan'=> $keterangan
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

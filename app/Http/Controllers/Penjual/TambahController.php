<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use File;
use Validator;

use App\Models\Barang;
use App\Models\Pengguna;

class TambahController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::where('email', session('email'))->get();

        /**
         * unable to create new product record before user profile completed
         * force account return to form to complete the data first
         */
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
            // $barang = Barang::where('penjual', session('email'))->get();
            return view('penjual.tambah');
        }
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
            'berat'         => 'required|numeric|digits_between:1,10',
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
                $nama       = $req->input('nama');
                $harga      = $req->input('harga');
                $jumlah     = $req->input('jumlah');
                $berat      = $req->input('berat');
                $keterangan = $req->input('keterangan');

                /**
                 * prosesor gambar di sini
                 */
                //encode gambar menjadi base64
                $getgambar  = $req->input('data-gambar');
                $explode    = explode(',', $getgambar);
                //mendecode string gambar yang diperoleh
                $gambar     = base64_decode($explode[1]);
                //nama barang sekaligus menjadi id
                $id     = date("ymdhis").Str::random(7).'-'.$this->clean($nama);
                //lokasi gambar
                $lokasibarang   = public_path().'/img/barangdagang/'.$id.'.png';
                //menyimpan file kedalam folder public/img/user
                File::put($lokasibarang, $gambar);
                Barang::create([
                    'id'        => $id,
                    'nama'      => $nama,
                    'harga'     => $harga,
                    'jumlah'    => $jumlah,
                    'berat'     => $berat,
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

<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class TambahController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (is_null($user->telepon) || is_null($user->alamat) || is_null($user->kota) || is_null($user->provinsi)) {
            flash('data akun belum lengkap')->error()->important();
            return redirect()->route('penjual-profil');
        }

        return view('penjual.tambah');
    }

    protected function clean($string)
    {
        $string = str_replace(' ', '_', $string);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        return preg_replace('/-+/', '_', $string);
    }

    public function formtambah(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nama'       => 'required|max:30',
            'harga'      => 'required|numeric|digits_between:1,10',
            'jumlah'     => 'required|numeric|digits_between:1,10',
            'berat'      => 'required|numeric|digits_between:1,10',
            'keterangan' => 'required|max:10000',
            'data-gambar'=> 'required',
        ]);

        if ($validator->fails()) {
            flash('Data tidak sesuai format atau gambar belum diunggah.')->error();
            return redirect()->route('penjual-tambah')->withErrors($validator)->withInput();
        }

        $nama = $req->input('nama');
        $id = date("ymdhis") . Str::random(7) . '-' . $this->clean($nama);

        $getgambar = $req->input('data-gambar');
        $explode = explode(',', $getgambar);
        $gambar = base64_decode($explode[1]);
        $lokasibarang = public_path('img/barangdagang/' . $id . '.png');
        File::put($lokasibarang, $gambar);

        Product::create([
            'id'         => $id,
            'user_id'    => Auth::id(),
            'nama'       => $nama,
            'harga'      => $req->input('harga'),
            'jumlah'     => $req->input('jumlah'),
            'berat'      => $req->input('berat'),
            'keterangan' => $req->input('keterangan'),
        ]);

        flash('berhasil menambah barang')->success();
        return redirect()->route('penjual-tambah');
    }
}

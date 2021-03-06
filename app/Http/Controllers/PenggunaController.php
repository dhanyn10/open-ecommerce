<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

use App\Pengguna;

class PenggunaController extends Controller
{

    public function profil(Request $req)
    {
        $validasi = Validator::make($req->all(),[
            'email'     => 'required|email|max:30',
            'nama'      => 'required|max:20',
            'telepon'   => 'required|numeric|digits_between:11,12',
            'alamat'    => 'required|max:255',
            'sandi'     => 'max:20'
        ]);

        if($validasi->fails())
        {
            flash('data tidak sesuai dengan format');
            if(session('peran') == 2)
            {
                return redirect()->route('akun-penjual');
            }
            else if(session('peran') == 3)
            {
                return redirect()->route('dasbor-pembeli');
            }
        }
        else
        {
            $data['email']  = $req->input('email');
            $data['nama']   = $req->input('nama');
            $telepon        = $req->input('telepon');
            $alamat         = $req->input('alamat');
            $sandi          = $req->input('sandi');
            $data['token']  = $data['email'].str_random(10);
            //inisiasi nilai konfirmasi 1(pengguna terkonfirmasi)
            $konfirmasi     = 1;

            $pengguna       = Pengguna::where('email', session('email'));
            $data_pengguna  = $pengguna->get();
            $data_email     = $data_pengguna->pluck('email')->first();
            $data_token     = $data_pengguna->pluck('token')->first();
            $data_sandi     = $data_pengguna->pluck('sandi')->first();

            //jika email berbeda dengan database, berarti email telah diperbarui
            if($data_email != $data['email'])
            {
                //ubah nilai konfirmasi menjadi 0, sehingga pengguna perlu melakukan konfirmasi ulang
                $konfirmasi = 0;
                //tambah sesi konfirmasi dengan nilai 0
                session([
                    'email'         => $data['email'],
                    'konfirmasi' => 0
                ]);
            }
            //jika email tidak berbeda dengan di database
            if($data_email == $data['email'])
            {
                //kembalikan nilai token seperti di database
                $data['token'] = $data_token;
            }
            if($sandi == null)
            {
                $sandi = $data_sandi;
            }
            $pengguna->update([
                'email'         => $data['email'],
                'nama'          => $data['nama'],
                'telepon'       => $telepon,
                'alamat'        => $alamat,
                'sandi'         => Hash::make($sandi),
                'konfirmasi'    => $konfirmasi,
                'token'         => $data['token']
            ]);
            flash('berhasil memperbarui data');
            if(session('peran') == 2)
            {
                return redirect()->route('akun-penjual');
            }
            else if(session('peran') == 3)
            {
                return redirect()->route('pembeli-profil');
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Pengguna;
use Validator;
use Mail;

class MasukController extends Controller
{
    protected function connect()
    {
        try
        {
            DB::connection()->getPdo();
        }
        catch(\PDOException $e)
        {
            return "koneksi database gagal";
        }
    }
    public function index()
    {
        if(!(session()->has('email')))
        {
            return view('masuk');
        }
        else
        {
            return redirect()->route('beranda');
        }
    }
    public function masuk(Request $req)
    {
        if($this->connect() == "koneksi database gagal")
        {
            flash('koneksi database gagal')->error();
            return redirect()->route('masuk');
        }
        //jika pengisian form valid
        else
        {
            $email  = $req->input('email');
            $sandi  = $req->input('sandi');
            
            //mengambil data dari tabel pengguna
            $data = Pengguna::where('email', $email)->get();
            //jika tidak ditemukan pengguna dengan data email
            if(count($data) == 0)
            {
                flash('Email belum terdaftar');
                return redirect()->route('masuk');
            }
            //jika ditemukan pengguna dengan email
            else
            {
                //jika pengguna belum melakukan konfirmasi email
                if($data->pluck('konfirmasi')->first() === "0")
                {
                    flash('konfirmasi email dulu <a href="/form_konfirmasi">form konfirmasi</a>')->error();
                    return redirect()->route('masuk');
                }
                //jika pengguna sudah melakukan konfirmasi email
                else
                {
                    //mengambil data di database
                    $data_nama  = $data->pluck('nama')->first();
                    $data_email = $data->pluck('email')->first();
                    $data_peran = $data->pluck('peran')->first();
                    $data_sandi = $data->pluck('sandi')->first();
                    
                    //cek apakah sandi yang dimasukkan sesuai dengan sandi di database
                    if($sandi == $data_sandi)
                    {
                        //jika sandi cocok, buat sesi dengan menggunakan data nama dan email
                        session([
                            'nama'      => $data_nama,
                            'email'     => $data_email,
                            'peran'     => $data_peran
                        ]);
                        else if(session("peran") == 2)
                        {
                            //mengalihkan halaman ke tambah barang penjual
                            return redirect()->route('penjual-tambah');
                        }
                        else if(session('peran') == 3)
                        {
                            //mengalihkan halaman ke beranda
                            return redirect()->route('beranda');
                        }   
                    }
                    else
                    {
                        flash("sandi tidak cocok <a href='reset_sandi'>reset sandi</a>")->error();
                        return redirect()->route('masuk');
                    }
                }
            }
        }
    }
    public function resetsandi()
    {
        if($this->connect() == "koneksi database gagal")
        {
            flash('terdapat masalah koneksi database');
            return view('resetsandi');
        }
        else
        {
            return view('resetsandi');
        }
    }
    public function formresetsandi(Request $req)
    {
        $validasi = Validator::make($req->all(),[
            'email' => 'required|email|max:30'
        ]);

        if($validasi->fails())
        {
            flash('pengisian formulir tidak valid');
            return redirect()->route('reset-sandi');
        }
        else
        {
            $data['email']  = $req->input('email');
            $pengguna       = Pengguna::where('email', $data['email']);
            if(count($pengguna->get())> 0)
            {
                $data['nama']   = $pengguna->get()->pluck('nama')->first();
                $data['sandi']  = str_random(20);
                try{
                    Pengguna::where('email', $data['email'])->update([
                        'sandi' => $data['sandi']
                        ]);
                    Mail::send('emailresetsandi', $data, function($pesan) use ($data){
                        $pesan->to($data['email']);
                        $pesan->subject('Reset Kata Sandi');
                    });
                    flash('berhasil reset kata sandi')->success();
                    return redirect()->route('masuk');
                }
                catch(Exception $e)
                {
                    flash('cek email kamu untuk melihat kata sandi baru')->error();
                    return redirect()->route('reset-sandi');
                }
            }
            else
            {
                flash('pengguna belum terdaftar')->error();
                return redirect()->route('reset-sandi');
            }
        }
    }
}
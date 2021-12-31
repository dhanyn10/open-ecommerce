<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Pengguna;
use Validator;
use Mail;

class DaftarController extends Controller
{
    public function index()
    {
        if(!(session()->has('email')))
        {
            return view('daftar');
        }
        else
        {
            return redirect()->route('beranda');
        }
    }
    public function formulirkonfirmasi()
    {
        return view('formkonfirmasi');
    }
    protected function connect()
    {
        try
        {
            DB::connection()->getPdo();
        }
        catch(\PDOException $e)
        {
            return "gagal";
        }
    }
    public function daftar(Request $req)
    {
        if($this->connect() == "gagal")
        {
            flash('koneksi database gagal')->error();
            return redirect()->route('daftar');
        }
        else
        {
            $valid = Validator::make($req->all(),[
                'nama'  => 'required|max:20',
                'email' => 'required|email|max:30',
                'peran' => 'required|in:2,3',
                'sandi' => 'required|max:20'
            ]);
            if($valid->fails())
            {
                flash('pengisian form belum benar')->error();
                return redirect()->route('daftar');
            }
            else
            {
                $data['email']  = $req->input('email');
                $pengguna      = Pengguna::where('email', $data['email'])->get();
                if(count($pengguna) != 0)
                {
                    flash("pengguna telah terdaftar<br/><a href='form_konfirmasi'>kirim ulang email konfirmasi</a>");
                    return redirect()->route("daftar");
                }
                
                $data['token']  = $data['email'].Str::random(10);
                $data['nama']   = $req->input('nama');
                try{
                    
                    Mail::send('konfirmasi', $data, function($pesan) use ($data){
                        $pesan->to($data['email'])->subject('Konfirmasi Pendaftaran');
                    });
                    Pengguna::create([
                        'email'         => $data['email'],
                        'nama'          => $data['nama'],
                        'sandi'         => $req->input('sandi'),
                        'peran'         => $req->input('peran'),
                        'konfirmasi'    => 0,
                        'token'         => $data['token']
                    ]);
                    flash('Email konfirmasi terkirim, Segera cek email kamu<br/><a href="form_konfirmasi">Kirim ulang email</a>');
                    return redirect()->route('masuk');
                }
                catch(Exception $e)
                {
                    flash('gagal mengirim email konfirmasi');
                    return redirect()->route('daftar');
                }
            }
        }
    }
    public function konfirmasi($token)
    {
        $pengguna   = Pengguna::where('token', $token)->first();
        if(!is_null($pengguna))
        {
            if($pengguna->konfirmasi == 0)
            {
                $pengguna->konfirmasi = 1;
                $pengguna->save();
                if(session()->has('konfirmasi'))
                {
                    session()->forget('konfirmasi');
                }
                flash('aktivasi berhasil, silahkan masuk');
            }
            else if($pengguna->konfirmasi == 1)
            {
                flash('akun sudah aktif');
            }
            return redirect()->route('masuk');
        }
        else
        {
            flash('token konfirmasi tidak benar <a href="/form_konfirmasi">kirim ulang konfirmasi</a>');
            return redirect()->route('masuk');
        }
    }
    public function data_konfirmasi(Request $req)
    {
        $validasi = Validator::make($req->all(),[
            'email' => 'required|email|max:30'
        ]);
        
        if($validasi->fails())
        {
            flash('Cek kembali pengisian email')->error();
            return redirect()->route('formkonfirmasi');
        }
        else
        {
            $data['email']  = $req->input('email');
            $cekdata = Pengguna::where('email', $data['email'])->get();
            if(count($cekdata) == null)
            {
                flash("email tidak terdaftar")->error();
                return redirect()->route('formkonfirmasi');
            }
            else
            {
                try{
                    $data['token']  = $data['email'].Str::random(10);
                    $data['email']  = $req->input('email');
                    
                    $pengguna       = Pengguna::where('email', $data['email']);
                    $data['nama']   = $pengguna->get()->pluck('nama')->first();
                    $pengguna->update([
                        'token' => $data['token']
                    ]);
                    
                    Mail::send('konfirmasi', $data, function($pesan) use ($data){
                        $pesan->to($data['email'])->subject('Konfirmasi Pendaftaran');
                    });
                    flash('Email konfirmasi terkirim, Segera cek email kamu');
                    return redirect()->route('formkonfirmasi');
                }
                catch(Exception $e)
                {
                    flash('gagal mengirim email konfirmasi');
                    return redirect()->route('formkonfirmasi');
                }
            }
        }
    }
}

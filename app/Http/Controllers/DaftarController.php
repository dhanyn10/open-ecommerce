<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DaftarController extends Controller
{
    public function index()
    {
        return view('daftar');
    }

    public function formulirkonfirmasi()
    {
        return view('formkonfirmasi');
    }

    public function daftar(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nama'  => 'required|max:20',
            'email' => 'required|email|unique:users,email|max:30',
            'peran' => 'required|in:2,3',
            'sandi' => 'required|max:20'
        ]);

        if ($validator->fails()) {
            return redirect()->route('daftar')->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $token = Str::random(20);

        try {
            $user = User::create([
                'email' => $data['email'],
                'nama' => $data['nama'],
                'password' => Hash::make($data['sandi']),
                'peran' => $data['peran'],
                'konfirmasi' => 0,
                'token' => $token,
            ]);

            Mail::send('konfirmasi', ['token' => $token, 'nama' => $data['nama']], function ($pesan) use ($data) {
                $pesan->to($data['email'])->subject('Konfirmasi Pendaftaran');
            });

            flash('Email konfirmasi terkirim, Segera cek email kamu.')->success();
            return redirect()->route('masuk');
        } catch (\Exception $e) {
            flash('Gagal mengirim email konfirmasi. Silakan coba lagi.')->error();
            return redirect()->route('daftar');
        }
    }

    public function konfirmasi($token)
    {
        $user = User::where('token', $token)->first();

        if ($user) {
            if ($user->konfirmasi == 0) {
                $user->konfirmasi = 1;
                $user->token = null; // Clear the token after confirmation
                $user->save();
                flash('Aktivasi berhasil, silahkan masuk.')->success();
            } else {
                flash('Akun sudah aktif.')->info();
            }
        } else {
            flash('Token konfirmasi tidak benar.')->error();
        }

        return redirect()->route('masuk');
    }

    public function data_konfirmasi(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email|exists:users,email|max:30'
        ]);

        if ($validator->fails()) {
            return redirect()->route('formkonfirmasi')->withErrors($validator)->withInput();
        }

        $user = User::where('email', $req->input('email'))->first();
        $token = Str::random(20);
        $user->token = $token;
        $user->save();

        try {
            Mail::send('konfirmasi', ['token' => $token, 'nama' => $user->nama], function ($pesan) use ($user) {
                $pesan->to($user->email)->subject('Konfirmasi Pendaftaran');
            });

            flash('Email konfirmasi terkirim, Segera cek email kamu.')->success();
        } catch (\Exception $e) {
            flash('Gagal mengirim email konfirmasi.')->error();
        }

        return redirect()->route('formkonfirmasi');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MasukController extends Controller
{
    public function index()
    {
        return view('masuk');
    }

    public function masuk(Request $req)
    {
        $credentials = $req->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            flash('Email belum terdaftar')->error();
            return redirect()->route('masuk');
        }

        if ($user->konfirmasi == 0) {
            flash('Silakan konfirmasi email Anda terlebih dahulu. <a href="/form_konfirmasi">Kirim ulang email konfirmasi</a>')->error();
            return redirect()->route('masuk');
        }

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $req->session()->regenerate();
            
            $peran = Auth::user()->peran;
            if ($peran == 1) {
                return redirect()->route('admin-dasbor');
            } elseif ($peran == 2) {
                return redirect()->route('penjual-lihat');
            } else {
                return redirect()->route('beranda');
            }
        }

        flash('Email atau kata sandi salah.')->error();
        return redirect()->route('masuk');
    }

    public function resetsandi()
    {
        return view('resetsandi');
    }

    public function formresetsandi(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return redirect()->route('reset-sandi')->withErrors($validator)->withInput();
        }

        $user = User::where('email', $req->input('email'))->first();
        $newPassword = Str::random(10);
        $user->password = $newPassword;
        $user->save();

        try {
            Mail::send('emailresetsandi', ['sandi' => $newPassword], function ($pesan) use ($user) {
                $pesan->to($user->email)->subject('Reset Kata Sandi');
            });

            flash('Kata sandi baru telah dikirim ke email Anda.')->success();
        } catch (\Exception $e) {
            flash('Gagal mengirim email reset kata sandi.')->error();
        }

        return redirect()->route('masuk');
    }
}

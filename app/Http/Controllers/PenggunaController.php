<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PenggunaController extends Controller
{
    public function profil(Request $req)
    {
        $validatedData = $req->validate([
            'email'     => 'required|email|max:30',
            'nama'      => 'required|string|max:20',
            'telepon'   => 'required|digits_between:8,15',
            'alamat'    => 'required|string|max:255',
            'kota'      => 'required|string|max:255',
            'provinsi'  => 'required|string|max:255',
            'password'  => 'nullable|string|max:30'
        ]);

        $user = Auth::user();

        // Handle email change and re-confirmation
        if ($user->email !== $validatedData['email']) {
            $user->konfirmasi = 0;
            $user->token = $validatedData['email'] . Str::random(10);
            session(['konfirmasi' => 0]);
        }

        $user->email = $validatedData['email'];
        $user->nama = $validatedData['nama'];
        $user->telepon = $validatedData['telepon'];
        $user->alamat = $validatedData['alamat'];
        $user->kota = $validatedData['kota'];
        $user->provinsi = $validatedData['provinsi'];

        // Only update password if a new one is provided
        if (!empty($validatedData['password'])) {
            $user->password = $validatedData['password'];
        }

        $user->save();

        // Update session email if it has changed
        if ($user->email !== session('email')) {
            session(['email' => $user->email]);
        }

        flash('Berhasil memperbarui data')->success();

        if ($user->peran == 2) {
            return redirect()->route('penjual-profil');
        } else {
            return redirect()->route('pembeli-profil');
        }
    }
}

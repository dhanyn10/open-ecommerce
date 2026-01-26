<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Pengguna;

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
            'sandi'     => 'nullable|string|max:30'
        ]);

        $pengguna = Pengguna::where('email', session('email'))->firstOrFail();

        // Handle email change and re-confirmation
        $konfirmasi = $pengguna->konfirmasi;
        $token = $pengguna->token;
        if ($pengguna->email !== $validatedData['email']) {
            $konfirmasi = 0;
            $token = $validatedData['email'] . Str::random(10);
            session(['konfirmasi' => 0]);
        }

        // Prepare data for update
        $updateData = [
            'email' => $validatedData['email'],
            'nama' => $validatedData['nama'],
            'telepon' => $validatedData['telepon'],
            'alamat' => $validatedData['alamat'],
            'kota' => $validatedData['kota'],
            'provinsi' => $validatedData['provinsi'],
            'konfirmasi' => $konfirmasi,
            'token' => $token,
        ];

        // Only update password if a new one is provided
        if (!empty($validatedData['sandi'])) {
            $updateData['sandi'] = $validatedData['sandi'];
        }

        $pengguna->update($updateData);

        // Update session email if it has changed
        if ($pengguna->email !== session('email')) {
            session(['email' => $pengguna->email]);
        }

        flash('Berhasil memperbarui data')->success();

        if (session('peran') == 2) {
            return redirect()->route('penjual-profil');
        } else {
            return redirect()->route('pembeli-profil');
        }
    }
}

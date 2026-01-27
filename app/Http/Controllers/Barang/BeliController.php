<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Pengguna;
use App\Http\Controllers\RajaOngkir;

class BeliController extends Controller
{    
    public function beli()
    {
        $user = Pengguna::with('pembelian.barangData')->find(session('id'));
        $pembelian = $user ? $user->pembelian : collect();

        foreach($pembelian as $item)
        {
            $barang = $item->barangData;
            $item->harga = $barang ? $barang->harga : 0;
        }

        $totalbelanja = 0;
        foreach($pembelian as $item)
        {
            $totalbelanja += $item->harga * $item->jumlah;
        }

        return view('barang.beli',[
            'data_pembelian'    => $pembelian,
            'total_belanja'     => $totalbelanja
        ]);
    }

    public function troliPlus($id)
    {
        $barang = Barang::find($id);
        if($barang)
        {
            $user = Pengguna::find(session('id'));

            // Check if item already in cart for this user
            $cek_beli = $user->pembelian()->where('idbarang', $id)->first();

            if($cek_beli) // Item exists in cart
            {
                $batasjml = $barang->jumlah;
                $jml_dibeli = Pembelian::where('idbarang', $id)->sum('jumlah');
                $sisabarang = $batasjml - $jml_dibeli;

                if($sisabarang > 0)
                {
                    $cek_beli->increment('jumlah');
                }
            }
            else // New item for cart
            {
                $id_beli = date("ymdhis").Str::random(7).'-'.str_replace(' ','-',$barang->nama);
                $user->pembelian()->create([
                    'id'            => $id_beli,
                    'waktu'         => date('y-m-d-h-i-s'),
                    'jumlah'        => 1,
                    'idbarang'      => $id,
                    'nama_barang'   => $barang->nama,
                ]);
            }
            
            return redirect()->route('data-belanja');
        }
        else
        {
            flash('barang tidak ditemukan')->error();
            return redirect()->route('beranda');
        }
    }

    public function troliDelete($id)
    {
        $user = Pengguna::find(session('id'));
        if ($user) {
            $user->pembelian()->where('idbarang', $id)->delete();
            flash('berhasil menghapus barang dari troli');
        }
        return redirect()->route('data-belanja');
    }

    public function troliMinus($id)
    {
        $user = Pengguna::find(session('id'));
        if ($user) {
            $cek_beli = $user->pembelian()->where('idbarang', $id)->first();

            if($cek_beli && $cek_beli->jumlah > 1)
            {
                $cek_beli->decrement('jumlah');
            }
        }

        return redirect()->route('data-belanja');
    }

    public function bayar()
    {
        $user = Pengguna::with('pembelian.barangData.pengguna')->find(session('id'));
        if (!$user) {
            flash('Silahkan login dulu')->error();
            return redirect()->route('masuk');
        }

        $pembelian = $user->pembelian;

        if ($pembelian->isEmpty()) {
            flash('Troli kosong')->error();
            return redirect()->route('beranda');
        }

        // Get shipping origin from the first seller in the cart
        $firstItem = $pembelian->first();
        $firstBarang = $firstItem ? $firstItem->barangData : null;

        if (!$firstBarang) {
            flash('Barang tidak ditemukan atau sudah tidak tersedia')->error();
            return redirect()->route('beranda');
        }

        $idkotaAsal = $firstBarang->pengguna ? $firstBarang->pengguna->kota : null;
        $idkotaTujuan = $user->kota;

        if ($idkotaAsal) {
            $idkotaAsal = explode('-', $idkotaAsal)[0];
        }
        if ($idkotaTujuan) {
            $idkotaTujuan = explode('-', $idkotaTujuan)[0];
        }

        $totalharga = 0;
        $totalBerat = 0;
        foreach($pembelian as $item)
        {
            $barang = $item->barangData;
            if ($barang) {
                $totalharga += $item->jumlah * $barang->harga;
                $totalBerat += $item->jumlah * $barang->berat;
            }
        }

        $ongkir = RajaOngkir::costRajaOngkir($idkotaAsal, $idkotaTujuan, $totalBerat*1000);

        return view('barang.bayar',[
            'totalharga' => $totalharga,
            'ongkir' => $ongkir
        ]);
    }
}

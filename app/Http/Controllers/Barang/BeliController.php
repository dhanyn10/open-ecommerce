<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\Pembelian;
use App\Models\Pengguna;
use App\Http\Controllers\RajaOngkir;

class BeliController extends Controller
{    
    public function beli()
    {
        $user = Pengguna::with('pembelian.product')->find(session('id'));
        $pembelian = $user ? $user->pembelian : collect();

        foreach($pembelian as $item)
        {
            $product = $item->product;
            $item->harga = $product ? $product->price : 0;
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
        $product = Product::find($id);
        if($product)
        {
            $user = Pengguna::find(session('id'));
            $cek_beli = $user->pembelian()->where('product_id', $id)->first();

            if($cek_beli)
            {
                if($product->current_stock > 0)
                {
                    $cek_beli->increment('jumlah');
                }
            }
            else
            {
                $id_beli = date("ymdhis").Str::random(7).'-'.str_replace(' ','-',$product->name);
                $user->pembelian()->create([
                    'id'            => $id_beli,
                    'waktu'         => date('y-m-d-h-i-s'),
                    'jumlah'        => 1,
                    'product_id'    => $id,
                    'product_name'  => $product->name,
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
            $user->pembelian()->where('product_id', $id)->delete();
            flash('berhasil menghapus barang dari troli');
        }
        return redirect()->route('data-belanja');
    }

    public function troliMinus($id)
    {
        $user = Pengguna::find(session('id'));
        if ($user) {
            $cek_beli = $user->pembelian()->where('product_id', $id)->first();

            if($cek_beli && $cek_beli->jumlah > 1)
            {
                $cek_beli->decrement('jumlah');
            }
        }

        return redirect()->route('data-belanja');
    }

    public function bayar()
    {
        $user = Pengguna::with('pembelian.product.pengguna')->find(session('id'));
        if (!$user) {
            flash('Silahkan login dulu')->error();
            return redirect()->route('masuk');
        }

        $pembelian = $user->pembelian;

        if ($pembelian->isEmpty()) {
            flash('Troli kosong')->error();
            return redirect()->route('beranda');
        }

        $firstItem = $pembelian->first();
        $firstProduct = $firstItem ? $firstItem->product : null;

        if (!$firstProduct) {
            flash('Barang tidak ditemukan atau sudah tidak tersedia')->error();
            return redirect()->route('beranda');
        }

        $idkotaAsal = $firstProduct->pengguna ? $firstProduct->pengguna->kota : null;
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
            $product = $item->product;
            if ($product) {
                $totalharga += $item->jumlah * $product->price;
                $totalBerat += $item->jumlah * $product->weight;
            }
        }

        $ongkir = RajaOngkir::costRajaOngkir($idkotaAsal, $idkotaTujuan, $totalBerat*1000);

        return view('barang.bayar',[
            'totalharga' => $totalharga,
            'ongkir' => $ongkir
        ]);
    }
}

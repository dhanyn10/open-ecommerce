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
        $pembelian  = Pembelian::where('pembeli', session('email'))->get();
        $nomor      = 0;
        foreach($pembelian as $data)
        {
            $idbarang   = $pembelian[$nomor]['idbarang'];
            $barang     = Barang::where('id', $idbarang)->get();
            $harga      = $barang->pluck('harga')->first();
            $pembelian[$nomor]['harga'] = $harga;
            $nomor++;
        }

        $totalbelanja = 0;
        $nomor = 0;
        foreach($pembelian as $data)
        {
            $totalbelanja += $pembelian[$nomor]['harga'] * $pembelian[$nomor]['jumlah'];
            $nomor++;
        }
        return view('barang.beli',[
            'data_pembelian'    => $pembelian,
            'total_belanja'     => $totalbelanja
        ]);
    }
    public function troliPlus($id)
    {
        $barang = Barang::where('id', $id)->get();
        if(count($barang) > 0)
        {
            $pembeli    = Pembelian::where('pembeli', session('email'))->get();
            if(count($pembeli) > 0) //pembeli yang telah terdata di tabel pembelian
            {
                //mengambil data id barang berdasarkan data id pembeli
                $cek_beli = Pembelian::where('idbarang', $id)->where('pembeli', session('email'))->get();
                if(count($cek_beli)> 0) //pengkondisian jika barang yang sama sudah masuk dalam troli pembeli
                {
                    //mengambil data pembelian di tabel pembelian berdasarkan id barang yang diberikan melalui url
                    $data_beli      = Pembelian::where('idbarang', $id)->where('pembeli', session('email'))->get();

                    //mengambil data barang di tabel barang berdasarkan id barang yang diberikan melalui url
                    $data_barang    = Barang::where('id', $id)->get();
    
                    //mengambil jumlah barang yang tersedia untuk membatasi maks pembelian di tabel barang
                    $batasjml       = $data_barang->pluck('jumlah')->first();
    
                    //mengambil data jumlah barang yang dibeli di tabel pembelian
                    $jumlah_beli    = $data_beli->pluck('jumlah')->first();
                    
                    //jumlah barang yang tersisa
                    //data jumlah barang yang dibeli di tabel pembelian
                    $jumlahbarang   = Pembelian::where('idbarang', $id)->get();

                    $jml_dibeli     = 0;
                    for($a = 0; $a < count($jumlahbarang); $a++)
                    {
                        $jml_dibeli += $jumlahbarang[$a]['jumlah'];
                    }

                    $sisabarang     = $batasjml - $jml_dibeli;

                    //pemgkondisian jika jumlah beli masih belum melebihi batas stok
                    if($sisabarang > 0)
                    {
                        $jumlah_beli++;
                    }
                    //memperbarui jumlah barang yang dipesan berdasarkan nilai variabel jumlah_beli
                    Pembelian::where('idbarang', $id)
                    ->where('pembeli', session('email'))
                    ->update(['jumlah' => $jumlah_beli]);
                }
                else //pembeli terdata baru pertama kali membeli barang yang bersangkutan
                {
                    //ambil data barang dari tabel barang
                    $barang         = Barang::where('id', $id)->get();
                    //ambil nama barang
                    $nama_barang    = $barang->pluck('nama')->first();
                    //buat id pembelian
                    $id_beli        = date("ymdhis").Str::random(7).'-'.str_replace(' ','-',$nama_barang);
                    //buat database pembelian
                    Pembelian::create([
                        'id'        => $id_beli,
                        'waktu'     => date('y-m-d-h-i-s'),
                        'jumlah'    => 1,
                        'idbarang' => $id,
                        'barang'    => $nama_barang,
                        'pembeli'   => session('email')
                    ]);
                }
            }
            else //pembeli baru
            {
                //ambil data barang dari tabel barang
                $barang         = Barang::where('id', $id)->get();
                //ambil nama barang
                $nama_barang    = $barang->pluck('nama')->first();
                //buat id pembelian
                $id_beli        = date("ymdhis").Str::random(7).'-'.str_replace(' ','-',$nama_barang);
                //buat database pembelian
                Pembelian::create([
                    'id'        => $id_beli,
                    'waktu'     => date('y-m-d-h-i-s'),
                    'jumlah'    => 1,
                    'idbarang' => $id,
                    'barang'    => $nama_barang,
                    'pembeli'   => session('email')
                ]);
            }
            //memasukkan harga kedalam array untuk keperluan tabel hitungan pembayaran
            $pembelian  = Pembelian::where('pembeli', session('email'))->get();
            $nomor      = 0;
            foreach($pembelian as $data)
            {
                $idbarang   = $pembelian[$nomor]['idbarang'];
                $barang     = Barang::where('id', $idbarang)->get();
                $harga      = $barang->pluck('harga')->first();
                $pembelian[$nomor]['harga'] = $harga;
                $nomor++;
            }
            
            //menghitung total belanja
            $totalbelanja   = 0;
            $nomor          = 0;
            foreach($pembelian as $data)
            {
                $totalbelanja += $pembelian[$nomor]['harga'] * $pembelian[$nomor]['jumlah'];
                $nomor++;
            }
            return view('barang.beli',[
                'data_pembelian'    => $pembelian,
                'total_belanja'     => $totalbelanja
            ]);
        }
        else
        {
            flash('barang tidak ditemukan')->error();
            return redirect()->route('beranda');
        }
    }
    public function troliDelete($id)
    {
        
        //menghapus belanja barang
        Pembelian::where('idbarang', $id)->delete();
        flash('berhasil menghapus barang dari troli');
        return redirect()->route('data-belanja');
    }
    public function troliMinus($id)
    {
        //mengambil data belanja di tabel pembelian
        $data_beli  = Pembelian::where('idbarang', $id)->get();
        //mengambil data jumlah barang yang dibeli
        $jumlah_beli = $data_beli->pluck('jumlah')->first();
        if($jumlah_beli > 1)
        {
            $jumlah_beli--;
        }
        //memperbarui jumlah barang yang dipesan berdasarkan nilai variabel jumlah_beli
        Pembelian::where('idbarang', $id)
        ->where('pembeli', session('email'))
        ->update(['jumlah' => $jumlah_beli]);

        return redirect()->route('data-belanja');
    }
    public function bayar()
    {
        $pembeli  = Pembelian::where('pembeli', session('email'))->get();
        $idBarang = $pembeli->pluck('idbarang')->first();
        $barang = Barang::where('id', $idBarang)->get();
        $penjualBarang = $barang->pluck('penjual')->first();
        $kotaAsal = Pengguna::where('email', $penjualBarang)->get();
        $idkotaAsal = $kotaAsal->pluck('kota')->first();
        $kotaTujuan = Pengguna::where('email', session('email'))->get();
        $idkotaTujuan = $kotaTujuan->pluck('kota')->first();
        $totalharga = 0;
        $nomor      = 0;
        $totalBerat = 0;
        foreach($pembeli as $data)
        {
            $barang = Barang::where('id', $data->idbarang)->get();
            $harga  = $barang->pluck('harga')->first();
            $berat  = $barang->pluck('berat')->first();
            $totalharga += $pembeli[$nomor]['jumlah'] * $harga;
            $nomor++;
            $totalBerat += $berat;
        }

        $ongkir = RajaOngkir::costRajaOngkir($idkotaAsal, $idkotaTujuan, $totalBerat*1000); //return array costs
        return view('barang.bayar',[
            'totalharga' => $totalharga,
            'ongkir' => $ongkir
        ]);
    }
}

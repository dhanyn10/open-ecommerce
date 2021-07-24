<?php

namespace App\Http\Controllers\Barang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use App\Barang;
use App\Pembelian;
use App\Pengguna;
use App\Http\Controllers\Barang\RajaOngkir;

class BarangController extends Controller
{
    private function sisaBarang($id)
    {
        $barang         = Barang::where('id', $id)->get();
        $emailpenjual   = $barang->pluck('penjual')->first();
        $pengguna       = Pengguna::where('email', $emailpenjual)->get();
        $namapenjual    = $pengguna->pluck('nama')->first();

        //jumlah barang yang tersisa
        $data_barang    = Barang::where('id', $id)->get();
        $batasjml       = $data_barang->pluck('jumlah')->first();
        //data jumlah barang yang dibeli di tabel pembelian
        $jumlahbarang   = Pembelian::where('idbarang', $id)->get();

        $jml_dibeli     = 0;
        for($a = 0; $a < count($jumlahbarang); $a++)
        {
            $jml_dibeli += $jumlahbarang[$a]['jumlah'];
        }

        $sisabarang = $batasjml - $jml_dibeli;
        return array(
            'barang'        => $barang,
            'namapenjual'   => $namapenjual,
            'sisabarang'    => $sisabarang
        );
    }

    public function index(Request $req, $id)
    {
        $arrayBarang = $this->sisaBarang($id);
        $rajaongkir = RajaOngkir::getApi('https://api.rajaongkir.com/starter/province?key=8085b36e047138f8fd2a16309f73c5ad');
        $provinsi = $rajaongkir->results;
        $req->session()->forget([
            'dataKotaAsal',
            'dataKotaTujuan',
            'provAsal',
            'provTujuan',
            'kotaAsal',
            'kotaTujuan',
            'berat',
            'biaya'
        ]);
        session([
            'provinsi' => $provinsi
        ]);
        return view('barang.index', [
            'data_barang'   => $arrayBarang['barang'],
            'penjual'       => $arrayBarang['namapenjual'],
            'sisabarang'    => $arrayBarang['sisabarang'],
            'provinsi'      => session('provinsi')
        ]);
    }
    public function cekongkir(Request $req, $id)
    {
        $arrayBarang = $this->sisaBarang($id);
        $provAsal   = $req->input('provinsiAsal');
        $kotaAsal   = $req->input('kotaAsal');
        $provTujuan = $req->input('provinsiTujuan');
        $kotaTujuan = $req->input('kotaTujuan');
        $berat      = $req->input('berat');
        $biaya      = $req->input('biaya');
        $dataKotaAsal = RajaOngkir::getApi('https://api.rajaongkir.com/starter/city?key=8085b36e047138f8fd2a16309f73c5ad&province='.$provAsal);
        $dataKotaAsal = $dataKotaAsal->results;
        $dataKotaTujuan = RajaOngkir::getApi('https://api.rajaongkir.com/starter/city?key=8085b36e047138f8fd2a16309f73c5ad&province='.$provTujuan);
        $dataKotaTujuan = $dataKotaTujuan->results;

        $harga = null;
        if($kotaAsal > 0 && $kotaTujuan > 0)
        {
            $harga = RajaOngkir::costRajaOngkir($kotaAsal, $kotaTujuan, $berat*1000); //return array cots
        }
        session([
            'dataKotaAsal'  => $dataKotaAsal,
            'dataKotaTujuan' => $dataKotaTujuan,
            'provAsal'      => $provAsal,
            'kotaAsal'      => $kotaAsal,
            'provTujuan'    => $provTujuan,
            'kotaTujuan'    => $kotaTujuan,
            'berat'         => $berat,
            'biaya'         => $biaya
        ]);
        return view('barang.index', [
            'data_barang'   => $arrayBarang['barang'],
            'penjual'       => $arrayBarang['namapenjual'],
            'sisabarang'    => $arrayBarang['sisabarang'],
            'provinsi'      => session('provinsi'),
            'provAsal'      => session('provAsal'),
            'dataKotaAsal'  => session('dataKotaAsal'),
            'dataKotaTujuan'  => session('dataKotaTujuan'),
            'kotaAsal'      => session('kotaAsal'),
            'provTujuan'    => session('provTujuan'),
            'kotaTujuan'    => session('kotaTujuan'),
            'harga'         => $harga
        ]);
    }
}

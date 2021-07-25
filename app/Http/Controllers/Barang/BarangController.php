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
        $rajaongkir = RajaOngkir::getApi('https://api.rajaongkir.com/starter/province?key='.env('RAJAONGKIR_API_KEY'));
        if($rajaongkir != null)
            $dataProvinsi = $rajaongkir->results;
        else
            $dataProvinsi = null;
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
            'provinsi' => $dataProvinsi
        ]);
        return view('barang.index', [
            'data_barang'   => $arrayBarang['barang'],
            'penjual'       => $arrayBarang['namapenjual'],
            'sisabarang'    => $arrayBarang['sisabarang'],
            'dataProvinsi'  => $dataProvinsi
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
        $roProvAsal = RajaOngkir::getApi('https://api.rajaongkir.com/starter/city?key='.env('RAJAONGKIR_API_KEY').'&province='.$provAsal);
        if($roProvAsal != null)
            $dataKotaAsal = $roProvAsal->results;
        else
            $dataKotaAsal = null;
        $roProvTujuan = RajaOngkir::getApi('https://api.rajaongkir.com/starter/city?key='.env('RAJAONGKIR_API_KEY').'&province='.$provTujuan);
        if($roProvTujuan != null)
            $dataKotaTujuan = $roProvTujuan->results;
        else
            $dataKotaTujuan = null;

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
            'dataProvinsi'  => session('provinsi'),
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

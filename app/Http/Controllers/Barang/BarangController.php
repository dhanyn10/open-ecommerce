<?php

namespace App\Http\Controllers\Barang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Barang;
use App\Pembelian;
use App\Pengguna;

use App\Http\Controllers\Barang\RajaOngkir;

class BarangController extends Controller
{
    public function index($id)
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

    private function costRajaOngkir($origin, $destination, $weight)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=".$origin."&destination=".$destination."&weight=".$weight."&courier=jne",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: 8085b36e047138f8fd2a16309f73c5ad"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        return "cURL Error #:" . $err;
        }
        else
        {
            $response_data = json_decode($response);
            $rajaongkir = $response_data->rajaongkir;
            $statusCode = $rajaongkir->status->code;
            if($statusCode == 200)
            {
                $results = $rajaongkir->results;
                $costs = $results[0]->costs;
                return $costs;
            }
            else
            {
                return null;
            }
        }
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
        $dataKotaAsal = $this->getApi('https://api.rajaongkir.com/starter/city?key=8085b36e047138f8fd2a16309f73c5ad&province='.$provAsal);
        $dataKotaAsal = $dataKotaAsal->results;
        $dataKotaTujuan = $this->getApi('https://api.rajaongkir.com/starter/city?key=8085b36e047138f8fd2a16309f73c5ad&province='.$provTujuan);
        $dataKotaTujuan = $dataKotaTujuan->results;

        $harga = null;
        if($kotaAsal > 0 && $kotaTujuan > 0)
            $harga = $this->costRajaOngkir($kotaAsal, $kotaTujuan, $berat*1000); //return array cots
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
            'data_barang'   => $barang,
            'penjual'       => $namapenjual,
            'sisabarang'   => $sisabarang
        ]);
    }
}

<?php
namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Barang;

use Validator;
use File;

class UbahController extends Controller
{
    public function index($id)
    {
        $barang = Barang::where('id', $id)->get();
        return view('penjual.ubah', [
            'barang'  => $barang
        ]);
    }
    public function formubah(Request $req)
    {
        $validasi = Validator::make($req->all(),[
            'nama'          => 'required|max:30',
            'harga'         => 'required|digits_between:1,10',
            'jumlah'        => 'required|max:10',
            'keterangan'    => 'required|max:1000'
        ]);
        if($validasi->fails())
        {
            flash('data tidak benar')->error();
        }
        else
        {
            //update tanpa gambar
            if($req->input('data-gambar') == null)
            {
                $id = $req->input('id');
                $update = Barang::where('id', $id)->update([
                    'nama'          => $req->input('nama'),
                    'harga'         => $req->input('harga'),
                    'jumlah'        => $req->input('jumlah'),
                    'keterangan'    => $req->input('keterangan')
                ]);
                if($update == 0)
                {
                    flash('gagal memperbarui data')->error();
                }
            }
            else
            {
                $id = $req->input('id');
                
                /**
                 * prosesor gambar di sini
                 */
                //encode gambar menjadi base64
                $getgambar  = $req->input('data-gambar');
                $explode    = explode(',', $getgambar);
                //mendecode string gambar yang diperoleh
                $gambar     = base64_decode($explode[1]);
                //lokasi gambar
                $lokasibarang   = public_path().'/img/barangdagang/'.$id.'.png';

                //cek ketersediaan file
                if(File::exists($lokasibarang))
                {
                    //hapus file lama
                    File::delete($lokasibarang);
                }
                //menaruh file gambar baru dengan nama yang sama
                File::put($lokasibarang, $gambar);

                $update = Barang::where('id', $id)->update([
                    'nama'          => $req->input('nama'),
                    'harga'         => $req->input('harga'),
                    'jumlah'        => $req->input('jumlah'),
                    'keterangan'    => $req->input('keterangan')
                ]);
                if($update == 0)
                {
                    flash('gagal memperbarui data')->error();
                }
            }
        }
        return redirect()->route('penjual-lihat');
    }
}
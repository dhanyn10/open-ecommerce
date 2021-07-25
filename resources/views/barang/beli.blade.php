@extends('tataletak')
@section('css')
<style>
.fotobarang{
    width:75px;
    height:75px;
}
</style>
@endsection
@section('konten')
<div class="container-fluid" style="margin-top:10px">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('beranda')}}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Troli</li>
            <li class="breadcrumb-item"><a href="{{route('bayar')}}">Pembayaran</a></li>
        </ol>
    </nav>
    <div class="card border-primary">
        <div class="card-body">
        @include('flash::message')
            @if(count($data_pembelian) > 0)
                <table class="table table-bordered">
                    <tr class="text-uppercase bg-primary text-white">
                        <th colspan="2">barang</th>
                        <th>harga satuan</th>
                        <th>jumlah</th>
                        <th>total</th>
                        <th colspan="3">Pilihan</th>
                    </tr>
                    @foreach($data_pembelian as $data)
                    <tr>
                        <td><img class="img-thumbnail rounded-circle fotobarang" src="{{URL::asset('img/barangdagang/'.$data->idbarang.'.png')}}"/></td>
                        <td>{{$data->barang}}</td>
                        <td style="direction:rtl">{{$data->harga}}</td>
                        <td class="text-center">{{$data->jumlah}}</td>
                        <td style="direction:rtl">{{$data->harga*$data->jumlah}}</td>
                        <td>
                            <a class="btn btn-block btn-outline-dark btn-sm text-uppercase" href="{{url('barang/hapus/'.$data->idbarang)}}">hapus</a>
                        </td>
                        <td>
                            <a class="btn btn-block btn-outline-dark btn-sm text-uppercase" href="{{url('barang/tambah/'.$data->idbarang)}}">+</a>
                        </td>
                        <td>
                            <a class="btn btn-block btn-outline-dark btn-sm text-uppercase" href="{{url('barang/kurang/'.$data->idbarang)}}">-</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="row">
                    <div class="col-md-4 ml-auto">
                        <div class="card">
                            <div class="card-header rounded-0 bg-primary text-white">
                                <div class="row">
                                    <div class="col-sm-6 text-uppercase">total belanja</div>
                                    <div class="col-sm-6" style="direction:rtl">{{$total_belanja}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <a href="{{route('bayar')}}" class="card-header rounded-0 bg-success text-white text-uppercase text-center">bayar</a>
                        </div>
                    </div>
                </div>
            @else
            <div class="alert alert-primary text-center">
                belum ada data pembelian barang
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@extends('tataletak')
@section('css')
<style>.fotobarang{width:75px;height:75px;}</style>
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
                        <td><a href="{{url('barang/'.$data->product_id)}}"><img class="img-thumbnail fotobarang" src="{{URL::asset('img/barangdagang/'.$data->product_id.'.png')}}"/></a></td>
                        <td>{{$data->product_name}}</td>
                        <td class="text-right">Rp {{ number_format($data->harga, 0, ',', '.') }}</td>
                        <td class="text-center">{{$data->jumlah}}</td>
                        <td class="text-right">Rp {{ number_format($data->harga*$data->jumlah, 0, ',', '.') }}</td>
                        <td><a class="btn btn-block btn-outline-dark btn-sm text-uppercase" href="{{url('barang/hapus/'.$data->product_id)}}">hapus</a></td>
                        <td><a class="btn btn-block btn-outline-dark btn-sm text-uppercase" href="{{url('barang/tambah/'.$data->product_id)}}">+</a></td>
                        <td><a class="btn btn-block btn-outline-dark btn-sm text-uppercase" href="{{url('barang/kurang/'.$data->product_id)}}">-</a></td>
                    </tr>
                    @endforeach
                </table>
                <div class="row">
                    <div class="col-md-4 ml-auto">
                        <div class="card">
                            <div class="card-header rounded-0 bg-primary text-white">
                                <div class="row">
                                    <div class="col-sm-6 text-uppercase">total belanja</div>
                                    <div class="col-sm-6 text-right">Rp {{ number_format($total_belanja, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <a href="{{route('bayar')}}" class="btn btn-success btn-block rounded-0 text-uppercase">bayar</a>
                        </div>
                    </div>
                </div>
            @else
            <div class="alert alert-primary text-center">belum ada data pembelian barang dalam troli</div>
            @endif
        </div>
    </div>
</div>
@endsection

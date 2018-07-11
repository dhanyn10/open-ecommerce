@extends('tataletak')
@section('konten')
<div class="container-fluid">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('beranda')}}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{route('data-belanja')}}">Troli</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-8">
            <div class="card border-primary">
                <div class="card-body">
                    <table class="table table-bordered text-uppercase">
                        <tr>
                            <th>keterangan</th>
                            <th>jumlah</th>
                        </tr>
                        <tr>
                            <td>total pembelian</td>
                            <td style="direction:rtl">{{$totalharga}}</td>
                        </tr>
                        <tr>
                            <td>biaya antar</td>
                            <td style="direction:rtl">10000</td>
                        </tr>
                        <tr>
                            <td>total tagihan</td>
                            <td style="direction:rtl">{{$totalharga + 10000}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white text-center">
                    Rekening Tujuan Transfer
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">Bank Mandiri</div>
                        <div class="col-sm-6">123456789</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
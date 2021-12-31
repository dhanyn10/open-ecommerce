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
                                <td>
                                    <input style="direction:rtl" type="number" name="" id="totalharga" class="form-control form-control-sm" value="{{$totalharga}}" disabled>
                                </td>
                            </tr>
                            <tr>
                                <td>biaya antar</td>
                                <td style="direction:rtl">
                                    <div class="form-group">
                                        @if (isset($ongkir) && $ongkir != null)
                                            <select name="ongkir" id="ongkir" class="form-control form-control-sm" onchange="totalHarga()">
                                            @foreach ($ongkir as $item)
                                                <option value="{{$item->cost[0]->value}}">[{{$item->service}}] {{$item->cost[0]->value}} (Etd: {{$item->cost[0]->etd}})</option>
                                            @endforeach
                                            </select>
                                        @else
                                            
                                        @endif
                                </td>
                            </tr>
                            <tr>
                                <td>total harga</td>
                                <td>
                                    <input style="direction:rtl" type="number" id="total-tagihan" class="form-control form-control-sm" disabled/>
                                </td>
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
    @section('js')
        <script>
            function totalHarga()
            {
                var harga = document.getElementById('totalharga').value
                var ongkir = document.getElementById('ongkir').value
                harga = parseInt(harga)
                ongkir = parseInt(ongkir)
                var tagihan = (harga + ongkir)
                document.getElementById('total-tagihan').value = tagihan
            }
            document.addEventListener('DOMContentLoaded', function () {
                totalHarga()
            })
        </script>
    @endsection
@endsection
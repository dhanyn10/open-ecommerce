@extends('tataletak')
@section('css')
@endsection
@section('konten')
<div class="container-fluid">
    <div class="row">
        @foreach($data_barang as $barang)
        <div class="col-md-3">
            <img class="img-thumbnail w-100" src="{{URL::asset('img/barangdagang/'.$barang->id.'.png')}}"/>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-uppercase">{{$barang->nama}}</h5>
                        </div>
                        <div class="col-md-6">
                            <strong class="text-danger float-right">Rp.{{$barang->harga}}</strong>
                        </div>
                    </div>
                    <strong>tersedia {{$sisabarang}} stok barang</strong>
                    <div class="row">
                        <div class="col-md-4 offset-md-8">
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="/barang/tambah/{{$barang->id}}" class="btn btn-block rounded-0 btn-danger text-uppercase text-white">beli</a>
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-block rounded-0 btn-outline-primary text-uppercase">wishlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="card">
                        <div class="card-header">Cek Ongkir</div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="row">
                                    {{ csrf_field() }}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Dari</label>
                                        </div>
                                        <div class="form-group">
                                            @if ($provUserPenjual != null)
                                            <input type="hidden" name="provinsiAsal" value="{{$provUserPenjual[0]}}">
                                            <input type="text" class="form-control form-control-sm" value="{{$provUserPenjual[1]}}" disabled>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            @if ($kotaUserPenjual != null)
                                                <input type="hidden" name="kotaAsal" value="{{$kotaUserPenjual[0]}}">
                                                <input type="text" class="form-control form-control-sm" value="{{$kotaUserPenjual[1]}}" disabled>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tujuan</label>
                                        </div>
                                        <div class="form-group">
                                            @if ($provUserPembeli != null)
                                            <input type="hidden" name="provinsiTujuan" value="{{$provUserPembeli[0]}}">
                                            <input type="text" class="form-control form-control-sm" value="{{$provUserPembeli[1]}}" disabled>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            @if ($kotaUserPembeli != null)
                                                <input type="hidden" name="kotaTujuan" value="{{$kotaUserPembeli[0]}}">
                                                <input type="text" class="form-control form-control-sm" value="{{$kotaUserPembeli[1]}}" disabled>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Berat</label>
                                        <div class="form-group">
                                            <input type="number" name="berat" id="" value="{{$berat}}" class="form-control form-control-sm" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Kurir(JNE)</label>
                                        <div class="form-group">
                                            @if (isset($harga) && $harga != null)
                                                <select name="harga" id="" class="form-control form-control-sm">
                                                @foreach ($harga as $item)
                                                    <option value="{{$item->service}}">[{{$item->service}}] {{$item->cost[0]->value}} (Etd: {{$item->cost[0]->etd}})</option>
                                                @endforeach
                                                </select>
                                            @else
                                                
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="enter-20"></div>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="tab-barang" role="tablist">
                    <li class="nav-item">
                        <a
                            class="nav-link active"
                            id="home-tab"
                            data-toggle="tab"
                            href="#detail"
                            role="tab"
                            aria-controls="detail"
                            aria-selected="true"
                        >
                            Deskripsi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="profile-tab"
                            data-toggle="tab"
                            href="#ulasan"
                            role="tab"
                            aria-controls="ulasan"
                            aria-selected="false"
                        >
                            Ulasan barang
                        </a>
                    </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card">
                                <div class="card-body">
                                    {!!$barang->keterangan!!}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="ulasan" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="card">
                                <div class="card-body">
                                    {!!$barang->keterangan!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-header">
                    Penjual
                </div>
                <div class="card-body">
                    {{$penjual}}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

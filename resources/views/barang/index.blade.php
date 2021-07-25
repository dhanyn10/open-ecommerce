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
                                            <select class="form-control form-control-sm" name="provinsiAsal" onchange="this.form.submit()">
                                                <option>Pilih</option>
                                                @if (isset($dataProvinsi))
                                                    @foreach ($dataProvinsi as $item)
                                                        @if (isset($provAsal) && $item->province_id == $provAsal)
                                                        <option value="{{$item->province_id}}" selected>{{$item->province}}</option>
                                                        @else
                                                        <option value="{{$item->province_id}}">{{$item->province}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control form-control-sm" name="kotaAsal" onchange="this.form.submit()">
                                                <option>Pilih</option>
                                                @if(isset($dataKotaAsal) && $dataKotaAsal != null)
                                                    @foreach ($dataKotaAsal as $item)
                                                        @if (isset($kotaAsal) && $item->city_id === $kotaAsal)
                                                        <option value="{{$item->city_id}}" selected>{{$item->type." ".$item->city_name}}</option>
                                                        @else
                                                        <option value="{{$item->city_id}}">{{$item->type." ".$item->city_name}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tujuan</label>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control form-control-sm" name="provinsiTujuan" onchange="this.form.submit()">
                                                <option>Pilih</option>
                                                @if (isset($dataProvinsi) && $dataProvinsi != null)
                                                    @foreach ($dataProvinsi as $item)
                                                        @if (isset($provTujuan) && $item->province_id == $provTujuan)
                                                        <option value="{{$item->province_id}}" selected>{{$item->province}}</option>
                                                        @else
                                                        <option value="{{$item->province_id}}">{{$item->province}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control form-control-sm" name="kotaTujuan" onchange="this.form.submit()">
                                                <option>Pilih</option>
                                                @if(isset($dataKotaTujuan) && $dataKotaTujuan != null)
                                                    @foreach ($dataKotaTujuan as $item)
                                                        @if (isset($kotaTujuan) && $item->city_id === $kotaTujuan)
                                                        <option value="{{$item->city_id}}" selected>{{$item->type." ".$item->city_name}}</option>
                                                        @else
                                                        <option value="{{$item->city_id}}">{{$item->type." ".$item->city_name}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Berat (Kg)</label>
                                        <div class="form-group">
                                            @if (session()->has('berat'))
                                                <input type="number" value="{{session('berat')}}" name="berat" id="" class="form-control form-control-sm" onchange="this.form.submit()">
                                            @else
                                                <input type="number" name="berat" id="" class="form-control form-control-sm" onchange="this.form.submit()">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Kurir (JNE)</label>
                                        @isset($harga)
                                            @if ($harga != null)
                                            <div class="form-group">
                                                <select class="form-control form-control-sm" name="biaya" onchange="this.form.submit()">
                                                    @foreach ($harga as $item)
                                                    <option value="{{$item->service}}">{{$item->service}} : {{$item->cost[0]->value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @else
                                            <div class="form-group">
                                                <label>gagal memperoleh data kurir</label>
                                            </div>
                                            @endif
                                        @endisset
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

@extends('tataletak')
@section('css')
<link href="{{URL::asset('css/barang/index.css')}}" rel="stylesheet"/>
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
                            <strong class="text-primary float-right">Rp.{{$barang->harga}}</strong>
                        </div>
                    </div>
                    <strong>tersedia {{$sisabarang}} stok barang</strong>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="/barang/beli/{{$barang->id}}" class="btn btn-sm btn-block rounded-0 btn-danger text-uppercase text-white">beli</a>
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-sm btn-block rounded-0 btn-outline-primary text-uppercase">bookmark</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="card">
                        <div class="card-body">
                            {!!$barang->keterangan!!}
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
                            Detail Barang
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
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                        In sed euismod diam. Curabitur tincidunt tortor pharetra lacus lobortis interdum. 
                        Aliquam vitae placerat nisi. Mauris pulvinar purus a dapibus sodales. 
                        Quisque ut massa eu nisl pharetra gravida. Ut iaculis, nisl ut malesuada congue, 
                        ligula nisi porta felis, volutpat volutpat quam risus sed nisl. 
                        Aenean et turpis in libero sagittis malesuada ac nec odio. 
                        Nam non sapien tincidunt, condimentum orci a, laoreet eros. 
                        Fusce fringilla, metus in rutrum interdum, nunc mauris venenatis tortor, 
                        nec interdum lorem orci eu tellus. Nulla facilisi. Donec maximus tortor vitae leo elementum, 
                        vitae varius arcu facilisis.
                        </div>
                        <div class="tab-pane fade" id="ulasan" role="tabpanel" aria-labelledby="profile-tab">
                        Phasellus a vulputate neque, vel sagittis velit. Nam molestie felis vitae ipsum consequat dictum. 
                        Donec et ligula elit. Aliquam at augue eu dolor convallis porttitor. Aenean vel purus commodo, 
                        cursus justo vel, maximus justo. In id pharetra leo. In varius ex quis viverra malesuada. 
                        Curabitur leo tortor, mollis nec tincidunt in, sodales malesuada dui. Curabitur maximus, 
                        leo pulvinar ornare ornare, ex mi viverra nulla, ut lacinia mauris sapien et augue. 
                        Etiam fringilla fermentum vehicula.
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
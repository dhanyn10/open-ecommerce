@extends('tataletak')
@section('css')
<link href="{{URL::asset('css/penjual/penjual.css')}}" rel="stylesheet"/>
@endsection
@section('konten')
<div class="container-fluid">
    <div class="row">
        @include('penjual.sidebar')
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-primary text-uppercase text-center">Mengubah Barang Dagang</h4>
                    @include('flash::message')
                    <form method="post">
                        {{csrf_field()}}
                        @foreach ($barang as $item)
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <div class="form-group">
                                <img id="preview-gambar" class="img-thumbnail" src="{{URL::asset('img/barangdagang/'.$item->id.'.png')}}" onError="this.onerror=null;this.src='{{URL::asset('img/noimage.svg')}}'"/>
                                <input type="hidden" name="data-gambar" id="data-gambar"/>
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control" id="gambar"/>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4"><label>nama barang</label></div>
                                <div class="col-md-8"><input type="text" name="name" class="form-control" maxlength="30" placeholder="nama barang" value="{{$item->name}}" required/></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4"><label>harga</label></div>
                                <div class="col-md-8"><input type="number" name="price" class="form-control" maxlength="10" placeholder="harga" value="{{$item->price}}" required/></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4"><label>berat</label></div>
                                <div class="col-md-8"><input type="number" name="weight" class="form-control" maxlength="10" placeholder="berat" value="{{$item->weight}}" required/></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4"><label>jumlah</label></div>
                                <div class="col-md-8"><input type="number" name="stock" class="form-control" maxlength="10" placeholder="jumlah" value="{{$item->stock}}" required/></div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4"><label>keterangan</label></div>
                                <div class="col-md-8"><textarea name="description" class="form-control" rows="6" maxlength="10000" placeholder="keterangan" required>{!! $item->description !!}</textarea></div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Ubah</button>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
<script src="{{URL::asset('js/penjual/bacagambar.js')}}"></script>
@endsection
@endsection

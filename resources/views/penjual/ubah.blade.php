@extends('tataletak')
@section('css')
<link href="{{URL::asset('css/penjual/penjual.css')}}" rel="stylesheet"/>
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
                                <img id="preview-gambar" class="img-thumbnail" src="{{URL::asset('img/barangdagang/'.$item->id.'.png')}}"/>
                                <input type="hidden" name="data-gambar" id="data-gambar"/>
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control" id="gambar"/>
                            </div>
                            <div class="form-group">
                                <input type="text" name="nama" class="form-control" maxlength="30" placeholder="namabarang" value="{{$item->nama}}" required/>
                            </div>
                            <div class="form-group">
                                <input type="text" name="harga" class="form-control" maxlength="10" placeholder="harga" value="{{$item->harga}}" required/>
                            </div>
                            <div class="form-group">
                                <input type="text" name="jumlah" class="form-control" maxlength="10" placeholder="jumlah" value="{{$item->jumlah}}" required/>
                            </div>
                            <div class="form-group">
                                <textarea name="keterangan" class="form-control" rows="6" maxlength="10000" placeholder="keterangan" required>{{$item->keterangan}}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Ubah</button>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{URL::asset('js/penjual/bacagambar.js')}}"></script>
@endsection 
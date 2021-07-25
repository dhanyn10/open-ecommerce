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
                    <h4 class="text-primary text-uppercase text-center">Menambah Barang Dagang</h4>
                    @include('flash::message')
                    <form method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <img id="preview-gambar" class="img-thumbnail"/>
                            <input type="hidden" name="data-gambar" id="data-gambar"/>
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control" id="gambar"/>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label>nama barang</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="nama" class="form-control" maxlength="30" placeholder="namabarang" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label>harga</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" name="harga" class="form-control" maxlength="10" placeholder="harga" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label>berat</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" name="berat" class="form-control" maxlength="10" placeholder="berat" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label>jumlah</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" name="jumlah" class="form-control" maxlength="10" placeholder="jumlah" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label>keterangan</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="keterangan" class="form-control" rows="6" maxlength="10000" placeholder="keterangan" required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
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
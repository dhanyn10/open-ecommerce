@extends('tataletak')
@section('konten')
<div class="container-fluid">
    <div class="row">
        @include('penjual.sidebar')
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @include('flash::message')
                    <div class="row">
                        @if(count($data_barang) > 0)
                            @foreach($data_barang as $barang)
                                <div class="col-md-3">
                                    <div class="card card-barangdagang w-100">
                                        <div class="fotobarangdagang">
                                            <img src="{{URL::asset('img/barangdagang/'.$barang->id.'.png')}}"/>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="text-uppercase">{{$barang->nama}}</h6>
                                            <span class="text-danger">{{$barang->harga}}</span>
                                            <div class="modal fade" id="modalhapus{{$barang->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Hapus {{$barang->nama}}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>yakin ingin menghapus <strong>{{$barang->nama}}</strong>?</p>
                                                                {{csrf_field()}}
                                                                <input type="hidden" name="jenis" value="hapusdata"/>
                                                                <input type="hidden" name="id-barang" value="{{$barang->id}}"/>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-sm btn-danger float-right text-uppercase">hapus</button>
                                                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">batal</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="ml-auto">
                                                    <a
                                                        class="btn btn-sm btn-light hover-visible"
                                                        title="edit"
                                                        href="{{route('penjual-ubah', $barang->id)}}"
                                                    >
                                                        <i class="fa fa-pencil-square"></i>
                                                    </a>
                                                    <button
                                                        class="btn btn-sm btn-light hover-visible"
                                                        data-toggle="modal"
                                                        data-target="#modalhapus{{$barang->id}}"
                                                        title="hapus"
                                                    >
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                        <div class="alert alert-primary text-center w-100">
                            belum ada data stok barang
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection
@extends('tataletak')
@section('konten')
<div class="container-fluid">
    <div class="row">
        @include('penjual.sidebar')
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0">Daftar Barang Dagangan</h5>
                </div>
                <div class="card-body">
                    @include('flash::message')
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Stok Saat Ini</th>
                                    <th>Stok Terjual</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($data_barang) > 0)
                                    @foreach($data_barang as $index => $barang)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">
                                                <img src="{{URL::asset('img/barangdagang/'.$barang->id.'.png')}}" style="width: 50px; height: 50px; object-fit: cover;"/>
                                            </td>
                                            <td>{{$barang->name}}</td>
                                            <td class="text-danger text-right">Rp {{ number_format($barang->price, 0, ',', '.') }}</td>
                                            <td class="text-center">{{$barang->current_stock}}</td>
                                            <td class="text-center">{{$barang->sold}}</td>
                                            <td class="text-center">
                                                <a
                                                    class="btn btn-sm btn-info"
                                                    title="edit"
                                                    href="{{route('penjual-ubah', $barang->id)}}"
                                                >
                                                    <i class="fa fa-pencil-square"></i>
                                                </a>
                                                <button
                                                    class="btn btn-sm btn-danger"
                                                    data-toggle="modal"
                                                    data-target="#modalhapus{{$barang->id}}"
                                                    title="hapus"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>

                                                <div class="modal fade" id="modalhapus{{$barang->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <form method="post" action="{{ route('penjual-lihat') }}">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-left">Hapus {{$barang->name}}</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body text-left">
                                                                    <p>yakin ingin menghapus <strong>{{$barang->name}}</strong>?</p>
                                                                    {{csrf_field()}}
                                                                    <input type="hidden" name="jenis" value="hapusdata"/>
                                                                    <input type="hidden" name="product_id" value="{{$barang->id}}"/>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-sm btn-danger float-right text-uppercase">hapus</button>
                                                                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">batal</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="alert alert-primary m-0">
                                                belum ada data stok barang
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection

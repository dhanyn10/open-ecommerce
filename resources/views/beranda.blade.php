@extends('tataletak')
@section('konten')
<div class="konten">
	<div class="container">
		@include('flash::message')
		<div class="row">
			<div class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<div class="carousel-item active">
						{{-- <img class="d-block w-100" src="" alt="First slide"> --}}
					</div>
				</div>
			</div>
		</div>
		<hr/>
		<div class="row">
			@if(isset($data_barang))
				@foreach($data_barang as $barang)
				<div class="col-md-3">
					<div class="card card-barangdagang w-100">
						<div class="fotobarangdagang">
							<img src="{{URL::asset('img/barangdagang/'.$barang->id.'.png')}}"/>
						</div>
						<div class="card-body">
							<h6 class="text-uppercase">{{$barang->nama}}</h6>
							<span class="text-danger">{{$barang->harga}}</span>
							<div class="form-group">
								<a class="text-uppercase btn btn-sm btn-danger hover-visible float-right" href="{{route('barang', $barang->id)}}">lihat</a>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			@endif
		</div>
	</div>
</div>
@endsection
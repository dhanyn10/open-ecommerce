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
					<div class="card w-100">
						<div class="fotobarangdagang">
							<img class="card-img-top" src="{{URL::asset('img/barangdagang/'.$barang->id.'.png')}}"/>
						</div>
						<div class="card-body">
							<p><a class="h5 card-title stretched-link beranda-link text-secondary" href="{{route('barang', $barang->id)}}">{{$barang->nama}}</a></p>
							<span class="text-danger">{{$barang->harga}}</span>
						</div>
						@if ($kota != null)
							<div class="card-footer">{{$kota}}</div>
						@endif
					  </div>
				</div>
				@endforeach
			@endif
		</div>
	</div>
</div>
@endsection
@extends('tataletak')
@section('konten')
<div class="konten">
	<div class="container">
		@include('flash::message')
		<div class="row">
			<div class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<div class="carousel-item active">
						<img class="d-block w-100" src="{{URL::asset('img/teachlikefinland.png')}}" alt="First slide">
					</div>
					<div class="carousel-item">
						<img class="d-block w-100" src="{{URL::asset('img/teachlikefinland.png')}}" alt="Second slide">
					</div>
					<div class="carousel-item">
						<img class="d-block w-100" src="{{URL::asset('img/teachlikefinland.png')}}" alt="Third slide">
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
							<span class="text-muted">{{$barang->harga}}</span>
							<div class="form-group">
								<a class="text-uppercase btn btn-sm btn-primary hover-visible float-right" href="{{route('barang', $barang->id)}}">lihat</a>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			@endif
		</div>
	</div>
</div>
<div class="col-mg-12 fixed-bottom bg-primary text-white">
		<div class="card-body">
			<div class="row">
				<div class="col-md-8"></div>
				<div class="col-md-4">
					<h4>Kontak</h4>
					<div class="row">
						<div class="col-md-6">email</div>
						<div class="col-md-6">dhanyn.dhan@gmail.com</div>
					</div>
					<div class="row">
						<div class="col-md-6">kontak</div>
						<div class="col-md-6">123456789</div>
					</div>
				</div>
			</div>
		</div>
</div>
@endsection
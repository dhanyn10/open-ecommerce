@extends('tataletak')
@section('konten')
<div class="konten">
	<div class="container">
		@include('flash::message')
		<div class="row">
			<div class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<div class="carousel-item active">
					</div>
				</div>
			</div>
		</div>
		<hr/>
		<div class="row">
			@if(isset($data_barang))
				@foreach($data_barang as $barang)
				<div class="col-md-3 mb-4">
					<div class="card h-100">
						<div class="fotobarangdagang">
							<img class="card-img-top" src="{{URL::asset('img/barangdagang/'.$barang->id.'.png')}}" onError="this.onerror=null;this.src='{{URL::asset('img/noimage.svg')}}'">
						</div>
						<div class="card-body">
							<p><a class="h5 card-title stretched-link beranda-link text-secondary text-uppercase" href="{{route('barang', $barang->id)}}">{{$barang->name}}</a></p>
							<span class="text-danger">Rp {{ number_format($barang->price, 0, ',', '.') }}</span>
						</div>
						@if ($kota != null)
							<div class="card-footer text-muted small">{{$kota}}</div>
						@endif
					  </div>
				</div>
				@endforeach
			@endif
		</div>
	</div>
</div>
@endsection

@extends('tataletak')
@section('konten')
<div class="container-fluid">
    <div class="row">
        @include('pembeli.sidebar')
        <div class="col-md-6">
            <div class="card border-primary">
                <div class="card-body">
                    @include('pengguna.formubahidentitas')
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-header bg-light text-center text-uppercase rounded-0">iklan di sini</div>
            </div>
        </div>
    </div>
</div>
@endsection
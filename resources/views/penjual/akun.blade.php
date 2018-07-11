@extends('tataletak')
@section('konten')
    <div class="container-fluid">
        <div class="row">
            @include('penjual.sidebar')
            <div class="col-md-6">
                @include('flash::message')
                <div class="card border-primary">
                    <div class="card-body">
                        @include('pengguna.formubahidentitas')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
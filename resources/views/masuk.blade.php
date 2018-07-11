@extends('tataletak')
@section('konten')
<div class="col-md-4 tengah">
    @include('flash::message')
    <div class="card border-primary w-100">
        <div class="card-header bg-primary text-center text-white">Masuk ke dalam akun kamu</div>
        <div class="card-body">
            <form method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <input name="email" type="text" class="form-control" placeholder="email" maxlength="30" required/>
                </div>
                <div class="form-group">
                    <input name="sandi" type="password" class="form-control" placeholder="kata sandi" maxlength="20" required/>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block">Masuk</button>
                </div>
                <div class="form-group">
                    Belum memiliki akun? <a href="{{route('daftar')}}">Daftar</a>
                    <small><a class="text-muted float-right" href="{{route('reset-sandi')}}">lupa sandi</a></small>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('tataletak')
@section('konten')
<div class="col-md-4 tengah">
    @include('flash::message')
    <div class="card border-primary w-100">
        <div class="card-header bg-primary text-center text-white">Daftar akun baru</div>
        <div class="card-body">
            <form method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <input name="nama" type="text" class="form-control" placeholder="nama lengkap" maxlength="20" required/>
                </div>
                <div class="form-group">
                    <input name="email" type="text" class="form-control" placeholder="email" maxlength="30" required/>
                </div>
                <div class="form-group">
                    <select name="peran" class="form-control" required>
                        <option value="2">penjual</option>
                        <option value="3">pembeli</option>
                    </select>
                </div>
                <div class="form-group">
                    <input name="sandi" type="password" class="form-control" placeholder="kata sandi" maxlength="20" required/>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block">Daftar</button>
                </div>
                <div class="form-group">
                    Sudah memiliki akun? <a href="{{route('masuk')}}">Masuk</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
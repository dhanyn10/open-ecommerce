@extends('tataletak')
@section('konten')
<div class="col-md-4 tengah">
    @include('flash::message')
    <div class="card border-primary w-100">
        <div class="card-header bg-primary text-center text-white">Reset sandi kamu</div>
        <div class="card-body">
            <form method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <input name="email" type="text" class="form-control" placeholder="masukkan email" maxlength="30" required/>
                </div>
                <div class="form-group">
                    <button class="btn btn-success btn-block">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
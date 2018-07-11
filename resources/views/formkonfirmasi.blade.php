@extends('tataletak')
@section('konten')
<div class="col-md-4 tengah">
    @include('flash::message')
    <div class="card border-primary w-100">
        <div class="card-header bg-primary text-white">Kirim email konfirmasi</div>
        <div class="card-body">
            <form method="post">
                {{csrf_field()}}
                <div class="form-group">
                    @if(session()->has('email'))
                        <input type="text" name="email" class="form-control" placeholder="email" value="{{session('email')}}" maxlength="30" required/>
                    @else
                        <input type="text" name="email" class="form-control" placeholder="email" maxlength="30" required/>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
<form method="post">
    {{csrf_field()}}
    <div class="form-group row">
        <div class="col-md-3">
            <label>email</label>
        </div>
        @if(session()->has('konfirmasi'))
            @if(session('konfirmasi') == 0)
            <div class="col-md-6">
                <input type="text" name="email" class="form-control form-control-sm" value="{{$pengguna->pluck('email')->first()}}" maxlength="30" required/>
            </div>
            <div class="col-md-3">
                <small><a class="text-danger float-right" href="{{route('formkonfirmasi')}}">konfirmasi email</a></small>
            </div>
            @endif
        @else
        <div class="col-md-9">
            <input type="text" name="email" class="form-control form-control-sm" value="{{$pengguna->pluck('email')->first()}}" maxlength="30" required/>
        </div>
        @endif
    </div>
    <div class="form-group row">
        <div class="col-md-3">
            <label>nama</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="nama" class="form-control form-control-sm" value="{{$pengguna->pluck('nama')->first()}}" maxlength="20" required/>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-3">
            <label>telepon</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="telepon" class="form-control form-control-sm" value="{{$pengguna->pluck('telepon')->first()}}" maxlength="12" required/>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-3">
            <label>alamat</label>
        </div>
        <div class="col-md-9">
            <textarea type="text" name="alamat" class="form-control form-control-sm" maxlength="255" required>{{$pengguna->pluck('alamat')->first()}}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-3">
            <label>password</label>
        </div>
        <div class="col-md-9">
            <input type="password" name="sandi" class="form-control form-control-sm" maxlength="20"/>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-sm btn-primary">Kirim</button>
    </div>
</form>
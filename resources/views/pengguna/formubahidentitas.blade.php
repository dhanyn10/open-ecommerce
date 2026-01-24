@include('flash::message')
<form method="post" id="ubahidentitas">
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
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="">provinsi</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control form-control-sm" name="provinsi" onchange="submitForm()">
                        <option value="" selected>Pilih</option>
                        @if (isset($dataProvinsi) && $dataProvinsi != null)
                            @foreach ($dataProvinsi as $item)
                                @if ($provinsi == $item->province)
                                    <option value="{{$item->province_id}}-{{$item->province}}" selected>{{$item->province}}</option>
                                @else
                                    <option value="{{$item->province_id}}-{{$item->province}}">{{$item->province}}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="">kota/kabupaten</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control form-control-sm" id="city-search" name="kota">
                        @if($kotaAsal && $userKota)
                            <option value="{{ $userKota }}" selected>{{ $kotaAsal }}</option>
                        @endif
                    </select>
                </div>
            </div>
            <textarea type="text" name="alamat" class="form-control form-control-sm" maxlength="255">{{$pengguna->pluck('alamat')->first()}}</textarea>
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

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // Simplified debounce function
    function debounce(func, delay) {
        let timeout;
        return function(...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), delay);
        };
    }

    $(document).ready(function() {
        $('#city-search').select2({
            placeholder: 'Cari kota atau kabupaten...',
            ajax: {
                url: '{{ route("ajax.cities.search") }}',
                dataType: 'json',
                delay: 250, // Debounce delay
                data: function (params) {
                    return {
                        q: params.term // search term
                    };
                },
                processResults: function (data) {
                    // Transform the API data into the format Select2 expects
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.subdistrict_id + '-' + item.city,
                                text: item.city + ', ' + item.subdistrict_name
                            }
                        })
                    };
                },
                cache: true
            }
        });
    });

    function submitForm() {
        const telepon = document.getElementsByName('telepon')[0].value;
        if (telepon.length > 0) {
            document.getElementById('ubahidentitas').submit();
        } else {
            alert('Nomor telepon belum diisi');
        }
    }
</script>
@endpush

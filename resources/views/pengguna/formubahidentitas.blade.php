@include('flash::message')
<form method="post" id="ubahidentitas">
    {{csrf_field()}}
    {{-- Other form fields like email, name, phone --}}
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
                    <label for="province-search">provinsi</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control form-control-sm" id="province-search" name="provinsi">
                        <option value="" selected>Pilih Provinsi</option>
                        @if (isset($dataProvinsi) && $dataProvinsi != null)
                            @foreach ($dataProvinsi as $item)
                                <option value="{{$item->id}}-{{$item->name}}" @if ($provinsi == $item->name) selected @endif>{{$item->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="city-search">kota/kabupaten</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control form-control-sm" id="city-search" name="kota">
                        @if($kotaAsal && $pengguna->pluck('kota')->first())
                            <option value="{{ $pengguna->pluck('kota')->first() }}" selected>{{ $kotaAsal }}</option>
                        @endif
                    </select>
                </div>
            </div>
            <textarea type="text" name="alamat" class="form-control form-control-sm" maxlength="255">{{$pengguna->pluck('alamat')->first()}}</textarea>
        </div>
    </div>

    {{-- Password field --}}
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
    $(document).ready(function() {
        // Initialize Select2 for Province
        const $provinceSelect = $('#province-search').select2({
            placeholder: 'Pilih Provinsi'
        });

        // Initialize Select2 for City
        const $citySelect = $('#city-search').select2({
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
                                id: item.subdistrict_id + '-' + item.city_name,
                                text: item.province_name + ', ' + item.city_name + ', ' + item.subdistrict_name
                            }
                        })
                    };
                },
                cache: true
            }
        });

        // Function to check province selection and enable/disable city
        function toggleCitySelect() {
            if ($provinceSelect.val()) {
                $citySelect.prop('disabled', false);
            } else {
                $citySelect.prop('disabled', true);
            }
        }

        // Add event listener for province selection
        $provinceSelect.on('change', function() {
            toggleCitySelect();
            // Clear city selection when province changes
            $citySelect.val(null).trigger('change');
        });

        // Initial check on page load
        toggleCitySelect();
    });
</script>
@endpush

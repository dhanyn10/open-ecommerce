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
                    <label for="province-select">provinsi</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control form-control-sm" id="province-select" name="provinsi">
                        <option value="" selected>Pilih Provinsi</option>
                        @if (isset($dataProvinsi) && $dataProvinsi != null)
                            @foreach ($dataProvinsi as $item)
                                <option value="{{$item['id']}}-{{$item['name']}}" @if ($provinsi == $item['name']) selected @endif>{{$item['name']}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="city-select">kota/kabupaten</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control form-control-sm" id="city-select" name="kota" disabled>
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
        const $provinceSelect = $('#province-select').select2({
            placeholder: 'Pilih Provinsi'
        });

        const $citySelect = $('#city-select').select2({
            placeholder: 'Pilih Kota/Kabupaten'
        });

        function fetchCities(provinceId, selectedCityValue = null) {
            if (!provinceId) {
                $citySelect.empty().append('<option value="">Pilih Kota/Kabupaten</option>').prop('disabled', true);
                return;
            }

            $citySelect.prop('disabled', true).empty().append('<option value="">Memuat...</option>');

            $.ajax({
                url: '{{ route("ajax.cities.by-province") }}',
                data: { province_id: provinceId },
                success: function(cities) {
                    $citySelect.empty().append('<option value="">Pilih Kota/Kabupaten</option>');
                    if (cities) {
                        cities.forEach(function(city) {
                            $citySelect.append(new Option(city.name, city.id + '-' + city.name));
                        });
                    }
                    $citySelect.prop('disabled', false);

                    // If a city was previously selected, re-select it
                    if (selectedCityValue) {
                        $citySelect.val(selectedCityValue).trigger('change');
                    }
                },
                error: function() {
                    $citySelect.empty().append('<option value="">Gagal memuat</option>').prop('disabled', true);
                }
            });
        }

        $provinceSelect.on('change', function() {
            const selectedProvince = $(this).val();
            const provinceId = selectedProvince ? selectedProvince.split('-')[0] : null;
            fetchCities(provinceId);
        });

        // Initial load
        const initialProvince = $provinceSelect.val();
        if (initialProvince) {
            const provinceId = initialProvince.split('-')[0];
            const selectedCity = "{{ $pengguna->pluck('kota')->first() }}";
            fetchCities(provinceId, selectedCity);
        }
    });
</script>
@endpush

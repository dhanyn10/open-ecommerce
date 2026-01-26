@include('flash::message')
<form method="post" id="ubahidentitas">
    {{csrf_field()}}

    <div class="form-group row">
        <div class="col-md-3">
            <label for="email">email</label>
        </div>
        <div class="col-md-9">
            <input type="text" id="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror" value="{{ old('email', $pengguna->email) }}" maxlength="30" required/>
            @if(session('konfirmasi') == 0)
                <small><a class="text-danger float-right" href="{{route('formkonfirmasi')}}">konfirmasi email</a></small>
            @endif
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3">
            <label for="nama">nama</label>
        </div>
        <div class="col-md-9">
            <input type="text" id="nama" name="nama" class="form-control form-control-sm @error('nama') is-invalid @enderror" value="{{ old('nama', $pengguna->nama) }}" maxlength="20" required/>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3">
            <label for="telepon">telepon</label>
        </div>
        <div class="col-md-9">
            <input type="text" id="telepon" name="telepon" class="form-control form-control-sm @error('telepon') is-invalid @enderror" value="{{ old('telepon', $pengguna->telepon) }}" maxlength="15" required/>
            @error('telepon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
                    <select class="form-control form-control-sm @error('provinsi') is-invalid @enderror" id="province-select" name="provinsi" required>
                        <option value="">Pilih Provinsi</option>
                        @if (isset($dataProvinsi))
                            @foreach ($dataProvinsi as $item)
                                <option value="{{$item['id']}}-{{$item['name']}}" @if (old('provinsi', $pengguna->provinsi) == $item['id'].'-'.$item['name']) selected @endif>{{$item['name']}}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('provinsi')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="city-select">kota/kabupaten</label>
                </div>
                <div class="col-md-8">
                    <select class="form-control form-control-sm @error('kota') is-invalid @enderror" id="city-select" name="kota" required>
                        @if(old('kota', $pengguna->kota))
                            <option value="{{ old('kota', $pengguna->kota) }}" selected>{{ explode('-', old('kota', $pengguna->kota))[1] ?? 'Pilih Kota/Kabupaten' }}</option>
                        @endif
                    </select>
                     @error('kota')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <textarea type="text" name="alamat" class="form-control form-control-sm @error('alamat') is-invalid @enderror" maxlength="255" required>{{ old('alamat', $pengguna->alamat) }}</textarea>
            @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3">
            <label for="password">password</label>
        </div>
        <div class="col-md-9">
            <input type="password" id="password" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror" maxlength="30"/>
            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
                $citySelect.empty().append('<option value="">Pilih Provinsi Dahulu</option>').prop('disabled', true);
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
            $citySelect.val(null).trigger('change'); // Clear city selection
            fetchCities(provinceId);
        });

        // Initial load
        const initialProvince = $provinceSelect.val();
        if (initialProvince) {
            const provinceId = initialProvince.split('-')[0];
            const selectedCity = "{{ old('kota', $pengguna->kota) }}";
            fetchCities(provinceId, selectedCity);
        } else {
             $citySelect.prop('disabled', true).empty().append('<option value="">Pilih Provinsi Dahulu</option>');
        }
    });
</script>
@endpush

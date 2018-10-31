<div class="col-md-3 sidebar">
    <div id="accordion">
        <div class="card">
            <nav class="nav flex-column">
                @if(Route::currentRouteName() == 'penjual-lihat')
                    <a class="nav-link text-dark collapsed" data-toggle="collapse" href="#barang">
                        Barang
                    </a>
                    <div id="barang" class="collapse show" data-parent="#accordion">
                        <a class="nav-link text-white bg-primary" href="{{route('penjual-lihat')}}">Lihat Barang</a>
                        <a class="nav-link text-dark" href="{{route('penjual-tambah')}}">Tambah Barang</a>
                    </div>
                @elseif(Route::currentRouteName() == 'penjual-tambah')
                    <a class="nav-link text-dark collapsed" data-toggle="collapse" href="#barang">
                        Barang
                    </a>
                    <div id="barang" class="collapse show" data-parent="#accordion">
                        <a class="nav-link text-dark" href="{{route('penjual-lihat')}}">Lihat Barang</a>
                        <a class="nav-link text-white bg-primary" href="{{route('penjual-tambah')}}">Tambah Barang</a>
                    </div>
                @else
                    <a class="nav-link text-dark collapsed" data-toggle="collapse" href="#barang">
                        Barang
                    </a>
                    <div id="barang" class="collapse" data-parent="#accordion">
                        <a class="nav-link text-dark" href="{{route('penjual-lihat')}}">Lihat Barang</a>
                        <a class="nav-link text-white bg-primary" href="{{route('penjual-tambah')}}">Tambah Barang</a>
                    </div>
                @endif

                @if(Route::currentRouteName() == 'akun-penjual')
                    <a class="nav-link text-white bg-primary" href="{{route('akun-penjual')}}">Akun</a>
                @else
                    <a class="nav-link text-dark" href="{{route('akun-penjual')}}">Akun</a>
                @endif
            </nav>
        </div>
    </div>
</div>
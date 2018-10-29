<div class="col-md-3 sidebar">
    <div id="accordion">
        <div class="card">
            <nav class="nav flex-column">
                @if(Route::currentRouteName() == 'dasbor-penjual')
                    <a class="nav-link text-white bg-primary" href="{{route('dasbor-penjual')}}">Dasbor</a>
                @else
                    <a class="nav-link text-dark" href="{{route('dasbor-penjual')}}">Dasbor</a>
                @endif
                
                @if(Route::currentRouteName() == 'barang-penjual')
                    <a class="nav-link text-white bg-primary collapsed" data-toggle="collapse" href="#barang">
                        Barang
                    </a>
                    <div id="barang" class="collapse show" data-parent="#accordion">
                        <a class="nav-link text-white bg-primary" href="{{route('barang-penjual')}}">Lihat Barang</a>
                    </div>
                @else
                    <a class="nav-link text-dark collapsed" data-toggle="collapse" href="#barang">
                        Barang
                    </a>
                    <div id="barang" class="collapse" data-parent="#accordion">
                        <a class="nav-link text-dark" href="{{route('barang-penjual')}}">Lihat Barang</a>
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
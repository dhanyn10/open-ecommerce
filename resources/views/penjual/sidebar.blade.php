<div class="col-md-3">
    <div class="card">
        <nav class="nav flex-column">
            @if(Route::currentRouteName() == 'dasbor-penjual')
                <a class="nav-link text-white bg-primary" href="{{route('dasbor-penjual')}}">Dasbor</a>
            @else
                <a class="nav-link text-dark" href="{{route('dasbor-penjual')}}">Dasbor</a>
            @endif
            
            @if(Route::currentRouteName() == 'barang-penjual')
                <a class="nav-link text-white bg-primary" href="{{route('barang-penjual')}}">Barang</a>
            @else
                <a class="nav-link text-dark" href="{{route('barang-penjual')}}">Barang</a>
            @endif
            
            @if(Route::currentRouteName() == 'akun-penjual')
                <a class="nav-link text-white bg-primary" href="{{route('akun-penjual')}}">Akun</a>
            @else
                <a class="nav-link text-dark" href="{{route('akun-penjual')}}">Akun</a>
            @endif
        </nav>
    </div>
</div>
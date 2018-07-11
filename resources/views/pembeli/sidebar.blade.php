<div class="col-md-3">
    <div class="card">
        <nav class="nav flex-column">
            @if(Route::currentRouteName() == 'dasbor-pembeli')
                <a class="nav-link text-white bg-primary" href="{{route('dasbor-penjual')}}">Dasbor</a>
            @else
                <a class="nav-link text-dark" href="{{route('dasbor-penjual')}}">Dasbor</a>
            @endif
        </nav>
    </div>
</div>
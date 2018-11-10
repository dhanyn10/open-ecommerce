<div class="col-md-3">
    <div class="card">
        <nav class="nav flex-column">
            @if(Route::currentRouteName() == 'pembeli-dasbor')
                <a class="nav-link text-white bg-primary" href="{{route('pembeli-dasbor')}}">Dasbor</a>
            @else
                <a class="nav-link text-dark" href="{{route('pembeli-dasbor')}}">Dasbor</a>
            @endif
        </nav>
    </div>
</div>
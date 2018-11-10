<div class="col-md-3">
    <div class="card">
        <nav class="nav flex-column">
            @if(Route::currentRouteName() == 'pembeli-profil')
                <a class="nav-link text-white bg-primary" href="{{route('pembeli-profil')}}">Profil</a>
            @else
                <a class="nav-link text-dark" href="{{route('pembeli-profil')}}">Profil</a>
            @endif
        </nav>
    </div>
</div>
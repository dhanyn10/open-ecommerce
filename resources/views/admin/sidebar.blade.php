<div class="col-md-3">
    <div class="card">
        <nav class="nav flex-column">
            @if(Route::currentRouteName() == 'admin-dasbor')
                <a class="nav-link text-white bg-primary" href="{{route('admin-dasbor')}}">Dasbor</a>
            @else
                <a class="nav-link text-dark" href="{{route('admin-dasbor')}}">Dasbor</a>
            @endif
            @if(Route::currentRouteName() == 'admin-profil')
                <a class="nav-link text-white bg-primary" href="{{route('admin-profil')}}">Profil</a>
            @else
                <a class="nav-link text-dark" href="{{route('admin-profil')}}">Profil</a>
            @endif
        </nav>
    </div>
</div>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{config('app.name')}}</title>
        <link href="{{URL::asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"/>
        <link href="{{URL::asset('fontawesome/css/font-awesome.min.css')}}" rel="stylesheet"/>
        <link href="{{URL::asset('css/global.css')}}" rel="stylesheet"/>
        @yield('css')
        <script src="{{URL::asset('js/jquery.min.js')}}"></script>
        <script src="{{URL::asset('js/tether.min.js')}}"></script>
        <script src="{{URL::asset('bootstrap/js/bootstrap.min.js')}}"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        @yield('js')
    </head>
    <body>
        <nav class="navbar sticky-top navbar-expand-md navbar-atas navbar-dark bg-primary">
            <a class="navbar-brand" href="{{route('beranda')}}">{{config('app.name')}}</a>
            <button
                    class="navbar-toggler navbar-toggler-right"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navigasi"
                    aria-controls="navigasi"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navigasi">
                @if(session()->has('peran'))
                <ul class="navbar-nav mr-auto">
                    @if(session('peran') == 2)
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('penjual-tambah')}}">dasbor</a>
                    </li>
                    @elseif(session('peran') == 3)
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('dasbor-pembeli')}}">dasbor</a>
                    </li>
                    @endif
                </ul>
                @endif
                <ul class="navbar-nav ml-auto">
                    @if(session()->has('peran'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('data-belanja')}}">Troli</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('keluar')}}">Keluar</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('masuk')}}">Masuk</a>
                    </li>
                    @endif
                </ul>
            </div>
        </nav>
        @yield('konten')
    </body>
</html>
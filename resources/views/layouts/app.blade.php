<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTableFix.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-v4.1.1/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-v1.10.18/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-v1.10.18/responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datepicker-v1.0.7/css/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free-v5.9.0/css/all.min.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('favicon.png') }}" alt="" class="brand" width="20" style="margin-right: 10px">
            <span>BilleteraV</span>
        </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <!-- <li class="nav-item">
                <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
            </li> -->
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Entrar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Registrar</a>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Salir</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
      </div>
    </nav>

    <div class="container-fluid" style="padding-top: 50px;padding-bottom: 50px;">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('plugins/jquery-v3.3.1/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('plugins/popper-v1.14.3/popper.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-v4.1.1/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-v1.10.18/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-v1.10.18/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-v1.10.18/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-v1.10.18/responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datepicker-v1.0.7/js/datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="datepicker"]').datepicker({
                format: 'yyyy-mm-dd',
                autoHide: true
            });
        });
    </script>
    @yield('script')
</body>
</html>

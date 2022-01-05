<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="{{URL::asset('icon.ico')}}">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

  <link rel="stylesheet" href="{{URL::asset('sweetalert/sweetalert2.min.css')}}">

  <style>
    section {
      min-height: 420px;
    }
  </style>
  <title>@yield('title')</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="{{ url ('/')}}">Bayu Anugerah</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
        </div>
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link @if (Request::segment( 1 ) == '' || Request::segment( 1 ) == "pokemon") active @endif" href="{{ url ('/')}}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (Request::segment( 1 ) == 'mypokemon') active @endif" href="{{url('/mypokemon')}}">MyPokemon</a>
            </li>
        </ul>
        @guest
        <a href="/login" style="text-decoration: none">
            <button class="btn btn-outline-info rounded-pill" type="button">Sign In</button>
        </a>
        @endguest
        @auth
            <div class="btn-group">
            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                Hi, {{auth()->user()->name}}
            </button>
                <div class="dropdown-menu">
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item">Sign Out</button>
                        </form>
                </div>
            </div>
        @endauth
      </div>
    </div>
  </nav>
  <div class="container mt-5">
      @yield('content')

  </div>

  {{-- <footer class="bg-dark text-white w-100">
    <div class="container">
      <div class="row pt-3">
        <div class="col text-center">
          <p>Copyright 2020.</p>
        </div>
      </div>
    </div>
  </footer> --}}


  <script src="{{URL::asset('jquery-3.6.0.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
  <script src="{{URL::asset('sweetalert/sweetalert2.all.min.js')}}"></script>
  @yield('script')
</body>

</html>

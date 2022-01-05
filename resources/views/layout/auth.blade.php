<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="icon.ico">

    <title>{{$title}}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="{{URL::asset('sweetalert/sweetalert2.min.css')}}">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

  </head>

  <body class="text-center">
    @yield('form')



    <script src="{{URL::asset('jquery-3.6.0.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <script src="{{URL::asset('sweetalert/sweetalert2.all.min.js')}}"></script>
    @if (Session::has('message'))
        <script>
            Swal.fire(
                'Success!',
                '{{ Session::get('message')}}',
                'success')
        </script>
    @endif
    @if (Session::has('messageError'))
        <script>
            Swal.fire(
                'Error!',
                '{{ Session::get('messageError')}}',
                'error')
        </script>
    @endif
  </body>
</html>

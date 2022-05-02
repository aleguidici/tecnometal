<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ URL::asset('/css/bootstrap.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('/font-awesome/css/font-awesome.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::asset('/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('/css/AdminLTE.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ URL::asset('/iCheck/square/blue.css')}}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <title>Tecnometal - Iniciar Sesión</title>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
        <a href="{{route('home')}}"><b>TECNOMETAL</b></a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Inicie sesión para comenzar a utilizar el sistema</p>
            @yield('content')
        </div>
    </div>


    <!-- jQuery 3 -->
<script src="{{URL::asset('/js/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ URL::asset("/js/bootstrap/bootstrap.min.js")}}"></script>
<!-- iCheck -->
<script src="{{ URL::asset('/iCheck/icheck.min.js')}}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>

<!Doctype HTML>
<html><meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="-1" />
  <!--
  Pasos previos para subir sistema:
    - php artisan cache:clear
    - php artisan config:clear
    - php artisan config:cache
    - php artisan route:clear
    - php artisan views:clear

    BORRAR bootstrap->cache->config.php
  -->
<head>
    <title>Tecnometal - @yield('title')</title>
    <!-- BOOSTRAP -->
    <link rel="stylesheet" href='{{ URL::asset('/css/bootstrap.css')}}'>
    <link rel="stylesheet" href='{{ URL::asset('/css/AdminLTE.css') }}'>
    <link rel="stylesheet" href='{{ URL::asset('/css/skin-blue.css')}}'>
    <link rel="stylesheet" href='{{ URL::asset('/font-awesome/css/font-awesome.css')}}'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    @yield('import_css')
</head>


<body class="hold-transition skin-blue sidebar-mini">
    <!-- Initialize Wrapper -->
    <div class="wrapper">
        <header class="main-header">
        <a href="{{route('home')}}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>T</b>MTL</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Tecnometal</b></span>
            </a>
            <nav class="navbar navbar-static-top">

                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Desplegar Sidebar</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ URL::to('/') }}/img/logo-tecnometal.png" class="user-image" alt="User Image">
                                <span class="hidden-xs">{{auth()->user()->name}}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                  <img src="{{ URL::to('/') }}/img/logo-tecnometal.png" class="img-circle" alt="User Image">
                                  <p>
                                    {{auth()->user()->name}}
                                  </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                  <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Perfil</a>
                                  </div>
                                  <div class="pull-right">
                                    <a href="#" class="btn btn-default btn-flat"  onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                                  </div>
                                </li>
                              </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MENÚ PRINCIPAL</li>
                    <li>
                        <a href="{{route('home')}}">
                          <i class="fa fa-home"></i> <span> INICIO</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('clientes.index')}}">
                          <i class="fa fa-users"></i> <span> CLIENTES</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('proveedores.index')}}">
                          <i class="fa fa-industry"></i> <span> PROVEEDORES</span>
                        </a>
                    </li>

                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-cube"></i><span> RECURSOS</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li>
                          <a href="{{route('materiales.index')}}">- &nbsp;<i class="fa fa-cubes"></i> Materiales &nbsp;&nbsp; </a>
                        </li>
                        <li>
                          <a href="{{route('manos_obra.index')}}">- &nbsp;<i class="fa fa-wrench"></i> Mano de Obra &nbsp;&nbsp; </a>
                        </li>
                        <li>
                          <a href="{{route('actividades_preestablecidas.index')}}">- &nbsp;<i class="fa fa-list-alt"></i> Estándares &nbsp;&nbsp; </a>
                        </li>
                      </ul>
                    </li>
                    <li>
                       <a href="{{route('presupuestos.index')}}">
                        <i class="fa fa-file-text"></i><span> PRESUPUESTOS</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-wrench "></i><span> DATOS GENÉRICOS</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="{{route('localidades.index')}}">- &nbsp; <i class="fa fa-map-o"></i>Localidades &nbsp;&nbsp; </a></li>
                          @if (auth()->user()->tipo_usuario == 1)
                        <li><a href="{{route('usuarios.index')}}">- &nbsp; <i class="fa fa-address-book-o"></i>Usuarios &nbsp;&nbsp; </a></li>
                          @endif
                          <li><a href="{{route('gastos_preest.index')}}">- &nbsp; <i class="fa fa-money"></i> Impuestos / Gastos<br>preestablecidos &nbsp;&nbsp;</a></li>
                        </ul>
                    </li>
                </ul>
            </section>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                @yield('content-header')
            </section>
            <section class="content">
                @yield('content')
            </section>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
              <b>Version</b> 1.0.1
            </div>
            <strong>Copyright &copy; <script>document.write(new Date().getFullYear())</script> - Software hecho por <a href="https://ijsingenieria.com.ar/">IJS Ingeniería Eléctrica</a> (Misiones - Argentina).</strong> Todos los derechos reservados.
        </footer>
    </div>

    <!-- jQuery 3 -->
    <script src='{{ URL::asset("/js/jquery/dist/jquery.min.js")}}'></script>
    <!-- jQuery UI 1.11.4 -->
    <script src='{{ URL::asset("/js/jquery-ui/jquery-ui.min.js")}}'></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src='{{ URL::asset("/js/bootstrap/bootstrap.min.js")}}'></script>
    <!-- AdminLTE App -->
    <script src='{{ URL::asset("/js/adminlte.min.js")}}'></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes)
    <script src="/js/dashboard.js"></script> -->
    @yield('imports_js')
</body>

</html>

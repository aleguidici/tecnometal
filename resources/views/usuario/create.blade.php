@extends('layout')

<!-- Título de la pag web y la sección-->
@section('title')
Crear un usuario
@endsection

<!-- Contenido Css Esxtra -->

@section('import_css')
<link rel="stylesheet" href="{{URL::asset('/css/bootstrap-select.min.css')}}">
<link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>


@csrf
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

<!-- Contenido Principal-->
@section('content')
<div class="col-md-3"></div>
<div class="row">
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h1 class="box-title">Tecnometal - Nuevo Usuario</h1>
            </div>
            <div class="box-body">
                <form action="{{route('usuarios.store')}}" method="post">
                    @csrf
                    <div class="form-group has-feedback">
                        <label>Nombre de Usuario:</label>
                        <input type="text" name="name" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="Nombre de Usuario" value="{{old('name')}}">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        {!! $errors->first('name', '<small style = "color:#ff0000">:message</small><br>') !!}
                    </div>
                    <div class="form-group has-feedback">
                        <label>Correo Electrónico:</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{old('email')}}">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        {!! $errors->first('email', '<small style = "color:#ff0000">:message</small><br>') !!}
                    </div>
                    <div class="form-group has-feedback">
                        <label>Contraseña</label>
                        <input type="password" name="password" id="password-field" class="form-control" placeholder="Contraseña" value="{{old('password')}}">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        {!! $errors->first('password', '<small style = "color:#ff0000">:message</small><br>') !!}
                        <input type="checkbox" onclick="mostrarContrasena()">Mostrar Contraseña
                    </div>
                    <div class="form-group has-feedback">
                        <label>Tipo de Usuario:</label>
                        <select class="form-control" name="tipo_usuario" required>
                            <option disabled selected hidden value="">Elija una Opción</option>
                            <option value="1" @if(old('tipo_usuario')=="1") selected @endif>Administrador</option>
                            <option value="2" @if(old('tipo_usuario')=="2") selected @endif>Usuario Común</option>
                        </select>
                        {!! $errors->first('tipo_usuario', '<small style = "color:#ff0000">:message</small><br>') !!}
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-md-12">
                            <a href="{{route('usuarios.index')}}" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-success pull-right">Registrar Usuario</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('imports_js')

<script>
    function mostrarContrasena(){
        var input_field = document.getElementById('password-field')
        if (input_field.type === "password") {
            input_field.type = "text";
        } else {
            input_field.type = "password";
        }
    }

</script>

@endsection

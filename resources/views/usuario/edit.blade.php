@extends('layout')

<!-- Título de la pag web y la sección-->
@section('title')
Editar Usuario
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
                <h1 class="box-title">Tecnometal - Editar Usuario</h1>
            </div>
            <div class="box-body">
                <form action="{{route('usuarios.update',$usuario->id)}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="form-group has-feedback">
                        <label>Nombre de Usuario:</label>
                        <input type="text" name="name" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="Nombre de Usuario" value="{{old('name',$usuario->name)}}">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        {!! $errors->first('name', '<small style = "color:#ff0000">:message</small><br>') !!}
                    </div>
                    <div class="form-group has-feedback">
                        <label>Correo Electrónico:</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{old('email',$usuario->email)}}">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        {!! $errors->first('email', '<small style = "color:#ff0000">:message</small><br>') !!}
                    </div>
                    <div class="form-group has-feedback" id="pass-div">
                        <input type="checkbox" onclick="cargarFormContrasena()">Cambiar Contraseña
                    </div>
                    {!! $errors->first('password', '<small style = "color:#ff0000">:message</small><br>') !!}
                    <div class="form-group has-feedback">
                        <label>Tipo de Usuario:</label>
                        <select class="form-control" name="tipo_usuario" required>
                            <option disabled selected hidden value="">Elija una Opción</option>
                            <option value="1" @if($usuario->tipo_usuario == 1 or old('tipo_usuario')=="1") selected @endif>Administrador</option>
                            <option value="2" @if($usuario->tipo_usuario == 2 or old('tipo_usuario')=="2") selected @endif>Usuario Común</option>
                        </select>
                        {!! $errors->first('tipo_usuario', '<small style = "color:#ff0000">:message</small><br>') !!}
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-md-12">
                            <a href="{{route('usuarios.index')}}" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-success pull-right">Editar Usuario</button>
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

    function cargarFormContrasena(){
        var div_contra = document.getElementById('pass-div')

        div_contra.innerHTML='<label>Contraseña</label><input type="password" name="password" id="password-field" class="form-control" placeholder="Contraseña"><span class="glyphicon glyphicon-lock form-control-feedback"></span><input type="checkbox" onclick="mostrarContrasena()">Mostrar Contraseña';
    }

</script>

@endsection

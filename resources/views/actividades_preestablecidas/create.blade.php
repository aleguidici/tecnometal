@extends('layout')

<!-- Título de la pag web y la sección-->
@section('title')
Crear Actividad Preestablecida
@endsection

<!-- Contenido Css Esxtra -->

@section('import_css')
    <link rel="stylesheet" href="{{URL::asset('/css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>
    <link rel="stylesheet" href="{{URL::asset('/duration-picker/jquery-duration-picker.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<!-- Contenido Principal-->
@section('content')

<div class="col-xs-1"></div>
<div class="col-xs-10">
    <div class="box box-info">
        <div class="box-header with-border">
            <h1 class="box-title">Tecnometal - Nueva Actividad Preestablecida</h1>
        </div>
        <div class="box-body">
            <div class="text-info">(*) Campos obligatorios</div>
            <br>
            <form role="form" action="{{route('actividades_preestablecidas.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-xs-12">
                        <label>Título* <br></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-file-text-o" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" maxlength="100" placeholder="Título" name="titulo" value="{{old('titulo')}}">
                        </div>
                        {!! $errors->first('titulo', '<small style = "color:#ff0000">:message</small><br>') !!}
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-xs-12">
                        <label>Descripción*</label>
                        <div class='input-group'>
                            <span class="input-group-addon"><i class="fa fa-info" aria-hidden="true"></i></span>
                            <textarea style="resize: none" type="text" maxlength="255" class="form-control" placeholder="Descripción" name="descripcion">{{old('descripcion')}}</textarea>
                        </div>
                        {!! $errors->first('descripcion', '<small style = "color:#ff0000">:message</small><br>') !!}
                    </div>
                </div>
                
                <br>
                <button type="submit" class="btn btn-success pull-right"><b>Crear</b></button>
                <a href="{{route('actividades_preestablecidas.index')}}" class="btn btn-danger"><b>Cancelar</b></a>
            </form>
        </div>
    </div>
</div>
@endsection

<!-- JS Extra -->
@section('imports_js')
    <script src="{{URL::asset('/js/bootstrap-select.min.js')}}"></script>
    <script src="{{URL::asset('/js/own_functions.js')}}"></script>
    <script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>
    <script src="{{URL::asset('/duration-picker/jquery-duration-picker.js')}}"></script>
    <script>
        $(function () {
            $('#duration2').val(60000);
            $('#duration2').durationPicker({ showSeconds:true, checkRanges: true, totalMin: 60000, totalMax: 86399999});
        });
    </script>
@endsection

@extends('layout')

<!-- Título de la pag web y la sección-->
@section('title')
Editar Material
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

    <div class="box box-info">
        <div class="box-header with-border">
            <h1 class="box-title">Tecnometal - Editar Material</h1>
        </div>
        <div class="box-body">
            <div class="text-info">(*) Campos obligatorios</div>
            <br>
            <form role="form" action="{{route('materiales.update', $material->id)}}" method="POST">
                @csrf
                @method('PATCH')

                <div class="row">
                    <div class="col-xs-12">
                        <label> Unidad de medida* <br></label>
                        <select class="selectpicker" title="Seleccione una unidad" data-show-subtext="true" data-live-search="true" name="unidad_id" id="unidad_select_picker" required="required" data-width="100%">
                            @foreach ($unidades as $unidad)
                                <option value="{{$unidad->id}}" @if ($material->unidad_id == $unidad->id) selected @endif>
                                    {{$unidad->descripcion}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-xs-12">
                        <label>Descripción*</label>
                        <div class='input-group'>
                            <span class="input-group-addon"><i class="fa fa-info" aria-hidden="true"></i></span>
                            <textarea style="resize: none" type="text" maxlength="255" class="form-control" placeholder="Descripción" name="descripcion">{{old('descripcion', $material->descripcion)}}</textarea>
                        </div>
                        {!! $errors->first('descripcion', '<small style = "color:#ff0000">:message</small><br>') !!}
                    </div>
                </div>

                <br>
                <button type="submit" class="btn btn-success pull-right"><b>Actualizar Material</b></button>
                <a href="{{route('materiales.index')}}" class="btn btn-danger"><b>Cancelar</b></a>
        </form>
    </div>
@endsection

<!-- JS Extra -->
@section('imports_js')
<script src="{{URL::asset('/js/bootstrap-select.min.js')}}"></script>
<script src="{{URL::asset('/js/own_functions.js')}}"></script>
<script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>

@endsection

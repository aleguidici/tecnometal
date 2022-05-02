@extends('layout')

<!-- Título de la pag web y la sección-->
@section('title')
Editar especificación de mano de obra
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

    <div class="box box-info">
        <div class="box-header with-border">
            <h1 class="box-title">Tecnometal - Editar Especificación de Mano de Obra</h1>
        </div>
        <div class="box-body">
            <div class="text-info">(*) Campos obligatorios</div>
            <br>
            <form role="form" action="{{route('manos_obra.update', $mano_obra->id)}}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="row">
                    <div class="col-xs-7">
                        <label>Nombre* <br></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-file-text-o" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" maxlength="100" placeholder="Nombre" name="name" value="{{old('name', $mano_obra->name)}}">
                        </div>
                        {!! $errors->first('name', '<small style = "color:#ff0000">:message</small><br>') !!}
                    </div>
                    
                    <div class="col-xs-5">
                        <label> Tipo* <br></label>
                        <select class="selectpicker" title="Seleccione un tipo" data-show-subtext="true" data-live-search="true" name="tipo_mano_obra_id" required="required" data-width="100%">
                            @foreach ($tipos_mano_obra as $un_tipo)
                                <option value="{{$un_tipo->id}}" @if ($mano_obra->tipo_mano_obra_id == $un_tipo->id) selected @endif>
                                    {{$un_tipo->descripcion}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <br>
                <div class="row">
                    <div class="col-xs-3">
                        <label> Duración* </label> (Mínimo 1 minuto)<br>
                        <input type="text" class="form-control" id="duration2" name="duration2" required="required">
                    </div>
                    <div class="col-xs-9">
                        <label>Descripción*</label>
                        <div class='input-group'>
                            <span class="input-group-addon"><i class="fa fa-info" aria-hidden="true"></i></span>
                            <textarea style="resize: none" type="text" maxlength="255" class="form-control" placeholder="Descripción" name="descripcion">{{old('descripcion', $mano_obra->descripcion)}}</textarea>
                        </div>
                        {!! $errors->first('descripcion', '<small style = "color:#ff0000">:message</small><br>') !!}
                    </div>
                </div>

                <br>
                <button type="submit" class="btn btn-success pull-right"><b>Actualizar</b></button>
                <a href="{{route('manos_obra.index')}}" class="btn btn-danger"><b>Cancelar</b></a>
        </form>
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
            $('#duration2').val(parseInt(JSON.parse("{{ json_encode($mano_obra->duracion) }}"))*1000);
            $('#duration2').durationPicker({ showSeconds:true, checkRanges: true, totalMin: 60000, totalMax: 86399999});
        });
    </script>
@endsection

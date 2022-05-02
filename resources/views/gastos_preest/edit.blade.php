@extends('layout')

<!-- Título de la pag web y la sección-->
@section('title')
Editar Valor Preestablecido
@endsection

@section('import_css')
    <link rel="stylesheet" href="{{URL::asset('/css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('/alertify/css/alertify.css')}}">

    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('title', 'Editar Valor Preestablecido')

@section('content')
    <div class="col-xs-3"></div>
    <div class="col-xs-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h1 class="box-title">  Editar Valor Preestablecido</h1>
            </div>
            <div class="box-body">
                <form role="form" action="{{route('gastos_preest.update', $gasto_preest->id)}}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="row">
                        <div class="col-xs-12">
                            <label>Descripción<br></label>
                            <h4 name="descripcion">{{$gasto_preest->descripcion}}</h4>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-6">
                            <label>Valor (Porcentaje)</label>
                            <div class='input-group'>
                                <input type="text" class="form-control" placeholder="Valor" name="valor" onkeypress="return validateNumber(event)" value="{{old('valor',$gasto_preest->valor*100)}}">
                                <span class="input-group-addon">%</span>
                            </div>
                            {!! $errors->first('valor', '<small style = "color:#ff0000">:message</small><br>') !!}
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success pull-right"><b>Actualizar Valor</b></button>
                        <a href="{{route('gastos_preest.index')}}" class="btn btn-danger"><b>Cancelar</b></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('imports_js')
    <script src="{{URL::asset('/js/bootstrap-select.min.js')}}"></script>
    <script src="{{URL::asset('/js/own_functions.js')}}"></script>
    <script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>
@endsection

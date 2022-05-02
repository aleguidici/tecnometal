@extends('layout')

@section('title', 'Tecnometal - Presupuestos')

@section('import_css')
 <!-- DataTables -->
 <link rel="stylesheet" href="{{URL::asset('/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">

    <style>
        .progress{
            background-color: #dcdcdc;
            -webkit-box-shadow: none;
            box-shadow: none;
        }
    </style>
@endsection

@section('content-header')
    <h1 class="display-1">Presupuestos</h1>
@endsection

@section('content')

<a class="btn btn-success pull-right" style="margin-right: 10px; margin-bottom: 10px;" href="{{route('presupuestos.create')}}"><i class="fa fa-plus" aria-hidden="true"></i> Crear Presupuesto</a>

@if (count($borradores)>0)

<div class="row">
    <div class="col-xs-12">
        <div class="box box-warning">
            <div class="box-header">
                <h1 class="box-title">Presupuestos sin cerrar</h1><br>
                <small>Presupuestos en definición, sobre los que se pueden aplicar modificaciones.</small>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="borradores" class="table row-border table-striped table-bordered table-condensed" style="width: 100%">
                        <thead>
                            <tr style="background-color: rgb(255, 228, 155);">
                                <th style="width: 10%">Creación</th>
                                <th style="width: 70%">Cliente [Ref. / Obra]</th>
                                <th style="width: 10%">Estado</th>
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($borradores as $presupuesto)
                                <tr style="background-color: rgb(255, 243, 210);">
                                    <td>
                                        <div class="row">
                                            <div style="font-size:80%;">
                                                <div class="col-md-12">
                                                    [<b>Cr.: </b>{{$presupuesto->created_at->format('d/m/Y')}}]
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="row">
                                            <div class="col-md-12">
                                                {{$presupuesto->persona->name}} 
                                            </div>
                                        </div>
                                        
                                        <div style="font-size:80%;">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-11">
                                                [
                                                    <b>Ref.:</b>
                                                    @if ($presupuesto->referencia)
                                                        {{$presupuesto->referencia}}
                                                    @endif
                                                    / <b>Obra: </b>
                                                    @if ($presupuesto->obra)
                                                        {{$presupuesto->obra}}
                                                    @else
                                                        -
                                                    @endif
                                                ]
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-yellow">{{$presupuesto->estado_presupuesto->descripcion}}</span>
                                    </td>
                                    <td class="text-center">
                                        <!--<a class="btn btn-success btn-xs" href="{{route('presupuestos.show',$presupuesto->id)}}" title="Ver detalles del presupuesto">
                                                <i class="fa fa-1x fa-info-circle"></i>
                                        </a>-->

                                        <a class="btn btn-primary btn-xs" href='{{route('presupuestos.edit', $presupuesto->id)}}' title="Editar presupuesto">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-xs" href="{{route('presupuestos.destroy',$presupuesto->id)}}" data-method="delete" title="Eliminar" onclick="return confirm('¿Seguro que desea eliminar este borrador? \nEl mismo no se podrá recuperar.')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif


<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <h1 class="box-title">Presupuestos Activos</h1><br>
                <small>Presupuestos cerrados, sobre los que no se podrán realizar modificaciones.</small>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="presupuestos" class="table row-border table-striped table-bordered table-condensed" style="width: 100%">
                        <thead>
                            <tr>
                                <th style="width: 13%">N° Presupuesto [Creación]</th>
                                <th style="width: 47%">Cliente [Ref. / Obra]</th>
                                <th style="width: 20%">Vigencia</th>
                                <th style="width: 10%">Estado</th>
                                <th style="width: 10%"></th>
                                <th style="display:none;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pres_cerrados as $presupuesto)
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-12">
                                                {{substr(sprintf('%05d', $presupuesto->id), -5).'/'.substr(sprintf('%02d', $presupuesto->id), 0, -5)}}
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div style="font-size:80%;">
                                                <div class="col-md-12">
                                                    [<b>Cr.: </b>{{$presupuesto->created_at->format('d/m/Y')}}]
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="row">
                                            <div class="col-md-12">
                                                {{$presupuesto->persona->name}} 
                                            </div>
                                        </div>
                                        
                                        <div style="font-size:80%;">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-11">
                                                [
                                                    <b>Ref.:</b>
                                                    @if ($presupuesto->referencia)
                                                        {{$presupuesto->referencia}}
                                                    @endif
                                                    / <b>Obra: </b>
                                                    @if ($presupuesto->obra)
                                                        {{$presupuesto->obra}}
                                                    @else
                                                        -
                                                    @endif
                                                ]
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            @if($presupuesto->estado_presupuesto->id ==1 or $presupuesto->estado_presupuesto->id == 2)
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        {{Carbon\Carbon::parse($presupuesto->fecha)->format('d/m/Y')}}
                                                    </div>
                                                    <div class="col-md-6">
                                                    <div class=" pull-right">{{Carbon\Carbon::parse($presupuesto->vencimiento)->format('d/m/Y')}}</div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="progress progress-xs progress-striped active">
                                                            <div
                                                                @if ($presupuesto->proporcion_diff <=10)
                                                                    class="progress-bar progress-bar-danger" style=" background-color: #3BF500; width: {{$presupuesto->proporcion_diff}}%;"
                                                                @elseif ($presupuesto->proporcion_diff <= 20)
                                                                    class="progress-bar progress-bar-danger" style=" background-color: #5DF500; width: {{$presupuesto->proporcion_diff}}%;"
                                                                @elseif ($presupuesto->proporcion_diff <= 30)
                                                                    class="progress-bar progress-bar-danger" style=" background-color: #7BF500; width: {{$presupuesto->proporcion_diff}}%;"
                                                                @elseif ($presupuesto->proporcion_diff <= 40)
                                                                    class="progress-bar progress-bar-danger" style=" background-color: #ABF500; width: {{$presupuesto->proporcion_diff}}%;"
                                                                @elseif ($presupuesto->proporcion_diff <= 50)
                                                                    class="progress-bar progress-bar-danger" style=" background-color: #D4F500; width: {{$presupuesto->proporcion_diff}}%;"
                                                                @elseif ($presupuesto->proporcion_diff <= 60)
                                                                    class="progress-bar progress-bar-danger" style=" background-color: #F5EE00; width: {{$presupuesto->proporcion_diff}}%;"
                                                                @elseif ($presupuesto->proporcion_diff <= 70)
                                                                    class="progress-bar progress-bar-danger" style=" background-color: #F5C800; width: {{$presupuesto->proporcion_diff}}%;"
                                                                @elseif ($presupuesto->proporcion_diff <= 80)
                                                                    class="progress-bar progress-bar-danger" style=" background-color: #F5A300; width: {{$presupuesto->proporcion_diff}}%;"
                                                                @elseif ($presupuesto->proporcion_diff <= 90)
                                                                    class="progress-bar progress-bar-danger" style=" background-color: #F58600; width: {{$presupuesto->proporcion_diff}}%;"
                                                                @elseif ($presupuesto->proporcion_diff <= 99)
                                                                    class="progress-bar progress-bar-danger" style=" background-color: #FF7400; width: {{$presupuesto->proporcion_diff}}%;"
                                                                @else
                                                                    class="progress-bar progress-bar-danger" style="width: {{$presupuesto->proporcion_diff}}%;"
                                                                @endif
                                                            ></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                    @switch($presupuesto->estado_presupuesto->id)
                                        @case(1)
                                            <span class="badge bg-yellow">{{$presupuesto->estado_presupuesto->descripcion}}</span>
                                            @break
                                        @case(2)
                                            <span class="badge bg-red">{{$presupuesto->estado_presupuesto->descripcion}}</span>
                                            @break
                                        @case(4)
                                            <span class="badge bg-secondary">{{$presupuesto->estado_presupuesto->descripcion}}</span>
                                            @break
                                        @case(6)
                                            <span class="badge bg-secondary" style="background-color: #5a0202">{{$presupuesto->estado_presupuesto->descripcion}}</span>
                                            @break
                                        @default
                                            <span class="badge bg-green">{{$presupuesto->estado_presupuesto->descripcion}}</span>
                                    @endswitch
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-bitbucket btn-xs" href='{{route('presupuestos.edit', $presupuesto->id)}}' title="Ver presupuesto">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a class="btn btn-danger btn-xs" href="{{route('presupuestos.destroy',$presupuesto->id)}}" data-method="delete" title="Eliminar" onclick="return confirm('¿Seguro que desea eliminar este presupuesto?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                    <td style="display:none;">{{$presupuesto->id}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection


@section('imports_js')

<!-- DataTables -->
<script src="{{URL::asset('/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>


<script>
$(document).ready(function() {
    $('#presupuestos').DataTable({
        "order": [[ 5, "desc" ]],
        language: {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "thousands": ".",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
    });

    $('#borradores').DataTable({
        "order": [[ 0, "asc" ]],
        language: {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "thousands": ".",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
    });
});
</script>

@endsection

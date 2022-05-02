@extends('layout')

@section('title')
Especificaciones de Mano de Obra
@endsection

@section('import_css')
 <!-- DataTables -->
 <link rel="stylesheet" href="{{URL::asset('/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
 <link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>
 <script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>
@endsection

@section('content-header')
    <h1 class="display-1">Especificaciones de Mano de Obra</h1>
@endsection

@section('content')

@if(session()->has('alert'))
    <script>
        alertify.alert("Error","{{ session()->get('alert') }}").set('basic', false);
    </script>
@endif

<a class="btn btn-success pull-right" style="margin-right: 10px; margin-bottom: 10px;" href="{{route('manos_obra.create')}}"><i class="fa fa-plus" aria-hidden="true"></i> Nueva Especificación</a>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="manos_obra" class="table row-border table-striped table-bordered table-condensed" style="width: 100%">
                        <thead>
                            <tr>
                                <th style="width: 16%">Nombre</th>
                                <th style="width: 60%">Descripción</th>
                                <th style="width: 16%">Tipo de Mano de Obra</th>
                                <th style="width: 8%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($manos_obra as $mano_obra)
                                <tr>
                                    <td>{{$mano_obra->name}}</td>
                                    <td>{{$mano_obra->descripcion}}</td>
                                    <td>{{$mano_obra->tipo_mano_obra->descripcion}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-xs" href='{{route('manos_obra.edit', $mano_obra->id)}}' title="Editar">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-xs" href="{{route('manos_obra.destroy',$mano_obra->id)}}" data-method="delete" title="Eliminar" onclick="return confirm('¿Seguro que desea eliminar esta especificación de mano de obra?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
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

<script>
$(document).ready(function() {
    $('#manos_obra').DataTable({
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
        }
    });
});
</script>

@endsection

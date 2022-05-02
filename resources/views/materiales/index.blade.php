@extends('layout')

@section('title')
Materiales
@endsection

@section('import_css')
 <!-- DataTables -->
 <link rel="stylesheet" href="{{URL::asset('/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
 <link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>
 <script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>
@endsection

@section('content-header')
    <h1 class="display-1">Materiales</h1>
@endsection

@section('content')

@if(session()->has('alert'))
    <script>
        alertify.alert("Error","{{ session()->get('alert') }}").set('basic', false);
    </script>
@endif

<a class="btn btn-success pull-right" style="margin-right: 10px; margin-bottom: 10px;" href="{{route('materiales.create')}}"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo Material</a>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="materiales" class="table table-bordered table-striped" style="width: 100%">
                    <thead>
                    <tr>
                        <th style="width: 60%">Descripción</th>
                        <th style="width: 30%">Unidad de medida</th>
                        <th style="width: 10%"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($materiales as $material)
                            <tr>
                                <td>{{$material->descripcion}}</td>
                                <td>{{$material->unidad->descripcion}}</td>
                                <td class="text-center">
                                    <a class="btn btn-primary btn-xs" href='{{route('materiales.edit', $material->id)}}' title="Editar">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a class="btn btn-danger btn-xs" href="{{route('materiales.destroy',$material->id)}}" data-method="delete" title="Eliminar" onclick="return confirm('¿Seguro que desea eliminar este material?')">
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
    $('#materiales').DataTable({
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

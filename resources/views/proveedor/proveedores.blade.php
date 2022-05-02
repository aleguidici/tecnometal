@extends('layout')

@section('title')
Proveedores
@endsection

@section('import_css')
 <!-- DataTables -->
 <link rel="stylesheet" href="{{URL::asset('/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
 <link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>
 <script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>
@endsection

@section('content-header')
    <h1 class="display-1">Proveedores</h1>
@endsection

@section('content')

@if(session()->has('alert'))
    <script>
        alertify.alert("Error","{{ session()->get('alert') }}").set('basic', false);
    </script>
@endif

<a class="btn btn-success pull-right" style="margin-right: 10px; margin-bottom: 10px;" href="{{route('proveedores.create')}}"><i class="fa fa-user-plus" aria-hidden="true"></i> Crear Proveedor</a>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="proveedores" class="table row-border table-striped table-bordered table-condensed" style="width: 100%">
                        <thead>
                            <tr>
                                <th style="width: 35%">Razón Social</th>
                                <th style="width: 15%">C.U.I.L/C.U.I.T</th>
                                <th style="width: 20%">Dirección</th>
                                <th style="width: 20%">Localidad - Provincia [ País ]</th>
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proveedores as $proveedor)
                                <tr>
                                    <td>{{$proveedor->name}}</td>
                                    <td>{{$proveedor->cuil}}</td>
                                    <td>
                                        <a target="_blank" href="http://maps.google.com/maps?q={{ $proveedor->direccion.' '.$proveedor->localidad->name.' '.$proveedor->localidad->provincia->name }}">{{ $proveedor->direccion }}</a>
                                    </td>
                                    <td>{{ $proveedor->localidad->name . ' - ' . $proveedor->localidad->provincia->name . ' [ ' . $proveedor->localidad->provincia->pais->iso_alfa3 . ' ]' }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-success btn-xs" href="{{route('proveedores.show',$proveedor->id)}}" title="Ver Detalles del Proveedor">
                                            <i class="fa fa-1x fa-info-circle"></i>
                                        </a>

                                        <a class="btn btn-primary btn-xs" href='{{route('proveedores.edit', $proveedor->id)}}' title="Editar Proveedor">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-xs" href="{{route('proveedores.destroy',$proveedor->id)}}" data-method="delete" title="Eliminar Proveedor" onclick="return confirm('¿Seguro que desea eliminar este proveedor?')">
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
    $('#proveedores').DataTable({
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

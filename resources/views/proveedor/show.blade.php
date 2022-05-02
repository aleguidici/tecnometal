@extends('layout')

@section('title', 'Proveedor | ' . $proveedor->name)

@section('import_css')

<link rel="stylesheet" href="{{URL::asset('/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">

@endsection

@section('content')

    <div class="box box-info">
        <div class="box-header with-border">
            <i class="fa fa-user"></i><h1 class="box-title">Tecnometal - Ver Proveedor</h1>
            <br>{{ $proveedor -> name }}
        </div>
        <div class="box-body">
            <dl class="dl-horizontal">
                <dt>Dirección</dt>
                <dd>
                    <a target="_blank" href="http://maps.google.com/maps?q={{ $proveedor->direccion.' '.$proveedor->localidad->name.' '.$proveedor->localidad->provincia->name }}">{{ $proveedor->direccion }}</a> - {{ $proveedor -> localidad -> name }}, {{ $proveedor -> localidad -> provincia -> name }} - {{ $proveedor -> localidad -> provincia -> pais -> name }} [C.P.: {{$proveedor -> localidad ->codigo_postal}}]
                </dd>
                <br>
                <dt>CUIL/CUIT</dt>
                <dd>{{ $proveedor->cuil }}</dd>
                <br>
                <dt>Condición IVA</dt>
                <dd>{{ $proveedor->condicion_iva }}</dd>
                <br>
                <dt>Ingresos Brutos</dt>
                @if ($proveedor->ingresos_brutos)
                    <dd>Con Ingresos Brutos.</dd>
                @else
                    <dd>Sin Ingresos Brutos.</dd>
                @endif
            </dl>
            <hr>
            <h3>Contactos</h3>
            <div class="table-responsive">
                <table id="contactos_proveedores" class="table row-border table-striped table-bordered table-condensed" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 50%">Nombre o Alias</th>
                            <th style="width: 25%">Email</th>
                            <th style="width: 25%">Telefono</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proveedor->contactos as $contacto)
                            <tr>
                                <td>{{ $contacto->name }}</td>
                                <td>{{ $contacto->email }}</td>
                                <td>{{ $contacto->telefono }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <div class="box-footer">
            <div class="pull-right">
                <a href="{{route('proveedores.index')}}" class="btn btn-sm btn-primary" data-toggle="tooltip">Volver</a>
            </div>
        </div>
        <!-- /.box-body -->
    </div>

@endsection

@section('imports_js')

<!-- DataTables -->
<script src="{{URL::asset('/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

<script>

$(document).ready(function() {
    $('#contactos_proveedores').DataTable({
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

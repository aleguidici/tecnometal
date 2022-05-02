@extends('layout')

@section('title', 'Clientes')


@section('content-header')
    <h1 class="display-1">Clientes</h1>
@endsection

@section('import_css')
<link rel="stylesheet" href="{{URL::asset('/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
<link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>
<script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>
@endsection

@section('content')
    @if(session()->has('alert'))
        <script>
            alertify.alert("Error","{{ session()->get('alert') }}").set('basic', false);
        </script>
    @endif

    <a href="{{route('clientes.create')}}" class="btn btn-success pull-right" style="margin-right: 10px; margin-bottom:10px;"  title="Nuevo Cliente" data-toggle="tooltip">
        <i class="fa fa-user-plus" aria-hidden="true"></i> Crear Cliente
    </a>

    <br><br>

    @include('clientes.tabla_clientes')

@endsection

@section('imports_js')

<!-- DataTables -->
<script src="{{URL::asset('/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

<script>

$(document).ready(function() {
    $('#clientes').DataTable({
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

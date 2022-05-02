@extends('layout')

@section('title', 'Localidades')


@section('content-header')
    <h1 class="display-1">Localidades</h1>
@endsection

@section('import_css')

<link rel="stylesheet" href="{{URL::asset('/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">

@endsection

@section('content')
    <a href="{{route('localidades.create')}}" class="btn btn-success pull-right" style="margin-right: 10px; margin-bottom:10px;"  title="Nueva Localidad" data-toggle="tooltip">
        <i class="fa fa-map-o" aria-hidden="true"></i>&nbsp; Crear Localidad
    </a>

    @include('localidades.tabla_localidades')

@endsection

@section('imports_js')

<!-- DataTables -->
<script src="{{URL::asset('/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#localidades').DataTable({
            "aaSorting": [ [0,'asc'], [1,'asc'] ],
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

    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        alert(msg);
    }
</script>

@endsection

@extends('layout')

@section('title', 'Impuestos / Gastos')


@section('content-header')
    <h1 class="display-1">Impuestos / Gastos Preestablecidos</h1>
@endsection

@section('import_css')

<link rel="stylesheet" href="{{URL::asset('/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
<link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>

@csrf
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('content')
    {{-- <a href="{{route('localidades.create')}}" class="btn btn-success pull-right" style="margin-right: 10px; margin-bottom:10px;"  title="Nueva Localidad" data-toggle="tooltip">
        <i class="fa fa-map-o" aria-hidden="true"></i>&nbsp; Crear Localidad
    </a> --}}
    @include('gastos_preest.tabla_gastos_preest')

@endsection

@section('imports_js')

<!-- DataTables -->
<script src="{{URL::asset('/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>
<script src="{{URL::asset('/js/own_functions.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#gastos_preest').DataTable({
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

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    function editar_valor(idGasto, descripcion, valor){
        $('#idGasto_modal').text(idGasto);
        $('#descripGasto_modal').text(descripcion);
        $('#valorGasto_modal').val(valor*100);
    }

    $(document).ready(function(){
    /*    $('#guardarValor').click(function(){
            valor = $('#valorGasto_modal').val();
            idGasto = $('#idGasto_modal').text();

            if (valor){
                cadena = 'valor='+valor;
                $.ajax({
                    type:"POST",
                    url:'{{URL::asset("/gastos_preest/'+idGasto+'")}}',
                    headers: {'X-CSRF-TOKEN': $('meta[valor="csrf-token"]').attr('content')},
                    data:cadena,
                    success:function(r){
                        alertify.success("Valor editado.")
                    },
                    error:function(r){
                        alertify.error("Error.");
                    },
                });
            }else{
                alertify.warning('El valor no debe quedar vacío');
            }
        });*/

        $('#crearGasto').click(function(){
            var desc = $('#desc_gasto').val();
            var perc = $('#valor').val();

            if (desc != "" && perc != ""){
                cadena = "desc="+desc+'&perc='+perc;
                $.ajax({
                    type:"POST",
                    url:"{{URL::asset('/gastos_preest/store')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:cadena,
                    success:function(r){
                        alertify.success("Gasto Preestablecido Creado.");
                        location.reload();
                    },
                    error:function(r){
                        alertify.error("Error al crear el Gasto Preestablecidos.");
                    },
                });
            }else{
                alertify.error("Debe completar todos los campos.")
            }
            $('#desc_gasto').val("");
            $('#valor').val("");
        });

        $('#close-create-gasto-prest').click(function(){
            $('#desc_gasto').val("");
            $('#valor').val("");
        });
    });
</script>

@endsection

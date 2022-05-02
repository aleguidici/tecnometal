@extends('layout')

<!-- Título de la pag web y la sección-->
@section('title')
Crear Detalles del Item
@endsection

<!-- Contenido Css Esxtra -->

@section('import_css')
    <link rel="stylesheet" href="{{URL::asset('/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/css/datepicker3_1.3.0.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>
    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        #um_material {
            display:inline-block;
            vertical-align: bottom;
            float: none;
        }
    </style>
@endsection

<!-- Contenido Principal-->
@section('content')
<body>
    <div class="row">
        <div class="col-xs-12">

            <div class="row">
                <div class="col-md-12" style="margin-bottom: 1em;">
                    <a href="{{route('presupuestos.items',$presupuesto->id)}}" class="btn btn-primary">Volver a Items del Presupuesto</a>
                    <div class="pull-right">
                        <a href="#impuestosModal" class="btn btn-success open-impuestosModal @if ($presupuesto->estado_presupuesto->id != 5) disabled @endif" data-toggle="modal"><i class="fa fa-calculator"></i> &nbsp; Impuestos del Item</a>
                    </div>
                </div>
            </div>

            <div class="box box-info">
                <div class="box-header with-border">
                    <h1 class="box-title">Crear Detalles del Item </h1>
                    @if ($presupuesto->estado_presupuesto_id != 5)
                        <h1 class="box-title pull-right">Presupuesto N° {{substr(sprintf('%05d', $presupuesto->id), -5).'/'.substr(sprintf('%02d', $presupuesto->id), 0, -5)}}</h1>
                    @endif
                </div>
                <div class='box-body'>
                    <ul class="nav nav-tabs border-0" id="myTab">
                        <li class="nav-item">
                            <a class="nav-link active border border-primary border-bottom-0" data-toggle="tab" href="#menu1">Resumen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu2">Estándares <i style="color:rgb(92, 92, 92)" id="cant_estandares"> (0)</i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu3">Materiales <i style="color:rgb(92, 92, 92)" id="cant_materiales"> (0)</i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu4">Mano de Obra <i style="color:rgb(92, 92, 92)" id="cant_manosObra"> (0)</i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu5">Reventa <i style="color:rgb(92, 92, 92)" id="cant_reventa"> (0)</i></a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Solapa de Resumen -->
                        <div id="menu1" class="tab-pane active">
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-11">
                                    <h5><b>Resumen de costos del item:</b></h5>
                                </div>

                                <div class="col-md-1"></div>
                                <div class="col-md-5">
                                    <div class="box box-default box-solid">
                                        <div class="box-header with-border">
                                            <b>Resumen Materiales </b>
                                        </div>
                                        <div class="box-body">
                                            <fieldset class="form-group col-xs-4">
                                                <input class="form-control" style="border: none;background-color: transparent; color:rgb(92, 92, 92); font-size: 20px;" readonly value="{{$presupuesto->moneda_materiales->signo}} ">
                                            </fieldset>
                                            <fieldset class="form-group col-xs-8">
                                                <input class="form-control text-right" style="border: none;background-color: transparent; color:rgb(92, 92, 92); font-size: 20px;" id="total_materiales_resumen" readonly value="0.00">
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="box box-default box-solid">
                                        <div class="box-header with-border">
                                            <b>Resumen Materiales de Reventa </b>
                                        </div>
                                        <div class="box-body">
                                            <fieldset class="form-group col-xs-4">
                                                <input class="form-control" style="border: none;background-color: transparent; color:rgb(92, 92, 92); font-size: 20px;" readonly value="{{$presupuesto->moneda_materiales->signo}} ">
                                            </fieldset>
                                            <fieldset class="form-group col-xs-8">
                                                <input class="form-control text-right" style="border: none;background-color: transparent; color:rgb(92, 92, 92); font-size: 20px;" id="total_matsReventa_resumen" readonly value="0.00">
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>

                            <br>
                            </div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="box box-default box-solid">
                                        <div class="box-header with-border">
                                            <b>Resumen Manos de Obra</b>
                                        </div>
                                        <div class="box-body">
                                            <fieldset class="form-group col-xs-4">
                                                <input class="form-control" style="border: none;background-color: transparent; color:rgb(92, 92, 92); font-size: 20px;" readonly value="{{$presupuesto->moneda_manos_obra->signo}} ">
                                            </fieldset>
                                            <fieldset class="form-group col-xs-8">
                                                <input class="form-control text-right" style="border: none;background-color: transparent; color:rgb(92, 92, 92); font-size: 20px;" id="total_manosObra_resumen" readonly value="0.00">
                                            </fieldset>
                                            <br>
                                            <fieldset class="form-group col-xs-6">
                                                <input class="form-control" style="border: none;background-color: transparent; color:rgb(92, 92, 92); font-size: 20px;" readonly value="Duración Estimada.">
                                            </fieldset>
                                            <fieldset class="form-group col-xs-6">
                                                <input class="form-control text-right" style="border: none;background-color: transparent; color:rgb(92, 92, 92); font-size: 20px;" id="total_horas_manosObra_resumen" readonly value="0.00">
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>

                        {{-- 2° tab --}}
                        @include ("presupuestos.tabs.create_item_detalles_estandares")

                        {{-- 3° tab --}}
                        @include ("presupuestos.tabs.create_item_detalles_materiales")

                        {{-- 4° tab --}}
                        @include ("presupuestos.tabs.create_item_detalles_manosObra")

                        {{-- 5° tab --}}
                        @include ("presupuestos.tabs.create_item_detalles_reventa")
                    </div>

                    <div class="box-footer">
                        <div class="form-group">
                            <a href="{{route('presupuestos.items',$presupuesto->id)}}" class="btn btn-primary">Volver a Items del Presupuesto</a>
                        </div>
                        <!-- box footer -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>



<!-- Modal Impuestos-->

<div class="modal" id="impuestosModal" tabindex="-1" role="dialog" aria-labelledby="impuestosModal" data-backdrop="static"  data-keyboard="false" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" style="color:rgb(0, 0, 0);">Impuestos asociados al item</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="item_id_imp" value="{{$item->id}}">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Ingresos Brutos:</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                    <input class="form-control" value="{{number_format((float)$item->gastos[0]->percentage*100,2,'.','')}}" id="iibb_perc" type="text" onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">
                                        <div class="input-group-addon">
                                            <i class="fa fa-percent"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>Gastos Generales:</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input class="form-control" id="gastos_grales" value="{{number_format((float)$item->gastos[1]->percentage*100,2,'.','')}}" type="text" onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">
                                        <div class="input-group-addon">
                                            <i class="fa fa-percent"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>Impuesto a la Ganancia:</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input class="form-control" id="impuesto_ganancia" value="{{number_format((float)$item->gastos[5]->percentage*100,2,'.','')}}" type="text" onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">
                                        <div class="input-group-addon">
                                            <i class="fa fa-percent"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>Impuesto al Cheque:</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input class="form-control" id="impuesto_cheque" value="{{number_format((float)$item->gastos[6]->percentage*100,2,'.','')}}" type="text" onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">
                                        <div class="input-group-addon">
                                            <i class="fa fa-percent"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="box box-danger">
                                <div class="box-header">
                                    <h1 class="box-title">Valores de Flete</h1><br>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Flete de Materiales:</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-dollar"></i>
                                                </div>
                                                <input class="form-control" id="flete" value="{{number_format((float)$item->gastos[2]->monto,2,'.','')}}" type="text" onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Flete de Materiales de Reventa:</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-dollar"></i>
                                                </div>
                                                <input class="form-control" id="flete_rev_act" value="{{number_format((float)$item->gastos[7]->monto,2,'.','')}}" type="text" onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <div class="box box-success">
                                <div class="box-header">
                                    <h1 class="box-title">Valores de Flete</h1><br>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Beneficio de Materiales (En {{$presupuesto->moneda_materiales->descripcion}}):&nbsp; <a href="#" data-toggle="tooltip" data-html="true" title="Se puede especificar un monto fijo o un porcentaje" data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group">

                                                <input class="form-control" id="beneficio_mat_perc" value="@if(!$item->gastos[3]->es_monto){{number_format((float)$item->gastos[3]->percentage*100,2,'.','')}} @endif" type="text" onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-percent"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-dollar"></i>
                                                </div>
                                                <input class="form-control" id="beneficio_mat_monto" value="@if($item->gastos[3]->es_monto){{number_format((float)$item->gastos[3]->monto,2,'.','')}} @endif" type="text" onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">

                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Beneficio de Materiales de Reventa (En {{$presupuesto->moneda_materiales->descripcion}}):&nbsp; <a href="#" data-toggle="tooltip" data-html="true" title="Se puede especificar un monto fijo o un porcentaje" data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group">

                                                <input class="form-control" id="beneficio_rev_perc" value="@if(!$item->gastos[8]->es_monto){{number_format((float)$item->gastos[8]->percentage*100,2,'.','')}} @endif" type="text" onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-percent"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-dollar"></i>
                                                </div>
                                                <input class="form-control" id="beneficio_rev_monto" value="@if($item->gastos[8]->es_monto){{number_format((float)$item->gastos[8]->monto,2,'.','')}} @endif" type="text" onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">

                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Beneficio de Mano de Obra (En {{$presupuesto->moneda_manos_obra->descripcion}}):&nbsp; <a href="#" data-toggle="tooltip" data-html="true" title="Se puede especificar un monto fijo o un porcentaje" data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <input class="form-control" id="beneficio_mo_perc" value="@if(!$item->gastos[4]->es_monto){{number_format((float)$item->gastos[4]->percentage*100,2,'.','')}}@endif" type="text" onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-percent"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-dollar"></i>
                                                </div>
                                                <input class="form-control" id="beneficio_mo_monto" value="@if($item->gastos[4]->es_monto) {{number_format((float)$item->gastos[4]->monto,2,'.','')}} @endif" type="text" onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" id="actualizarImpuestos" class="btn btn-success pull-right" data-dismiss="modal">Actualizar Impuestos</button>
                            <button type="button" class="btn btn-danger" id="cancelar-editarImpuestos" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fin Modal Impuestos -->

@endsection

@section('imports_js')
    <script src="{{URL::asset('/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('/js/bootstrap-select.min.js')}}"></script>
    <script src="{{URL::asset('/js/bootstrap-datepicker_1.3.0.js')}}"></script>
    <script>
        // global app configuration object
        var config = {
            routes: {
                alta_materiales: "{{route('item.material.store')}}",
                alta_mo: "{{route('item.mano_obra.store')}}",
                update_pu_mat: "{{route('item.material.update_pu')}}",
                update_pu_mo: "{{route('item.mano_obra.update_pu')}}",
            },
            item: '{{$item->id}}',
            moneda_materiales: '{{$presupuesto->moneda_materiales->id}}',
            moneda_mo: '{{$presupuesto->moneda_manos_obra->id}}',
            proveedores: '{!!$proveedores!!}',
            impuestos:{
                iibb: "{{$item->gastos[0]->percentage}}",
                gastos_generales: "{{$item->gastos[1]->percentage}}",
                ganancias: "{{$item->gastos[5]->percentage}}",
                cheque: "{{$item->gastos[6]->percentage}}",
                flete: "{{$item->gastos[2]->monto}}",
                flete_rev: "{{$item->gastos[7]->monto}}",
                ben_mat_es_monto: "{{$item->gastos[3]->es_monto}}",
                ben_mat_per: "{{$item->gastos[3]->percentage}}",
                ben_mat_monto: "{{$item->gastos[3]->monto}}",
                ben_mo_es_monto: "{{$item->gastos[4]->es_monto}}",
                ben_mo_per: "{{$item->gastos[4]->percentage}}",
                ben_mo_monto: "{{$item->gastos[4]->monto}}",
                ben_rev_es_monto: "{{$item->gastos[8]->es_monto}}",
                ben_rev_per: "{{$item->gastos[8]->percentage}}",
                ben_rev_monto: "{{$item->gastos[8]->monto}}",
            },
        };
    </script>
    <script src="{{URL::asset('/js/own_functions.js')}}"></script>
    <script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>
    {{-- <script src="{{URL::asset('/js/moment-with-locales.js')}}"></script> --}} {{-- https://momentjs.com/downloads/moment-with-locales.js --}}

    {{-- https://momentjs.com/ --}}
    <script>
        //Permite la correcta carga de las columnas de los dataTable a traves de los TABS
        $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
            $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
        } );

        function isFloat(n){
            return Number(n) === n && n % 1 !== 0;
        }

        window.onbeforeunload = function(e) {
            document.activeElement.blur();
        };

        $(document).ready(function() {

            $('#tabla_estandares').DataTable({
                bAutoWidth: false,
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

            $('#tabla_materiales').DataTable({
                bAutoWidth: false,
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

            $('#tabla_manosObra').DataTable({
                bAutoWidth: false,
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

            $('#tabla_matsReventa').DataTable({
                bAutoWidth: false,
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

            var table_mat = $("#tabla_materiales").DataTable();
            var table_mo = $("#tabla_manosObra").DataTable();
            var table_est = $("#tabla_estandares").DataTable();
            var table_matReventa = $("#tabla_matsReventa").DataTable();
            document.getElementById("cant_materiales").innerHTML = "("+table_mat.rows().count()+")";
            document.getElementById("cant_manosObra").innerHTML = "("+table_mo.rows().count()+")";
            document.getElementById("cant_estandares").innerHTML = "("+table_est.rows().count()+")";
            document.getElementById("cant_reventa").innerHTML = "("+table_matReventa.rows().count()+")";

            actualizar_total_materiales();
            actualizar_total_manoObra();
            actualizar_total_matsReventa();

            //boton add estandar
            $('#btn_add_estandar').click(function(){
                var ban = 0;
                var cont = 0;
                estandar_cant = $('#cant_unEstandar').val();
                estandar = JSON.parse($('#estandares_select_picker').val());

                var table = $("#tabla_estandares").DataTable();

                table.rows().every(function() {
                    if(this.data()[0] == estandar["id"]){
                        //Actualizar Estandar existente
                        ban = 1;
                        actualizar_estandar_existente(this,estandar_cant,cont,this.data()['5']);
                    }
                    cont++;
                });

                if (!ban){
                    create_ap_item(estandar,estandar_cant);
                }

                $('#estandares_select_picker').val(0);
                $('#estandares_select_picker').selectpicker('refresh');
                $('#cant_unEstandar').val(1);
                document.getElementById("btn_add_estandar").disabled = true;

            });

            function actualizar_estandar_existente(row,cantidad,cont,ap_item_id)
            {
                var cantidad_nueva = parseInt(row.column(3).nodes()[cont]['childNodes'][0].value)+parseInt(cantidad)
                var cadena = 'ap_item_id='+ap_item_id+'&cantidad='+cantidad_nueva;

                $.ajax({
                    method:"POST",
                    url:"{{route('item.ap_item.update_amount')}}",
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:cadena,
                    success:function(r){
                        alertify.success("Estándar actualizado.");

                        row.column(3).nodes()[cont].innerHTML = '<input class="form-control" style="border: none; background-color: transparent; width:70%;" name="ap_cant['+r.ap_item["actividad_preestablecida"]["id"]+']" value="'+r.ap_item["cantidad"]+'" readonly> <a href="#" id="editarCantidadEstandar" class="btn btn-primary btn-xs" title="Editar Cantidad Estándar" data-toggle="modal" data-target="#modal_editCantEstandar" onclick="editar_cantEstandar('+r.ap_item["id"]+', '+r.ap_item["cantidad"]+')"><i class="fa fa-edit" aria-hidden="true "></i></a>';

                        add_estandar_materiales_y_manoObra(r.ap_item,cantidad);
                    },
                    error:function(r){
                        alertify.error("Error al actualizar el estándar.")
                    }
                });
            }

            function create_ap_item(estandar,estandar_cant)
            {
                var cadena = "ap_id="+estandar["id"]+"&item_id={{$item->id}}&cantidad="+estandar_cant;

                $.ajax({
                    method:"POST",
                    url:"{{route('item.ap_item.store')}}",
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    data:cadena,
                    success:function(r){
                        alertify.success("Estándar relacionado con éxito con el item.");
                        //add_estandar_tabla(r.ap_item);
                        add_estandar_materiales_y_manoObra(r.ap_item,0);
                        location.reload();
                    },
                    error:function(r){
                        alertify.error("No se pudo relacionar al estándar con el item.");
                    }
                });
            }

            /*function add_estandar_tabla(ap_item)
            {

                var table = $("#tabla_estandares").DataTable();
                var materiales = new Array();
                ap_item["actividad_preestablecida"]["a_p_materiales"].forEach(ap => {
                    materiales.push(ap["material"]);
                });

                console.log (ap_item["id"]);
                console.log (ap_item["actividad_preestablecida"]["a_p_materiales"]);
                console.log (materiales);

                //Esto fue para pruebas nomas
                var ap_mt = JSON.stringify(ap_item["actividad_preestablecida"]["a_p_materiales"]);
                //console.log(ap_mt);
                var mats = JSON.stringify(materiales);
                console.log(JSON.stringify(mats));
                //Esto fue para pruebas nomas

                //Alta en tabla
                table.row.add([
                    ap_item["actividad_preestablecida"]["id"],
                    ap_item["actividad_preestablecida"]["titulo"]+" - "+ap_item["actividad_preestablecida"]["descripcion"],

                    //acá mati
                    '<div class="text-center"><a href="#" class="btn button btn-info btn-xs" title="Ver lista de materiales" data-toggle="modal" data-target="#modal_verListaMats" onclick="ver_listaMats2('+ap_item["id"]+', \''+ap_mt+'\', \''+mats+'\')"><span class="glyphicon glyphicon-list-alt"></span></a></div>',
                    //acá mati

                    '<input class="form-control" style="border: none; background-color: transparent; width:70%;" name="ap_cant['+ap_item["actividad_preestablecida"]["id"]+']" value="'+ap_item["cantidad"]+'" readonly> <a href="#" id="editarCantidadEstandar" class="btn btn-primary btn-xs" title="Editar Cantidad Estándar" data-toggle="modal" data-target="#modal_editCantEstandar" onclick="editar_cantEstandar('+ap_item["id"]+', '+ap_item["cantidad"]+')"><i class="fa fa-edit" aria-hidden="true "></i></a>',
                    '<div class="text-center"><a href="#" class="delete btn button btn-danger btn-xs" title="Delete" data-toggle="tooltip" onclick="delete_estandar('+ap_item["id"]+');"><span class="glyphicon glyphicon-trash"></span></a></div>',
                    ap_item['id']
                ]).draw(false);
                table.columns(0).visible(false);
                table.column(5).visible(false);
                document.getElementById("cant_estandares").innerHTML = "("+table.rows().count()+")";

                //llamada a metodo creador de materiales y manos de obra
                add_estandar_materiales_y_manoObra(ap_item,0); //Se pasa 0 porque se trata de una creación
            }*/

            //boton add material
            $('#btn_add_material').click(function(){
                material_cant = parseFloat($('#cant_unMaterial').val()).toFixed(2);

                if (!isNaN(material_cant) && material_cant>0){
                    var ban = 0;
                    var cont = 0;
                    material = JSON.parse($('#materiales_select_picker').val());

                    var table = $("#tabla_materiales").DataTable();

                    table.rows().every(function() {
                        if(this.data()[0] == material["id"]){
                            //Actualizar Material Existente
                            ban = 1;
                            item_materia_id = this.data()[10];
                            actualizar_material_existente(this,material_cant,cont,item_materia_id);
                            //this.column(3).nodes()[cont]['childNodes'][0].value=(parseFloat(this.column(3).nodes()[cont]['childNodes'][0].value)+parseFloat(material_cant)).toFixed(2);
                            //precio_unit_material_change(this.column(0).nodes()[cont]['childNodes'][0]["data"]);
                        }
                        cont++;
                    });

                    if (!ban){
                        save_material_extra(material,material_cant);
                    }

                    $('#materiales_select_picker').val(0);
                    $('#materiales_select_picker').selectpicker('refresh');
                    $('#cant_unMaterial').val(1.00);
                    document.getElementById("btn_add_material").disabled = true;
                    document.getElementById("um_material").value = "";
                    actualizar_total_materiales();
                } else {
                    alertify.alert("Error","Debe ingresar una cantidad válida, mayor a 0").set('basic', false);
                }
            });

            function actualizar_material_existente(row,cantidad,cont,item_material_id){
                var cant_nueva = (parseFloat(row.column(3).nodes()[cont]['childNodes'][0].value)+parseFloat(cantidad)).toFixed(2);

                var cadena = "id_item_mat="+item_material_id+"&cantidad="+cant_nueva;

                $.ajax({
                    method:"POST",
                    url:"{{route('item.material.update_amount')}}",
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    data:cadena,
                    success:function(r){
                        alertify.success("Detalle de material actualizado.")
                        row.column(3).nodes()[cont]['childNodes'][0].value=cant_nueva;
                        precio_unit_material_change(row.column(0).nodes()[cont]['childNodes'][0]["data"], item_material_id, r.item["iibb"], r.item["gastos_generales"]);
                    },
                    error:function(r){
                        alertify.error("Error al actualizar el detalle de material.")
                    }
                });
            }

            function save_material_extra(material,cant){
                var cadena = "cant="+cant+'&pu='+0.00+'&marca='+null+'&codigo='+null+'&item={{$item->id}}&mat_id='+material['id']+'&moneda_id={{$presupuesto->moneda_materiales->id}}'+'&reventa='+0;
                $.ajax({
                    method:"POST",
                    url: '{{route("item.material.store")}}',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    data:cadena,
                    success:function(r){
                        add_material_to_table(r.item);
                    },
                    error:function(r){
                        alertify.error('Error al agregar detalle a la base de datos')
                    }
                });
            }

            function add_material_to_table(item)
            {
                var table = $("#tabla_materiales").DataTable();
                var descrip_mat = item["material"]["descripcion"];
                table.row.add([
                    item["material"]["id"],
                    item["material"]["descripcion"]+'&nbsp&nbsp&nbsp<a href="#" id="editarMaterial" class="btn btn-primary btn-xs" title="Editar Datos Material" data-toggle="modal" data-target="#modal_editDatosMaterial" onclick="editar_datosMaterial('+item["id"]+','+item["marca"]+','+item["codigo"]+');"><i class="fa fa-edit" aria-hidden="true "></i> Marca / Modelo</a>',
                    '<input class="form-control" style="border: none;background-color: transparent; width:100%;" id="estandar_mat_cant['+item["material"]["id"]+']" value="0.00" readonly>',
                    '<input class="form-control" style="border: none;background-color: transparent; width:70%;" id="extra_mat_cant['+item["material"]["id"]+']" value="'+item["cantidad"]+'" readonly> <a href="#" id="editarCantidadMatReventa" class="btn btn-primary btn-xs" title="Editar Cantidad Extra Material" data-toggle="modal" data-target="#modal_editCantExtraMaterial" onclick="editar_cantExtraMaterial('+item["id"]+', '+item["cantidad"]+')"><i class="fa fa-edit" aria-hidden="true "></i></a>',
                    item["material"]["unidad"]["descripcion"],
                    '<input class="form-control" style="width:100%;" id="precio_unit_mat['+item["material"]["id"]+']" value="0.00" onkeypress="return validateFloat(event)" onpaste="return false" onkeyup="javascript:precio_unit_material_change('+item["material"]["id"]+','+item["id"]+', '+item["iibb"]+', '+item["gastos_generales"]+')" onfocusout="javascript:actualizar_material_bd('+item["id"]+',this.value)">',
                    '<input class="form-control" style="border: none;background-color: transparent; width:100%;" id="subtot_material['+item["material"]["id"]+']" value="0.00" readonly>',
                    '<a href="#" id="editarReferencia" class="btn btn-primary btn-xs" title="Editar Referencia Material" data-toggle="modal" data-target="#modal_editReferencia" onclick="editar_referenciaMaterial('+item["id"]+', '+item["presupuesto_proveedor"]+', '+item["iibb"]+', '+item["gastos_generales"]+', '+item["persona_id"]+');"><i class="fa fa-edit" aria-hidden="true "></i> Ref.</a>',
                    '<input class="form-control" style="border: none;background-color: transparent; width:100%;" id="subtot_conImpuestos['+item["material"]["id"]+']" value="0.00" readonly data-iibb="'+item["iibb"]+'" data-gast_gen="'+item["gastos_generales"]+'">',
                    '<div class="text-center"><a href="#" class="delete btn button btn-danger btn-xs text-center" title="Delete" data-toggle="tooltip" onclick="delete_item_material('+item["id"]+',0)"><span class="glyphicon glyphicon-trash"></span></a></div>',
                    item["id"],
                ]).draw(false);
                table.columns(0).visible(false);
                table.columns(10).visible(false);
                document.getElementById("cant_materiales").innerHTML = "("+table.rows().count()+")";
            }

            //boton add mano Obra
            $('#btn_add_manoObra').click(function(){
                manosObra_cant = parseFloat($('#cant_hsManoObra').val()).toFixed(2);

                if (!isNaN(manosObra_cant) && manosObra_cant>0){
                    var ban = 0;
                    var cont = 0;
                    mano_obra = JSON.parse($('#manosObra_select_picker').val());

                    var table = $("#tabla_manosObra").DataTable();

                    table.rows().every(function() {
                        if(this.data()[0] == mano_obra["id"]){
                            //Actualizar Mano de Obra
                            ban = 1;
                            id_item_mo = this.data()[7]
                            actualizar_mano_obra_existente(this,manosObra_cant,cont,id_item_mo);
                            //this.column(3).nodes()[cont]['childNodes'][0].value = (parseFloat(this.column(3).nodes()[cont]['childNodes'][0].value)+parseFloat(manosObra_cant)).toFixed(2);

                            precio_unit_manoObra_change(this.column(0).nodes()[cont]['childNodes'][0]["data"],id_item_mo);
                        }
                        cont++;
                    });

                    if (!ban){
                        save_mano_obra_extra(mano_obra,manosObra_cant);
                    }

                    $('#manosObra_select_picker').val(0);
                    $('#manosObra_select_picker').selectpicker('refresh');
                    $('#cant_hsManoObra').val(1.00);
                    document.getElementById("btn_add_manoObra").disabled = true;
                } else {
                    alertify.alert("Error","Debe ingresar una cantidad válida, mayor a 0").set('basic', false);
                }
            });

            //boton add reventa
            $('#btn_add_matReventa').click(function(){
                material_cant = parseFloat($('#cant_unMatReventa').val()).toFixed(2);

                if (!isNaN(material_cant) && material_cant>0){
                    var ban = 0;
                    var cont = 0;
                    material = JSON.parse($('#matsReventa_select_picker').val());

                    var table = $("#tabla_matsReventa").DataTable();

                    table.rows().every(function() {
                        if(this.data()[0] == material["id"]){
                            //Actualizar Material Existente
                            ban = 1;
                            item_materia_id = this.data()[9];
                            actualizar_matReventa_existente(this,material_cant,cont,item_materia_id);
                            //this.column(3).nodes()[cont]['childNodes'][0].value=(parseFloat(this.column(3).nodes()[cont]['childNodes'][0].value)+parseFloat(material_cant)).toFixed(2);
                            //precio_unit_material_change(this.column(0).nodes()[cont]['childNodes'][0]["data"]);
                        }
                        cont++;
                    });

                    if (!ban){
                        save_matReventa(material,material_cant);
                    }

                    $('#matsReventa_select_picker').val(0);
                    $('#matsReventa_select_picker').selectpicker('refresh');
                    $('#cant_unMatReventa').val(1.00);
                    document.getElementById("btn_add_matReventa").disabled = true;
                    document.getElementById("um_matReventa").value = "";
                    actualizar_total_matsReventa();
                } else {
                    alertify.alert("Error","Debe ingresar una cantidad válida, mayor a 0").set('basic', false);
                }
            });

            function actualizar_matReventa_existente(row,cantidad,cont,item_material_id){
                var cant_nueva = (parseFloat(row.column(2).nodes()[cont]['childNodes'][0].value)+parseFloat(cantidad)).toFixed(2);

                var cadena = "id_item_mat="+item_material_id+"&cantidad="+cant_nueva;

                $.ajax({
                    method:"POST",
                    url:"{{route('item.material.update_amount')}}",
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    data:cadena,
                    success:function(r){
                        alertify.success("Detalle de material para Reventa actualizado.")
                        row.column(2).nodes()[cont]['childNodes'][0].value=cant_nueva;
                        precio_unit_material_change(row.column(0).nodes()[cont]['childNodes'][0]["data"], item_material_id, r.item["iibb"], r.item["gastos_generales"]);
                    },
                    error:function(r){
                        alertify.error("Error al actualizar el detalle de material.")
                    }
                });
            }

            function save_matReventa(material,cant){
                var cadena = "cant="+cant+'&pu='+0.00+'&marca='+null+'&codigo='+null+'&item={{$item->id}}&mat_id='+material['id']+'&moneda_id={{$presupuesto->moneda_materiales->id}}'+'&reventa='+1;
                $.ajax({
                    method:"POST",
                    url: '{{route("item.material.store")}}',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    data:cadena,
                    success:function(r){
                        add_matReventa_to_table(r.item);
                    },
                    error:function(r){
                        alertify.error('Error al agregar detalle a la base de datos')
                    }
                });
            }

            function add_matReventa_to_table(item)
            {
                var table = $("#tabla_matsReventa").DataTable();
                var descrip_mat = item["material"]["descripcion"];
                table.row.add([
                    item["material"]["id"],
                    item["material"]["descripcion"]+'&nbsp&nbsp&nbsp<a href="#" id="editarMatReventa" class="btn btn-primary btn-xs" title="Editar Datos Material" data-toggle="modal" data-target="#modal_editDatosMatReventa" onclick="editar_datosMatReventa('+item["id"]+','+item["marca"]+','+item["codigo"]+');"><i class="fa fa-edit" aria-hidden="true "></i> Marca / Modelo</a>',
                    '<input class="form-control" style="border: none;background-color: transparent; width:70%;" id="reventa_cant['+item["material"]["id"]+']" value="'+item["cantidad"]+'" readonly> <a href="#" id="editarCantidadMatReventa" class="btn btn-primary btn-xs" title="Editar Cantidad Extra Material" data-toggle="modal" data-target="#modal_editCantReventa" onclick="editar_cantExtraMatReventa('+item["id"]+', '+item["cantidad"]+')"><i class="fa fa-edit" aria-hidden="true "></i></a>',
                    item["material"]["unidad"]["descripcion"],
                    '<input class="form-control" style="width:100%;" id="precio_unit_matReventa['+item["material"]["id"]+']" value="0.00" onkeypress="return validateFloat(event)" onpaste="return false" onkeyup="javascript:precio_unit_matReventa_change('+item["material"]["id"]+','+item["id"]+', '+item["iibb"]+', '+item["gastos_generales"]+')" onfocusout="javascript:actualizar_material_bd('+item["id"]+',this.value)">',
                    '<input class="form-control" style="border: none;background-color: transparent; width:100%;" id="subtot_matReventa['+item["material"]["id"]+']" value="0.00" readonly>',
                    '<div class="text-center"><a href="#" id="editarReferenciaReventa" class="btn btn-primary btn-xs" title="Editar Referencia Material" data-toggle="modal" data-target="#modal_editReferenciaReventa" onclick="editar_referenciaMatReventa('+item["id"]+', '+item["presupuesto_proveedor"]+', '+item["iibb"]+', '+item["gastos_generales"]+', '+item["persona_id"]+');"><i class="fa fa-edit" aria-hidden="true "></i> Ref.</a>',
                    '<input class="form-control" style="border: none;background-color: transparent; width:100%;" id="subtot_conImpuestosReventa['+item["material"]["id"]+']" value="0.00" readonly data-iibb="'+item["iibb"]+'" data-gast_gen="'+item["gastos_generales"]+'">',
                    '<div class="text-center"><a href="#" class="delete btn button btn-danger btn-xs text-center" title="Delete" data-toggle="tooltip" onclick="delete_item_matReventa('+item["id"]+',0)"><span class="glyphicon glyphicon-trash"></span></a></div>',
                    item["id"],
                ]).draw(false);
                table.columns(0).visible(false);
                table.columns(9).visible(false);
                document.getElementById("cant_reventa").innerHTML = "("+table.rows().count()+")";
            }

            //Script que permite setear como activo el tab que estaba antes de recargar la pagina
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });

            var activeTab = localStorage.getItem('activeTab');

            if(activeTab){
                $('#myTab a[href="' + activeTab + '"]').tab('show');
            }

            $('#editMarcaCodigoMat').click(function(){
                var marca = $('#marcaMaterial_edit_modal').val();
                var codigo = $('#codigoMaterial_edit_modal').val();
                var id_item = $('#id_item_marca_cod').val();

                if ((marca || codigo) && id_item){
                    cadena = "id_item_mat="+id_item+"&marca="+marca+"&codigo="+codigo;
                    $.ajax({
                        method:"POST",
                        url: "{{route('item.material.update_marca_codigo')}}",
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:cadena,
                        success:function(r){
                            alertify.success("Datos actualizados.");
                            location.reload();
                        },
                        error:function(r){
                            alertify.error("Error al actualizar datos del material.")
                        }
                    });
                }else{
                    alertify.error("No se actualizó. Debe completar al menos un campo.")
                }
            });

            $('#editMarcaCodigoMatReventa').click(function(){
                var marca = $('#marcaMatReventa_edit_modal').val();
                var codigo = $('#codigoMatReventa_edit_modal').val();
                var id_item = $('#id_item_marca_cod_reventa').val();

                if ((marca || codigo) && id_item){
                    cadena = "id_item_mat="+id_item+"&marca="+marca+"&codigo="+codigo;
                    $.ajax({
                        method:"POST",
                        url: "{{route('item.material.update_marca_codigo')}}",
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:cadena,
                        success:function(r){
                            alertify.success("Datos actualizados.");
                            location.reload();
                        },
                        error:function(r){
                            alertify.error("Error al actualizar datos del material.")
                        }
                    });
                }else{
                    alertify.error("No se actualizó. Debe completar al menos un campo.")
                }
            });

            $('#editReferenciasMaterial').click(function(){
                var prov = $('#proveedor_select_picker').val();
                var id_item = $('#id_item_ref').val();
                var iibb = isNaN($('#IIBB_edit_modal').val()) ? 0.00 : $('#IIBB_edit_modal').val();
                var gastos_grales = isNaN($('#gastosGrales_edit_modal').val()) ? 0.00 : $('#gastosGrales_edit_modal').val();
                var ref_prov = $('#nroPresupuesto_edit_modal').val();

                var cadena = "id_item_mat="+id_item+"&prov="+prov+"&iibb="+iibb+"&gastos_generales="+gastos_grales+"&ref_prov="+ref_prov;

                $.ajax({
                    method:"POST",
                    url:"{{route('item.material.update_impuestos')}}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    data:cadena,
                    success:function(r){
                        alertify.success("Datos Actualizados.");
                        location.reload();
                    },
                    error:function(r){
                        alertify.error("Error al actualizar los datos");
                    }
                })
            });

            $('#editReferenciasMatReventa').click(function(){
                var prov = $('#proveedor_select_picker_reventa').val();
                var id_item = $('#id_item_ref_reventa').val();
                var iibb = isNaN($('#IIBB_edit_modal_reventa').val()) ? 0.00 : $('#IIBB_edit_modal_reventa').val();
                var gastos_grales = isNaN($('#gastosGrales_edit_modal_reventa').val()) ? 0.00 : $('#gastosGrales_edit_modal_reventa').val();
                var ref_prov = $('#nroPresupuesto_edit_modal_reventa').val();

                var cadena = "id_item_mat="+id_item+"&prov="+prov+"&iibb="+iibb+"&gastos_generales="+gastos_grales+"&ref_prov="+ref_prov;

                $.ajax({
                    method:"POST",
                    url:"{{route('item.material.update_impuestos')}}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    data:cadena,
                    success:function(r){
                        alertify.success("Datos Actualizados.");
                        location.reload();
                    },
                    error:function(r){
                        alertify.error("Error al actualizar los datos");
                    }
                })
            });

            $("#editCantExtraMaterial").click(function(){
                var cantidad = $("#cantExtraMaterial_edit_modal").val();
                var id_item_material = $('#id_item_cantExtra').val();

                if (cantidad>=0){
                    var cadena = "id_item_mat="+id_item_material+"&cantidad="+cantidad;
                    $.ajax({
                        method:"POST",
                        url:"{{route('item.material.update_amount')}}",
                        headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:cadena,
                        success:function(r){
                            alertify.success("Cantidad extra actualiziada");
                            location.reload();
                        },
                        error:function(r){
                            alertify.error("Error al modificar la cantidad");
                        }
                    });
                }else{
                    alertify.error("Debe ingresar una cantidad mayor a 0.");
                }
            });


            $("#editCantReventa").click(function(){
                var cantidad = $("#cantReventa_edit_modal").val();
                var id_item_material = $('#id_item_cantReventa').val();

                if (cantidad>=0){
                    var cadena = "id_item_mat="+id_item_material+"&cantidad="+cantidad;
                    $.ajax({
                        method:"POST",
                        url:"{{route('item.material.update_amount')}}",
                        headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:cadena,
                        success:function(r){
                            alertify.success("Cantidad para reventa actualiziada");
                            location.reload();
                        },
                        error:function(r){
                            alertify.error("Error al modificar la cantidad");
                        }
                    });
                }else{
                    alertify.error("Debe ingresar una cantidad mayor a 0.");
                }
            });

            $('#editCantExtraManoObra').click(function(){
                var cantidad = $('#cantExtraManoObra_edit_modal').val();
                var id_item_mo = $("#id_item_mo").val();

                if (cantidad>=0){
                    var cadena = "id_item_mano_obra="+id_item_mo+"&cantidad="+cantidad*3600;

                    $.ajax({
                        method:"POST",
                        url:"{{route('item.mano_obra.update_amount')}}",
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        data:cadena,
                        success:function(r){
                            alertify.success("Cantidad actualizada.");
                            location.reload();
                        },
                        error: function(r){
                            alertify.error("Error al actualizar la cantidad.");
                        }
                    });
                }else{
                    alertify.error("Debe ingresar una duración mayor a 0.");
                }
            });

            $('#editCantEstandar').click(function(){
                var cantidad = $('#cantEstandar_edit_modal').val();
                var id_ap_item = $('#id_ap_item').val();

                if (cantidad > 0){
                    cadena = "ap_item_id="+id_ap_item+"&cantidad="+cantidad;

                    $.ajax({
                        method:"POST",
                        url:"{{route('item.ap_item.update_amount')}}",
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        data:cadena,
                        success:function(r){
                            alertify.success("Cantidad actualizada.");
                            location.reload();
                        },
                        error: function(r){
                            alertify.error("Error al actualizar la cantidad.");
                        }
                    });
                }else{
                    alertify.error('La cantidad ingresada debe ser mayor a 0.')
                }
            });


            $('#actualizarImpuestos').click(function(){
            var res = confirm("Al actualizar impuestos, es posible que se actualicen los montos de cada uno de los detalles del item ¿Desea continuar?")

            if(res){
                var iibb =  ($('#iibb_perc').val()!="") ? $('#iibb_perc').val() : 0.00;
                var gastos_grales = ($('#gastos_grales').val()!="") ? $('#gastos_grales').val() : 0.00;
                var flete = ($('#flete').val()!="") ? $('#flete').val() : 0.00;
                var flete_rev = ($('#flete_rev_act').val()!="") ? $('#flete_rev_act').val() : 0.00;
                var ganancia = ($('#impuesto_ganancia').val()!="") ? $('#impuesto_ganancia').val() : 0.00;
                var cheque = ($('#impuesto_cheque').val()!="") ? $('#impuesto_cheque').val() : 0.00;

                console.log(flete_rev);
                if($('#beneficio_mat_perc').val() !=""){
                    var beneficio_mat = $('#beneficio_mat_perc').val();
                    var perc_mat = 1;
                }else{
                    if ($('#beneficio_mat_monto').val() !=""){
                        var beneficio_mat = $('#beneficio_mat_monto').val();
                        var perc_mat = 0;
                    }else{
                        var beneficio_mat = 0.00
                        var perc_mat = 1;
                    }
                }

                if($('#beneficio_rev_perc').val() !=""){
                    var beneficio_rev = $('#beneficio_rev_perc').val();
                    var perc_rev = 1;
                }else{
                    if ($('#beneficio_rev_monto').val() !=""){
                        var beneficio_rev = $('#beneficio_rev_monto').val();
                        var perc_rev = 0;
                    }else{
                        var beneficio_rev = 0.00
                        var perc_rev = 1;
                    }
                }

                if($('#beneficio_mo_perc').val() !=""){
                    var beneficio_mo = $('#beneficio_mo_perc').val();
                    var perc_mo = 1;
                }else{
                    if ($('#beneficio_mo_monto').val() !=""){
                        var beneficio_mo = $('#beneficio_mo_monto').val();
                        var perc_mo = 0;
                    }else{
                        var beneficio_mo = 0.00
                        var perc_mo = 1;
                    }
                }

                var item_id = $('#item_id_imp').val();

                var cadena = 'item_id='+item_id+'&beneficio_mat='+beneficio_mat+'&perc_mat='+perc_mat+"&beneficio_mo="+beneficio_mo+"&perc_mo="+perc_mo+"&iibb="+iibb+'&gastos_grales='+gastos_grales+'&flete='+flete+'&ganancia='+ganancia+'&cheque='+cheque+'&beneficio_rev='+beneficio_rev+'&perc_rev='+perc_rev+'&flete_rev='+flete_rev;

                $.ajax({
                    type:"POST",
                    url:"{{route('presupuesto.item.update_impuestos')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:cadena,
                    success:function(r){
                        alertify.success('Impuestos Actualizados');
                        location.reload();
                    },
                    error:function(r){
                        alertify.error('Error al actualizar impuestos');
                    },
                });
            }
        });
        $('#beneficio_mat_perc').keydown(function(){
            $('#beneficio_mat_monto').val("");
        });

        $('#beneficio_mat_monto').keydown(function(){
            $('#beneficio_mat_perc').val("");
        });

        $('#beneficio_rev_perc').keydown(function(){
            $('#beneficio_rev_monto').val("");
        });

        $('#beneficio_rev_monto').keydown(function(){
            $('#beneficio_rev_perc').val("");
        });

        $('#beneficio_mo_perc').keydown(function(){
            $('#beneficio_mo_monto').val("");
        });

        $('#beneficio_mo_monto').keydown(function(){
            $('#beneficio_mo_perc').val("");
        });
    });

        function actualizar_mano_obra_existente(row,cantidad,cont,id_item_mo){
            var cantidad_nueva = (parseFloat(row.column(3).nodes()[cont]['childNodes'][0].value)+parseFloat(cantidad)).toFixed(2);
            var cadena = "id_item_mano_obra="+id_item_mo+"&cantidad="+cantidad_nueva*3600;

            $.ajax({
                method:"POST",
                url:"{{route('item.mano_obra.update_amount')}}",
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                data:cadena,
                success:function(r){
                    alertify.success("Detalle de Mano de Obra Actualizado.");
                    row.column(3).nodes()[cont]['childNodes'][0].value = cantidad_nueva;
                    precio_unit_manoObra_change(row.column(0).nodes()[cont]['childNodes'][0]["data"],id_item_mo);
                },
                error:function(r){
                    alertify.error("Error al actualizar la mano de obra.");
                }
            });
        }

        function save_mano_obra_extra(mano_obra,cant)
        {
            var cadena = "cant="+cant*3600+"&pu="+0.00+"&item_id={{$item->id}}&mano_obra_id="+mano_obra['id']+"&moneda_id={{$presupuesto->moneda_manos_obra->id}}";

            $.ajax({
                method:"POST",
                url: "{{route('item.mano_obra.store')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:cadena,
                success:function(r){
                    alertify.success("Mano de obra agregada a base de datos.");
                    add_mano_obra_to_table(r.item);
                },
                error:function(r){
                    alertify.error("Error al dar de alta la mano de obra.")
                },
            });
        }

        function add_mano_obra_to_table(item)
        {
            var table = $("#tabla_manosObra").DataTable();
            var descrip_manoObra = item["mano_obra"]["name"] + " (" + item["mano_obra"]["descripcion"] + ")";

            table.row.add([
                item["mano_obra"]["id"],
                descrip_manoObra,
                '<input class="form-control" style="border: none;background-color: transparent; width:100%;" id="estandar_manoObra_cant['+item["mano_obra"]["id"]+']" value="0.00" readonly>',
                '<input class="form-control" style="border: none;background-color: transparent; width:100%;" id="extra_manoObra_cant['+item["mano_obra"]["id"]+']" value="'+item["cantidad"]/3600+'" readonly> <a href="#" id="editarCantidadExtraManoObra" class="btn btn-primary btn-xs" title="Editar Cantidad Extra Mano Obra" data-toggle="modal" data-target="#modal_editCantExtraManoObra" onclick="editar_cantExtraManoObra('+item["id"]+', '+item["cantidad"]+')"><i class="fa fa-edit" aria-hidden="true "></i></a>',

                '<input class="form-control" style="width:100%;" id="precio_unit_manoObra['+item["mano_obra"]["id"]+']" value="0.00" onkeypress="return validateFloat(event)" onpaste="return false" onkeyup="javascript:precio_unit_manoObra_change('+item["mano_obra"]["id"]+','+item['id']+')" onfocusout="javascript:actualizar_mo_bd('+item["id"]+',this.value)">',

                '<input class="form-control" style="border: none;background-color: transparent; width:100%;" id="subtot_manoObra['+item["mano_obra"]["id"]+']" value="0.00" readonly>',
                '<div class="text-center"><a href="#" class="delete btn button btn-danger btn-xs" title="Delete" data-toggle="tooltip" onclick="delete_item_mano_obra('+item["id"]+',0);"><span class="glyphicon glyphicon-trash"></span></a></div>',
                item['id'],
            ]).draw(false);
            table.columns(0).visible(false);
            table.columns(7).visible(false);
            document.getElementById("cant_manosObra").innerHTML = "("+table.rows().count()+")";
        }

        function editar_datosMaterial(id,marca,codigo){
            $('#marcaMaterial_edit_modal').val(marca);
            $('#codigoMaterial_edit_modal').val(codigo);
            $('#id_item_marca_cod').val(id);
        }

        function editar_datosMatReventa(id,marca,codigo){
            $('#marcaMatReventa_edit_modal').val(marca);
            $('#codigoMatReventa_edit_modal').val(codigo);
            $('#id_item_marca_cod_reventa').val(id);
        }

        function editar_referenciaMaterial(id,nro_pres,iibb,gast_gral,proveedor_item){
            $('#id_item_ref').val(id);
            $('#nroPresupuesto_edit_modal').val(nro_pres);
            $('#IIBB_edit_modal').val((parseFloat(iibb)*100).toFixed(2));
            $('#gastosGrales_edit_modal').val((parseFloat(gast_gral)*100).toFixed(2));

            $('#proveedor_select_picker').selectpicker();
            $('#proveedor_select_picker').find('option').remove().end();

            lista_provs = JSON.parse(config.proveedores);

            for (i=0;i<lista_provs.length;i++){
                if (lista_provs[i]['id'] == proveedor_item){
                    $('#proveedor_select_picker').append('<option value="'+lista_provs[i]['id']+'">'+lista_provs[i]['name']+'</option>');
                    $('#proveedor_select_picker').selectpicker("refresh");
                    $('#proveedor_select_picker').val(lista_provs[i]['id']);
                    $('#proveedor_select_picker').selectpicker("refresh");
                }else{
                    $('#proveedor_select_picker').append('<option value="'+lista_provs[i]['id']+'">'+lista_provs[i]['name']+'</option>');
                }
                $('#proveedor_select_picker').selectpicker("refresh");
            }
        }

        function editar_referenciaMatReventa(id,nro_pres,iibb,gast_gral,proveedor_item){
            $('#id_item_ref_reventa').val(id);
            $('#nroPresupuesto_edit_modal_reventa').val(nro_pres);
            $('#IIBB_edit_modal_reventa').val((parseFloat(iibb)*100).toFixed(2));
            $('#gastosGrales_edit_modal_reventa').val((parseFloat(gast_gral)*100).toFixed(2));

            $('#proveedor_select_picker_reventa').selectpicker();
            $('#proveedor_select_picker_reventa').find('option').remove().end();

            lista_provs = JSON.parse(config.proveedores);

            for (i=0;i<lista_provs.length;i++){
                if (lista_provs[i]['id'] == proveedor_item){
                    $('#proveedor_select_picker_reventa').append('<option value="'+lista_provs[i]['id']+'">'+lista_provs[i]['name']+'</option>');
                    $('#proveedor_select_picker_reventa').selectpicker("refresh");
                    $('#proveedor_select_picker_reventa').val(lista_provs[i]['id']);
                    $('#proveedor_select_picker_reventa').selectpicker("refresh");
                }else{
                    $('#proveedor_select_picker_reventa').append('<option value="'+lista_provs[i]['id']+'">'+lista_provs[i]['name']+'</option>');
                }
                $('#proveedor_select_picker_reventa').selectpicker("refresh");
            }
        }

        function delete_item_material(id_item_mat,cant_est){

            var res = confirm("¿Seguro que desea eliminar este detalle?")
            if (res){
                var cadena = "id_item_mat="+id_item_mat;
                $.ajax({
                    method:"POST",
                    url:"{{route('item.material.delete')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:cadena,
                    success:function(r){
                        if(r.status_result == 0){
                        alertify.success("Detalle borrado con éxito.");
                    }else{
                        alertify.error("No se borró al detalle debido a que está asociado a un estándar.")
                    }
                        location.reload();
                    },
                    error:function(r){
                        alertify.error("Error al borrar el detalle.");
                    }
                });
            }
        }

        function delete_item_matReventa(id_item_mat){
            var res = confirm("¿Seguro que desea eliminar este detalle?")
            if (res){
                var cadena = "id_item_mat="+id_item_mat;
                $.ajax({
                    method:"POST",
                    url:"{{route('item.material.delete')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:cadena,
                    success:function(r){
                        if(r.status_result == 0){
                            alertify.success("Detalle borrado con éxito.");
                        }else{
                            alertify.error("No se borró al detalle debido a que está asociado a un estándar.")
                        }
                        location.reload();
                    },
                    error:function(r){
                        alertify.error("Error al borrar el detalle.");
                    }
                });
            }
        }

        function delete_item_mano_obra(id_item_mo,cant_est){
            var res = confirm("¿Seguro que desea eliminar este detalle?")
            if(res){
                var cadena = "id_item_mano_obra="+id_item_mo;
                $.ajax({
                    method:"POST",
                    url:"{{route('item.mano_obra.delete')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:cadena,
                    success:function(r){
                        if(r.status_result == 0){
                            alertify.success("Detalle borrado con éxito.");
                        }else{
                            alertify.error("No se borró al detalle debido a que está asociado a un estándar.")
                        }
                        location.reload();
                    },
                    error:function(r){
                        alertify.error("Error al borrar el detalle.");
                    }
                });
            }
        }

        function delete_estandar(id_st){
            var res = confirm("¿Seguro que desea eliminar el estándar?")
            if (res){
                cadena = "id_st="+id_st;
                $.ajax({
                    method:"POST",
                    url:"{{route('item.ap_item.delete')}}",
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:cadena,
                    success:function(r){
                        alertify.success("Estándar eliminado con éxito.");
                        location.reload();
                    },
                    error:function(r){
                        alertify.error("Error al eliminar el estándar.");
                    }
                });
            }
        }

        function editar_cantExtraMaterial(id, cant){
            $('#id_item_cantExtra').val(id);
            $('#cantExtraMaterial_edit_modal').val(parseFloat(cant).toFixed(2));
        }

        function editar_cantExtraMatReventa(id, cant){
            $('#id_item_cantReventa').val(id);
            $('#cantReventa_edit_modal').val(parseFloat(cant).toFixed(2));
        }

        function editar_cantExtraManoObra(id, cant){
            $('#id_item_mo').val(id);
            $('#cantExtraManoObra_edit_modal').val(parseFloat(cant/3600).toFixed(2));
        }

        function ver_listaMats(id, ap_materiales, materiales){
            $('#id_ap_item').val(id);
            //console.log(id);
            //console.log(ap_materiales);
            //console.log(materiales);

            var tableRef = document.getElementById('materiales_ap_table').getElementsByTagName('tbody')[0];

            while(tableRef.hasChildNodes())
            {
                tableRef.removeChild(tableRef.firstChild);
            }

            if (ap_materiales.length == 0){
                tableRef.insertRow().innerHTML =
                    "<td> - </td>"+
                    "<td> - </td>"+
                    "<td> - </td>";
            };

            ap_materiales.forEach(ap_material => {
                materiales.forEach(material => {
                    if (ap_material["material_id"] == material["id"]){
                        tableRef.insertRow().innerHTML =
                        "<td>" +material["descripcion"]+ "</td>"+
                        "<td>" +ap_material["cantidad"]+ "</td>"+
                        "<td>" +material["unidad"]["descripcion"]+ "</td>";
                    }
                });
            });
        }

        /*function ver_listaMats2(id, ap_materiales, materiales){
            console.log(id);
            console.log(ap_materiales);
            console.log(materiales);
        }*/

        function editar_cantEstandar(id, cant){
            $('#id_ap_item').val(id);
            $('#cantEstandar_edit_modal').val(parseInt(cant));
        }
    </script>
@endsection

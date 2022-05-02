@extends('layout')

@section('title')
Estándares - Materiales
@endsection

@section('import_css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{URL::asset('/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>
    <script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>

    <style>
        .modal {
        }

        .vertical-alignment-helper {
            display:table;
            height: 100%;
            width: 100%;
        }

        .vertical-align-center {
            /* To center vertically */
            display: table-cell;
            vertical-align: middle;
        }
        .modal-content {
            /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
            width:inherit;
            height:inherit;
            /* To center horizontally */
            margin: 0 auto;
        }
    </style>
    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content-header')
    <h1 class="display-1">Estándares - Materiales</h1>
@endsection

@section('content')
@if(session()->has('alert'))
    <script>
        alertify.alert("Error","{{ session()->get('alert') }}").set('basic', false);
    </script>
@endif

<div class="row">
    <div class="col-xs-9">
        <h4><b>Título: </b>{{$actividad_preestablecida->titulo}}</h4>
        <b>Descripción: </b>{{$actividad_preestablecida->descripcion}}
    </div>
</div>
<hr style="width: 100%; color: rgb(113, 197, 223); height: 1px;background-color: rgb(113, 197, 223);"/>

<div class="row">
    <div class="col-xs-6">
        <h4>Especificaciones</h4>
    </div>
    <div class="col-xs-6">
        @if ($actividad_preestablecida->pendiente)
            <a class="btn btn-warning pull-right open-createEspecMO @if(count($materiales)==0) disabled @endif" style="margin-right: 10px; margin-bottom: 10px;" href="#createEspecMO" onclick="setApidToModal('{{$actividad_preestablecida->id}}')" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Materiales</a>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-warning">
            <div class="box-body">

                <div class="table-responsive">
                    <table id="ap_manos_obra" class="table row-border table-striped table-bordered table-condensed" style="width: 100%">
                        <thead>
                            <tr style="background-color: #fff6c3">
                                <th style="width: 20%">
                                    Marca <a href="#" data-toggle="tooltip" title="Marca del material utilizado." data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a>
                                </th>
                                <th style="width: 52%">Descripción <a href="#" data-toggle="tooltip" title="Descripción específica del material." data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a></th>
                                <th style="width: 20%">Cantidad Requerida <a href="#" data-toggle="tooltip" title="Cantidad requerida del material, para una única pasada." data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a></th>
                                @if ($actividad_preestablecida->pendiente)
                                    <th style="width: 8%"></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($relaciones as $una_relacion)
                                <tr class="warning">
                                    <td>
                                        @if ($una_relacion->material->marca)
                                            {{$una_relacion->material->marca}}
                                        @else
                                           (Sin Marca)
                                        @endif
                                    </td>
                                    <td>{{$una_relacion->material->descripcion}}</td>
                                    <td>{{$una_relacion->cantidad}}&nbsp{{$una_relacion->material->unidad->descripcion}}
                                        &nbsp

                                        @if ($actividad_preestablecida->pendiente)
                                            <button type="button" class="btn btn-primary btn-xs open-editCantidad" data-toggle="modal" data-id="botonMO" id="botonMO" href="#editCantidad" onclick="modificar_cantidad_mat('{{$loop->index+1}}','{{$una_relacion->material_id}}','{{$una_relacion->ap_id}}','{{$una_relacion->material->marca}}','{{$una_relacion->cantidad}}','{{$una_relacion->material->unidad->descripcion}}');">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        @endif
                                    </td>

                                    @if ($actividad_preestablecida->pendiente)
                                        <td class="text-center">
                                            {{-- <a class="btn btn-primary btn-xs" href='{{route('actividades_preestablecidas.manos_obra', $mano_obra->id)}}' title="Editar">
                                                <i class="fa fa-edit"></i>
                                            </a> --}}
                                            <a class="btn btn-danger btn-xs" href="{{route('actividades_preestablecidas.materiales.destroy',['id'=>$una_relacion->id])}}" data-method="delete" title="Eliminar" onclick="return confirm('¿Seguro que desea eliminar este mterial de la actividad preestablecida?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach


                            <div class="modal" id="editCantidad" tabindex="-1" role="dialog" aria-labelledby="modalEditCantidad" data-backdrop="static" data-keyboard="false" aria-hidden="true">
                                <div class="vertical-alignment-helper">
                                    <div class="modal-dialog modal-sm vertical-align-center" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h5 class="modal-title" id="modalEditCantidad">Editar Cantidad Requerida <i id="name_mano_obra_modal"></i></h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-4 vcenter">
                                                        <label>Cantidad:</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <input style="border:1px solid #000000" type="name" id="cant_material" class="form-control" required maxlength="255" onkeypress="return validateFloat(event)" onpaste="return false" onkeyup="this.value = this.value.replace(/,/g,'.');">
                                                    </div>
                                                    <div class="col-md-4"><i id="unidad_mat_modal"></i></div>
                                                    <input type="hidden" id="id_mat_input" value="">
                                                    <input type="hidden" id="id_ap_input" value="">
                                                    <input type="hidden" id="id_table_cantidad" value="">
                                                </div>
                                                <hr>

                                                <button type="button" id="btn_actualizarMat" class="btn btn-success pull-right" data-dismiss="modal">Actualizar</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="modal" id="createEspecMO" tabindex="-1" role="dialog" aria-labelledby="modalEditCantidad" data-backdrop="static" data-keyboard="false" aria-hidden="true">
                                <div class="vertical-alignment-helper">
                                    <div class="modal-dialog vertical-align-center modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" id="boton_close_crear" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h5 class="modal-title">Agregar Materiales</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Material:<br></label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <select class="selectpicker" data-show-subtext="true" data-live-search="true"
                                                    id="material_picker" data-width="100%" title="Seleccione un Material">
                                                        @foreach ($materiales as $mat)
                                                            <option value="{{$mat->id}}" data-unidad="{{$mat->unidad->descripcion}}">
                                                            @if ($mat->marca)
                                                                {{\Illuminate\Support\Str::limit($mat->marca.' - '.$mat->descripcion,150,$end='...')}}
                                                            @else
                                                                {{ \Illuminate\Support\Str::limit($mat->descripcion,150,$end='...')}}
                                                            @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Cantidad:</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                    <input name="cantidad_material_crear" placeholder="Cantidad" id="cantidad_material_crear" type="text" class="form-control" onkeypress="return validateFloat(event)" onkeyup="this.value = this.value.replace(/,/g,'.');" onpaste="return false">
                                                    </div>
                                                    <div class="col-md-4"><i id="unidad_mat_modal_crear"></i></div>
                                                    <input id="id_ap_MATtoAP" type="hidden" value="">
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="button" id="asociarMOtoAP" class="btn btn-success pull-right" data-dismiss="modal">Guardar</button>
                                                        <button type="button" id="cancelarAsociacion" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </tbody>
                    </table>
                <a class="btn btn-primary pull-right" style="margin-top: 1em" href="{{route('actividades_preestablecidas.index')}}">Volver</a>
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
<script src="{{URL::asset('/js/bootstrap-select.min.js')}}"></script>
<script src="{{URL::asset('/js/own_functions.js')}}"></script>

<script>

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$(document).ready(function() {
    $('#ap_manos_obra').DataTable({
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

$(document).ready(function(){
    $('#btn_actualizarMat').click(function(){
        if (parseInt($("#cant_material").val())>0){
            var cantidad = $("#cant_material").val();
            var id_material = $("#id_mat_input").val();
            var id_ap = $("#id_ap_input").val();
            var id_table_cantidad = $('#id_table_cantidad').val();
            cadena = "cantidad="+cantidad+"&id_material="+id_material+"&id_ap="+id_ap;
            $.ajax({
                type:"POST",
                url:"{{URL::asset('/actividades_preestablecidas/materiales/actualizar_cantidad')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:cadena,
                success:function(r){
                        alertify.success("Cantidad Actualizada");
                        location.reload();
                    },
                    error:function(r){
                        alertify.error("Error al actualizar la cantidad.");
                    },
            });
        } else {
            alertify.alert("Ingrese un valor mayor a 0");
        };
    });
});

function modificar_cantidad_mat(id_table,id_mo,id_ap,name,cantidad,unidad){
    $('#cant_material').val(cantidad);
    $('#id_mat_input').val(id_mo);
    $('#id_ap_input').val(id_ap);
    $('#name_mano_obra_modal').text(name);
    $('#id_table_cantidad').val(id_table);
    $('#unidad_mat_modal').text(unidad);
};

function setApidToModal(ap_id){
    $('#id_ap_MATtoAP').val(ap_id);
}

$(document).ready(function(){
    $('#material_picker').change(function(){
        var unidad = $(this).find(':selected').data('unidad');
        $('#unidad_mat_modal_crear').text(unidad);
    });

    $('#cancelarAsociacion').click(function(){
        $('#cantidad_material_crear').val("");
        $('#material_picker').val('default');
        $('#material_picker').selectpicker('refresh');
        $('#unidad_mat_modal_crear').text("");
    });

    $('#boton_close_crear').click(function(){
        $('#cantidad_material_crear').val("");
        $('#material_picker').val('default');
        $('#material_picker').selectpicker('refresh');
        $('#unidad_mat_modal_crear').text("");
    });

    $('#asociarMOtoAP').click(function(){
        var MatId = $('#material_picker').val();
        var APId =  $('#id_ap_MATtoAP').val();
        var cantidad = $('#cantidad_material_crear').val();
        if(cantidad>=0){
            if (MatId && cantidad){
                cadena = 'ap_id='+APId+'&mat_id='+MatId+'&cantidad='+cantidad;
                $.ajax({
                    type:"POST",
                    url:"{{URL::asset('/actividades_preestablecidas/manos_obra/asociar_mat')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:cadena,
                    success:function(r){
                        alertify.success("Mano de obra asociada a la actividad preestablecida.");
                        location.reload();
                    },
                    error:function(r){
                        alertify.error("Error al asociar la mano de obra con la actividad preestablecida.");
                    },
                });
            }else{
                alertify.error("Debe rellenar todos los campos.")
            }
        } else {
            alertify.error("La cantidad debe ser mayor a 0.")
        }

        $('#cantidad_material_crear').val("");
        $('#material_picker').val('default');
        $('#material_picker').selectpicker('refresh');
        $('#unidad_mat_modal_crear').text("");

    });
});
</script>

@endsection

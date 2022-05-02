@extends('layout')

@section('title')
Estándares - Manos de obra
@endsection

@section('import_css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{URL::asset('/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>
    <link rel="stylesheet" href="{{URL::asset('/duration-picker/jquery-duration-picker.css')}}">

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
    <h1 class="display-1">Estándares - Mano de obra</h1>
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
    <div class="col-xs-3">
        <p class="well-sm" style="color:white; background-color:black">
            <label>Duración total</label><br>
            {{ str_replace('.', ',',$all_relaciones->duracion_total) }}
            @if ($all_relaciones->duracion_total == 1)
                {{ " hora" }}
            @else
                {{ " horas" }}
            @endif

            @if ($all_relaciones->duracion_total > 0)
                &nbsp
                </b>
                <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                <i>
                {{" (" }}
                @if ($all_relaciones->tot_horas > 0)
                    {{ $all_relaciones->tot_horas . " hs." }}
                @endif
                @if ($all_relaciones->tot_horas > 0 && $all_relaciones->total_minutos > 0)
                    {{ " y " }}
                @endif
                @if ($all_relaciones->total_minutos > 0)
                    {{ str_replace('.', ',',$all_relaciones->total_minutos) . " min." }}
                @endif
                {{ ")" }}
                </i>
            @endif
        </p>
    </div>
</div>
<hr style="width: 100%; color: rgb(113, 197, 223); height: 1px;background-color: rgb(113, 197, 223);"/>

<div class="row">
    <div class="col-xs-6">
        <h4>Especificaciones</h4>
    </div>
    <div class="col-xs-6">
        @if ($actividad_preestablecida->pendiente)
            <a class="btn btn-success pull-right open-createEspecMO @if(count($manos_obra)==0) disabled @endif" style="margin-right: 10px; margin-bottom: 10px;" href="#createEspecMO" onclick="setApidToModal('{{$actividad_preestablecida->id}}')" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Especificación de Mano de Obra</a>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-body">

                <div class="table-responsive">
                    <table id="ap_manos_obra" class="table row-border table-striped table-bordered table-condensed" style="width: 100%">
                        <thead>
                            <tr  style="background-color: #cae7bd;">
                                <th style="width: 14%">
                                    Nombre <a href="#" data-toggle="tooltip" title="Nombre identificatorio de la mano de obra" data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a>
                                </th>
                                <th style="width: 40%">Descripción <a href="#" data-toggle="tooltip" title="Descripción de las actividades realizadas en la mano de obra." data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a></th>
                                <th style="width: 14%">Tipo de Mano de Obra <a href="#" data-toggle="tooltip" title="Tipo de actividad de la mano de obra. Puede ser Fabricación, Instalación o Mantenimiento." data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a></th>
                                <th style="width: 20%">Duración <a href="#" data-toggle="tooltip" title="Duración total de la mano de obra, en una única pasada." data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a></th>
                                @if ($actividad_preestablecida->pendiente)
                                    <th style="width: 8%"></th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_relaciones as $una_relacion)
                                <tr class="success">
                                    <td>{{$una_relacion->mano_obra->name}}</td>
                                    <td>
                                        {{$una_relacion->mano_obra->descripcion}}
                                    </td>
                                    <td>{{$una_relacion->mano_obra->tipo_mano_obra->descripcion}}</td>
                                    <td><b>
                                        {{ str_replace('.', ',',$una_relacion->duracion_individual) }}
                                        @if ($una_relacion->duracion_individual == 1)
                                            {{ " hora" }}
                                        @else
                                            {{ " horas" }}
                                        @endif
                                        <br>
                                        &nbsp
                                        &nbsp
                                        &nbsp
                                        </b>
                                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                        <i>
                                        {{" (" }}
                                        @if ($una_relacion->horas_individual > 0)
                                            {{ $una_relacion->horas_individual . " hs." }}
                                        @endif
                                        @if ($una_relacion->horas_individual > 0 && $una_relacion->minutos_individual > 0)
                                            {{ " y " }}
                                        @endif
                                        @if ($una_relacion->minutos_individual > 0)
                                            {{ str_replace('.', ',',$una_relacion->minutos_individual) . " min." }}
                                        @endif
                                        {{ ")" }}
                                        </i>
                                        &nbsp
                                        @if ($actividad_preestablecida->pendiente)
                                            <button type="button" class="btn btn-primary btn-xs open-editCantidad" data-toggle="modal" data-id="botonMO" id="botonMO" href="#editCantidad" onclick="modificar_cantidad_mo('{{$loop->index+1}}','{{$una_relacion->mano_obra_id}}','{{$una_relacion->ap_id}}','{{$una_relacion->mano_obra->name}}','{{$una_relacion->duracion}}');">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        @endif

                                    </td>
                                    @if ($actividad_preestablecida->pendiente)
                                        <td class="text-center">
                                            {{-- <a class="btn btn-primary btn-xs" href='{{route('actividades_preestablecidas.manos_obra', $mano_obra->id)}}' title="Editar">
                                                <i class="fa fa-edit"></i>
                                            </a> --}}
                                            <a class="btn btn-danger btn-xs" href="{{route('actividades_preestablecidas.mano_obra_destroy',['ap_id'=>$una_relacion->ap_id,'mano_obra_id'=>$una_relacion->mano_obra_id])}}" data-method="delete" title="Eliminar" onclick="return confirm('¿Seguro que desea eliminar esta mano de obra de la actividad preestablecida?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach


                            <div class="modal" id="editCantidad" tabindex="-1" role="dialog" aria-labelledby="modalEditCantidad" data-backdrop="static" data-keyboard="false" aria-hidden="true">
                                <div class="vertical-alignment-helper">
                                    <div class="modal-dialog modal-md vertical-align-center" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h5 class="modal-title" id="modalEditCantidad">Editando <i id="name_mano_obra_modal"></i></h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12 vcenter">
                                                        <label>Duracion Total Mano de Obra:</label>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input style="border:1px solid #000000" type="name" id="duracion_mano_obra_edit" class="form-control" placeholder="Nombre de Proyecto" required maxlength="255">
                                                        <input type="hidden" id="id_mo_input" value="">
                                                        <input type="hidden" id="id_ap_input" value="">
                                                        <input type="hidden" id="id_table_cantidad" value="">
                                                    </div>
                                                </div>
                                                <hr>

                                                <button type="button" id="btn_actualizarMO" class="btn btn-success pull-right" data-dismiss="modal">Actualizar</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="modal" id="createEspecMO" tabindex="-1" role="dialog" aria-labelledby="modalEditCantidad" data-backdrop="static" data-keyboard="false" aria-hidden="true">
                                <div class="vertical-alignment-helper">
                                    <div class="modal-dialog vertical-align-center" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h5 class="modal-title">Crear Especificación de Mano de Obra</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Mano de Obra:<br></label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <select class="selectpicker" data-show-subtext="true" data-live-search="true"
                                                        name="mano_obra_id" id="mano_obra_picker" data-width="100%" title="Seleccione una Mano de Obra">
                                                        @foreach ($manos_obra as $mo)
                                                            <option value="{{$mo->id}}">{{$mo->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Duración Total Mano de Obra:</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input name="duracion_mano_obra" id="duracion_mano_obra_MOtoAP" type="text" class="form-control">

                                                        <input id="id_ap_MOtoAP" type="hidden" value="">
                                                    </div>
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
<script src="{{URL::asset('/js/moment.js')}}"></script>

<script src="{{URL::asset('/duration-picker/jquery-duration-picker.js')}}"></script>
<script>
    $(function () {
        $('#duracion_mano_obra_MOtoAP').val(60000);
        $('#duracion_mano_obra_MOtoAP').durationPicker({ showSeconds:true, checkRanges: true, totalMin: 60000, totalMax: 86399999});
    });
</script>

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
    $('#btn_actualizarMO').click(function(){
        var duracion = $("#duracion_mano_obra_edit").val();
        var id_mano_obra = $("#id_mo_input").val();
        var id_ap = $("#id_ap_input").val();
        var id_table_cantidad = $('#id_table_cantidad').val();
        cadena = "duracion="+duracion+"&id_mano_obra="+id_mano_obra+"&id_ap="+id_ap;
        $.ajax({
            type:"POST",
            url:"{{URL::asset('/actividades_preestablecidas/manos_obra/actualizar_cantidad')}}",
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
    });
});

function modificar_cantidad_mo(id_table,id_mo,id_ap,name,duracion){
    $('#duracion_mano_obra_edit').val(duracion*1000);
    $('#duracion_mano_obra_edit').durationPicker({ showSeconds:true, checkRanges: true, totalMin: 60000, totalMax: 86399999});

    $('#id_mo_input').val(id_mo);
    $('#id_ap_input').val(id_ap);
    $('#name_mano_obra_modal').text(name);
    $('#id_table_cantidad').val(id_table)
};

function setApidToModal(ap_id){
    $('#id_ap_MOtoAP').val(ap_id);
}


$(document).ready(function(){
    $('#cancelarAsociacion').click(function(){
        $('#cantidad_mano_obra').val("");
        $('#mano_obra_picker').val('default');
        $('#mano_obra_picker').selectpicker('refresh');
    })
});

$(document).ready(function(){
    $('#asociarMOtoAP').click(function(){
        var MOId = $('#mano_obra_picker').val();
        var APId =  $('#id_ap_MOtoAP').val();
        var duracion = $('#duracion_mano_obra_MOtoAP').val();
        if (MOId && duracion>=0 || duracion != "" ){
            cadena = 'ap_id='+APId+'&mo_id='+MOId+'&duracion='+duracion;
            $.ajax({
                type:"POST",
                url:"{{URL::asset('/actividades_preestablecidas/manos_obra/asociar_a_ap')}}",
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
    });
});
</script>

@endsection

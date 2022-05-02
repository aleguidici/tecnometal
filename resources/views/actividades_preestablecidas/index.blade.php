@extends('layout')

@section('title')
Actividades Preestablecidas
@endsection

@section('import_css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{URL::asset('/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>

    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content-header')
    <h1 class="display-1">Estándares</h1>
@endsection

@section('content')

@if(count($actividades_pendientes))
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">
                <div class="box-body">
                    <h4><b>Pendientes</b></h4>
                    <h6>(Estos <b>Estándares</b> no estarán disponibles hasta que se asocie, por lo menos, un material o una especificación de mano de obra)</h6>
                    <div class="table">
                        <table id="actividades_preestablecidas_sinDatos" class="table row-border table-striped table-bordered table-condensed" style="width: 100%">
                            <thead class="danger">
                                <tr style="background-color: #eccaca;">
                                    <th style="display:none;"></th>
                                    <th style="width: 20%">Título</th>
                                    <th style="width: 40%">Descripción</th>
                                    <th style="width: 20%">Mano de obra: Tiempo total</th>
                                    <th style="width: 10%">Tipos de Mats.</th>
                                    <th style="width: 10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($actividades_pendientes as $una_activ_preest)
                                    <tr class="danger">
                                        <td style="display:none;">{{$una_activ_preest->id}}</td>
                                        <td>{{$una_activ_preest->titulo}}</td>
                                        <td>{{$una_activ_preest->descripcion}}</td>
                                        {{-- <td class="text-center" style="vertical-align: middle;"><b>
                                            <a class="btn btn-success btn-xs" title="Mano de Obra" href="{{route('actividades_preestablecidas.manos_obra', $una_activ_preest)}}">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </td> --}}

                                        @if ($una_activ_preest->tiempo_total > 0)
                                            <td style="vertical-align: middle;"><b>
                                                {{ str_replace('.', ',',$una_activ_preest->tiempo_total) }}
                                                @if ($una_activ_preest->tiempo_total == 1)
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
                                                @if ($una_activ_preest->horas > 0)
                                                    {{ $una_activ_preest->horas . " hs." }}
                                                @endif
                                                @if ($una_activ_preest->horas > 0 && $una_activ_preest->minutos > 0)
                                                    {{ " y " }}
                                                @endif
                                                @if ($una_activ_preest->minutos > 0)
                                                    {{ str_replace('.', ',',$una_activ_preest->minutos) . " min." }}
                                                @endif
                                                {{ ")" }}&nbsp
                                                </i>
                                                <a class="btn btn-primary btn-xs" title="Mano de Obra" href="{{route('actividades_preestablecidas.manos_obra', $una_activ_preest)}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td class="text-center" style="vertical-align: middle;">
                                                <a class="btn btn-success btn-xs" title="Mano de Obra" href="{{route('actividades_preestablecidas.manos_obra', $una_activ_preest)}}">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </td>
                                        @endif
                                        {{-- <td class="text-center" style="vertical-align: middle;">
                                            <a class="btn btn-success btn-xs" title="Materiales" href="{{route('actividades_preestablecidas.materiales', $una_activ_preest->id)}}">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </td> --}}
                                        <td class="text-center" style="vertical-align: middle;">
                                            @if ($una_activ_preest->total_materiales > 0)
                                                {{$una_activ_preest->total_materiales}}&nbsp
                                                <a class="btn btn-primary btn-xs" title="Materiales" href="{{route('actividades_preestablecidas.materiales', $una_activ_preest->id)}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @else
                                                <a class="btn btn-success btn-xs" title="Materiales" href="{{route('actividades_preestablecidas.materiales', $una_activ_preest->id)}}">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            @if ($una_activ_preest->tiempo_total > 0 || $una_activ_preest->total_materiales > 0)
                                                <a class="btn btn-success btn-xs" title="Confirmar" onclick="confirmarAP('{{$una_activ_preest->id}}')">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                            @endif
                                            <a class="btn btn-warning btn-xs open-editarEstandares" href="#editarEstandares" data-toggle="modal" title="Editar Estándar" onclick="fill_edit_modal('{{$una_activ_preest->id}}','{{$una_activ_preest->titulo}}','{{$una_activ_preest->descripcion}}')">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a class="btn btn-danger btn-xs" href="{{route('actividades_preestablecidas.destroy',$una_activ_preest->id)}}" data-method="delete" title="Eliminar" onclick="return confirm('¿Seguro que desea eliminar este estándar?')">
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
@endif

<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-6">
                        <h4><b>Disponibles</b></h4>
                    </div>
                    <div class="col-xs-6">
                        <a class="btn btn-success pull-right" style="margin-right: 10px; margin-bottom: 10px;" href="{{route('actividades_preestablecidas.create')}}"><i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo estándar</a>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table id="actividades_preestablecidas" class="table row-border table-striped table-bordered table-condensed" style="width: 100%">
                        <thead>
                            <tr>
                                <th style="display:none;"></th>
                                <th style="width: 20%">Título</th>
                                <th style="width: 40%">Descripción</th>
                                <th style="width: 20%">Mano de obra: Tiempo total</th>
                                <th style="width: 10%">Tipos de Mats.</th>
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($actividades_disponibles as $una_activ_preest)
                                <tr>
                                    <td style="display:none;">{{$una_activ_preest->id}}</td>
                                    <td>{{$una_activ_preest->titulo}}</td>
                                    <td>{{$una_activ_preest->descripcion}}</td>

                                    @if ($una_activ_preest->tiempo_total > 0)
                                        <td style="vertical-align: middle;"><b>
                                            {{ str_replace('.', ',',$una_activ_preest->tiempo_total) }}
                                            @if ($una_activ_preest->tiempo_total == 1)
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
                                            @if ($una_activ_preest->horas > 0)
                                                {{ $una_activ_preest->horas . " hs." }}
                                            @endif
                                            @if ($una_activ_preest->horas > 0 && $una_activ_preest->minutos > 0)
                                                {{ " y " }}
                                            @endif
                                            @if ($una_activ_preest->minutos > 0)
                                                {{ str_replace('.', ',',$una_activ_preest->minutos) . " min." }}
                                            @endif
                                            {{ ")" }}&nbsp
                                            </i>
                                            <a class="btn btn-primary btn-xs" title="Mano de Obra" href="{{route('actividades_preestablecidas.manos_obra', $una_activ_preest)}}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    @else
                                        <td class="text-center" style="vertical-align: middle;">
                                            -
                                        </td>
                                    @endif

                                    <td class="text-center" style="vertical-align: middle;">
                                        @if ($una_activ_preest->total_materiales > 0)
                                            {{$una_activ_preest->total_materiales}}&nbsp
                                            <a class="btn btn-primary btn-xs" title="Materiales" href="{{route('actividades_preestablecidas.materiales', $una_activ_preest->id)}}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <a class="btn btn-warning btn-xs open-editarEstandares" href="#editarEstandares" data-toggle="modal" title="Editar Estándar" onclick="fill_edit_modal('{{$una_activ_preest->id}}','{{$una_activ_preest->titulo}}','{{$una_activ_preest->descripcion}}')">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-xs" href="{{route('actividades_preestablecidas.destroy',$una_activ_preest->id)}}" data-method="delete" title="Eliminar" onclick="return confirm('¿Seguro que desea eliminar esta Actividad Preestablecida? \n\nTenga en cuenta que también se eliminarán todas las relaciones que existan (materiales y especificaciones de mano de obra)')">
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

        <div class="modal" id="editarEstandares" tabindex="-1" role="dialog" aria-labelledby="modalEditarEstandares" data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="vertical-alignment-helper">
                <div class="modal-dialog modal-lg vertical-align-center" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="modal-title" id="modalEditCantidad">Editar Estándar<i id="name_mano_obra_modal"></i></h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4 vcenter">
                                    <label>Título:</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-file-text-o" aria-hidden="true"></i></span>
                                        <input style="border:1px solid #000000" type="text" id="titulo_ap" class="form-control">
                                    </div>
                                </div>
                                <input type="hidden" id="id_ap_input" value="">
                                <input type="hidden" id="id_table" value="">
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4 vcenter">
                                    <label>Descripción:</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-info" aria-hidden="true"></i></span>
                                        <textarea style="border:1px solid #000000" type="text" id="descripcion_ap" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <button type="button" id="btn_actualizarAP" class="btn btn-success pull-right" data-dismiss="modal">Actualizar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('imports_js')

<!-- DataTables -->
<script src="{{URL::asset('/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>

<script>
$(document).ready(function() {
    $('#actividades_preestablecidas').DataTable({
        "order": [[ 0, "desc" ]],
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

<script>
$(document).ready(function(){
    $('#btn_actualizarAP').click(function(){
        var titulo = $('#titulo_ap').val();
        var desc = $('#descripcion_ap').val();
        var id_ap = $('#id_ap_input').val();

        if (titulo && desc && id_ap){
            cadena='titulo='+titulo+'&desc='+desc+'&id_ap='+id_ap;
            $.ajax({
                type:"POST",
                url:"{{URL::asset('/actividades_preestablecidas/update/')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:cadena,
                success:function(r){
                    alertify.success("Estándar Actualizado.");
                    location.reload();
                },
                error:function(r){
                    alertify.error("Error al actualizar el Estándar.");
                },
            });
        }else{
            alertify.error("Debe rellenar todos los campos.");
        }
        $('#titulo_ap').val("");
        $('#descripcion_ap').val("");
        $('#id_ap_input').val("");
    });
});

function fill_edit_modal(id_ap,name,description){
    $('#titulo_ap').val(name);
    $('#descripcion_ap').val(description);
    $('#id_ap_input').val(id_ap);
}

function confirmarAP(id){

    var res = confirm("¿Seguro que desea confirmar el estándar? Una vez confirmado no se podran realizar modificaciones.")
    if(res){
        cadena= 'id='+id;

        $.ajax({
            method:'POST',
            url: "{{route('ap.update_pendiente')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:cadena,
            success:function(r){
                alertify.success("Estándar Confirmado.");
                location.reload();
            },
            error:function(r){
                alertify.error("Error al confirmar el estándar.");
            }
        });
    }
}
</script>

@endsection

<!-- Solapa de Estándares -->

<style>
    #tabla_estandares > tbody > tr > td:nth-child(3) {
        vertical-align: middle;
    }
</style>

<div id="menu2" class="tab-pane">
    <br>
    <div class="row">
        <div class="col-md-9">
            <label> Agregar un estándar</label>
        </div>
        <div class="col-md-3">
            <label> Cantidad</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <select data-container="body" class="selectpicker" title="Seleccione un estándar" data-show-subtext="true" data-live-search="true" name="estandares_select_picker" id="estandares_select_picker" required="required" data-width="100%" onchange="javascript:cambio_estandares_select_picker()" @if($presupuesto->estado_presupuesto_id!=5) disabled @endif>
                @foreach ($actividades_disponibles as $un_estandar)
                    <option value="{{json_encode ($un_estandar)}}">
                        {{$un_estandar->titulo}}
                        -> Tiempo total:
                        {{ str_replace('.', ',',$un_estandar->tiempo_total) }}
                        @if ($un_estandar->tiempo_total == 1)
                            {{ " hora" }}
                        @else
                            {{ " horas" }}
                        @endif

                        @if ($un_estandar->tiempo_total > 0)
                            {{" (" }}
                            @if ($un_estandar->horas > 0)
                                {{ $un_estandar->horas . " hs." }}
                            @endif
                            @if ($un_estandar->horas > 0 && $un_estandar->minutos > 0)
                                {{ " y " }}
                            @endif
                            @if ($un_estandar->minutos > 0)
                                {{ str_replace('.', ',',$un_estandar->minutos) . " min." }}
                            @endif
                            {{ ") - " }}
                        @else
                        {{ "-" }}
                        @endif
                        Tipos de materiales:
                        {{$un_estandar->total_materiales}}
                    </option>
                @endforeach
            </select>
            <script>
                function cambio_estandares_select_picker() {
                    document.getElementById("btn_add_estandar").disabled = false;
                }
            </script>
        </div>
        <div class="col-md-2">
            <input name="cant_unEstandar" id="cant_unEstandar" class="form-control" type="number" min="1" value="1" onchange="javascript:cantidad_estandar_change()" @if($presupuesto->estado_presupuesto_id!=5) disabled @endif>
            <script>
                function cantidad_estandar_change(){
                    var cant_temp = parseInt(document.getElementById("cant_unEstandar").value);
                    if (Number.isInteger(cant_temp)) {
                    if (cant_temp > 0)
                        cant_unEstandar.value = cant_temp;
                    else
                        cant_unEstandar.value = "1";
                    } else
                    cant_unEstandar.value = "1";
                };
            </script>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-success btn-sm" id="btn_add_estandar" name="btn_add_estandar" disabled {{--  onClick="confirm_datos()" --}}>
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>

    <div class="row">
        <hr>
        <div class="col-md-12">
            <h4><label>Estándares cargados</label></h4>
        </div>
    </div>
    <div class="table-responsive">
        <table id="tabla_estandares" class="table row-border table-striped table-bordered table-condensed" style="width: 100%">
            <thead>
                <tr>
                    <th style="display:none;"></th>
                    <th style="width: 76%">Estándar</th> {{-- Titulo + descripcion --}}
                    <th style="width: 10%">Ver lista de materiales</th>
                    <th style="width: 10%">Cantidad</th>
                    <th style="width: 4%"></th> {{-- Edit solo para cantidad y delete --}}
                    <th style="display:none;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($item->AP_items as $ap_item)
                <tr>
                    <td style="display:none;">{{$ap_item->actividad_preestablecida->id}}</td>
                    <td>{{$ap_item->actividad_preestablecida->titulo." - ".$ap_item->actividad_preestablecida->descripcion}}</td>
                    <td style="vertical-align:middle;"><div class="text-center"><a href="#" class="delete btn button btn-info btn-xs" title="Ver lista de materiales" data-toggle="modal" data-target="#modal_verListaMats" onclick="ver_listaMats({{$ap_item->id}},{{$ap_item->actividad_preestablecida->ap_materiales}}, {{$materiales}})"><span class="glyphicon glyphicon-list-alt"></span></a></div></td>
                    <td style="vertical-align:middle;"><input class="form-control" style="border: none; background-color: transparent; width:70%;" name="ap_cant[{{$ap_item->actividad_preestablecida->id}}]" value="{{$ap_item->cantidad}}" readonly> <a href="#" id="editarCantidadExtraManoObra" class="btn btn-primary btn-xs @if($presupuesto->estado_presupuesto_id!=5) disabled @endif" title="Editar Cantidad Estándar" data-toggle="modal" data-target="#modal_editCantEstandar" onclick="editar_cantEstandar({{$ap_item->id}},{{$ap_item->cantidad}})"><i class="fa fa-edit" aria-hidden="true "></i></a></td>
                    <td style="vertical-align:middle;"><div class="text-center"><a href="#" class="delete btn button btn-danger btn-xs @if($presupuesto->estado_presupuesto_id!=5) disabled @endif" title="Delete" data-toggle="tooltip" onclick="delete_estandar({{$ap_item->id}});"><span class="glyphicon glyphicon-trash"></span></a></div></td>
                    <td style="display:none;">{{$ap_item->id}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Cantidad Extra material --}}
<div class="modal fade" id="modal_editCantEstandar" tabindex="-1" role="dialog" aria-labelledby="editCantExtraMaterial" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="color:rgb(0, 0, 0);">Editar Cantidad Estándar</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Cantidad:</label>
                        <input style="border:1px solid #000000" id="cantEstandar_edit_modal" maxlength="100" class="form-control" placeholder="Cantidad" onkeypress="return validateInteger(event)" onpaste="return false">
                    </div>
                </div>
                <br>
                <input type="hidden" id="id_ap_item" />

                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <div>
                            <button type="button" class="btn btn-danger" id="btn-cancel-cantEstandar-edit-modal" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-success pull-right" id="editCantEstandar" data-dismiss="modal">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Lista de materiales --}}
<div class="modal fade" id="modal_verListaMats" tabindex="-1" role="dialog" aria-labelledby="verListaMateriales" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="color:rgb(0, 0, 0);">Lista de materiales del Estándar</h4>
            </div>
            <div class="modal-body">
                <div class="table">
                    <table id="materiales_ap_table" class="table row-border table-striped table-bordered table-condensed" style="width: 100%">
                        <thead class="danger">
                            <tr>
                                <th style="width: 75%">Descripción [Marca / Codigo]</th>
                                <th style="width: 10%">Cant. s/estándar</th>
                                <th style="width: 15%">Unidad de Medida</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <br>
                <input type="hidden" id="id_ap_item" />

                <div>
                    <button type="button" class="btn btn-primary" id="btn-cancel-cantEstandar-edit-modal" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

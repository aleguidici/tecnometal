<!-- Solapa de Manos de obra -->

<style>
    #tabla_manosObra > tbody > tr > td:nth-child(6) {
        vertical-align: middle;
    }
</style>

<div id="menu4" class="tab-pane">
    <br>
    <div class="row">
        <div class="col-md-9">
            <label> Agregar una actividad de Mano de obra extra </label>
        </div>
        <div class="col-md-3">
            <label> Tiempo en horas</label> <i> (Ej. 0.5hs = 30min) </i>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <select data-container="body" class="selectpicker" title="Seleccione una Actividad de Mano de obra" data-show-subtext="true" data-live-search="true" name="manosObra_select_picker" id="manosObra_select_picker" required="required" data-width="100%" onchange="javascript:cambio_manosObra_select_picker()" @if($presupuesto->estado_presupuesto_id!=5) disabled @endif>
                @foreach ($manos_obra as $una_manoObra)
                    <option value="{{json_encode ($una_manoObra)}}">
                        {{$una_manoObra->name}} ({{$una_manoObra->descripcion}})
                    </option>
                @endforeach
            </select>
            <script>
                //controles
                function cambio_manosObra_select_picker() {
                    if (document.getElementById("cant_hsManoObra").value == "") {
                        document.getElementById("btn_add_manoObra").disabled = true;
                    } else {
                        document.getElementById("btn_add_manoObra").disabled = false;
                    }
                }
            </script>
        </div>
        <div class="col-md-2">
            <input name="cant_hsManoObra" id="cant_hsManoObra" type="text" class="form-control" onkeypress="return validateFloat(event)" onkeyup="javascript:cantidad_manoObra_change()" onpaste="return false" value="1.00" placeholder="Cantidad" @if($presupuesto->estado_presupuesto_id!=5) disabled @endif>
            <script>
                //controles
                function cantidad_manoObra_change(){
                    document.getElementById("cant_hsManoObra").value = document.getElementById("cant_hsManoObra").value.replace(/,/g,'.');

                    if (document.getElementById("manosObra_select_picker").selectedIndex > 0){
                        if (document.getElementById("cant_hsManoObra").value == "") {
                            document.getElementById("btn_add_manoObra").disabled = true;
                        } else {
                            document.getElementById("btn_add_manoObra").disabled = false;
                        }
                    }
                };
            </script>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-success btn-sm" id="btn_add_manoObra" name="btn_add_manoObra" disabled {{--  onClick="confirm_datos()" --}}>
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>

    <div class="row">
        <hr>
        <div class="col-md-12">
            <h4><label>Actividades de Mano de obra cargadas</label></h4>
        </div>
    </div>
    <div class="table-responsive">
        <table id="tabla_manosObra" class="table row-border table-striped table-bordered table-condensed" style="width: 100%">
            <thead>
                <tr>
                    <th style="display:none;"></th>
                    <th style="width: 55%">Nombre - Descripción</th>
                    <th style="width: 10%">Horas s/estándar</th>
                    <th style="width: 10%">Horas extra</th> {{-- editable --}}
                    <th style="width: 10%">Precio unit.</th> {{-- editable --}}
                    <th style="width: 10%">Subtotal</th>
                    <th style="width: 5%"></th>
                    <th style="display:none;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($item->items_manos_obra as $item_mo)
                <tr>
                    <td style="display:none;">{{$item_mo->mano_obra->id}}</td>
                    <td>{{$item_mo->mano_obra->descripcion}}</td>
                    <td><input class="form-control" style="border: none;background-color: transparent; width:100%;" id="estandar_manoObra_cant[{{$item_mo->mano_obra->id}}]" value="@isset($item_mo->cant_estandar) {{number_format((float)$item_mo->cant_estandar/3600, 2, '.', '')}} @else 0.00  @endisset" readonly></td>

                    {{-- Cantidad extra --}}
                    <td><input class="form-control" style="border: none;background-color: transparent; width:70%;" id="extra_manoObra_cant[{{$item_mo->mano_obra->id}}]" value="{{number_format((float)$item_mo->cantidad/3600, 2, '.', '')}}" readonly><a href="#" id="editarCantidadExtraManoObra" class="btn btn-primary btn-xs @if($presupuesto->estado_presupuesto_id!=5) disabled @endif" title="Editar Cantidad Extra Mano Obra" data-toggle="modal" data-target="#modal_editCantExtraManoObra" onclick="editar_cantExtraManoObra({{$item_mo->id}}, {{$item_mo->cantidad}})"><i class="fa fa-edit" aria-hidden="true "></i></a></td>

                    {{-- Precio unitario mano obra --}}
                    <td><input class="form-control" style="width:100%;" id="precio_unit_manoObra[{{$item_mo->mano_obra->id}}]" value="{{number_format((float) $item_mo->precio_unitario, 2, '.', '')}}" onkeypress="return validateFloat(event)" onpaste="return false" onkeyup="javascript:precio_unit_manoObra_change({{$item_mo->mano_obra->id}},{{$item_mo->id}})" onfocusout="javascript:actualizar_mo_bd({{$item_mo->id}},this.value)" @if($presupuesto->estado_presupuesto_id!=5) disabled @endif></td>

                    <td><input class="form-control" style="border: none;background-color: transparent; width:100%;" id="subtot_manoObra[{{$item_mo->mano_obra->id}}]" value="{{number_format((float)(number_format((float)($item_mo->cantidad + $item_mo->cant_estandar)/3600, 2, '.', '') * $item_mo->precio_unitario), 2, '.', '')}}" readonly></td>
                    <td><div class="text-center"><a href="#" class="delete btn button btn-danger btn-xs @if($presupuesto->estado_presupuesto_id!=5) disabled @endif" title="Delete" data-toggle="tooltip" onclick="delete_item_mano_obra({{$item_mo->id}},@isset($item_mo->cant_estandar) {{number_format((float)$item_mo->cant_estandar/3600, 2, '.', '')}} @else 0.00  @endisset)"><span class="glyphicon glyphicon-trash"></span></a></div></td>
                    <td style="display:none;">{{$item_mo->id}}>',
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal Cantidad Extra material --}}
    <div class="modal fade" id="modal_editCantExtraManoObra" tabindex="-1" role="dialog" aria-labelledby="editCantExtraManoObra" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" style="color:rgb(0, 0, 0);">Editar Tiempo Extra</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Tiempo en Horas:</label>
                            <input style="border:1px solid #000000" id="cantExtraManoObra_edit_modal" maxlength="100" class="form-control" placeholder="Cantidad" onkeypress="return validateFloat(event)" onpaste="return false" onkeyup="javascript:cambio_coma_a_punto(this.id)">
                        </div>
                    </div>
                    <br>
                    <input type="hidden" id="id_item_mo" />

                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <div>
                                <button type="button" class="btn btn-danger" id="btn-cancel-cantExtraManoObra-edit-modal" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-success pull-right" id="editCantExtraManoObra" data-dismiss="modal">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="col-md-7"></div>

    <div class="col-md-5">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <b>Costo de mano de obra, en {{$presupuesto->moneda_manos_obra->descripcion}} </b>
            </div>

            <div class="box-body">
                <b>
                <div class="row">
                    <div class="col-md-9">
                        Subtotal Mano Obra
                        <div class="pull-right">
                            {{$presupuesto->moneda_manos_obra->signo}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p id="subto_mo_limpio" class="pull-right">0.00</p>
                    </div>
                </div>
                </b>

                <hr>

                <div class="row">
                    <div class="col-md-9">
                        Gastos Generales ({{number_format((float)$item->gastos[1]->percentage*100,2,'.','')}} %)
                        <div class="pull-right">
                            {{$presupuesto->moneda_manos_obra->signo}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p id="gg_mo" class="pull-right">0.00</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9">
                        Beneficio Mano Obra @if (!$item->gastos[4]->es_monto) ({{number_format((float)$item->gastos[3]->percentage*100,2,'.','')}} %) @endif
                        <div class="pull-right">
                            {{$presupuesto->moneda_manos_obra->signo}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p id="ben_mo" class="pull-right">0.00</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9">
                        &nbsp
                        &nbsp
                        &nbsp
                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        Impuesto a la Ganancia ({{number_format((float)$item->gastos[5]->percentage*100,2,'.','')}} %)
                        <div class="pull-right">
                            {{$presupuesto->moneda_manos_obra->signo}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p id="ganancia_mo" class="pull-right">0.00</p>
                    </div>
                </div>

                <br>
                <b>
                <div class="row">
                    <div class="col-md-9">
                        Subtotal + Impuestos
                        <div class="pull-right">
                            {{$presupuesto->moneda_manos_obra->signo}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p id="subto_mo" class="pull-right">0.00</p>
                    </div>
                </div>
                </b>

                <div class="row">
                    <div class="col-md-9">
                        Impuesto al cheque ({{number_format((float)$item->gastos[6]->percentage*100,2,'.','')}} %)
                        <div class="pull-right">
                            {{$presupuesto->moneda_manos_obra->signo}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p id="cheque_mo" class="pull-right">0.00</p>
                    </div>
                </div>

                <hr>

                <b>
                <div class="row">
                    <div class="col-md-9">
                        TOTAL MANO DE OBRA DEL ITEM
                        <div class="pull-right">
                            {{$presupuesto->moneda_manos_obra->signo}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p id="tot_mo" class="pull-right">0.00</p>
                    </div>
                </div>
                </b>


                <!--<fieldset class="form-group col-xs-4">
                    <input class="form-control" style="border: none;background-color: transparent; color:rgb(92, 92, 92); font-size: 20px;" readonly value="{{$presupuesto->moneda_materiales->signo}} ">
                </fieldset>
                <fieldset class="form-group col-xs-8">
                    <input class="form-control text-right" style="border: none;background-color: transparent; color:rgb(92, 92, 92); font-size: 20px;" id="total_materiales" readonly value="0.00">
                </fieldset>-->
            </div>
        </div>
    </div>
</div>

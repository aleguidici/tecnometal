<!-- Solapa de Materiales -->

<style>
    #tabla_materiales > tbody > tr > td:nth-child(9) {
        text-align: center;
    }
</style>

<div id="menu3" class="tab-pane">
    <br>
    <div class="row">
        <div class="col-md-7">
            <label> Agregar un material extra </label>
        </div>
        <div class="col-md-5">
            <label> Cantidad</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <select data-container="body" class="selectpicker" title="Seleccione un material" data-show-subtext="true" data-live-search="true" name="materiales_select_picker" id="materiales_select_picker" required="required" data-width="100%" onchange="javascript:cambio_materiales_select_picker()" @if($presupuesto->estado_presupuesto_id!=5) disabled @endif>
                @foreach ($materiales as $un_material)
                    <option value="{{json_encode ($un_material)}}">
                        {{$un_material->descripcion}}
                    </option>
                @endforeach
            </select>
            <script>
                //controles
                function cambio_materiales_select_picker() {
                    document.getElementById("um_material").value = JSON.parse($('#materiales_select_picker').val())["unidad"]["descripcion"];

                    if (document.getElementById("cant_unMaterial").value == "") {
                        document.getElementById("btn_add_material").disabled = true;
                    } else {
                        document.getElementById("btn_add_material").disabled = false;
                    }
                }
            </script>
        </div>
        <div class="col-md-4">
            <div class="row" >
                <div class="col-md-5">
                    <input name="cant_unMaterial" id="cant_unMaterial" type="text" class="form-control" onkeypress="return validateFloat(event)" onkeyup="javascript:cantidad_material_change()" onpaste="return false" value="1.00" placeholder="Cantidad" @if($presupuesto->estado_presupuesto_id!=5) disabled @endif>
                    <script>
                        //controles
                        function cantidad_material_change(){
                            document.getElementById("cant_unMaterial").value = document.getElementById("cant_unMaterial").value.replace(/,/g,'.');

                            if (document.getElementById("materiales_select_picker").selectedIndex > 0){
                                if (document.getElementById("cant_unMaterial").value == "") {
                                    document.getElementById("btn_add_material").disabled = true;
                                } else {
                                    document.getElementById("btn_add_material").disabled = false;
                                }
                            }
                        };
                    </script>
                </div>
                <div class="col-md-7" style="vertical-align:middle;">
                    <input class="form-control" style="border: none;background-color: transparent; width:100%;" id="um_material" readonly>
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-success btn-sm" id="btn_add_material" name="btn_add_material" disabled {{--  onClick="confirm_datos()" --}}>
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>

    <div class="row">
        <hr>
        <div class="col-md-12">
            <h4><label>Materiales cargados</label></h4>
        </div>
    </div>
    <div class="table-responsive">
        <table id="tabla_materiales" class="table row-border table-striped table-bordered table-condensed" style="width: 100%">
            <thead>
                <tr>
                    <th style="display:none;"></th>
                    <th style="width: 30%">Descripci??n [Marca / Codigo]</th>
                    <th style="width: 7%">Cant. s/est??ndar</th>
                    <th style="width: 14%">Cant. extra</th> {{-- editable --}}
                    <th style="width: 9%">Unidad de Medida</th>
                    <th style="width: 9%">Precio unit.</th> {{-- editable --}}
                    <th style="width: 11%">Subtotal</th>
                    <th style="width: 6%">Referencia</th>
                    <th style="width: 12%">Subtotal c/impuestos</th>
                    <th style="width: 2%"></th>
                    <th style="display:none;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($item->items_materiales as $item_mat)
                    @if (!$item_mat->reventa)
                        <tr>
                            <td style="display:none;">{{$item_mat->material->id}}</td>
                            <td>{{$item_mat->material->descripcion}} &nbsp&nbsp&nbsp<a href="#" id="editarMaterial" class="btn btn-primary btn-xs" title="Editar Datos Material" data-toggle="modal" data-target="#modal_editDatosMaterial" onclick="editar_datosMaterial({{$item_mat->id}},'{{$item_mat->marca}}','{{$item_mat->codigo}}')"><i class="fa fa-edit" aria-hidden="true "></i> Marca / Modelo</a></td>
                            <td><input class="form-control" style="border: none;background-color: transparent; width:100%;" id="estandar_mat_cant[{{$item_mat->material->id}}]" value="@isset($item_mat->cant_estandar) {{$item_mat->cant_estandar}}  @else 0.00 @endisset" readonly></td>
                            {{-- Cantidad extra --}}
                            <td><input class="form-control" style="border: none;background-color: transparent; width:70%;" id="extra_mat_cant[{{$item_mat->material->id}}]" value="{{number_format((float)$item_mat->cantidad, 2, '.', '')}}" readonly> <a href="#" id="editarCantidadExtraMaterial" class="btn btn-primary btn-xs @if($presupuesto->estado_presupuesto_id!=5) disabled @endif" title="Editar Cantidad Extra Material" data-toggle="modal" data-target="#modal_editCantExtraMaterial" onclick="editar_cantExtraMaterial({{$item_mat->id}}, {{$item_mat->cantidad}})" ><i class="fa fa-edit" aria-hidden="true "></i></a></td>
                            {{-- Unidad de medida --}}
                            <td>{{$item_mat->material->unidad->descripcion}}</td>
                            <td><input class="form-control" style="width:100%;" id="precio_unit_mat[{{$item_mat->material->id}}]" value="{{number_format((float)$item_mat->precio_unitario, 2, '.', '')}}" onkeypress="return validateFloat(event)" onpaste="return false" onkeyup="javascript:precio_unit_material_change({{$item_mat->material->id}},{{$item_mat->id}},{{$item_mat->iibb}},{{$item_mat->gastos_generales}})" onfocusout="javascript:actualizar_material_bd({{$item_mat->id}},this.value)" @if($presupuesto->estado_presupuesto_id!=5) disabled @endif></td>
                            <td><input class="form-control" style="border: none;background-color: transparent; width:100%;" id="subtot_material[{{$item_mat->material->id}}]" value="{{number_format((float)($item_mat->precio_unitario * $item_mat->cantidad + $item_mat->precio_unitario * $item_mat->cant_estandar), 2, '.', '')}}" readonly></td>
                            <td><div class="text-center"><a href="#" id="editarReferencia" class="btn btn-primary btn-xs" title="Editar Referencia Material" data-toggle="modal" data-target="#modal_editReferencia" onclick="editar_referenciaMaterial({{$item_mat->id}},'{{$item_mat->presupuesto_proveedor}}',{{$item_mat->iibb}},{{$item_mat->gastos_generales}},{{$item_mat->persona_id}});"><i class="fa fa-edit" aria-hidden="true "></i> Ref.</a></div></td>
                            <td><input class="form-control" style="border: none;background-color: transparent; width:100%;" data-iibb="{{$item_mat->iibb}}" data-gast_gen="{{$item_mat->gastos_generales}}" id="subtot_conImpuestos[{{$item_mat->material->id}}]" value="{{number_format((float)($item_mat->precio_unitario * ($item_mat->cantidad + $item_mat->cant_estandar)*(1+$item_mat->iibb+$item_mat->gastos_generales)), 2, '.', '')}}" readonly></td>
                            <td><div class="text-center"><a href="#" class="delete btn button btn-danger btn-xs text-center @if($presupuesto->estado_presupuesto_id!=5) disabled @endif" title="Delete" data-toggle="tooltip" onclick="delete_item_material({{$item_mat->id}},@isset($item_mat->cant_estandar) {{$item_mat->cant_estandar}}  @else 0 @endisset);"><span class="glyphicon glyphicon-trash"></span></a></div></td>
                            <td style="display:none;">{{$item_mat->id}}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal Cantidad Extra material --}}
    <div class="modal fade" id="modal_editCantExtraMaterial" tabindex="-1" role="dialog" aria-labelledby="editCantExtraMaterial" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" style="color:rgb(0, 0, 0);">Editar Cantidad Extra</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Cantidad:</label>
                            <input style="border:1px solid #000000" id="cantExtraMaterial_edit_modal" maxlength="100" class="form-control" placeholder="Cantidad" onkeypress="return validateFloat(event)" onpaste="return false" onkeyup="javascript:cambio_coma_a_punto(this.id)">
                        </div>
                    </div>
                    <br>
                    <input type="hidden" id="id_item_cantExtra" />

                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <div>
                                <button type="button" class="btn btn-danger" id="btn-cancel-cantExtraMaterial-edit-modal" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-success pull-right" id="editCantExtraMaterial" data-dismiss="modal">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Marca y Codigo del material --}}
    <div class="modal fade" id="modal_editDatosMaterial" tabindex="-1" role="dialog" aria-labelledby="editDatosMaterial" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" style="color:rgb(0, 0, 0);">Editar Datos del Material</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Marca:</label>
                            <input style="border:1px solid #000000" id="marcaMaterial_edit_modal" maxlength="100" class="form-control" placeholder="Marca">
                        </div>
                        <div class="col-md-6">
                            <label>C??digo:</label>
                            <input style="border:1px solid #000000" id="codigoMaterial_edit_modal" maxlength="50" class="form-control" placeholder="Codigo">
                        </div>
                    </div>
                    <br>
                    <input type="hidden" id="id_item_marca_cod" />

                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <div>
                                <button type="button" class="btn btn-danger" id="btn-cancel-material-edit-modal" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-success pull-right @if($presupuesto->estado_presupuesto_id!=5) disabled @endif" id="editMarcaCodigoMat" data-dismiss="modal" @if($presupuesto->estado_presupuesto_id!=5) disabled @endif>Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Proveedor, presupuesto de referencia e impuestos del material --}}
    <div class="modal fade" id="modal_editReferencia" tabindex="-1" role="dialog" aria-labelledby="editReferenciasMaterial" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" style="color:rgb(0, 0, 0);">Editar Referencias Material</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Proveedor:</label>
                            <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="proveedor_id" id="proveedor_select_picker" required="required" data-width="100%" title="Seleccione un proveedor">
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>N?? de presupuesto de Referencia:</label> {{-- Puede ser nulo --}}
                            <input style="border:1px solid #000000" id="nroPresupuesto_edit_modal" maxlength="50" class="form-control" placeholder="N?? de presupuesto">
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Ingresos Brutos:</label>
                            <div class="input-group">
                                <input style="border:1px solid #000000" id="IIBB_edit_modal" type="text" maxlength="50" class="form-control" placeholder="Ingresos Brutos" onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">
                                <div class="input-group-addon">
                                    <i class="fa fa-percent"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Gastos generales:</label> {{-- Puede ser nulo --}}
                            <div class="input-group">
                                <input style="border:1px solid #000000" id="gastosGrales_edit_modal" type="text" maxlength="50" class="form-control" placeholder="Gastos Generales"  onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">
                                <div class="input-group-addon" >
                                    <i class="fa fa-percent"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="id_item_ref" />

                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <div>
                                <button type="button" class="btn btn-danger" id="btn-cancel-material-edit-modal" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-success pull-right @if($presupuesto->estado_presupuesto_id!=5) disabled @endif" id="editReferenciasMaterial" data-dismiss="modal" @if($presupuesto->estado_presupuesto_id!=5) disabled @endif>Guardar</button>
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
                <b>Costo de materiales, en {{$presupuesto->moneda_materiales->descripcion}} </b>
            </div>
            <div class="box-body">
                <b>
                <div class="row">
                    <div class="col-md-9">
                        Subtotal Materiales
                        <div class="pull-right">
                            {{$presupuesto->moneda_materiales->signo}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p id="subtot_mat_limpio" class="pull-right">0.00</p>
                    </div>
                </div>
                </b>

                <hr>

                <div class="row">
                    <div class="col-md-9">
                        Flete
                        <div class="pull-right">
                            {{$presupuesto->moneda_materiales->signo}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p id="flete_mat" class="pull-right">0.00</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9">
                        Beneficio Material @if (!$item->gastos[3]->es_monto)({{number_format((float)$item->gastos[3]->percentage*100,2,'.','')}} %) @endif
                        <div class="pull-right">
                            {{$presupuesto->moneda_materiales->signo}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p id="ben_mat_per" class="pull-right">0.00</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9">
                        &nbsp
                        &nbsp
                        &nbsp
                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        Impuesto a la Ganancia ({{number_format((float) $item->gastos[5]->percentage*100,2,'.','')}} %)
                        <div class="pull-right">
                            {{$presupuesto->moneda_materiales->signo}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p id="ganancia_mat" class="pull-right">0.00</p>
                    </div>
                </div>

                <br>
                <b>
                <div class="row">
                    <div class="col-md-9">
                        Subtotal + Impuestos
                        <div class="pull-right">
                            {{$presupuesto->moneda_materiales->signo}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p id="subtot_1_mat" class="pull-right">0.00</p>
                    </div>
                </div>
                </b>

                <div class="row">
                    <div class="col-md-9">
                        Impuesto al cheque ({{number_format((float)$item->gastos[6]->percentage*100,2,'.','')}} %)
                        <div class="pull-right">
                            {{$presupuesto->moneda_materiales->signo}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p id="cheque_mat" class="pull-right">0.00</p>
                    </div>
                </div>

                <hr>


                <b>
                <div class="row">
                    <div class="col-md-9">
                        TOTAL MATERIALES DEL ITEM
                        <div class="pull-right">
                            {{$presupuesto->moneda_materiales->signo}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p id="total_mat" class="pull-right">0.00</p>
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

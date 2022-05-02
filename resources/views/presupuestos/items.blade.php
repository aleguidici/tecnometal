@extends('layout')

@section('title','Items del Presupuesto')

@section('import_css')

<link rel="stylesheet" href="{{URL::asset('/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">

<link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>

@csrf
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('content')
<body>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h1 class="box-title">Items</h1>
                    @if ($presupuesto->estado_presupuesto_id != 5)
                        <h1 class="box-title pull-right">Presupuesto N° {{substr(sprintf('%05d', $presupuesto->id), -5).'/'.substr(sprintf('%02d', $presupuesto->id), 0, -5)}}</h1>
                    @endif
                </div>
                <div class="box-body">
                    @if ($presupuesto->estado_presupuesto->descripcion != "Borrador")
                    <div class="callout callout-info">
                        <h4>Presupuesto Cerrado!</h4>

                        <p>El presupuesto se encuentra cerrado para su presentación al cliente. No se permiten creaciones ni modificaciones de items.</p>
                      </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 1em;">
                            <div class="pull-right">
                                <a href="#impuestosClienteModal" class="btn btn-success open-impuestosClienteModal @if ($presupuesto->estado_presupuesto->id != 5) disabled @endif" data-toggle="modal"><i class="fa fa-calculator"></i> &nbsp; Impuestos Para el Cliente</a>

                                <a href="#createItemModal" class="btn btn-success open-createItemModal @if ($presupuesto->estado_presupuesto->id != 5) disabled @endif" data-toggle="modal"><i class="fa fa-plus"></i> &nbsp; Crear Item</a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="items" class="table row-border table-striped table-bordered table-condensed" style="width: 100%">
                            <thead>
                                <tr>
                                    <th style="width: 5%">Item</th>
                                    <th style="width: 5%">Cantidad</th>
                                    <th style="width: 77%">Descripción</th>
                                    <th style="width: 13%"></th>
                                </tr>
                            </thead>
                            @if (count($presupuesto->items)>0)
                                <tbody>
                                    @foreach ($presupuesto->items as $item)
                                    <tr>
                                        <td>{{$loop->index +1}}</td>
                                        <td>{{$item->cantidad}}</td>
                                        <td>{{$item->descripcion}}</td>
                                        <td><div class="text-center"><a type='button' class='btn btn-success btn-xs' href="{{route('presupuestos.create_item_detalles',$item->id)}}" title="Ver detalles del item">Detalles</a>
                                        <a href='#modifyItem' class='btn btn-primary btn-xs open-modifyItem @if ($presupuesto->estado_presupuesto->descripcion != "Borrador") disabled @endif' data-toggle='modal' title="Editar Item" data-id="{{$item->id}}" onclick="cargarDatosItem('{{$item->id}}','{{$item->cantidad}}','{{$item->descripcion}}','{{$item->descripcion_materiales}}','{{$item->descipcion_manos_obra}}')"><i class="fa fa-pencil-square-o"></i></a>
                                        <a href="{{route('presupuesto.item.destroy',$item->id)}}" data-method="DELETE" title="Eliminar Item" type="button" class="btn btn-danger btn-xs @if ($presupuesto->estado_presupuesto->descripcion != "Borrador") disabled @endif" onclick="confirm('¿Desea eliminar este item? Al hacerlo se eliminarán todos sus detalles.')"><i class="fa fa-trash"></i></a></div></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group">
                        <a href="{{Route('presupuestos.edit',$presupuesto->id)}}" class="btn btn-primary">Volver a la Definición del Presupuesto</a>
                    </div>
                    <!-- box footer -->
                </div>
                <!-- box-body-->
            </div>
            <!-- col-md-12-->
        </div>
        <!-- ./row -->
    </div>

    @if (isset($presupuesto->items))
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h1 class="box-title">Items a Imprimir</h1>
                </div>
                <div class="box-body">
                    <h4>Detalles de Materiales</h4>

                    <div class="table-responsive">
                        <table id="itemsMateriales" class="table row-border table-striped table-bordered table-condensed" style="width: 100%">
                            <thead>
                                <tr>
                                    <th style="width: 5%">Item</th>
                                    <th style="width: 5%">Cantidad</th>
                                    <th style="width: 50%">Descripción</th>
                                    <th style="width: 20%">Precio Unitario en {{$presupuesto->moneda_materiales->signo}}</th>
                                    <th style="width: 20%">Subtotal en {{$presupuesto->moneda_materiales->signo}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($presupuesto->items as $item)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$item->cantidad}}</td>
                                        <td>@isset($item->descripcion_materiales){{$item->descripcion_materiales}}@else{{$item->descripcion}}@endisset</td>
                                        <td>{{number_format((float)$item->total_material, 2, '.', '')}}</td>
                                        <td>{{number_format((float)$item->total_material*$item->cantidad, 2, '.', '')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-7"></div>

                    <div class="col-md-5" style="margin-bottom: 3em;">
                        <div class="box box-default box-solid">
                            <div class="box-body">
                                <b>
                                <div class="row">
                                    <div class="col-md-12">
                                        Subtotal Materiales + Mats. reventa sin IVA
                                        <div class="pull-right"> {{$presupuesto->moneda_materiales->signo}} {{$subtot_mat}} </div>
                                    </div>
                                </div>
                                </b>

                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        I.V.A. {{number_format((float)$presupuesto->presupuesto_gastos_preest[2]->percentage*100,2,'.','')}} %:
                                        <div class="pull-right"> {{$presupuesto->moneda_materiales->signo}} {{number_format((float)$subtot_mat * $presupuesto->presupuesto_gastos_preest[2]->percentage,2,'.','')}} </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        Perc. IIBB {{number_format((float)$presupuesto->presupuesto_gastos_preest[1]->percentage*100,2,'.','')}} %:
                                        <div class="pull-right"> {{$presupuesto->moneda_materiales->signo}} {{number_format((float)$subtot_mat * $presupuesto->presupuesto_gastos_preest[1]->percentage,2,'.','')}} </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        Perc. Mun. {{number_format((float)$presupuesto->presupuesto_gastos_preest[0]->percentage*100,2,'.','')}} %:
                                        <div class="pull-right"> {{$presupuesto->moneda_materiales->signo}} {{number_format((float)$subtot_mat * $presupuesto->presupuesto_gastos_preest[0]->percentage,2,'.','')}} </div>
                                    </div>
                                </div>

                                <hr>
                                <b>
                                <div class="row">
                                    <div class="col-md-12" style="color: rgb(65, 0, 0);">
                                        TOTAL MATERIALES
                                        <div class="pull-right"> {{$presupuesto->moneda_materiales->signo}} {{number_format((float)$tot_mat_cliente,2,'.','')}} </div>
                                    </div>
                                </div>
                                </b>


                            </div>
                        </div>
                    </div>
                    <br>

                    <h4>Detalles de Mano de Obra</h4>

                    <div class="table-responsive">
                        <table id="itemsManoObra" class="table row-border table-striped table-bordered table-condensed" style="width: 100%">
                            <thead>
                                <tr>
                                    <th style="width: 5%">Item</th>
                                    <th style="width: 5%">Cantidad</th>
                                    <th style="width: 50%">Descripción</th>
                                    <th style="width: 20%">Precio Unitario en {{$presupuesto->moneda_manos_obra->signo}}</th>
                                    <th style="width: 20%">Subtotal en {{$presupuesto->moneda_manos_obra->signo}}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($presupuesto->items as $item)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$item->cantidad}}</td>
                                        <td>@isset($item->descipcion_manos_obra){{$item->descipcion_manos_obra}}@else{{$item->descripcion}}@endisset</td>
                                        <td>{{number_format((float)$item->total_mo,2,'.','')}}</td>
                                        <td>{{number_format((float)$item->total_mo*$item->cantidad,2,'.','')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-7"></div>

                    <div class="col-md-5" style="margin-bottom: 3em;">
                        <div class="box box-default box-solid">
                            <div class="box-body">

                                <b>
                                <div class="row">
                                    <div class="col-md-12">
                                        Subtotal mano de obra sin IVA
                                        <div class="pull-right"> {{$presupuesto->moneda_manos_obra->signo}} {{$subtot_mo}} </div>
                                    </div>
                                </div>
                                </b>

                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        I.V.A. {{number_format((float)$presupuesto->presupuesto_gastos_preest[2]->percentage*100,2,'.','')}} %:
                                        <div class="pull-right"> {{$presupuesto->moneda_manos_obra->signo}} {{number_format((float)$subtot_mo * $presupuesto->presupuesto_gastos_preest[2]->percentage,2,'.','')}} </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        Perc. IIBB {{number_format((float)$presupuesto->presupuesto_gastos_preest[1]->percentage*100,2,'.','')}} %:
                                        <div class="pull-right"> {{$presupuesto->moneda_manos_obra->signo}} {{number_format((float)$subtot_mo * $presupuesto->presupuesto_gastos_preest[1]->percentage,2,'.','')}} </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        Perc. Mun. {{number_format((float)$presupuesto->presupuesto_gastos_preest[0]->percentage*100,2,'.','')}} %:
                                        <div class="pull-right"> {{$presupuesto->moneda_manos_obra->signo}} {{number_format((float)$subtot_mo * $presupuesto->presupuesto_gastos_preest[0]->percentage,2,'.','')}} </div>
                                    </div>
                                </div>

                                <hr>
                                <b>
                                <div class="row">
                                    <div class="col-md-12" style="color: rgb(65, 0, 0);">
                                        TOTAL MANO DE OBRA
                                        <div class="pull-right"> {{$presupuesto->moneda_manos_obra->signo}} {{number_format((float)$tot_mo_cliente,2,'.','')}} </div>
                                    </div>
                                </div>
                                </b>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal Crear Item -->

    <div class="modal" id="createItemModal" tabindex="-1" role="dialog" aria-labelledby="createItemModal" data-backdrop="static"  data-keyboard="false" aria-hidden="true">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" id="close-create-item" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title">Crear Item</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 vcenter">
                                <label>Descripción del Item</label>
                            </div>
                        </div>
                        <div class="row">
                            @csrf
                            <div class="col-md-12">
                                <input type="hidden" id="id_presupuesto" value="{{$presupuesto->id}}">
                                <textarea style="border: 1px solid #000000" maxlength="255" type="text" id="descItem" class="form-control"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4 vcenter">
                                <label>Cantidad</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="number" id="cantidadItem" style="border: 1px solid #000000" class="form-control" onkeypress="return validateInteger(event)">
                            </div>
                        </div>

                        <br>

                        {{-- <div class="row">
                            <div class="col-md-6 vcenter">
                                <label>Descripción de Materiales <a href="#" data-toggle="tooltip" data-html="true" title="Descripción de los materiales que componen al item. <em><b>Es recomendable completarlo.</b></em>" data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a> </label>
                            </div>
                            <div class="col-md-6 vcenter">
                                <label>Descripción de Mano de Obra <a href="#" data-toggle="tooltip" data-html="true" title="Descripción de los materiales que componen al item. <em><b>Es recomendable completarlo.</b></em>" data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" id="div_desc_mat_mod">
                                <textarea style="border: 1px solid #000000" id="desc_materiales_cr" class="form-control"></textarea>
                            </div>
                            <div class="col-md-6" id="div_desc_mo_mod">
                                <textarea style="border: 1px solid #000000" id="desc_mo_cr" class="form-control"></textarea>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="col-md-6 vcenter">
                                <label>Descripción de Materiales <a href="#" data-toggle="tooltip" data-html="true" title="Descripción de los materiales que componen al item. <em><b>Es recomendable completarlo.</b></em>" data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a> </label>
                                <div id="div_desc_mat_mod">
                                    <textarea style="border: 1px solid #000000" id="desc_materiales_cr" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 vcenter">
                                <label>Descripción de Mano de Obra <a href="#" data-toggle="tooltip" data-html="true" title="Descripción de los materiales que componen al item. <em><b>Es recomendable completarlo.</b></em>" data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a></label>
                                <div id="div_desc_mo_mod">
                                    <textarea style="border: 1px solid #000000" id="desc_mo_cr" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" id="crearItem" class="btn btn-success pull-right" data-dismiss="modal">Agregar Item</button>
                                <button type="button" class="btn btn-danger" id="cancelar-create-item" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fin Modal Crear Item -->


    <!-- Modal Impuestos Cliente-->

    <div class="modal" id="impuestosClienteModal" tabindex="-1" role="dialog" aria-labelledby="impuestosModal" data-backdrop="static"  data-keyboard="false" aria-hidden="true">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-warning">
                                    <div class="box-header with-border">
                                        <h1 class="box-title">Impuestos del cliente</h1>
                                    </div>
                                    <div class="box-body">
                                        <br>
                                        <input type="hidden" id="pres_id_imp_cliente" value="{{$presupuesto->id}}">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>I.V.A.:</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                <input class="form-control" value="{{number_format((float)$presupuesto->presupuesto_gastos_preest[2]->percentage*100,2,'.','')}}" id="ivaCliente" type="text" onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-percent"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Ingresos Brutos del Cliente:</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <input class="form-control" id="iibb_cliente" value="{{number_format((float)$presupuesto->presupuesto_gastos_preest[1]->percentage*100,2,'.','')}}" type="text" onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-percent"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Percepción Municipalidad:</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <input class="form-control" id="perc_mun_cliente" value="{{number_format((float)$presupuesto->presupuesto_gastos_preest[0]->percentage*100,2,'.','')}}" type="text" onkeypress="return validateFloat(event)" onkeyup="javascript:cambio_coma_a_punto(this.id)" onpaste="return false">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-percent"></i>
                                                    </div>
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
                                <button type="button" id="actualizarImpuestosCliente" class="btn btn-success pull-right" data-dismiss="modal">Actualizar Impuestos</button>
                                <button type="button" class="btn btn-danger" id="cancelar-editarImpuestos" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fin Modal Impuestos Cliente-->


    <!-- Modal Modificar Item -->
    <div class="modal" id="modifyItem" tabindex="-1" role="dialog" aria-labelledby="modifyItemModal" data-backdrop="static"  data-keyboard="false" aria-hidden="true">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog vertical-align-center modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" id="close-create-item" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title">Editar Item</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 vcenter">
                                <label>Descripción del Item</label>
                            </div>
                        </div>
                        <div class="row">
                            @csrf
                            <div class="col-md-12">
                                <input type="hidden" id="id_item" value="">
                                <textarea style="border: 1px solid #000000" type="text" id="descItem_mod" class="form-control"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4 vcenter">
                                <label>Cantidad</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="number" id="cantidadItem_mod" style="border: 1px solid #000000" class="form-control">
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-6 vcenter">
                                <label>Descripción de Materiales <a href="#" data-toggle="tooltip" data-html="true" title="Descripción de los materiales que componen al item. <em><b>Es recomendable completarlo.</b></em>" data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a> </label>
                            </div>
                            <div class="col-md-6 vcenter">
                                <label>Descripción de Mano de Obra <a href="#" data-toggle="tooltip" data-html="true" title="Descripción de los materiales que componen al item. <em><b>Es recomendable completarlo.</b></em>" data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a></label>
                            </div>
                        </div>
                        <!-- Completado con javascript - Campos de descripciones -->
                        <div class="row">
                            <div class="col-md-6" id="div_desc_mat_mod">
                                <textarea style="border: 1px solid #000000" id="desc_materiales_mod" class="form-control"></textarea>
                            </div>
                            <div class="col-md-6" id="div_desc_mo_mod">
                                <textarea style="border: 1px solid #000000" id="desc_mo_mod" class="form-control"></textarea>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" id="modItem" class="btn btn-success pull-right" data-dismiss="modal">Actualizar Item</button>
                                <button type="button" class="btn btn-danger" id="cancelar-modify-item" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal Modificar Item-->
</body>
@endsection

@section('imports_js')

<script src="{{URL::asset('/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>
<script src="{{URL::asset('/js/own_functions.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#items').DataTable({
            "order": [[ 0, "asc" ]],
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
        $('#tabla_impuestos').DataTable({
            "order": [[ 0, "asc" ]],
            lengthMenu: [[3], [3]],
            pageLength: 3,
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
    });
</script>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $(document).ready(function(){

        $('#close-create-item').click(function(){
            clean_fields()
        });

        $('#cancelar-create-item').click(function(){
            clean_fields()
        });

        function clean_fields(){
            $('#descItem').val("");
            $('#cantidadItem').val("");
            $('#desc_materiales_cr').val("");
            $('#desc_mo_cr').val("");
        }


        $('#crearItem').click(function(){
            var id_pres = $('#id_presupuesto').val();
            var desc_item = $('#descItem').val();
            var cantidad = $('#cantidadItem').val();

            var desc_mat = $('#desc_materiales_cr').val();
            var desc_mo = $('#desc_mo_cr').val();

            if (id_pres && desc_item && cantidad) {
                cadena = 'id_pres='+id_pres+'&desc_item='+desc_item+'&cantidad='+cantidad;

                if (desc_mat){
                    cadena = cadena+'&desc_mat='+desc_mat;
                }
                if (desc_mo){
                    cadena = cadena +'&desc_mo='+desc_mo;
                }

                $.ajax({
                    type:"POST",
                    url:"{{route('presupuesto.item.create')}}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    data:cadena,
                    success:function(r){
                        alertify.success('Item Creado');
                        location.reload();
                    },
                    error:function(r){
                        alertify.error('Error al crear el item');
                    },
                });
            }else{
                alertify.error("Debe rellenar todos los campos");
            }
        });

        $('#actualizarImpuestosCliente').click(function(){
            var iibb_cliente =  ($('#iibb_cliente').val()!="") ? $('#iibb_cliente').val() : 0.00;
            var perc_mun_cliente = ($('#perc_mun_cliente').val()!="") ? $('#perc_mun_cliente').val() : 0.00;
            var iva_cliente = ($('#ivaCliente').val()!="") ? $('#ivaCliente').val() : 0.00;

            var pres_id = $('#pres_id_imp_cliente').val();

            var cadena = 'pres_id='+pres_id+'&iibb_cliente='+iibb_cliente+'&perc_mun_cliente='+perc_mun_cliente+"&iva_cliente="+iva_cliente;

            $.ajax({
                type:"POST",
                url:"{{route('presupuesto.update_impuestos_cliente')}}",
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
        });

        $('#modItem').click(function(){
            var id_item = $('#id_item').val();
            var desc_item = $('#descItem_mod').val();
            var cantidad = $('#cantidadItem_mod').val();

            var desc_mat = $('#desc_materiales_mod').val();
            var desc_mo = $('#desc_mo_mod').val();

            if (id_item && desc_item && cantidad) {
                cadena = 'id_item='+id_item+'&desc_item='+desc_item+'&cantidad='+cantidad

                cadena = cadena+'&desc_mat='+desc_mat;
                cadena = cadena +'&desc_mo='+desc_mo;

                $.ajax({
                    type:"POST",
                    url:"{{route('presupuesto.item.edit')}}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    data:cadena,
                    success:function(r){
                        alertify.success('Item Modificado');
                        location.reload();
                    },
                    error:function(r){
                        alertify.error('Error al crear el item');
                    },
                });
            }else{
                alertify.error("Debe rellenar todos los campos");
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

    function cargarDatosItem(id, cantidad, descripcion, desc_mat, desc_mo){
        $('#id_item').val(id);
        $('#descItem_mod').val(descripcion);
        $('#cantidadItem_mod').val(cantidad);
        $('#desc_materiales_mod').val(desc_mat);
        $('#desc_mo_mod').val(desc_mo);
    }

</script>

@endsection

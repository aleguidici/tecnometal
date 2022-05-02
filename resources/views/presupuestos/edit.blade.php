@extends('layout')

<!-- Título de la pag web y la sección-->
@section('title')
Editar un Presupuesto
@endsection

<!-- Contenido Css Esxtra -->

@section('import_css')
    <link rel="stylesheet" href="{{URL::asset('/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/css/datepicker3_1.3.0.css')}}">
    <link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{URL::asset('/js/bootstrap3-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

<!-- Contenido Principal-->
@section('content')


<body>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h1 class="box-title">Editar Presupuesto / Cotización </h1>
                    
                    @if ($presupuesto->estado_presupuesto_id != 5)
                        <h1 class="box-title pull-right">Presupuesto N° {{substr(sprintf('%05d', $presupuesto->id), -5).'/'.substr(sprintf('%02d', $presupuesto->id), 0, -5)}}</h1>
                    @endif
                </div>
                <div class='box-body'>
                    @if ($presupuesto->estado_presupuesto->id != 5)
                        @switch ($presupuesto->estado_presupuesto->id)
                            @case(1)
                                <div class="callout callout-info">
                                    <h4>Presupuesto Listo para Entregar al Cliente!</h4>

                                    <p>El presupuesto se cerró para ser entregado al cliente. En este punto, ya no se pueden realizar modificaciones. Los datos se muestran con fines informativos. Se puede:
                                        <br><ul>
                                            <li><em>Anular/Cancelar el Presupuesto.</em></li>
                                            <li><em>Aprobar el Presupuesto para su venta.</em></li>
                                            <li><em>Generar comprobantes del Presupuesto.</em></li>
                                        </ul></p>
                                </div>
                                @break
                            @case(2)
                                <div class="callout callout-danger">
                                    <h4>Presupuesto Vencido!</h4>

                                    <p>El presupuesto se venció. No se pueden realizar modificaciones. Se puede:
                                        <br><ul>
                                            <li><em>Generar comprobantes del Presupuesto.</em></li>
                                            <li><em>Reactivar el Presupuesto, con un nuevo número identificador.</em></li>
                                        </ul></p>
                                </div>
                                @break
                            @case(3)
                                <div class="callout callout-success">
                                    <h4>Presupuesto Pasado a Venta!</h4>

                                    <p>El presupuesto se pasó a venta. No se pueden realizar modificaciones. Se puede:
                                        <br><ul>
                                            <li><em>Generar comprobantes del Presupuesto.</em></li>
                                        </ul>
                                    </p>
                                </div>
                                @break
                            @case(4)
                                <div class="callout callout-danger">
                                    <h4>Presupuesto Anulado!</h4>

                                    <p>El presupuesto se anuló. No se pueden realizar modificaciones. Se puede:
                                        <br><ul>
                                            <li><em>Generar comprobantes del Presupuesto.</em></li>
                                            <li><em>Reactivar el Presupuesto, con un nuevo número identificador.</em></li>
                                        </ul></p>
                                </div>
                                @break
                            @case(6)
                                <div class="callout callout-secondary"  style="background-color: #5a0202">
                                    <h4 style="color:white">Presupuesto Rechazado por el Cliente!</h4>

                                    <p style="color:white">El presupuesto fue rechazado por el cliente.
                                        <br><br> Motivo:
                                        <ul style="color:white">
                                            @if ($presupuesto->rechazado != "")
                                                <li><em>{{$presupuesto->rechazado}}</em></li>
                                            @else 
                                                <li><em>Sin motivo</em></li>
                                            @endif
                                        </ul>
                                    </p>
                                </div>
                                @break
                        @endswitch
                    @endif
                    
                    @if ($presupuesto->estado_presupuesto_id == 5 && $presupuesto->moneda_material == $presupuesto->moneda_mano_obra)
                        @if ($presupuesto->tablas_unificadas == 0)
                            <a href="#" id="changeBooleanTablas" data-pres_id="{{$presupuesto->id}}" class="btn btn-danger" style="background-color: #000000"><i class="fa fa-compress"></i> &nbsp;Unificar tablas</a>
                            &nbsp;
                        @else
                            <a href="#" id="changeBooleanTablas" data-pres_id="{{$presupuesto->id}}" class="btn btn-danger" style="background-color: #242424"><i class="fa fa-expand"></i> &nbsp;Separar tablas</a>
                            &nbsp;
                        @endif
                    @endif  
                    <a href="{{route('presupuesto.imprimible.cliente',$presupuesto->id)}}" target="_blank" class="btn btn-primary" title="Generar Presupuesto Imprimible para el Cliente."><i class="fa fa-print"></i> &nbsp; Imprimible Cliente</a>

                    <div class="pull-right">
                        <a href="{{route('presupuestos.items',$presupuesto->id)}}" class="btn btn-success"><i class="fa fa-list"></i>&nbsp; Ver Items</a>
                    </div>
                    <br>
                    <div style="margin-top: 2em;">
                        <form action="{{route('presupuestos.update',$presupuesto->id)}}" method="POST" id="table-create-presupuesto">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="text-info">(*) Campos obligatorios</div>
                                </div>
                                @if ($presupuesto->estado_presupuesto->id != 5)
                                    <div class="col-md-6">
                                        <div class="pull-right">
                                            <nobr>Fecha de emisión: {{Carbon\Carbon::parse($presupuesto->fecha)->format('d/m/Y')}} </nobr><br>
                                            <nobr>Fecha de Vencimiento: {{Carbon\Carbon::parse($presupuesto->vencimiento)->format('d/m/Y')}}</nobr>
                                            <input type="hidden" name="presupuesto_id" value="{{$presupuesto->id}}">
                                        </div>
                                        <br>
                                    </div>
                                @endif
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label> Cliente* <br></label>
                                    <select class="selectpicker" title="Seleccione un Cliente" data-show-subtext="true" data-live-search="true" name="cliente_id" id="cliente_select_picker" required="required" data-width="100%" @if ($presupuesto->estado_presupuesto->id != 5) disabled @endif>
                                        @foreach ($clientes as $un_cliente)
                                            <option value={{$un_cliente->id}} @if($presupuesto->persona->id == $un_cliente->id) selected @endif>
                                                {{ Illuminate\Support\Str::limit($un_cliente->name.' (CUIT: '.$un_cliente->cuil.'; Dirección: '.$un_cliente->direccion.' - '.$un_cliente->localidad->name.', '. $un_cliente->localidad->provincia->name.')',150) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <b><p id="contacto_label" style="color: @if ($presupuesto->contacto) black @elseif (count($contactos) > 0) black @else grey @endif"><input type='checkbox' onclick='handleClick(this);' id="contacto_checkbox" @if ($presupuesto->contacto) checked @elseif (count($contactos) == 0) disabled @endif>&nbsp Con solicitante<br></p></b>
                                    <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="contacto_id" id="contacto_select_picker" required="required" data-width="100%" title="Seleccione un solicitante" @if (!$presupuesto->contacto) disabled @endif>
                                        @foreach ($contactos as $un_contacto)
                                            <option value={{$un_contacto->id}} @if ($presupuesto->contacto) @if($presupuesto->contacto->id == $un_contacto->id) selected @endif @endif>
                                                {{ Illuminate\Support\Str::limit($un_contacto->name,150) }}
                                                @if ($un_contacto->email != "" && $un_contacto->email != null)
                                                    {{ Illuminate\Support\Str::limit(' - [Email: '.$un_contacto->email.']',150) }}
                                                @endif
                                                @if ($un_contacto->telefono != "" && $un_contacto->telefono != null)
                                                    {{ Illuminate\Support\Str::limit(' - [Telefono: '.$un_contacto->telefono.']',150) }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <script>
                                        function handleClick(cb) {
                                            $('#contacto_select_picker').attr('disabled',!cb.checked);
                                            $('#contacto_select_picker').val('default');;
                                            $('#contacto_select_picker').selectpicker('refresh');
                                        }
                                    </script>
                                </div>
                            </div>
                            <br>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label> Ref. </label>
                                    <input type="text" class="form-control" name="referencia" id="referencia" maxlength="100" placeholder="Ingrese Referencia" value="{{ old('referencia',$presupuesto->referencia) }}" @if ($presupuesto->estado_presupuesto->id != 5) disabled @endif>
                                </div>
                                <div class="col-md-6">
                                    <label> Obra </label>
                                    <input type="text" class="form-control" name="obra" id="obra" maxlength="100" placeholder="Ingrese Obra" value="{{ old('obra',$presupuesto->obra) }}" @if ($presupuesto->estado_presupuesto->id != 5) disabled @endif>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="moneda_material">Tipo de Moneda de los Materiales *<br></label>
                                    <select class="form-control" name="moneda_material" id="moneda_material" required @if ($presupuesto->estado_presupuesto->id != 5) disabled @endif>
                                        <option disabled selected hidden value="">Elija una Opción</option>
                                        @foreach ($tipos_moneda as $moneda)
                                            <option value="{{$moneda->id}}" @if($moneda->id == $presupuesto->moneda_materiales->id) selected @endif>
                                                {{$moneda->descripcion}} ({{$moneda->signo}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="moneda_material">Tipo de Moneda de las Mano de Obra *</label>
                                    <select class="form-control" name="moneda_mano_obra" id="moneda_mano_obra" required @if ($presupuesto->estado_presupuesto->id != 5) disabled @endif>
                                        <option disabled selected hidden value="" >Elija una Opción</option>
                                        @foreach ($tipos_moneda as $moneda)
                                            <option value="{{$moneda->id}}" @if($moneda->id == $presupuesto->moneda_manos_obra->id) selected @endif>
                                                {{$moneda->descripcion}} ({{$moneda->signo}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <br>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="observacionesTextArea">Observaciones</label>
                                    <br><br>
                                <textarea id="observacionesTextArea" class="form-group" name="observaciones" rows="10" cols="80" style="width: 100%;" @if ($presupuesto->estado_presupuesto->id != 5) disabled @endif>{!! $presupuesto->observaciones !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="form-group">
                                <div class="pull-right">
                                    @switch($presupuesto->estado_presupuesto->id)
                                        @case(2) <!-- VENCIDO -->
                                            <a href="#" id="reactivarPresupuesto" data-pres_id="{{$presupuesto->id}}" class="btn btn-info"><b>Reactivar Presupuesto</b></a>
                                            
                                            <a href="#" id="btnRechazarPres" data-pres_id="{{$presupuesto->id}}" class="btn btn-danger" style="background-color: #5a0202"><b>Presupuesto rechazado</b></a>&nbsp;

                                            {{-- <a href="#" class="btn btn-success" id="btnAprobarPres" data-pres_id="{{$presupuesto->id}}" ><b>Aprobar de todos modos</b></a> --}}
                                            @break
                                        @case(3) <!-- APROBADO -->
                                            @break
                                        @case(4) <!-- ANULADO -->
                                            <a href="#" id="reactivarPresupuesto" data-pres_id="{{$presupuesto->id}}" class="btn btn-info"><b>Reactivar Presupuesto</b></a>
                                            @break
                                        @case(5) <!-- BORRADOR -->
                                            <a href="#modalConfirmarPresupuesto" id="btnConfirmarPres" data-toggle="modal" class="btn btn-success open-modalConfirmarPresupuesto" ><b>Activar Presupuesto</b></a>&nbsp;
                                            <button type="submit" class="btn btn-warning"><b>Actualizar Borrador</b></button>
                                            @break
                                        @case(6) <!-- RECHAZADO -->
                                            <a href="#" id="reactivarPresupuesto" data-pres_id="{{$presupuesto->id}}" class="btn btn-info"><b>Reactivar Presupuesto</b></a>
                                            @break
                                        @default <!-- ACTIVO -->
                                            <a href="#" id="btnRechazarPres" data-pres_id="{{$presupuesto->id}}" class="btn btn-danger" style="background-color: #5a0202 "><b>Presupuesto rechazado</b></a>&nbsp;

                                            <a href="#" id="btnAnularPres" data-pres_id="{{$presupuesto->id}}" class="btn btn-danger"><b>Anular Presupuesto</b></a>&nbsp;

                                            <a href="#" class="btn btn-success" id="btnAprobarPres" data-pres_id="{{$presupuesto->id}}" ><b>Aprobar Presupuesto</b></a>
                                    @endswitch
                                </div>
                                <a href="{{route('presupuestos.index')}}" class="btn btn-primary"><b>Volver al Índice de Presupuestos</b></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Confirmar Presupuesto --}}
    <div class="modal fade" id="modalConfirmarPresupuesto" tabindex="-1" role="dialog" aria-labelledby="editCantExtraMaterial" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" style="color:rgb(0, 0, 0);">Cerrar Presupuesto</h4>
                </div>
                <div class="modal-body">

                    <div class="callout callout-warning">
                        <h4>Fijar fecha de emisión y vencimiento del presupuesto.</h4>

                        <p>Al presionar "Activar Presupuesto" este entrará en vigencia. Para ello, debe ingresar su fecha de emisión y vencimiento.</p>
                    </div>

                    <input type="hidden" id="id_presupuesto_confirm" value="{{$presupuesto->id}}">

                    <div class="row">
                        <div class="col-md-12">
                            <label>Fecha de Emisión del Presupuesto:</label>
                            <input style="border:1px solid #000000" id="fechaEmisionPres" maxlength="100" class="form-control" readonly>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <label>Fecha de Vencimiento del Presupuesto:</label>
                            <input style="border:1px solid #000000" id="fechaVenc" maxlength="100" class="form-control" readonly>
                            <div class="pull-right" id="validez_div"></div>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <div>
                                <button type="button" class="btn btn-danger" id="btn-cancel-confirm-presupuesto" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-success pull-right" id="btnConfirmar" data-dismiss="modal">Activar Presupuesto</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

@endsection

@section('imports_js')
    <script src="{{URL::asset('/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('/js/bootstrap-select.min.js')}}"></script>
    <script src="{{URL::asset('/js/bootstrap-datepicker_1.3.0.js')}}"></script>
    <script src="{{URL::asset('/js/own_functions.js')}}"></script>
    <script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>
    <script src="{{URL::asset('/js/ckeditor.js')}}"></script>
    <script src="{{URL::asset('/js/bootstrap3-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
    <script>
        $('#fechaEmisionPres').datepicker( {
            format: 'dd/mm/yyyy',
            autoclose: true,
            maxDate:'+10d'
        }).on('changeDate', dateChanged);

        $('#fechaVenc').datepicker( {
            format: 'dd/mm/yyyy',
            autoclose: true,
            maxDate:'+10d'
        }).on('changeDate', dateChanged);

        //poner en own_functions
        Date.prototype.addDays = function(days) {
            this.setDate(this.getDate() + days);
            return this;
        };

        $(document).ready(function(){
            
            
            $('#cliente_select_picker').change(function(){
                cliente_id = $('#cliente_select_picker').val();
                if (cliente_id){
                    cadena = 'cliente_id='+cliente_id;
                    $.ajax({
                        type:"POST",
                        url:"{{URL::asset('/contactos/get_contactos')}}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data:cadena,
                        success:function(r){
                            if (r.data.length > 0) {
                                $('#contacto_checkbox').attr('disabled', false);
                                add_options_contacto('#contacto_select_picker',r.data);
                                $('#contacto_checkbox').prop("checked", false);
                                $('#contacto_checkbox').attr('disabled', false);
                                document.getElementById('contacto_label').style.color = "black";
                                $('#contacto_select_picker').attr('disabled', true);
                                $('#contacto_select_picker').val('default');
                                $('#contacto_select_picker').selectpicker('refresh');
                            } else {
                                $('#contacto_select_picker').attr('disabled', true);
                                $('#contacto_select_picker').val(0);
                                $('#contacto_select_picker').selectpicker('refresh');
                                $('#contacto_checkbox').prop("checked", false);
                                $('#contacto_checkbox').attr('disabled', true);
                                document.getElementById('contacto_label').style.color = "grey";
                            }
                        },
                    });
                }
            });
            
            $('#btnConfirmarPres').click(function(){
                var myDate = new Date();
                $("#fechaEmisionPres").datepicker("setDate", myDate); //set date
                $("#fechaEmisionPres").datepicker("setStartDate", myDate);
                $("#fechaVenc").datepicker("setStartDate", myDate);
                $("#fechaVenc").datepicker("setDate", myDate.addDays(7)); //set date
            });

            $('#fechaEmisionPres').change(function(){
                myDate = $('#fechaEmisionPres').datepicker("getDate");
                $("#fechaVenc").datepicker("setDate", myDate.addDays(1));
            });

            $('#btnConfirmar').click(function(){
                var fechaEmisionPres = $('#fechaEmisionPres').val();
                var fechaVenc = $("#fechaVenc").val();
                var id_presupuesto = $('#id_presupuesto_confirm').val();

                if (fechaEmisionPres && fechaVenc){
                    cadena = "id_presupuesto="+id_presupuesto+"&fechaEmisionPres="+fechaEmisionPres+"&fechaVenc="+fechaVenc;
                    $.ajax({
                        method:"POST",
                        url: "{{route('presupuestos.confirmar')}}",
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data:cadena,
                        success:function(r){
                            window.location = r.url;
                        },
                        error:function(r){
                            alertify.error("Error al confirmar el presupuesto");
                        }
                    });
                }else{
                    alertify.error("Debe ingresar fehca de emisión y vencimiento.")
                }
            });

            $('#btnAprobarPres').click(function(){
                var res = confirm("Está aprobando el presupuesto. Esto implica que el cliente lo aceptó y este se pasa a venta. Confirme la operación.")

                if (res){
                    var id_pres = $("#btnAprobarPres").data('pres_id');
                    var cadena = "id_presupuesto="+id_pres;
                    $.ajax({
                        method:"POST",
                        url: "{{route('presupuestos.aprobar')}}",
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data:cadena,
                        success:function(r){
                            location.reload();
                        },
                        error:function(r){
                            alertify.error("Error al aprobar el presupuesto");
                        }
                    });
                }
            });

            $('#btnAnularPres').click(function(){
                var res = confirm("¿Seguro que quiere anular el presupuesto? Esta acción es irreversible.");
                if(res){
                    var id_pres = $("#btnAnularPres").data('pres_id');
                    var cadena = "id_presupuesto="+id_pres;
                    $.ajax({
                        method:"POST",
                        url: "{{route('presupuestos.anular')}}",
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data:cadena,
                        success:function(r){
                            location.reload();
                        },
                        error:function(r){
                            alertify.error("Error al anular el presupuesto");
                        }
                    });
                }
            });

            $('#changeBooleanTablas').click(function(){
                var id_pres = $("#changeBooleanTablas").data('pres_id');
                var cadena = "id_presupuesto="+id_pres;
                $.ajax({
                    method:"POST",
                    url: "{{route('presupuestos.booleanTablas')}}",
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:cadena,
                    success:function(r){
                        location.reload();
                    },
                    error:function(r){
                        alertify.error("Error al unificar las tablas del presupuesto");
                    }
                });
            });

            $('#btnRechazarPres').click(function(){
                var resp = prompt('¿Seguro que quiere establecer el presupuesto como rechazado? Esta situación se da cuando el cliente informa que no acepta el presupuesto. Esta acción es irreversible. \n\nIngrese el motivo del rechazo:');

                if(resp || resp === ""){
                    var id_pres = $("#btnRechazarPres").data('pres_id');
                    var cadena = "id_presupuesto="+id_pres+"&rechazado="+resp;
                    $.ajax({
                        method:"POST",
                        url: "{{route('presupuestos.rechazar')}}",
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data:cadena,
                        success:function(r){
                            location.reload();
                        },
                        error:function(r){
                            alertify.error("Error al establecer el presupuesto como rechazado");
                        }
                    });
                }
            });

            $('#reactivarPresupuesto').click(function(){
                var res = confirm('¿Desea reactivar el presupuesto? Esto generará una copia exacta, en un borrador.');

                if(res){
                    var id_pres = $("#reactivarPresupuesto").data('pres_id');
                    var cadena = "id_presupuesto="+id_pres;
                    $.ajax({
                        method:"POST",
                        url: "{{route('presupuesto.reactivar')}}",
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data:cadena,
                        success:function(r){
                            window.location = '{{route("presupuestos.index")}}';
                        },
                        error:function(r){
                            alertify.error("Error al reactivar el presupuesto");
                        }
                    });
                }
            });


        });

        function dateChanged() {
            const date1 = $('#fechaEmisionPres').datepicker("getDate");
            const date2 = $('#fechaVenc').datepicker('getDate');

            const diffTime = Math.abs(date2 - date1);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            var dia = " días de corrido";

            if (diffDays == 1)
                dia = " día";

            document.getElementById("validez_div").innerHTML = "<b>Validez de oferta:</b> " + diffDays + dia;
        }
        
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            //CKEDITOR.replace('observaciones');
            //bootstrap WYSIHTML5 - text editor
            $('#observacionesTextArea').wysihtml5({
                "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
                "emphasis": true, //Italics, bold, etc. Default true
                "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
                "html": false, //Button which allows you to edit the generated HTML. Default false
                "link": true, //Button to insert a link. Default true
                "image": false, //Button to insert an image. Default true,
                "color": false, //Button to change color of font
                "blockquote": false, //Blockquote
            });
        });
    </script>
@endsection

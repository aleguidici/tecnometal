@csrf

<div class="box box-info">
    <div class="box-header with-border">
        <h1 class="box-title">Tecnometal - Editar Cliente</h1>
    </div>
    <div class="box-body">
        <div class="text-info">(*) Campos obligatorios</div>
        <br>

        <div class="row">
            <div class="col-md-4">
                <label> Razón Social* <br></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="name" placeholder="Ingrese Nombre y Apellido" value="{{ old('name', $cliente->name) }}" required="required">
                </div>
                {!! $errors->first('name', '<small style = "color:#ff0000">:message</small><br>') !!}
            </div>
            <div class="col-md-3">
                <label> Condición IVA* <br></label>
                <select class="form-control" name="condicion_iva" id="condicion_iva" placeholder="Ingrese Cond. IVA" required="required">
                    <option disabled selected hidden value="">Elija una Opción</option>
                    <option value="N/D" @if ($cliente->condicion_iva == "N/D") selected @endif>N/D</option>
                    <option value="IVA Responsable Inscripto" @if ($cliente->condicion_iva == "IVA Responsable Inscripto") selected @endif>IVA Responsable Inscripto</option>
                    <option value="IVA Responsable No Inscripto" @if ($cliente->condicion_iva == "IVA Responsable No Inscripto") selected @endif>IVA Responsable No Inscripto</option>
                    <option value="IVA No Responsable" @if ($cliente->condicion_iva == "IVA No Responsable") selected @endif>IVA No Responsable</option>
                    <option value="IVA Sujeto Exento" @if ($cliente->condicion_iva == "IVA Sujeto Exento") selected @endif>IVA Sujeto Exento</option>
                    <option value="Consumidor Final" @if ($cliente->condicion_iva == "Consumidor Final") selected @endif>Consumidor Final</option>
                    <option value="Monotributista" @if ($cliente->condicion_iva == "Monotributista") selected @endif>Monotributista</option>
                    <option value="Sujeto No Categorizado" @if ($cliente->condicion_iva == "Sujeto No Categorizado") selected @endif>Sujeto No Categorizado</option>
                    <option value="Cliente del Exterior" @if ($cliente->condicion_iva == "Cliente del Exterior") selected @endif>Cliente del Exterior</option>
                </select>
            </div>
            <div class="col-md-2">
                <label> C.U.I.T./C.U.I.L.* <br></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="cuil" placeholder="Ingrese CUIT/CUIL" value="{{ old('cuil',$cliente->cuil) }}" onkeypress="return validateCuil(event)" required="required">
                </div>
                {!! $errors->first('cuil', '<small style = "color:#ff0000">:message</small><br>') !!}
            </div>

            <div class="col-xs-3">
                <label>Ingresos Brutos*</label>
                <select class="form-control" name="ingresos_brutos" required="required">
                    <option disabled selected hidden value="">Elija una Opción</option>
                    <option value="1" @if ($cliente->ingresos_brutos == 1 or old('ingresos_brutos')==1) selected @endif>Con Convenio Multilateral</option>
                    <option value="0" @if ($cliente->ingresos_brutos == 0 or old('ingresos_brutos')==0) selected @endif>Sin Convenio Multilateral</option>
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <label> País* <br></label>
                <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="pais_id" id="pais_select_picker" required="required" data-width="100%" onchange="javascript:listado_provincias()">
                    @foreach ($paises as $pais)
                            <option value="{{$pais->id}}" @if ($cliente->localidad->provincia->pais->id == $pais->id) selected @endif>{{$pais->name}}</option>
                        @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label>Provincia / Estado* <br></label>
                <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="provincia_id" id="prov_select_picker" required="required" data-width="100%">
                    @foreach ($provincias as $provincia)
                            <option value="{{$provincia->id}}" @if ($cliente->localidad->provincia->id == $provincia->id) selected @endif>{{$provincia->name}}</option>
                        @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label>Localidad*</label>

                <a id='buttom-crear-loc' data-toggle="modal" class='btn' title='Crear una Nueva Localidad' style="padding-top: 0px; padding-bottom: 0px;" data-target="#modal_nuevaLocalidad"><i class="fa fa-1 fa-plus-square" style="color:#008a55;" aria-hidden="true "></i></a>

                <div class="modal fade" id="modal_nuevaLocalidad" tabindex="-1" role="dialog" aria-labelledby="nuevaLoc" data-backdrop="static" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="nuevaLoc">Nueva Localidad</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>País:</label>
                                        <!--<select class="selectpicker" data-show-subtext="true" data-live-search="true" name="pais_modal" id="pais_modal" data-width="100%"  title="Seleccione un país">
                                            @foreach ($paises as $pais)
                                                <option value="{{$pais->id}}">
                                                    {{$pais->name}}
                                                </option>
                                            @endforeach
                                        </select>-->
                                        <h4 id='nombre_pais_modal'></h4>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Provincia:</label>
                                        <!--<select class="selectpicker" data-show-subtext="true" data-live-search="true" name="provincia_modal" id="provincia_modal"  data-width="100%"  title="Seleccione una provincia"></select>-->
                                        <h4 id='nombre_prov_modal'></h4>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Código Postal:</label>
                                        <input style="border:1px solid #000000" id="cp_modal" class="form-control" placeholder="Código Postal">
                                    </div>
                                    <div class="col-md-8">
                                        <label>Nombre Localidad:</label>
                                        <input style="border:1px solid #000000" id="nombreLocalidad_modal" class="form-control" placeholder="Nombre">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <br>
                                        <div>
                                            <button type="button" class="btn btn-danger" id="btn-cancel-modal" data-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-success pull-right" data-dismiss="modal" id="crearLocalidad">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="localidad_id" id="loc_select_picker" required="required" data-width="100%" title="Seleccione una Localidad">
                    @foreach ($localidades as $loc)
                        <option value="{{$loc->id}}" @if ($cliente->localidad->id == $loc->id) selected @endif>
                            {{$loc->name}} [C.P.:{{$loc->codigo_postal}}]
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-12">
                <label> Dirección* <br></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-address-card" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="direccion" placeholder="Ingrese Dirección" value="{{ old('direccion', $cliente->direccion) }}" required="required">
                </div>
                {!! $errors->first('direccion', '<small style = "color:#ff0000">:message</small><br>') !!}
            </div>
        </div>
        <br>
        <div class="row" style="margin-top: 3px;">
            <div class="col-md-12">
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <div class="col-md-6">
                            <h3 class="box-title">Contactos</h3>
                        </div>
                        <div class="col-md-6" >
                            <span class="pull-right">
                                <a id='buttom-crear-contacto' data-toggle="modal" class='btn btn-info btn-xs' title='Nuevo Contacto' data-target="#modal_nuevoContacto">
                                    AGREGAR
                                </a>
                            </span>
                        </div>
                    </div>

                    @include('generics/modal_create_contacto')

                    @include('generics/modal_edit_contacto')


                        <div class="box-body no-padding">
                        <table class="table row-border table-striped table-bordered table-condensed" id="contactosTable" name="contactosTable">
                            <tr>
                                <th style="width: 7%">#</th>
                                <th style="width: 30%">Nombre</th>
                                <th style="width: 30%">E-mail</th>
                                <th style="width: 25%">Teléfono/s</th>
                                <th style="width: 8%"></th>
                            </tr>
                            @foreach ($cliente->contactos as $contacto)
                            <tr>
                                <td>{{$loop->index + 1}}<input type="hidden" name="id_contacto_real[{{$loop->index+1}}]" value="{{$contacto->id}}"/></td>
                                <td><input class="form-control" style="border: none;background-color: transparent;" name="name_cont[{{$loop->index+1}}]" value="{{$contacto->name}}" readonly></td>
                                <td><input class="form-control" style="border: none;background-color: transparent;" name="email_cont[{{$loop->index+1}}]" value="{{$contacto->email}}" readonly></td>
                                <td><input class="form-control" style="border: none;background-color: transparent;" name="tel_cont[{{$loop->index+1}}]" value="{{$contacto->telefono}}" readonly></td>
                                <td><a href="#" id="editarContacto" class="btn btn-primary btn-xs" title="Editar Contacto" data-toggle="modal" data-target="#modal_editContacto" onclick="editar_contacto('{{$loop->index + 1}}','{{$contacto->name}}',@isset($contacto->email)'{{$contacto->email}}'@else null @endisset,@isset($contacto->telefono)'{{$contacto->telefono}}'@else null @endisset);">
                                    <i class="fa fa-edit" aria-hidden="true "></i>
                                </a>
                                <a title="Eliminar Contacto" href="#" class="btn btn-danger btn-xs delete"><i class="fa fa-1x fa-trash-o"></i></a></td>
                            </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- vvv Eliminar vvv --}}
        <br>
        <div style="display: none;">
            <input type="text" class="form-control" name="ingresos_brutos" value="0">
        </div>
        <div style="display: none;">
            <input type="text" class="form-control" name="tipo_persona_id" value="1">
        </div>
        {{-- ^^^ ELIMINAR ^^^ --}}

        <br>
        <button class="btn btn-success pull-right"><b>Actualizar Cliente<b></button>
        <a href="{{route('clientes.index')}}" class="btn btn-danger"><b>Cancelar</b></a>
    </div>
</div>

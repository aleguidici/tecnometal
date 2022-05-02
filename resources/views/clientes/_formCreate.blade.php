@csrf

<div class="box box-info">
    <div class="box-header with-border">
        <h1 class="box-title">Tecnometal - Nuevo Cliente</h1>
    </div>
    <div class="box-body">
        <div class="text-info">(*) Campos obligatorios</div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <label> Razón social* <br></label>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="name" id="name" maxlength="180" placeholder="Ingrese Nombre y Apellido" value="{{ old('name') }}" required="required">
                </div>
                {!! $errors->first('name', '<small style = "color:#ff0000">:message</small><br>') !!}
            </div>
            <div class="col-md-3">
                <label> Condición IVA* <br></label>
                <select class="form-control" name="condicion_iva" id="condicion_iva" placeholder="Ingrese Cond. IVA" value="{{ old('condicion_iva') }}" required>
                    <option disabled selected hidden value="">Seleccione una Condición</option>
                    <option value="N/D">N/D</option>
                    <option value="IVA Responsable Inscripto">IVA Responsable Inscripto</option>
                    <option value="IVA Responsable No Inscripto">IVA Responsable No Inscripto</option>
                    <option value="IVA No Responsable">IVA No Responsable</option>
                    <option value="IVA Sujeto Exento">IVA Sujeto Exento</option>
                    <option value="Consumidor Final">Consumidor Final</option>
                    <option value="Monotributista">Monotributista</option>
                    <option value="Sujeto No Categorizado">Sujeto No Categorizado</option>
                    <option value="Cliente del Exterior">Cliente del Exterior</option>
                </select>
            </div>
            <div class="col-md-3">
                <label> C.U.I.T./C.U.I.L.* <br></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" id="cuil" name="cuil" maxlength="15" placeholder="Ingrese CUIT/CUIL" value="{{ old('cuil') }}" onkeypress="return validateCuil(event)" required="required">
                </div>
                {!! $errors->first('cuil', '<small style = "color:#ff0000">:message</small><br>') !!}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xs-3">
                <label>Ingresos Brutos*</label>
                <select class="form-control" name="ingresos_brutos" id="ingresos_brutos" value="{{ old('ingresos_brutos') }}" required>
                    <option disabled selected hidden value="">Seleccione una Opción</option>
                    <option value="0">Sin Convenio Multilateral</option>
                    <option value="1">Con Convenio Multilateral</option>
                </select>
            </div>
            <div class="col-md-2">
                <label> País* <br></label>
                <select class="selectpicker" title="Seleccione un país" data-show-subtext="true" data-live-search="true" name="pais_id" id="pais_select_picker" required="required" data-width="100%">
                    @foreach ($paises as $pais)
                        <option value={{$pais->id}}>
                            {{$pais->name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>Provincia / Estado* <br></label>
                <select class="selectpicker" data-show-subtext="true" title="Seleccione una provincia" data-live-search="true" disabled name="provincia_id" id="prov_select_picker" required="required" data-width="100%" disabled> </select>
            </div>

            <div class="col-md-4">
                <label>Localidad*</label>

                <a id='buttom-crear-loc' data-toggle="modal" class='btn disabled' title='Nueva Localidad' style="padding-top: 0px; padding-bottom: 0px;" data-target="#modal_nuevaLocalidad"><i class="fa fa-1 fa-plus-square" style="color:#008a55;" aria-hidden="true "></i></a>

                <div class="modal fade" id="modal_nuevaLocalidad" tabindex="-1" role="dialog" aria-labelledby="nuevaLoc" data-backdrop="static" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Nueva Localidad</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>País:</label>
                                        <h4 id='nombre_pais_modal'></h4>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Provincia:</label>
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
                                            <button type="button" class="btn btn-danger" id="btn-cancel-modal-loc" data-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-success pull-right" id="crearLocalidad" data-dismiss="modal">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <select class="selectpicker" data-show-subtext="true" title="Seleccione una localidad" data-live-search="true" disabled name="localidad_id" id="loc_select_picker" required="required" data-width="100%" disabled></select>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-12">
                <label> Dirección* <br></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-address-card" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" name="direccion" id="direccion" maxlength="180" placeholder="Ingrese Dirección" value="{{ old('direccion') }}" required="required">
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
                    <div class="box-body no-padding">
                        <table class="table row-border table-striped table-bordered table-condensed" id="contactosTable" name="contactosTable">
                            <tr>
                                <th style="width: 7%">#</th>
                                <th style="width: 30%">Nombre</th>
                                <th style="width: 30%">E-mail</th>
                                <th style="width: 25%">Teléfono/s</th>
                                <th style="width: 8%"></th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-success pull-right" id="btn-crear-cliente"><b>Crear Cliente</b></button>
        <a href="{{route('clientes.index')}}" class="btn btn-danger"><b>Cancelar</b></a>
    </div>
</div>

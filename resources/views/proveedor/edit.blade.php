@extends('layout')

<!-- Título de la pag web y la sección-->
@section('title')
Editar Proveedor
@endsection

<!-- Contenido Css Esxtra -->

@section('import_css')
<link rel="stylesheet" href="{{URL::asset('/css/bootstrap-select.min.css')}}">
<link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>


@csrf
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

<!-- Contenido Principal-->
@section('content')

    <div class="box box-info">
        <div class="box-header with-border">
            <h1 class="box-title">Tecnometal - Editar Proveedor</h1>
        </div>
        <div class="box-body">
            <div class="text-info">(*) Campos obligatorios</div>
            <br>
            <form role="form" action="{{route('proveedores.update', $proveedor->id)}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row">

                    <div class="col-xs-4">
                        <label>Razón Social* <br></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" placeholder="Razón social" name="name" value="{{old('name',$proveedor->name)}}" required>
                        </div>
                            {!! $errors->first('name', '<small style = "color:#ff0000">:message</small><br>') !!}
                    </div>

                    <div class="col-xs-3">
                        <label>Condición Iva*</label>
                        <select class="form-control" name="condicion_iva" required>
                            <option disabled selected hidden value="">Elija una Opción</option>
                            <option value="N/D" @if ($proveedor->condicion_iva == "N/D") selected @endif>N/D</option>
                            <option value="IVA Responsable Inscripto" @if ($proveedor->condicion_iva == "IVA Responsable Inscripto") selected @endif>IVA Responsable Inscripto</option>
                            <option value="IVA Responsable No Inscripto" @if ($proveedor->condicion_iva == "IVA Responsable No Inscripto") selected @endif>IVA Responsable No Inscripto</option>
                            <option value="IVA No Responsable" @if ($proveedor->condicion_iva == "IVA No Responsable") selected @endif>IVA No Responsable</option>
                            <option value="IVA Sujeto Exento" @if ($proveedor->condicion_iva == "IVA Sujeto Exento") selected @endif>IVA Sujeto Exento</option>
                            <option value="Consumidor Final" @if ($proveedor->condicion_iva == "Consumidor Final") selected @endif>Consumidor Final</option>
                            <option value="Monotributista" @if ($proveedor->condicion_iva == "Monotributista") selected @endif>Monotributista</option>
                            <option value="Sujeto No Categorizado" @if ($proveedor->condicion_iva == "Sujeto No Categorizado") selected @endif>Sujeto No Categorizado</option>
                            <option value="Proveedor del Exterior" @if ($proveedor->condicion_iva == "Proveedor del Exterior") selected @endif>Proveedor del Exterior</option>
                        </select>
                        {!! $errors->first('condicion_iva', '<small style = "color:#ff0000">:message</small><br>') !!}
                    </div>

                    <div class="col-xs-2">
                        <label>C.U.I.L/C.U.I.T*</label>
                        <div class='input-group'>
                            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="Ingrese CUIT/CUIL" name="cuil" onkeypress="return validateCuil(event)" value="{{old('cuil',$proveedor->cuil)}}" required>
                        </div>
                        {!! $errors->first('cuil', '<small style = "color:#ff0000">:message</small><br>') !!}
                    </div>

                    <div class="col-xs-3">
                        <label>Convenio multilateral*</label>
                        <select class="form-control" name="ingresos_brutos" required>
                            <option disabled selected hidden value="">Elija una Opción</option>
                            <option value="1" @if ($proveedor->ingresos_brutos == 1 or old('ingresos_brutos')==1) selected @endif>Con Convenio Multilateral</option>
                            <option value="0" @if ($proveedor->ingresos_brutos == 0 or old('ingresos_brutos')==0) selected @endif>Sin Convenio Multilateral</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-4">
                        <label>Pais*<br></label>
                        <select  class="selectpicker" data-show-subtext="true" data-live-search="true" name="pais_id"
                        id="pais_select_picker" title="Seleccione un País" required="required" data-width="100%">
                        @foreach ($paises as $pais)
                            <option value="{{$pais->id}}" @if ($proveedor->localidad->provincia->pais->id == $pais->id) selected @endif>{{$pais->name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <label>Provincia*<br></label>
                        <select class="selectpicker" data-show-subtext="true" data-live-search="true"
                        name="provincia_id" id="prov_select_picker" required="required" data-width="100%" title="Seleccione una Provincia">
                        @foreach ($provincias as $provincia)
                            <option value="{{$provincia->id}}" @if ($proveedor->localidad->provincia->id == $provincia->id) selected @endif>{{$provincia->name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <label>Localidad*<br></label>

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


                        <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="localidad_id"
                        id="loc_select_picker" required="required" data-width="100%" title="Seleccione una Localidad">
                        @foreach ($localidades as $loc)
                            <option value="{{$loc->id}}" @if ($proveedor->localidad->id == $loc->id) selected @endif>
                                {{$loc->name}} [C.P.:{{$loc->codigo_postal}}]
                            </option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class='row'>
                    <div class="col-xs-12">
                        <label>Dirección*<br></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-address-card" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="Ingrese Dirección" name="direccion" value="{{old('direccion',$proveedor->direccion)}}" required>
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
                                    @foreach ($proveedor->contactos as $contacto)
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


            </div>

                <div class="box-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success pull-right"><b>Actualizar Proveedor</b></button>
                        <a href="{{route('proveedores.index')}}" class="btn btn-danger"><b>Cancelar</b></a>
                    </div>
                </div>
        </form>
    </div>
@endsection

<!-- JS Extra -->
@section('imports_js')
<script src="{{URL::asset('/js/bootstrap-select.min.js')}}"></script>
<script src="{{URL::asset('/js/own_functions.js')}}"></script>
<script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>

<script>
    //Activar y cargar selector de provincia
    $(document).ready(function(){
        $('#pais_select_picker').change(function(){
            pais_id = $('#pais_select_picker').val();

            if (pais_id){
                cadena = 'pais_id='+pais_id;
                $.ajax({
                    type:"POST",
                    url:"{{URL::asset('/provincias/get_provs')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:cadena,
                    success:function(r){
                        add_options('#prov_select_picker',r.data)
                    },
                });
            }
        });
    });

    //Activar y cargar selector de localidad
    $(document).ready(function(){
        $('#prov_select_picker').change(function(){
            provincia_id = $('#prov_select_picker').val();

            if (provincia_id){
                var buttom_create_loc = document.getElementById('buttom-crear-loc');
                buttom_create_loc.classList.remove("disabled")
                cadena = 'provincia_id='+provincia_id;
                $.ajax({
                    type:"POST",
                    url:"{{URL::asset('/localidades/get_locs')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:cadena,
                    success:function(r){
                        add_options('#loc_select_picker',r.data)
                    },
                });
            }
        });
    });

    //Cargar selects si es que ya fue seleccionado un pais o una porvincia
    $(document).ready(function(){
        $('#buttom-crear-loc').click(function(){
            pais_id = $('#pais_select_picker option:selected').text();
            prov_id = $('#prov_select_picker option:selected').text();

            if(pais_id && prov_id){
                $('#nombre_pais_modal').text(pais_id);
                $('#nombre_prov_modal').text(prov_id);
            }
        });
    });
    $(document).ready(function(){
        $('#crearLocalidad').click(function(){
            provincia_id = $('#prov_select_picker').val();
            pais_id = $('#pais_select_picker').val();
            name = $('#nombreLocalidad_modal').val();
            codigo_postal = $('#cp_modal').val();

            if (pais_id && provincia_id && name && codigo_postal){
                cadena = 'name='+name+'&provincia_id='+provincia_id+'&codigo_postal='+codigo_postal;
                $.ajax({
                    type:"POST",
                    url:"{{URL::asset('/localidades/store_locs')}}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:cadena,
                    success:function(r){
                        alertify.success("Localidad Creada.");
                        add_localidad(r.data);
                        $('#nombreLocalidad_modal').val("");
                        $('#cp_modal').val("");
                    },
                    error:function(r){
                        alertify.error("Error al crear la localidad.");
                    },
                });
            }else{
                alertify.warning('Debe completar todos los campos');
            }
        });
    });

    $(document).ready(function(){
        $('#btn-cancel-modal').click(function(){
            $('#nombreLocalidad_modal').val("");
            $('#cp_modal').val("");
        });
    });

    //Contactos JS

    function editar_contacto(id,name,email,telefono){
        $('#nombreContacto_edit_modal').val(name);
        $('#emailContacto_edit_modal').val(email);
        $('#telefContacto_edit_modal').val(telefono);
        $('#id_contacto_modal').val(id);
    }

    $(document).ready(function(){
        $('#editContacto').click(function(){
            var id_contacto = $('#id_contacto_modal').val();
            var table = document.getElementById('contactosTable');

            var name = $('#nombreContacto_edit_modal').val();
            var email = $('#emailContacto_edit_modal').val();
            var telefono = $('#telefContacto_edit_modal').val();

            table.rows[id_contacto].cells[1].innerHTML = '<input class="form-control" style="border: none;background-color: transparent;" name="name_cont['+id_contacto+']" value="'+name+'" readonly>';
            table.rows[id_contacto].cells[2].innerHTML = '<input class="form-control" style="border: none;background-color: transparent;" name="email_cont['+id_contacto+']" value="'+email+'" readonly>';
            table.rows[id_contacto].cells[3].innerHTML = '<input class="form-control" style="border: none;background-color: transparent;" name="tel_cont['+id_contacto+']" value="'+telefono+'" readonly>';
            table.rows[id_contacto].cells[4].innerHTML = '<a href="#" id="editarContacto" class="btn btn-primary btn-xs" title="Editar Contacto" data-toggle="modal" data-target="#modal_editContacto" onclick="editar_contacto(\''+id_contacto+'\',\''+name+'\',\''+email+'\',\''+telefono+'\');"><i class="fa fa-edit" aria-hidden="true "></i></a> <a href="#" class="delete btn button btn-danger btn-xs" title="Delete" data-toggle="tooltip" onclick="return false"><span class="glyphicon glyphicon-trash"></span></a>';
        });
    });

    $(document).ready(function(){
        $('#crearContacto').click(function(){
            name_cont = $('#nombreContacto_modal').val();
            name_cont = name_cont.charAt(0).toUpperCase() + name_cont.slice(1);
            email_cont = $('#emailContacto_modal').val();
            tel_cont = $('#telefContacto_modal').val();

            if ( (name_cont && email_cont) || (name_cont && tel_cont)){
                var table = document.getElementById("contactosTable");
                var ban = true;
                for (var i = 1, row; row = table.rows[i]; i++) {
                    if (row.cells[2].getElementsByTagName("input")[0].value == email_cont || row.cells[3].getElementsByTagName("input")[0].value == tel_cont){
                        ban = false;
                    }
                }
                if (ban){
                    var table = document.getElementById("contactosTable");
                    var row = table.insertRow(table.rows.length);
                    var cell1 = row.insertCell(0);
                    var id_cont = table.rows.length-1;
                    cell1.innerHTML = id_cont+'<input type="hidden" name="id_contacto_real['+id_cont+']" value=""/>';
                    var cell2 = row.insertCell(1);
                    cell2.setAttribute("data-name", "name");
                    cell2.innerHTML = '<input class="form-control" style="border: none;background-color: transparent;" name="name_cont['+id_cont+']" value="'+name_cont+'" readonly>';
                    var cell3 = row.insertCell(2);
                    cell3.setAttribute("data-name", "email");
                    cell3.innerHTML = '<input class="form-control" style="border: none;background-color: transparent;" name="email_cont['+id_cont+']" value="'+email_cont+'" readonly>';
                    var cell4 = row.insertCell(3);
                    cell4.setAttribute("data-name", "telefono");
                    cell4.innerHTML = '<input class="form-control" style="border: none;background-color: transparent;" name="tel_cont['+id_cont+']" value="'+tel_cont+'" readonly>';
                    var cell5 = row.insertCell(4);
                    cell5.innerHTML = '<a href="#" id="editarContacto" class="btn btn-primary btn-xs" title="Editar Contacto" data-toggle="modal" data-target="#modal_editContacto" onclick="editar_contacto(\''+id_cont+'\',\''+name_cont+'\',\''+email_cont+'\',\''+tel_cont+'\');"><i class="fa fa-edit" aria-hidden="true "></i></a> <a href="#" class="delete btn button btn-danger btn-xs" title="Delete" data-toggle="tooltip" onclick="return false"><span class="glyphicon glyphicon-trash"></span></a>';
                } else {
                    alertify.error('No se puede ingresar un e-mail o teléfono ya existente');
                }
            }else{
                alertify.warning('Debe ingresar un nombre y al menos un e-mail o teléfono');
            }
            $('#nombreContacto_modal').val("");
            $('#emailContacto_modal').val("");
            $('#telefContacto_modal').val("");
        });
    });

    $(document).on("click", ".delete", function(){
        var response = confirm("¿Seguro que desea eliminar este contacto?");
        if(response){

            $(this).parents("tr").remove();
            var tbl  = document.getElementById('contactosTable');
            var rows = tbl.getElementsByTagName('tr');

            for (var row=1; row<$('#contactosTable tr').length;row++) {
                var cels = rows[row].getElementsByTagName('td');
                var id_cont_real = cels[0].getElementsByTagName('input')[0].value;
                var name_cont = cels[1].getElementsByTagName('input')[0].value;
                var email_cont = cels[2].getElementsByTagName('input')[0].value;
                var tel_cont = cels[3].getElementsByTagName('input')[0].value;
                cels[0].innerHTML = row+'<input type="hidden" name="id_contacto_real['+row+']" value="'+id_cont_real+'"/>';
                cels[1].innerHTML = '<input class="form-control" style="border: none;background-color: transparent;" name="name_cont['+row+']" value="'+name_cont+'" readonly>';
                cels[2].innerHTML = '<input class="form-control" style="border: none;background-color: transparent;" name="email_cont['+row+']" value="'+email_cont+'" readonly>';
                cels[3].innerHTML = '<input class="form-control" style="border: none;background-color: transparent;" name="tel_cont['+row+']" value="'+tel_cont+'" readonly>';
                //cels[0].innerHTML = row;
            }
        }
    });

    $(document).ready(function(){
        $('#btn-cancel-modal-cont').click(function(){
            $('#nombreContacto_modal').val("");
            $('#emailContacto_modal').val("");
            $('#telefContacto_modal').val("");
        });
    });
</script>


@endsection

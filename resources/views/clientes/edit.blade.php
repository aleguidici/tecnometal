@extends('layout')


@section('import_css')
    <link rel="stylesheet" href="{{URL::asset('/css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('/alertify/css/alertify.css')}}">
    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('title', 'Editar Cliente')

@section('content')
    <form method="POST" action="{{route('clientes.update', $cliente)}}">
        @method('PATCH') <!-- Exclusivo de laravel, es lo mismo que escribir <input type="hidden" name="_method" value="PATCH"> -->

        @include('clientes._formEdit')
    </form>

@endsection

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
                            alertify.success("Localidad Creada.")
                            add_localidad(r.data)
                            $('#nombreLocalidad_modal').val("")
                            $('#cp_modal').val("")
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

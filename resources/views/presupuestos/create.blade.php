@extends('layout')

<!-- Título de la pag web y la sección-->
@section('title')
Crear un Presupuesto
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
                    <h1 class="box-title">Nuevo Presupuesto / Cotización </h1>
                    <!--<h1 class="box-title pull-right">N° {{substr(sprintf('%05d', $last_id), -5).'/'.substr(sprintf('%02d', $last_id), 0, -5)}}</h1> -->
                </div>
                <div class='box-body'>
                    <form action="{{route('presupuestos.store')}}" method="POST" id="table-create-presupuesto">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-info">(*) Campos obligatorios</div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <input type="hidden" value="{{$last_id}}" name="presupuesto_id">
                            <div class="col-md-12">
                                <label> Cliente* <br></label>
                                <select class="selectpicker" title="Seleccione un Cliente" data-show-subtext="true" data-live-search="true" name="cliente_id" id="cliente_select_picker" required="required" data-width="100%">
                                    @foreach ($clientes as $un_cliente)
                                        <option value={{$un_cliente->id}}>
                                            {{ Illuminate\Support\Str::limit($un_cliente->name.' (CUIT: '.$un_cliente->cuil.'; Dirección: '.$un_cliente->direccion.' - '.$un_cliente->localidad->name.', '. $un_cliente->localidad->provincia->name.')',150) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <b><p id="contacto_label" style="color: grey"><input type='checkbox' onclick='handleClick(this);' id="contacto_checkbox" disabled>&nbsp Con solicitante<br></p></b>
                                <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="contacto_id" id="contacto_select_picker" required="required" data-width="100%" title="Seleccione un solicitante" disabled>
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
                                <input type="text" class="form-control" name="referencia" id="referencia" maxlength="100" placeholder="Ingrese Referencia" value="{{ old('referencia') }}">
                            </div>
                            <div class="col-md-6">
                                <label> Obra </label>
                                <input type="text" class="form-control" name="obra" id="obra" maxlength="100" placeholder="Ingrese Obra" value="{{ old('obra') }}">
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="moneda_material">Tipo de Moneda de los Materiales *<br></label>
                                <select class="form-control" name="moneda_material" id="moneda_material" required>
                                    <option disabled selected hidden value="">Elija una Opción</option>
                                    @foreach ($tipos_moneda as $moneda)
                                        <option value="{{$moneda->id}}">{{$moneda->descripcion}} ({{$moneda->signo}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="moneda_material">Tipo de Moneda de las Mano de Obra *</label>
                                <select class="form-control" name="moneda_mano_obra" id="moneda_mano_obra" required>
                                    <option disabled selected hidden value="">Elija una Opción</option>
                                    @foreach ($tipos_moneda as $moneda)
                                        <option value="{{$moneda->id}}">{{$moneda->descripcion}} ({{$moneda->signo}})</option>
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
                                <textarea id="observacionesTextArea" name="observaciones" rows="10" cols="80" style="width: 100%;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success pull-right"><b>Crear Presupuesto</b></button>
                            <a href="{{route('presupuestos.index')}}" class="btn btn-danger"><b>Cancelar</b></a>
                        </div>
                    </div>
                </form>
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
        
        //Activar y cargar selector de solicitante
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
            
            //$('#contacto_select_picker').change(function(){
            //    console.log($('#cliente_select_picker').val());
            //    console.log($('#contacto_select_picker').val());
            //});
        });
    </script>
@endsection
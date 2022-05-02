@extends('layout')

@section('import_css')
    <link rel="stylesheet" href="{{URL::asset('/css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('/alertify/css/alertify.css')}}">

    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title', 'Editar Localidad')

@section('content')
    <form method="POST" action="{{route('localidades.update', $localidad)}}">
        @method('PATCH')

        @include('localidades._formEdit')
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
                        url:"/provincias/get_provs",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data:cadena,
                        success:function(r){
                            add_options('#prov_select_picker',r.data)
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
    </script>
@endsection

@extends('layout')

@section('import_css')
<link rel="stylesheet" href="{{URL::asset('/css/bootstrap-select.min.css')}}">
<link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>

@csrf
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('title', 'Crear Localidad')

@section('content')
    <form method="POST" action="{{route('localidades.store')}}">
        @include('localidades._formCreate')
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
</script>
@endsection

@extends('layout')

@section('title')
Gestión de Usuarios
@endsection

@section('import_css')
 <!-- DataTables -->
 <link rel="stylesheet" href="{{URL::asset('/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
 <link rel="stylesheet" href="{{URL::asset('/alertify/css/alertify.min.css')}}"/>
 <script src="{{URL::asset('/alertify/alertify.min.js')}}"></script>
@endsection

@section('content-header')
    <h1 class="display-1">Usuarios</h1>
@endsection

@section('content')

@if(session()->has('alert'))
    <script>
        alertify.alert("Error","{{ session()->get('alert') }}").set('basic', false);
    </script>
@endif

<a class="btn btn-success pull-right" style="margin-right: 10px; margin-bottom: 10px;" href="{{route('usuarios.create')}}"><i class="fa fa-user-plus" aria-hidden="true"></i> Crear Usuario</a>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="proveedores" class="table row-border table-striped table-bordered table-condensed" style="width: 100%">
                        <thead>
                            <tr>
                                <th style="width: 30%">Usuario</th>
                                <th style="width: 17%">Email</th>
                                <th style="width: 43%">Tipo Usuario</th>
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td>{{$usuario->name}}</td>
                                    <td>{{$usuario->email}}</td>
                                    <td>@if ($usuario->tipo_usuario == 1)
                                        Administrador
                                    @else
                                        Usuario Común
                                    @endif</td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-xs" href='{{route('usuarios.edit', $usuario->id)}}' title="Editar">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-xs" href="{{route('usuarios.destroy',$usuario->id)}}" data-method="delete" title="Eliminar" onclick="return confirm('¿Seguro que desea eliminar este proveedor?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
            </div>
            <!-- /.box -->
    </div>
</div>
@endsection

@section('imports_js')

<!-- DataTables -->
<script src="{{URL::asset('/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

<script>
$(document).ready(function() {
    $('#proveedores').DataTable({
        "order": [[ 0, "asc" ]],
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

@endsection

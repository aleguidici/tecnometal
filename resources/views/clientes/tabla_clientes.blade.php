<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="clientes" class="table row-border table-striped table-bordered table-condensed" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 35%">Razón Social</th>
                                <th style="width: 20%">Dirección</th>
                                <th style="width: 20%">Localidad - Provincia [ País ]</th>
                                <th style="width: 15%">IIBB</th>
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $un_cliente)
                                <tr>
                                    <td>{{ $un_cliente->name }}</td>
                                    <td>
                                        <a target="_blank" href="http://maps.google.com/maps?q={{ $un_cliente->direccion.' '.$un_cliente->localidad->name.' '.$un_cliente->localidad->provincia->name }}">{{ $un_cliente->direccion }}</a>
                                    </td>
                                    <td>{{ $un_cliente->localidad->name . ' - ' . $un_cliente->localidad->provincia->name . ' [ ' . $un_cliente->localidad->provincia->pais->iso_alfa3 . ' ]' }}</td>
                                    <td>
                                        @if ( $un_cliente->ingresos_brutos == '0' )
                                            Sin conv. mult. 
                                        @else
                                            Con conv. mult. 
                                        @endif 
                                    </td> 
                                    <td class="text-center">
                                        <a href="{{route('clientes.show', $un_cliente)}}" class="btn btn-success btn-xs" title="Ver detalles del Cliente" data-toggle="tooltip">
                                            <i class="fa fa-1x fa-info-circle" aria-hidden="true "></i>
                                        </a>
                                        <a href="{{route('clientes.edit', $un_cliente)}}" class="btn btn-primary btn-xs" title="Editar Cliente" data-toggle="tooltip">
                                            <i class="fa fa-edit" aria-hidden="true "></i>
                                        </a>
                                        <a title="Eliminar Cliente" href="{{URL::to('/clientes/destroy/'.$un_cliente->id)}}" class="btn btn-danger btn-xs" onclick="return confirm('¿Seguro que desea eliminar este cliente?')"><i class="fa fa-1x fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

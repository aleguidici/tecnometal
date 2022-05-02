<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="localidades" class="table row-border table-striped table-bordered table-condensed" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 20%">País</th>
                                <th style="width: 25%">Provincia</th>
                                <th style="width: 30%">Localidad</th>
                                <th style="width: 15%">Código Postal</th>
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($localidades as $una_localidad)
                                <tr>
                                    <td>{{ $una_localidad->provincia->pais->name }}</td>
                                    <td>{{ $una_localidad->provincia->name }}</td>
                                    <td>{{ $una_localidad->name }}</td>
                                    <td>{{ $una_localidad->codigo_postal }}</td>
                                    <td class="text-center">
                                        <a href="{{route('localidades.edit', $una_localidad)}}" class="btn btn-primary btn-xs" title="Editar Localidad" data-toggle="tooltip">
                                            <i class="fa fa-edit" aria-hidden="true "></i>
                                        </a>
                                        <a title="Eliminar Localidad" href="{{URL::to('/localidades/destroy/'.$una_localidad->id)}}" class="btn btn-danger btn-xs" onclick="return confirm('¿Seguro que desea eliminar esta localidad?')"><i class="fa fa-1x fa-trash-o"></i></a>
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

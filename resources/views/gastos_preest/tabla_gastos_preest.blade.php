<div class="row">
    <div class="col-xs-2"></div>
    <div class="col-xs-8">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="pull-right">
                            <a href="#createGastoPrest" class="btn btn-success open-createGastoPrest" data-toggle="modal"><i class="fa fa-plus"></i>&nbsp; Crear Gasto Preestablecido</a>
                        </div>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table id="gastos_preest" class="table row-border table-striped table-bordered table-condensed" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 10%">#</th>
                                <th style="width: 60%">Descripcion</th>
                                <th style="width: 20%">Valor</th>
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gastos_preest as $un_gasto)
                                <tr>
                                    <td>{{ $un_gasto->id }}</td>
                                    <td>{{ $un_gasto->descripcion }}</td>
                                    <td class="text-center">{{ $un_gasto->valor * 100 }}%</td>
                                    <td class="text-center">
                                        <a href="{{route('gastos_preest.edit', $un_gasto)}}" class="btn btn-primary btn-xs" title="Editar Valor" data-toggle="tooltip">
                                            <i class="fa fa-edit" aria-hidden="true "></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!--<div class="modal fade" id="modal_editarValor" tabindex="-1" role="dialog" aria-labelledby="editValor" data-backdrop="static" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" style="color:rgb(0, 0, 0);">Editar valor</h4>
                                    <h4 id='idGasto_modal'></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Descripción:</label>
                                            <h4 id='descripGasto_modal'></h4>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Porcentaje:</label>
                                            <input style="border:1px solid #000000" id="valorGasto_modal" maxlength="100" class="form-control" placeholder="Porcentaje">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <br>
                                            <div>
                                                <button type="button" class="btn btn-danger" id="btn-cancel-modal-cont" data-dismiss="modal">Cancelar</button>
                                                <button type="button" class="btn btn-success pull-right" id="guardarValor" data-dismiss="modal">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="createGastoPrest" tabindex="-1" role="dialog" aria-labelledby="createGastoPrest" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" id="close-create-gasto-prest" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title">Crear Gasto Preestablecido <a href="#" data-toggle="tooltip" data-html="true" title="<em><b>¿Qué es un gasto preestablecido?</b></em> Es todo impuesto, costo, beneficio o porcentaje a ser considerado en el presupuesto." data-placement="right"><i class="fa fa-question-circle-o" style="color: rgb(88, 155, 182);" aria-hidden="true"></i></a></h5>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 vcenter">
                                <label>Descripción del Gasto Preestablecido</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <textarea type="text" id="desc_gasto" style="border: 1px solid #000000" class="form-control" required></textarea>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-md-12 vcenter">
                                <label>Porcentaje por defecto:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class='input-group'>
                                    <input type="text" class="form-control" placeholder="Valor" id="valor" style="border: 1px solid #000000" name="valor" onkeypress="return validateFloat(event)" onkeyup="this.value = this.value.replace(/,/g,'.');" onpaste="return false" required>
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" id="crearGasto" class="btn btn-success pull-right" data-dismiss="modal">Agregar Gasto Preestablecido</button>
                                <button type="button" class="btn btn-danger" id="cancelar-gasto" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>

                    </div>
                </div>
        </div>
    </div>

</div>

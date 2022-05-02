<div class="modal fade" id="modal_nuevoContacto" tabindex="-1" role="dialog" aria-labelledby="nuevoContacto" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="color:rgb(0, 0, 0);">Nuevo Contacto</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>Nombre o Alias:</label>
                        <input style="border:1px solid #000000" id="nombreContacto_modal" maxlength="100" class="form-control" placeholder="Nombre o Alias">
                    </div>
                    <div class="col-md-6">
                        <label>E-mail:</label>
                        <input style="border:1px solid #000000" id="emailContacto_modal" maxlength="100" class="form-control" placeholder="E-mail">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label>Teléfono/s:</label>
                        <input style="border:1px solid #000000" id="telefContacto_modal" maxlength="100" class="form-control" placeholder="Teléfono/s" onkeypress="return validateNumber(event)">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <div>
                            <button type="button" class="btn btn-danger" id="btn-cancel-modal-cont" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-success pull-right" id="crearContacto" data-dismiss="modal">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

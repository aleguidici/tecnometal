<div class="modal fade" id="modal_editContacto" tabindex="-1" role="dialog" aria-labelledby="editContacto" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="color:rgb(0, 0, 0);">Editar Contacto</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>Nombre o Alias:</label>
                        <input style="border:1px solid #000000" id="nombreContacto_edit_modal" maxlength="100" class="form-control" placeholder="Nombre o Alias">
                    </div>
                    <div class="col-md-6">
                        <label>E-mail:</label>
                        <input style="border:1px solid #000000" id="emailContacto_edit_modal" maxlength="100" class="form-control" placeholder="E-mail">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label>Teléfono/s:</label>
                        <input style="border:1px solid #000000" id="telefContacto_edit_modal" maxlength="100" class="form-control" placeholder="Teléfono/s" onkeypress="return validateNumber(event)">
                    </div>
                    <input type="hidden" id="id_contacto_modal" />
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <div>
                            <button type="button" class="btn btn-danger" id="btn-cancel-cont-edit-modal" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-success pull-right" id="editContacto" data-dismiss="modal">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

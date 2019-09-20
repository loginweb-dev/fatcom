{{-- Modal nuevo cliente --}}
<form id="form-nuevo_cliente" action="" method="post">
    <div class="modal modal-info fade" tabindex="-1" id="modal-nuevo_cliente" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="voyager-person"></i> Nuevo cliente</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nombre o razón social</label>@if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Nombre completo o razón social del cliente. este campo es obligatorio."></span> @endif
                        <input type="text" name="razon_social" class="form-control" placeholder="Ingrese el nombre o razón social del cliente" required>
                    </div>
                    <div class="form-group">
                        <label for="">NIT o CI</label>@if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="NIT o CI del cliente. este campo no es obligatorio."></span> @endif
                        <input type="text" name="nit" class="form-control" placeholder="Ingrese el NIT o CI del cliente">
                    </div>
                    <div class="form-group">
                        <label for="">Movil</label>@if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Número de celular del cliente. este campo no es obligatorio."></span> @endif
                        <input type="text" name="movil" class="form-control" placeholder="Ingrese el número de celular del cliente">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary pull-right"value="Aceptar">
                    <button type="button" class="btn btn-default pull-right" id="btn-cancel-map" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</form>
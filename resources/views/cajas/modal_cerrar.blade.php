{{-- modal cerrar --}}
<form id="form-close" action="{{route('cajas_close')}}" method="POST">
    <div class="modal modal-danger fade" tabindex="-1" id="modal_close" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        <i class="voyager-treasure"></i> Estás seguro que quieres cerrar la caja?
                    </h4>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="">
                    <textarea name="observaciones" class="form-control" rows="5" placeholder="Observaciones"></textarea>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-danger pull-right delete-confirm"value="Sí, cerrar!">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

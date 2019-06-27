{{-- modal delete iamgen del producto--}}
<form id="form-delete_imagen" action="{{route('delete_imagen')}}" method="POST">
    <div class="modal modal-danger fade" tabindex="-1" id="modal_delete" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        <i class="voyager-trash"></i> Estás seguro que quieres borrar la imagen?
                    </h4>
                </div>

                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="">
                    <input type="submit" class="btn btn-danger pull-right delete-confirm"value="Sí, bórralo!">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

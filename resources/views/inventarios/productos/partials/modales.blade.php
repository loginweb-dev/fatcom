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

<div class="modal fade" id="dropzone_modal" tabindex="-1" role="dialog" aria-labelledby="dropzone_modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Agregar imagenes</h4>
        </div>
        <div class="modal-body">
            <form action="{{route('add_images_product', ['id'=>$producto_id])}}" class='dropzone' >
                @csrf
                <div class="dz-default dz-message" data-dz-message="">
                    <h3 class="text-muted">
                        Da click o arrastra un archivo<br>
                        <small>(Tamaño máximo 5MB, formatos admitidos .jpeg,.jpg,.png)</small>
                    </h3>
                </div>
            </form> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"> Cerrar</button>
        </div>
      </div>
    </div>
  </div>

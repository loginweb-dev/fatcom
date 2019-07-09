<div class="modal modal-primary fade" tabindex="-1" id="modal_mapa" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="voyager-location"></i> Ubicación del pedido</h4>
            </div>
            <div class="modal-body">
                <div id="list-ubicaciones"></div>
                <div id="contenedor_mapa">
                    <div id="map"></div>
                </div>

                <input type="hidden" name="lat" id="latitud" >
                <input type="hidden" name="lon" id="longitud">
                <input type="hidden" name="coordenada_id" id="input-coordenada_id">
                <textarea name="descripcion" class="form-control" id="input-descripcion" rows="2" maxlength="200" placeholder="Datos descriptivos de su ubicación..."></textarea>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary pull-right"value="Aceptar" data-dismiss="modal">
                <button type="button" class="btn btn-default pull-right" id="btn-cancel-map" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

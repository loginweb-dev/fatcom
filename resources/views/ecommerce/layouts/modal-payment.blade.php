<div class="modal modal-info fade" tabindex="-1" id="modal_confirmar" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <i class="fa fa-credit-card"></i> Elija la forma de pago
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <table width="100%" cellpadding="10">
                        @php
                            $checked = 'checked';
                        @endphp
                        @foreach ($pasarela_pago as $item)
                        <tr>
                            <td><input type="radio" {{ $checked }} @if($item->estado == 0) disabled @endif name="tipo_pago"></td>
                            <td><img src="{{ url('storage/'.$item->icono) }}" width="80px" alt="icono"></td>
                            <td>{{ $item->nombre }} <br> <b>{{ $item->descripcion }}</b></td>
                        </tr>
                        @php
                            $checked = '';
                        @endphp
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <input type="submit" class="btn btn-info delete-confirm"value="Confirmar">
            </div>
        </div>
    </div>
</div>
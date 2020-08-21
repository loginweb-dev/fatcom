
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th style="width:80px">N&deg; ticket</th>
                <th>Tipo</th>
                <th>Hora de <br> Pedido</th>
                <th>Hora de <br> entregar</th>
                <th>Detalles</th>    
                <th class="actions text-right" style="width:100px">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ventas as $item)
            <tr>
                <td>{{ $item->nro_venta }} {{ $item->dias }}</td>
                <td>{{ $item->tipo_venta }}</td>
                <td>{{ date('H:i', strtotime($item->created_at)) }} <br> <small>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small></td>
                <td>
                    {{ date('H:i', strtotime($item->hora_entrega)) }}
                    <br> <small @if($item->hora_entrega < date('Y-m-d H:i:s')) class="text-danger" style="font-weight:bold" @endif>{{ \Carbon\Carbon::parse($item->hora_entrega)->diffForHumans() }}</small>
                </td>
                <td>
                    <ul style="list-style:none;font-size:16px">
                        @foreach ($item->items as $detalle)
                            <li>
                                {{ intval($detalle->cantidad) }} {{ $detalle->producto->nombre }} {{ $detalle->productoadicional ? $detalle->productoadicional->nombre : ''  }} {{ $detalle->producto->subcategoria->nombre }}
                            </li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <button title="Listo" class="btn btn-success btn-lg btn-listo" data-id="{{ $item->id }}" style="text-decoration:none">
                        <i class="voyager-check"></i> <span class="hidden-xs hidden-sm">Listo</span>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No hay pedidos pendientes <span class="voyager-frown"></span> </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function(){
        $('.btn-listo').click(function(){
            id = $(this).data('id');
            $(this).html('Enviando...');
            $.get('{{ url("admin/ventas/lista") }}/'+id, function(res){
                if(res == 1){
                    get_pendientes();
                }else{
                    toastr.error('Ocurrión un problema insperado', 'Error');
                }
            });
        });
    });
</script>
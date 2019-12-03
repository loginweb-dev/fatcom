<div class="table-responsive">
    <table id="dataTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>N&deg; venta</th>
                <th>N&deg; ticket</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Opción</th>
                <th class="actions text-right">Acciones</th>
            </tr>
        </thead>
        <tbody id="lista-ventas">
            @forelse ($registros as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>#{{ $item->nro_venta }}</td>
                    <td><ins class="text-{{ $item->tipo_etiqueta }}" style="font-weight:bold">{{ $item->tipo_nombre }}</ins></td>
                    <td>{{ date('d-m-Y H:i', strtotime($item->created_at)) }} <br> <small>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small> </td>
                    <td>{{ $item->cliente }}</td>
                    <td class="text-center">
                        {{ $item->importe_base }}
                        @if(!$item->efectivo)
                            <br> <i class="voyager-credit-card text-info" style="font-size:22px"></i>
                        @endif
                    </td>
                    {{-- Calcular si el cluente debe --}}
                    @php
                        $debe = false;
                        $deuda = '';
                        if($item->importe_base > $item->monto_recibido){
                            $debe = true;
                            $deuda = number_format($item->importe_base - $item->monto_recibido, 2, ',', '');
                        }
                    @endphp
                    {{-- Mostrar etiqueta del estado de la venta --}}
                    <td>
                        @if($item->estado == 'A')
                            <label class="label label-danger">Anulada</label>
                        @else
                            <label class="label label-{{$item->estado_etiqueta}}">{{$item->estado_nombre}}</label>
                            {{-- Si debe y el estado es LISTO se muestra la deuda --}}
                            @if($debe && $item->estado_id == 3) <label class="label label-danger" data-toggle="tooltip" data-placement="bottom" title="El cliente tiene una deuda de {{$deuda}} Bs.">Debe Bs. {{ $deuda }}</label>@endif
                        @endif
                    </td>
                    <td>
                        @if($item->estado == 'V')
                            @if($item->siguiente_estado)
                                <a  title="{{ $item->siguiente_estado->nombre }}" class="btn btn-cambiar_estado btn-delivery btn-{{ $item->siguiente_estado->etiqueta }}"
                                    @if($item->siguiente_estado->id == 4)
                                        href="#" data-toggle="modal" data-target="#modal_delivery" data-id="{{$item->id}}"
                                    @else
                                    href="{{ route('estado_update', ['id' => $item->id, 'valor' => $item->siguiente_estado->id]) }}"
                                    @endif
                                >
                                    <i class="{{ $item->siguiente_estado->icono }}"></i> <span class="hidden-xs hidden-sm">{{ $item->siguiente_estado->nombre }}</span>
                                </a>
                            @endif
                        @endif
                    </td>
                    <td class="no-sort no-click text-right" id="bread-actions">
                        @if(auth()->user()->hasPermission('read_ventas'))
                        <a href="{{route('ventas_view', ['id' => $item->id])}}" title="Ver" class="btn btn-sm btn-warning view">
                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                        </a>

                            @if($item->estado == 'V')
                            <a title="Imprimir" onclick="print({{ $item->id }})" class="btn btn-sm btn-primary btn-print">
                                <i class="voyager-polaroid"></i> <span class="hidden-xs hidden-sm">Imprimir</span>
                            </a>
                            @endif
                        @endif
                        @if(auth()->user()->hasPermission('delete_ventas') && $item->estado == 'V')
                        <a href="#" title="Borrar" class="btn btn-sm btn-danger btn-delete" data-id="{{$item->id}}" data-importe="{{$item->importe_base}}" data-caja_id="{{$item->caja_id}}" data-toggle="modal" data-target="#modal_delete">
                            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                        </a>
                        @endif
                    </td>
                </tr>
            @empty
            <tr>
                <td colspan="9"><p class="text-center"><br>No hay registros para mostrar.</p></td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="col-md-12">
    <div class="col-md-4" style="overflow-x:auto">
        @if(count($registros)>0)
            <p class="text-muted">Mostrando del {{$registros->firstItem()}} al {{$registros->lastItem()}} de {{$registros->total()}} registros.</p>
        @endif
    </div>
    <div class="col-md-8" style="overflow-x:auto">
        <nav class="text-right">
            {{ $registros->links() }}
        </nav>
    </div>
</div>

<script>
    $(document).ready(function(){

        // set valor de delete
        $('.btn-delete').click(function(){
            $('#modal_delete input[name="id"]').val($(this).data('id'));
            $('#modal_delete input[name="importe"]').val($(this).data('importe'));
            $('#modal_delete input[name="caja_id"]').val($(this).data('caja_id'));
        });

        // Set valor de asignar repartidor
        $('.btn-delivery').click(function(){
            $('#modal_delivery input[name="id"]').val($(this).data('id'));
        });

        $('.page-link').click(function(e){
            e.preventDefault();
            let link = $(this).attr('href');
            if(link){
                page = link.split('=')[1];
                // Set variable de pagina actual
                page_actual = page;
                get_data(sucursal_actual, search, page)
            }
        });
    });
</script>
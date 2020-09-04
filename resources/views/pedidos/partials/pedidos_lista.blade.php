<div class="table-responsive">
    <table id="dataTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>N&deg; Pedido</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Estado</th>
                <th class="actions text-right">Acciones</th>
            </tr>
        </thead>
        <tbody id="lista-ventas">
            @forelse ($registros as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ date('d-m-Y H:i', strtotime($order->created_at)) }} <br> <small>{{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</small> </td>
                    <td>
                        {{ $order->cliente }} <br>
                        @if ($order->cliente_movil)
                            <a href="tel:{{ $order->cliente_movil }}"><small>{{ $order->cliente_movil }}</small></a>
                        @endif
                    </td>
                    <td>
                        {{ $order->total }}
                    </td>
                    {{-- Mostrar etiqueta del estado del pedido --}}
                    <td>
                        @if($order->estado == 'R')
                            <label class="label label-danger">Recepcionado</label>
                        @else
                            <label class="label label-{{$order->estado}}">{{$order->estado}}</label>
                        @endif
                    </td>
                    <td class="no-sort no-click text-right" id="bread-actions">
                        @if(auth()->user()->hasPermission('read_orders'))
                            @if(setting('empresa.facturas') && $order->estado == 'V' && !$order->nro_factura)
                            <a data-toggle="modal" data-target="#modal_change" data-id="{{ $order->id }}" title="Convertir a factura" class="btn btn-sm btn-dark btn-change">
                                <i class="voyager-certificate"></i> <span class="hidden-xs hidden-sm"></span>
                            </a>
                            @endif
                        <a href="{{ route('orders.show',['id' => $order->id])}}" title="Ver" class="btn btn-sm btn-warning view">
                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                        </a>

                            @if($order->estado == 'F')
                            <a title="Imprimir" onclick="print({{ $order->id }})" class="btn btn-sm btn-primary btn-print">
                                <i class="voyager-polaroid"></i> <span class="hidden-xs hidden-sm">Imprimir</span>
                            </a>
                            @endif
                        @endif
                        @if(auth()->user()->hasPermission('delete_orders') && $order->estado == 'V')
                        <a href="#" title="Borrar" class="btn btn-sm btn-danger btn-delete" data-id="{{ $order->id }}" data-importe="{{$order->importe_base}}" data-caja_id="{{$order->caja_id}}" data-toggle="modal" data-target="#modal_delete">
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
        
        // set id de venta que se convertirá a factura
        $('.btn-change').click(function(){
            $('#modal_change input[name="id"]').val($(this).data('id'));
        });

        // set valor de delete
        $('.btn-delete').click(function(){
            $('#modal_delete input[name="id"]').val($(this).data('id'));
            $('#modal_delete input[name="importe"]').val($(this).data('importe'));
            $('#modal_delete input[name="caja_id"]').val($(this).data('caja_id'));
        });

        // Set valor de asignar repartidor
        $('.btn-delivery').click(function(){
            $('#modal_delivery input[name="id"]').val($(this).data('id'));
            $('.btn-elegir-repartidor').removeAttr('disabled');
        });

        // Cambiar estado al pedido
        $('.btn-cambiar_estado').click(function(e){
            let url = $(this).prop('href');
            // Si el ultimo caracter del atributo href es # quiere decir que esta visualizando una ventana modal (para elegir repartidor)
            if(url[url.length-1] !== '#'){
                e.preventDefault();
                $.get(url, function(data){
                    if(data.success){
                        toastr.success('El cambio de estado fué actualizado exitosamente.', 'Bien hecho!');
                        get_data(sucursal_actual, search, page_actual);
                    }else{
                        toastr.error(data.error, 'Error!');
                    }
                });
            }
        });

        $('.page-link').click(function(e){
            e.preventDefault();
            let link = $(this).attr('href');
            if(link){
                page = link.split('=')[1];
                // Set variable de pagina actual
                page_actual = page;
                $('#data').html(`<div class="text-center" style="height:200px"><br><img src="${loader}" width="100px"></div>`);
                get_data(sucursal_actual, search, page);
            }
        });
    });
</script>
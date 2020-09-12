<div>
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th style="width:60px">Imagen</th>
                    @if ($deposito->inventario)
                    <th class="actions text-right">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php
                    $cont = 0;
                @endphp
                @forelse ($registros as $item)
                    @php
                        $img = ($item->imagen != '') ? url('storage/'.str_replace('.', '_small.', $item->imagen)) : url('/img/default.png');
                        $imagen = url('storage/'.$item->imagen) ?? '';
                    @endphp
                    <tr>
                        <td>{{ $item->codigo }}</td>
                        <td>{{ $item->nombre }} <br> <small>{{ $item->subcategoria }}</small></td>
                        <td>{{ $item->precio_venta }} {{ $item->abreviacion }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td><a href="{{ $imagen }}" data-fancybox="galeria1" data-caption="{{ $item->nombre }}"><img src="{{ $img }}" width="50px" alt=""></a></td>
                        @if ($deposito->inventario)
                        <td class="no-sort no-click text-right" id="bread-actions">
                            @if(auth()->user()->hasPermission('edit_producto_depositos'))
                            <a data-toggle="modal" data-target="#modal_edit_producto" data-id="{{ $item->id }}" data-cantidad="{{ $item->cantidad }}" title="Editar" class="btn btn-sm btn-primary btn-edit">
                                <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span>
                            </a>
                            <a data-toggle="modal" data-target="#modal_delete_producto" data-id="{{ $item->id }}" data-cantidad="{{ $item->cantidad }}" title="Anular" class="btn btn-sm btn-danger btn-delete">
                                <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Anular</span>
                            </a>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @php
                        $cont++;
                    @endphp
                @empty
                <tr>
                    <td colspan="7"><p class="text-center"><br>No hay registros para mostrar.</p></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <div class="col-md-6" style="overflow-x:auto">
            @if(count($registros)>0)
                <p class="text-muted">Mostrando del {{$registros->firstItem()}} al {{$registros->lastItem()}} de {{$registros->total()}} registros.</p>
            @endif
        </div>
        <div class="col-md-6" style="overflow-x:auto">
            <nav class="text-right">
                {{ $registros->links() }}
            </nav>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        $('.page-link').click(function(e){
            e.preventDefault();
            let link = $(this).attr('href');
            if(link){
                page = link.split('=')[1];
                listItems(list_items, page);
            }
        });
         // set valor de delete
         $('.btn-delete').click(function(){
            $('#modal_delete_producto input[name="producto_id"]').val($(this).data('id'));
            $('#modal_delete_producto input[name="stockActual"]').val($(this).data('cantidad'));
        });
        // set valor de edit
        $('.btn-edit').click(function(){
            $('#modal_edit_producto input[name="producto_id"]').val($(this).data('id'));
            $('#modal_edit_producto input[name="stock_actual"]').val($(this).data('cantidad'));
        });
    });
</script>
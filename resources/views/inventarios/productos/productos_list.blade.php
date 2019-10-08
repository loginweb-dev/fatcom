<div class="table-responsive">
    <table id="dataTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th class="actions text-right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @php
                $cont = 0;
            @endphp
            @forelse ($registros as $item)
                @php
                    $img = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : 'productos/default.png';
                    $imagen = ($item->imagen!='') ? $item->imagen : 'productos/default.png';
                @endphp
                <tr>
                    @if(!empty($item->codigo_interno))
                    <td>{{$item->codigo_interno}}</td>
                    @else
                    <td>{{$item->id}}</td>
                    @endif
                    <td>{{$item->nombre}} <br> <small>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</small> </td>
                    <td>{{$item->subcategoria}}</td>
                    <td>{{$item->precio_venta}}</td>
                    <td>{{$item->stock}}</td>
                    <td><a href="{{ url('storage').'/'.$imagen }}" data-fancybox="galeria1" data-caption="{{ $item->nombre }}"><img src="{{url('storage').'/'.$img}}" width="50px" alt=""></a></td>
                    <td class="no-sort no-click text-right" id="bread-actions">
                        <a href="{{route('productos_copy', ['id' => $item->id])}}" title="Copiar" class="btn btn-sm btn-success">
                            <i class="voyager-wand"></i> <span class="hidden-xs hidden-sm">Copiar</span>
                        </a>
                        @if(auth()->user()->hasPermission('read_productos'))
                        <a href="{{route('productos_view', ['id' => $item->id])}}" title="Ver" class="btn btn-sm btn-warning view">
                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                        </a>
                        @endif
                        @if(auth()->user()->hasPermission('edit_productos'))
                        <a href="{{route('productos_edit', ['id'=>$item->id])}}" title="Editar" class="btn btn-sm btn-primary edit">
                            <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span>
                        </a>
                        @endif
                        @if(auth()->user()->hasPermission('delete_productos'))
                        <a href="#" title="Borrar" class="btn btn-sm btn-danger btn-delete" data-id="{{$item->id}}" data-toggle="modal" data-target="#modal_delete">
                            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                        </a>
                        @endif
                    </td>
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
        });

        $('.page-link').click(function(e){
            e.preventDefault();
            let link = $(this).attr('href');
            if(link){
                page = link.split('=')[1];
                filtro('{{url("admin/productos/lista")}}', page);
            }
        });
    });
</script>
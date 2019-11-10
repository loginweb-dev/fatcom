<div class="table-responsive">
    <table id="dataTable" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Detalles</th>
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
                    <td>{{$item->codigo}}</td>
                    @endif
                    <td>{{ $item->nombre }} <br> <small>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small> </td>
                    {{-- Detalle del producto --}}
                    <td>
                        <table style="font-size:12px">
                            <tr>
                                <td><b>Categoría</b></td>
                                <td>: {{ $item->categoria }}</td>
                            </tr>
                            <tr>
                                <td><b>Subcategoría</b></td>
                                <td>: {{ $item->subcategoria }}</td>
                            </tr>
                            <tr>
                                <td><b>Marca</b></td>
                                <td>: {{ $item->marca }}</td>
                            </tr>
                            
                            {{-- Solo si el negocio es una boutique se muestran estos demas datos --}}
                            @if(setting('admin.modo_sistema') == 'boutique')
                            <tr>
                                <td><b>Talla</b></td>
                                <td>: {{ $item->talla }}</td>
                            </tr>
                            <tr>
                                <td><b>Color</b></td>
                                <td>: {{ $item->color }}</td>
                            </tr>
                            <tr>
                                <td><b>Género</b></td>
                                <td>: {{ $item->genero }}</td>
                            </tr>
                            @endif

                        </table>
                    </td>
                    <td>{{ $item->moneda }} {{ $item->precio_venta }}</td>
                    <td>{{ $item->stock }}</td>
                    <td><a href="{{ url('storage').'/'.$imagen }}" data-fancybox="galeria1" data-caption="{{ $item->nombre }}"><img src="{{ url('storage').'/'.$img }}" width="80px" alt=""></a></td>
                    <td class="no-sort no-click text-right" id="bread-actions">
                        <a href="#" data-toggle="modal" data-target="#modal_copy" data-id="{{ $item->id }}" title="Copiar" class="btn btn-sm btn-success btn-copy">
                            <i class="voyager-wand"></i> <span class="hidden-xs hidden-sm">Copiar</span>
                        </a>
                        @if(auth()->user()->hasPermission('read_productos'))
                        <a href="{{route('productos_view', ['id' => $item->id])}}" title="Ver" class="btn btn-sm btn-warning view">
                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                        </a>
                        @endif
                        @if(auth()->user()->hasPermission('edit_productos'))
                        <a href="{{route('productos_edit', ['id' => $item->id])}}" title="Editar" class="btn btn-sm btn-primary edit">
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

<form action="{{ route('productos_copy') }}" method="POST" >
    <div class="modal modal-success fade" tabindex="-1" id="modal_copy" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        <i class="voyager-list-add"></i> Estás seguro que quieres hacer una copia del siguiente registro?
                    </h4>
                </div>

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pull-right">Copiar</button>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
    $(document).ready(function(){
        // set valor de delete
        $('.btn-delete').click(function(){
            $('#modal_delete input[name="id"]').val($(this).data('id'));
        });

        // set valor de copy
        $('.btn-copy').click(function(){
            $('#modal_copy input[name="id"]').val($(this).data('id'));
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
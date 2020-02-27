<div>
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th style="width:60px">Imagen</th>
                    <th class="actions text-right">Acciones</th>
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
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->precio }} Bs.</td>
                        <td>{{ $item->stock }}</td>
                        <td><a href="{{ $imagen }}" data-fancybox="galeria1" data-caption="{{ $item->nombre }}"><img src="{{ $img }}" width="50px" alt=""></a></td>
                        <td class="no-sort no-click text-right" id="bread-actions">

                        </td>
                    </tr>
                    @php
                        $cont++;
                    @endphp
                @empty
                <tr>
                    <td colspan="5"><p class="text-center"><br>No hay registros para mostrar.</p></td>
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
    });
</script>
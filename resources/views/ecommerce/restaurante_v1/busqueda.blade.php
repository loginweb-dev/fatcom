<div class="row">
    @forelse ($productos as $item)
    @php
        $precio_venta = $item->precio_venta;
        $precio_actual = $precio_venta;
        if($item->monto_oferta){
            if($item->tipo_descuento=='porcentaje'){
                $precio_venta -= ($precio_actual*($item->monto_oferta/100));
            }else{
                $precio_venta -= $item->monto_oferta;
            }
        }
    @endphp
    <div class="col-md-6">
        <div class="row mb-4 hoverable align-items-center">
            <div class="col-6">
                @php
                    $img = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : 'productos/default.png';
                @endphp
            <a href="{{ route('detalle_producto_ecommerce', ['producto'=>$item->slug]) }}">
                <img src="{{ url('storage/'.$img) }}" class="img-fluid" alt="{{ $item->nombre }}" width="100px">
            </a>
            </div>
            <div class="col-6">
            <!-- Title -->
            <a class="pt-5" href="{{ route('detalle_producto_ecommerce', ['producto'=>$item->slug]) }}">
                <strong>{{ $item->nombre }}</strong>
            </a>
            <!-- Rating -->
            <ul class="rating">
                @php
                    $puntos = $item->puntos ? intval($item->puntos) : 0;
                    $cont = 0;
                @endphp
                {{-- Estrellas obtenidas --}}
                @for ($i = 0; $i < $puntos; $i++)
                    <li><i class="fas fa-star gray-text"></i></li>
                    @php $cont++; @endphp
                @endfor
                {{-- Estrellas falantes --}}
                @for ($i = $cont; $i < 5; $i++)
                    <li><i class="fas fa-star grey-text"></i></li>
                    @php $cont++; @endphp
                @endfor
            </ul>
            <!-- Price -->
            <h6 class="h6-responsive font-weight-bold dark-grey-text">
                <strong>{{ $item->moneda }} {{ number_format($precio_venta, 2, ',', '.') }}</strong>
                @if($item->monto_oferta)
                    <span class="red-text"><small><s>{{ $item->moneda }} {{ number_format($precio_actual, 2, ',', '.') }}</s></small></span>
                @endif
            </h6>
            </div>
        </div>
    </div>
    @empty
        <div class="col-md-12 text-center bg-white padding-y-lg">
            <h1 class="display-4">OOPS!</h1>
            <h2 class="display-6">No se encontraron resultados.</h2>
        </div>
    @endforelse
</div>
@if(count($productos)>0)
    <div class="row justify-content-center mt-4 mb-4">
        <nav class="mb-4">
            <div id="paginador-search" class="col-md-12" style="overflow-x:auto">
                {{ $productos->links() }}
            </div>
        </nav>
    </div>
@endif

<script>
    // Paginador de busqueda
    $('.page-link').click(function(){
        let page = $(this).prop('href');
        search(page.split('page=')[1]);
        return false;
    });
</script>

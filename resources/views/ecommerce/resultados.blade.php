@forelse ($productos as $item)
    @php
        $precio_venta = $item->precio_venta;
        $precio_actual = $precio_venta;
        if($item->monto_oferta){
            if($item->tipo_descuento=='porcentaje'){
                $precio_actual -= ($precio_actual*($item->monto_oferta/100));
            }else{
                $precio_actual -= $item->monto_oferta;
            }
        }
    @endphp
    <article class="card card-product">
        <div class="card-body">
            <div class="row">
                @php
                    $img = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : 'productos/default.png';
                @endphp
                {{-- imagen --}}
                <aside class="col-lg-3">
                    <div class="img-wrap"><img src="{{ url('storage/'.$img) }}"></div>
                </aside>
                {{-- detalles --}}
                <article class="col-lg-5">
                    <h4 class="title"> {{$item->nombre}} </h4>
                    <div class="rating-wrap">
                        <ul class="rating-stars">
                            <li style="width:{{$item->puntos*20}}%" class="stars-active">
                                <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </li>
                            <li>
                                <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </li>
                        </ul>
                        <div class="label-rating"> {{number_format($item->puntos, 1, ',', '')}}</div>
                        <div class="label-rating" title="Visto {{$item->vistas}} veces"> <span class="fa fa-eye"></span> {{$item->vistas}} </div>
                    </div>
                    <p> {{$item->descripcion_small}} </p>
                    <dl class="dlist-align">
                        <dt>Marca</dt>
                        <dd>{{$item->marca}}</dd>
                    </dl>
                    <dl class="dlist-align">
                        <dt>Modelo</dt>
                        <dd>{{$item->modelo}}</dd>
                    </dl>
                    <dl class="dlist-align">
                        <dt>Garantía</dt>
                        <dd>{{$item->garantia}}</dd>
                    </dl>
                </article>
                {{-- botones --}}
                <aside class="col-lg-4 border-left">
                    <div class="action-wrap">
                        <div class="price-wrap h4">
                            @if(!$item->monto_oferta)
                            <span class="price"> {{$item->moneda}} {{number_format($precio_venta, 2, ',', '.')}} </span>
                            @else
                            <span class="price"> {{$item->moneda}} {{number_format($precio_actual, 2, ',', '.')}} </span>
                            <del class="price-old"> {{$item->moneda}} {{number_format($precio_venta, 2, ',', '.')}} </del>
                            @endif
                        </div>
                        {{-- <p class="text-success">Free shipping</p> --}}
                        <br>
                        <p>
                            <button style="margin:5px" type="button" id="btn-add_carrito" class="btn btn-warning" onclick="agregar({{$item->id}})"> <i class="fa fa-shopping-cart"></i> Agregar</button>
                            <a style="margin:5px" href="{{ route('detalle_producto_ecommerce', ['producto'=>$item->slug]) }}" class="btn btn-primary link-page"> <i class="fa fa-list"></i> Detalles  </a>
                        </p>
                        {{-- <a href="#"><i class="fa fa-heart"></i> Add to wishlist</a> --}}
                    </div>
                </aside>
            </div>
        </div>
    </article>
@empty
    <div class="col-md-12 text-center bg-white padding-y-lg">
        <h1 class="display-4">OOPS!</h1>
        <h2 class="display-6">No se encontraron resultados.</h2>
    </div>
@endforelse
@if(count($productos)>0)
<div class="row">
    <div id="paginador-search" class="col-md-12" style="overflow-x:auto">
        {{$productos->links()}}
    </div>
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

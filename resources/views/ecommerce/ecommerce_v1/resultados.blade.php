<header class="border-bottom mb-4 pb-3">
    <div class="form-inline">
        <span class="mr-md-auto" id="label-search-total"><b>{{ count($productos) }} Resultados</b></span>
        {{-- <select class="mr-2 form-control">
            <option>Latest items</option>
            <option>Trending</option>
            <option>Most Popular</option>
            <option>Cheapest</option>
        </select> --}}
        <div class="btn-group">
            <a href="#" class="btn btn-outline-secondary btn-type-view @if($view == 'normal') active @endif" data-type="normal" data-toggle="tooltip" title="Lista"><i class="fa fa-bars"></i></a>
            <a href="#" class="btn  btn-outline-secondary btn-type-view @if($view == 'grid') active @endif" data-type="grid" data-toggle="tooltip" title="Cuadrícula"><i class="fa fa-th"></i></a>
        </div>
    </div>
</header>

{{-- Hay un problema con el template al generar el diseño "grid" asi que se agrega la clase "row" --}}
<div class="@if($view == 'grid') row @endif">
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
            $img = ($item->imagen!='') ? str_replace('.', '_medium.', $item->imagen) : '../img/default.png';
        @endphp
        @if ($view == 'normal')
            <article class="card card-product-list">
                <div class="row no-gutters">
                    <aside class="col-md-3">
                        <a href="{{ route('detalle_producto_ecommerce', ['producto'=>$item->slug]) }}" class="img-wrap">
                            @if ($item->nuevo)
                                <span class="badge badge-danger"> Nuevo </span>
                            @endif
                            <img src="{{ url('storage/'.$img) }}">
                        </a>
                    </aside> <!-- col.// -->
                    <div class="col-md-6">
                        <div class="info-main">
                            <a href="{{ route('detalle_producto_ecommerce', ['producto'=>$item->slug]) }}" class="h5 title"> {{ $item->nombre }}  </a>
                            <div class="rating-wrap mb-3">
                                <ul class="rating-stars">
                                    <li style="width:{{ $item->puntos*20 }}%" class="stars-active"> 
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
                                {{-- <div class="label-rating">7/10</div> --}}
                                <div class="label-rating"> {{ number_format($item->puntos, 1, ',', '') }}</div>
                                <div class="label-rating" title="Visto {{ $item->vistas }} veces"> <span class="fa fa-eye"></span> {{$item->vistas}} </div>
                            </div> <!-- rating-wrap.// -->
                            
                            <p> {{$item->descripcion_small}} </p>
                            <br>
                            <dl class="dlist-align">
                                <dt><b>Categoría</b></dt>
                                <dd>{{ $item->subcategoria }}</dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt><b>Marca</b></dt>
                                <dd>{{ $item->marca }}</dd>
                            </dl>
                        </div> <!-- info-main.// -->
                    </div> <!-- col.// -->
                    <aside class="col-sm-3">
                        <div class="info-aside">
                            <div class="price-wrap h4">
                                @if(!$item->monto_oferta)
                                    <span class="price-wrap"> {{$item->moneda}} {{number_format($precio_venta, 2, ',', '.')}} </span>
                                @else
                                    <span class="price-wrap"> {{$item->moneda}} {{number_format($precio_actual, 2, ',', '.')}} </span>
                                    <del class="price-old text-danger"> {{$item->moneda}} {{number_format($precio_venta, 2, ',', '.')}} </del>
                                @endif
                            </div> <!-- info-price-detail // -->
                            {{-- <p class="text-success">Free shipping</p> --}}
                            <br>
                            <p>                        
                                <a style="margin:5px" href="{{ route('detalle_producto_ecommerce', ['producto'=>$item->slug]) }}" class="btn btn-primary btn-block"> <i class="fa fa-list"></i> Detalles  </a>
                                <button style="margin:5px" type="button" id="btn-add_carrito" class="btn btn-light btn-block" onclick="addCart({{ $item->id }})"> <i class="fa fa-shopping-cart"></i> Agregar</button>
                            </p>
                        </div> <!-- info-aside.// -->
                    </aside> <!-- col.// -->
                </div> <!-- row.// -->
            </article>
            <div class="clearfix"></div>
        @else
            {{-- <div class="row"> --}}
                <div class="col-md-4">
                    <figure class="card card-product-grid">
                        <div class="img-wrap"> 
                            @if ($item->nuevo)
                                <span class="badge badge-danger"> Nuevo </span>
                            @endif
                            <a href="{{ route('detalle_producto_ecommerce', ['producto'=>$item->slug]) }}"><img src="{{ url('storage/'.$img) }}"></a>
                            <a class="btn-overlay" href="{{ route('detalle_producto_ecommerce', ['producto'=>$item->slug]) }}"><i class="fa fa-search-plus"></i> Ver detalles</a>
                        </div> <!-- img-wrap.// -->
                        <figcaption class="info-wrap">
                            <div class="fix-height">
                                {{-- <a href="#" class="title">Great item name goes here</a> --}}
                                <a href="{{ route('detalle_producto_ecommerce', ['producto'=>$item->slug]) }}" class="h6 title text-truncate" style="max-width: 230px;"> {{ $item->nombre }}  </a>
                                <div class="rating-wrap mb-1">
                                    <ul class="rating-stars">
                                        <li style="width:{{ $item->puntos*20 }}%" class="stars-active"> 
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
                                    {{-- <div class="label-rating">7/10</div> --}}
                                    <div class="label-rating"> {{ number_format($item->puntos, 1, ',', '') }}</div>
                                    <div class="label-rating" title="Visto {{ $item->vistas }} veces"> <span class="fa fa-eye"></span> {{$item->vistas}} </div>
                                </div>
                                <div class="price-wrap">
                                    @if(!$item->monto_oferta)
                                        <span class="price"> {{$item->moneda}} {{number_format($precio_venta, 2, ',', '.')}} </span>
                                    @else
                                        <span class="price"> {{$item->moneda}} {{number_format($precio_actual, 2, ',', '.')}} </span>
                                        <del class="price-old text-danger"> {{$item->moneda}} {{number_format($precio_venta, 2, ',', '.')}} </del>
                                    @endif
                                </div>
                            </div>
                            <button onclick="addCart({{ $item->id }})" class="btn btn-block btn-primary">
                                Añadir al carrito <i class="fa fa-shopping-cart"></i>
                            </button>
                        </figcaption>
                    </figure>
                </div> 
            {{-- </div> --}}
        @endif

    @empty
        <div class="col-md-12 text-center bg-white padding-y-lg">
            <h1 class="display-4">OOPS!</h1>
            <h2 class="display-6">No se encontraron resultados.</h2>
        </div>
    @endforelse
</div>

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
        currentPage = page;
        search(page.split('page=')[1]);
        return false;
    });

    $('.btn-type-view').click(function(e){
        e.preventDefault();
        search(currentPage, $(this).data('type'))
    });
</script>

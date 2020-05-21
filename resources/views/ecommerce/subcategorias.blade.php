@extends('ecommerce.layouts.master')

@section('meta-datos')
    <title>{{$subcategoria->nombre}}</title>
    <meta property="og:url"           content="{{route('subcategorias_ecommerce', ['subcategoria'=>$subcategoria->slug])}}" />
    <meta property="og:type"          content="E-Commerce" />
    <meta property="og:title"         content="{{$subcategoria->nombre}} " />
    <meta property="og:description"   content="Echa un vistazo a nuestros productos de {{$subcategoria->nombre}}." />
    <meta property="og:image"         content="{{ url('storage').'/'.str_replace('\\', '/', setting('admin.social_image')) }}" />
@endsection

@section('banner')
    {{-- <section class="section-pagetop bg-secondary">
        <div class="container clearfix">
            <h2 class="title-page">{{setting('admin.nombre')}}</h2>
        </div> <!-- container //  -->
    </section> --}}
@endsection

@section('content')
    <main id="contenido" class="col-md-9 col-sm-12">
        <h1 class="display-5 my-3">{{$subcategoria->nombre}} <div class="fb-like" data-href="{{route('subcategorias_ecommerce', ['subcategoria'=>$subcategoria->slug])}}" data-width="" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div></h1>
        @php
            $cont = 0;
        @endphp
        @forelse ($productos as $item)
            @php
                $precio_venta = $precios[$cont]['precio'];
                $precio_actual = $precio_venta;
                if($ofertas[$cont]['oferta']){
                    if($ofertas[$cont]['oferta']->tipo_descuento=='porcentaje'){
                        $precio_actual -= ($precio_actual*($ofertas[$cont]['oferta']->monto/100));
                    }else{
                        $precio_actual -= $ofertas[$cont]['oferta']->monto;
                    }
                }

                $excede_precio = false;
                // filtrar por precio
                if(!empty($precio_min)){
                    if($precio_min > $precio_actual){
                        // return false;
                        // dd($precio_actual);
                        $excede_precio = true;
                    }
                }
                if(!empty($precio_max)){
                    if($precio_max < $precio_actual){
                        // return false;
                        // dd($precio_actual);
                        $excede_precio = true;
                    }
                }
            @endphp
            @if(!$excede_precio)
                <article class="card card-product">
                    <div class="card-body">
                        <div class="row">
                            @php
                                $img = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : 'productos/default.png';
                            @endphp
                            <aside class="col-sm-3">
                                <div class="img-wrap"><img src="{{url('storage').'/'.$img}}"></div>
                            </aside>
                            <article class="col-sm-5">
                                <h4 class="title"> {{$item->nombre}} </h4>
                                <div class="rating-wrap">
                                    <ul class="rating-stars">
                                        <li style="width:{{$puntuaciones[$cont]['puntos']*20}}%" class="stars-active">
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
                                    {{-- <div class="label-rating">132 reviews</div>
                                    <div class="label-rating">154 orders </div> --}}
                                    <div class="label-rating"> {{number_format($puntuaciones[$cont]['puntos'], 1, ',', '')}}</div>
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
                            <aside class="col-sm-4 border-left">
                                <div class="action-wrap">
                                    <div class="price-wrap h4">
                                        @if(!$ofertas[$cont]['oferta'])
                                        <span class="price"> {{$item->moneda}} {{number_format($precio_venta, 2, ',', '.')}} </span>
                                        @else
                                        <span class="price"> {{$item->moneda}} {{number_format($precio_actual, 2, ',', '.')}} </span>
                                        <del class="price-old"> {{$item->moneda}} {{number_format($precio_venta, 2, ',', '.')}} </del>
                                        @endif
                                    </div>
                                    {{-- <p class="text-success">Free shipping</p> --}}
                                    <br>
                                    <p>
                                        <button type="button" id="btn-add_carrito" class="btn btn-warning" onclick="cartAdd({{ $item->id }})"> <i class="fa fa-shopping-cart"></i> Agregar</button>
                                        <a href="{{route('detalle_producto_ecommerce', ['producto'=>$item->slug])}}" class="btn btn-primary link-page"> <i class="fa fa-list"></i> Detalles  </a>
                                    </p>
                                    {{-- <a href="#"><i class="fa fa-heart"></i> Add to wishlist</a> --}}
                                </div>
                            </aside>
                        </div>
                    </div>
                </article>
            @endif
            @php
                $cont++;
            @endphp
        @empty
            <div class="col-md-12 text-center bg-white padding-y-lg">
                <h1 class="display-4">OOPS!</h1>
                <h2 class="display-6">No se encontraron resultados.</h2>
            </div>
        @endforelse
        <div class="row">
            <div id="paginador-search" class="col-md-12" style="overflow-x:auto">
                {{$productos->links()}}
            </div>
        </div>
    </main>
    <aside class="col-md-3 col-sm-12">
        <div class="card card-filter">
            <div class="box">
                <h6>Productos más vistos</h6><br>
                @foreach ($recomendaciones as $item)
                    <figure class="itemside mb-3">
                        @php
                            $img = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : 'productos/default.png';
                        @endphp
                        <div class="aside">	<img class="img-sm" width="80" src="{{url('storage').'/'.$img}}"> </div>
                        <figcaption class="text-wrap">
                            <p class="title b">{{$item->nombre}}</p>
                            <button class="btn btn-warning btn-sm" type="button" title="Agregar al carrito de compra" onclick="cartAdd({{ $item->id }})"> <i class="fa fa-shopping-cart"></i> </button>
                            <a href="{{route('detalle_producto_ecommerce', ['producto'=>$item->slug])}}" title="Detalles" class="btn btn-primary btn-sm link-page"> <i class="fa fa-list"></i> </a>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </aside>

@endsection
<script src="{{url('ecommerce_public/js/jquery-2.0.0.min.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover({ html : true });

        // cambiar imagen de muestra
        $('.img-gallery').click(function(){
            let img_medium = $(this).data('img').replace('_small', '_medium');
            let img = $(this).data('img').replace('_small', '');
            $('#img-medium').attr('src', img_medium);
            $('#img-slider').attr('href', img);
        });

        // Paginador de busqueda
        $('.page-link').click(function(){
            let page = $(this).prop('href');
            categorias(page.split('page=')[1], {{$id}});
            return false;
        });
    });
</script>

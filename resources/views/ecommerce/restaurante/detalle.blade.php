@extends('ecommerce.master')

@section('meta-datos')
    <title>{{$producto->nombre}}</title>
    <meta property="og:url"           content="{{route('detalle_producto_ecommerce', ['id' => $id])}}" />
    <meta property="og:type"          content="E-Commerce" />
    <meta property="og:title"         content="{{$producto->nombre}}" />
    <meta property="og:description"   content=" {{$producto->descripcion_small}}" />
    <meta property="og:image"         content="{{url('storage').'/'.$producto->imagen}}" />
@endsection

@section('banner')
    {{-- <section class="section-pagetop bg-secondary">
        <div class="container clearfix">
            <h2 class="title-page">{{setting('empresa.nombre')}}</h2>
        </div> <!-- container //  -->
    </section> --}}
@endsection

@section('content')
    <main id="contenido" class="col-md-9 col-sm-12">
        <div class="card">
            <div class="row no-gutters">
                <aside class="col-sm-6 border-right">
                    <article class="gallery-wrap">
                        <div class="img-big-wrap" style="text-align:center">
                            @php
                                $img = ($producto->imagen!='') ? str_replace('.', '_medium.', $producto->imagen) : 'productos/default.png';
                                $imagen = ($producto->imagen!='') ? $producto->imagen : 'productos/default.png';
                            @endphp
                            <a id="img-slider" href="{{url('storage').'/'.$imagen}}" data-fancybox="slider1">
                                <img id="img-medium" class="img-thumbnail img-sm" src="{{url('storage').'/'.$img}}">
                            </a>
                        </div>
                        <div class="img-small-wrap">
                            @foreach ($imagenes as $item)
                                @php
                                    $img = str_replace('.', '_small.', $item->imagen);
                                    $imagen = $item->imagen;
                                @endphp
                                <div class="item-gallery"><img src="{{url('storage').'/'.$img}}" class="img-thumbnail img-sm img-gallery" data-img="{{url('storage').'/'.$img}}"></div>
                                {{-- <a id="img-slider" href="{{url('storage').'/'.$imagen}}" data-fancybox="slider1"></a> --}}
                            @endforeach
                        </div>
                    </article> <!-- gallery-wrap .end// -->
                </aside>
                <aside class="col-sm-6">
                    <article class="card-body">
                    <!-- short-info-wrap -->
                        <h3 class="title mb-3">{{$producto->nombre}}</h3>
                        <div class="mb-3">
                            @php
                                $precio_venta = $precios_venta[0]->precio;
                                $precio_actual = $precio_venta;
                                if($oferta){
                                    if($oferta->tipo_descuento=='porcentaje'){
                                        $precio_actual -= ($precio_actual*($oferta->monto/100));
                                    }else{
                                        $precio_actual -= $oferta->monto;
                                    }
                                }
                            @endphp
                            <var class="price h3 text-warning">
                                @if(!$oferta)
                                    <span class="currency">{{$producto->moneda}} </span><span class="num">{{number_format($precio_venta, 2, ',', '.')}}</span>
                                @else
                                    <span class="currency">{{$producto->moneda}} </span><span class="num">{{number_format($precio_actual, 2, ',', '.')}}</span>
                                    <del class="price-old">{{$producto->moneda}} {{number_format($precio_venta, 2, ',', '.')}}</del>
                                @endif
                            </var>
                        </div>
                        @if($oferta)
                        @php
                            $monto_ahorro = $precio_venta-$precio_actual;
                            $porcentaje_ahorro = ($monto_ahorro*100)/$precio_venta;
                        @endphp
                        <dl class="row">
                            <dt class="col-sm-3">Ahorras</dt>
                            <dd class="col-sm-9 b text-danger">{{$producto->moneda}} {{number_format($monto_ahorro, '2', ',', '.')}} ({{intval($porcentaje_ahorro)}}%)</dd>
                            @if($oferta->fin!='')
                            <dt class="col-md-12 b text-info">La oferta finaliza {{\Carbon\Carbon::parse($oferta->fin)->diffForHumans()}}</dt>
                            @endif
                        </dl>
                        @endif
                        <dl>
                            <dt>Descripción</dt>
                            <dd><p>{{$producto->descripcion_small}} </p></dd>
                        </dl>
                        @php
                            $puntuacion = number_format($puntuacion, 1, '.', '');
                        @endphp
                        <div class="rating-wrap">
                            <ul class="rating-stars">
                                <li style="width:{{$puntuacion*20}}%" class="stars-active">
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
                            {{-- <div class="label-rating">132 reviews</div> --}}
                            <div class="label-rating"> {{$puntuacion}}</div>
                            <div class="label-rating">
                                @if((empty($habilitar_puntuar)))
                                    <button class="btn btn-info btn-sm" data-toggle="popover" data-trigger="click" data-html="true" title="Calificación" data-placement="top" data-content='
                                        <div class="text-center" style="width:250px">
                                            <h6>¿Qué te parece nuestro producto?</h6>
                                            <hr>
                                            <form action="{{route('productos_puntuar')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$id}}">
                                                <input type="hidden" name="puntos" id="input-puntos" value="" required>
                                                <ul class="rating-stars">
                                                    <li style="width:0%" id="puntuacion" class="stars-active">
                                                        <i class="fa fa-star" onclick="puntuar(20)"></i>
                                                        <i class="fa fa-star" onclick="puntuar(40)"></i>
                                                        <i class="fa fa-star" onclick="puntuar(60)"></i>
                                                        <i class="fa fa-star" onclick="puntuar(80)"></i>
                                                        <i class="fa fa-star" onclick="puntuar(100)"></i>
                                                    </li>
                                                    <li>
                                                        <i class="fa fa-star" onclick="puntuar(20)"></i>
                                                        <i class="fa fa-star" onclick="puntuar(40)"></i>
                                                        <i class="fa fa-star" onclick="puntuar(60)"></i>
                                                        <i class="fa fa-star" onclick="puntuar(80)"></i>
                                                        <i class="fa fa-star" onclick="puntuar(100)"></i>
                                                    </li>
                                                </ul>
                                                <hr>
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-sm btn-info">Enviar</button>
                                                </div>
                                            </form>
                                        </div>'>
                                    Puntuar</button></div>
                                @endif
                            <div class="label-rating" title="Visto {{$producto->vistas}} veces"> <span class="fa fa-eye"></span> {{$producto->vistas}} </div>
                        </div>
                        <hr>
                        <button style="margin:5px" type="button" id="btn-add_carrito" data-id="{{$id}}" class="btn btn-warning" onclick="agregar({{$id}})"> <i class="fa fa-shopping-cart"></i> Agregar al carrito</button>
                        <a style="margin:5px" href="{{url('carrito/agregar/comprar').'/'.$id}}" class="btn  btn-outline-warning"> Comprar ahora </a>
                        <hr>
                        <table>
                            <tr>
                                <td>
                                    {{-- Compartir por Facebook --}}
                                    <div class="fb-like" data-href="{{route('detalle_producto_ecommerce', ['id' => $id])}}" data-width="" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>
                                </td>
                                <td>
                                    {{-- Compratir por Whatsapp --}}
                                    @if($dispositivo=='pc')
                                    <a href="https://api.whatsapp.com/send?phone=&text={{route('detalle_producto_ecommerce', ['id' => $id])}}&source=&data=" title="Compartir vía WhatsApp" class="btn btn-success btn-sm" target="_blank">
                                        WhatsApp <i class="fab fa-whatsapp"></i>
                                    </a>
                                    @else
                                        <a href="whatsapp://send?text={{route('detalle_producto_ecommerce', ['id' => $id])}}" class="btn btn-success btn-sm"title="Compartir vía WhatsApp"  target="_blank">
                                            WhatsApp <i class="fab fa-whatsapp"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </article>
                </aside>
            </div>
        </div>
        @if(!empty($producto->descripcion_long))
        <div class="card mb-3">
            <header class="card-header">
                <a href="#" data-toggle="collapse" data-target="#collapse11" aria-expanded="true" class="">
                    <i class="icon-action fa fa-chevron-down"></i>
                    <h5 class="title">Descripción detallada</h5>
                </a>
            </header>
            <div class="collapse" id="collapse11" style="">
                <article class="card-body">
                        {!!$producto->descripcion_long!!}
                </article>
            </div>
        </div>
        @endif
    </main>
    <aside class="col-md-3 col-sm-12">
        <div class="card card-filter">
            <div class="box" style="height:539px;overflow-y:auto">
                <h6>Productos similares</h6><br>
                @foreach ($recomendaciones as $item)
                    <figure class="itemside mb-3">
                        @php
                            $img = ($item['imagen']!='') ? str_replace('.', '_small.', $item['imagen']) : 'productos/default.png';
                        @endphp
                        <div class="aside">	<img class="img-sm" width="80" src="{{url('storage').'/'.$img}}"> </div>
                        <figcaption class="text-wrap">
                            <p class="title b">{{$item['nombre']}}</p>
                            <button class="btn btn-warning btn-sm" type="button" title="Agregar al carrito de compra" onclick="agregar({{$item['id']}})"> <i class="fa fa-shopping-cart"></i> </button>
                            <a href="{{route('detalle_producto_ecommerce', ['id'=>$item['id']])}}" title="Detalles" class="btn btn-primary btn-sm"> <i class="fa fa-list"></i> </a>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </aside>

@endsection
<script src="{{url('ecommerce/js/jquery-2.0.0.min.js')}}" type="text/javascript"></script>
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
    });

    function puntuar(puntos){
        $('#puntuacion').css('width', puntos+'%');
        $('#input-puntos').val(puntos);
    }
</script>

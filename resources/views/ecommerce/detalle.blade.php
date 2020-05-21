@extends('ecommerce.layouts.master')

@section('meta-datos')
    <title>{{$producto->nombre}}</title>
    <meta property="og:url"           content="{{route('detalle_producto_ecommerce', ['producto' => $producto->slug])}}" />
    <meta property="og:type"          content="E-Commerce" />
    <meta property="og:title"         content="{{ $producto->nombre }}" />
    <meta property="og:description"   content="{{ $producto->descripcion_small }}" />
    <meta property="og:image"         content="{{ url('storage').'/'.$producto->imagen }}" />

    {{-- Script del evento --}}
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v3.3&appId=302829090588863&autoLogAppEvents=1"></script>
@endsection

@section('chat_facebook')
    <!-- Your customer chat code -->
    <div class="fb-customerchat"
		attribution=setup_tool
		page_id="{{ env('FACEBOOK_CHAT_ID', NULL) }}"
		theme_color="#ffc300"
		logged_in_greeting="Hola! Te puedo ayudar?"
		logged_out_greeting="Hola! Te puedo ayudar?">
	</div>
    <!-- End your customer chat code -->
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
        <div class="card">
            <div class="row no-gutters">
                <aside class="col-sm-6 border-right">
                    <article class="gallery-wrap">
                        <div class="img-big-wrap" style="text-align:center">

                            {{-- Loader de imagen --}}
                            <div id="loader-img" style="display:none;position:absolute;width:100%;height:100%;background-color:rgba(0, 0, 0, 0.7);justify-content: center;align-items: center;">
                                <img src="{{voyager_asset('images/load.gif')}}" style="width:70px;height:70px" alt="loader">                                
                            </div>
                            {{-- End loader de imagen --}}

                            @php
                                $img = ($producto->imagen!='') ? str_replace('.', '_medium.', $producto->imagen) : 'productos/default.png';
                                $imagen = ($producto->imagen!='') ? $producto->imagen : 'productos/default.png';
                            @endphp
                            <a id="img-slider" href="{{ url('storage/'.$imagen) }}" data-fancybox="slider1">
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
                            @endforeach
                        </div>
                    </article> <!-- gallery-wrap .end// -->
                </aside>
                <aside class="col-sm-6">
                    <article class="card-body">
                    <!-- short-info-wrap -->
                        <h3 class="title mb-3">{{ $producto->nombre }}</h3>
                        <div class="mb-3">
                            @php
                                // Calcular precio de oferta si existe
                                $precio_venta = $producto->precio_venta;
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
                            @if (count($precios_venta) > 1)
                            <var class="price h3 text-warning">
                                @php
                                $lista_precios = '';
                                foreach ($precios_venta as $item) {
                                    if ($item->cantidad_minima > 1) {
                                        $lista_precios .= '<h6 class="text-dark">A partir de '.$item->cantidad_minima.' a '.$item->moneda.' '.$item->precio.'</h6>';
                                    }
                                }    
                                @endphp
                                <button class="btn btn-success btn-sm" data-toggle="popover" data-trigger="focus" data-html="true" title="Todos los precios" data-placement="bottom" data-content='
                                    <div class="text-center" style="width:200px">
                                        {{$lista_precios}}
                                    </div>'>
                                    <i class="fas fa-plus"></i> Precios
                                </button>
                            </var>
                            @endif
                        </div>

                        @if($oferta)
                        @php
                            $monto_ahorro = $precio_venta-$precio_actual;
                            $porcentaje_ahorro = round(($monto_ahorro*100)/$precio_venta, 0, PHP_ROUND_HALF_UP);
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
                            <dd><p>{{ $producto->descripcion_small }} </p></dd>
                        </dl>
                        {{-- Si el sistema está en modo "electronica_computacion" se muestran sus características --}}
                        @if (setting('admin.modo_sistema') == 'electronica_computacion')
                        <dl class="row">
                                <dt class="col-sm-3">Marca</dt>
                                <dd class="col-sm-9">{{ $producto->marca }}</dd>
    
                                <dt class="col-sm-3">Modelo</dt>
                                <dd class="col-sm-9">{{ $producto->modelo }}</dd>
    
                                @if(!empty($producto->garantia))
                                <dt class="col-sm-3">Garantía</dt>
                                <dd class="col-sm-9">{{ $producto->garantia }}</dd>
                                @endif
    
                                @if(!empty($producto->catalogo))
                                <dt class="col-sm-3">Catálogo</dt>
                                <dd class="col-sm-9"><a target="_blank" class="btn btn-success btn-sm" href="{{url('storage').'/'.$producto->catalogo}}">Ver <span class="fas fa-book"></span></a></dd>
                                @endif
                            </dl>
                        @endif
                        
                        @php
                            $puntuacion = number_format($puntuacion, 1, '.', '');
                        @endphp
                        <div class="rating-wrap">
                            <ul class="rating-stars">
                                <li style="width:{{ $puntuacion*20 }}%" class="stars-active">
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
                            {{-- Si el usuario no ha puntuado el producto se habilita el popover de puntuación --}}
                            @if((empty($habilitar_puntuar)))
                                <div class="label-rating">
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
                                                        <i class="fa fa-star" onclick="set_rate(20)"></i>
                                                        <i class="fa fa-star" onclick="set_rate(40)"></i>
                                                        <i class="fa fa-star" onclick="set_rate(60)"></i>
                                                        <i class="fa fa-star" onclick="set_rate(80)"></i>
                                                        <i class="fa fa-star" onclick="set_rate(100)"></i>
                                                    </li>
                                                    <li>
                                                        <i class="fa fa-star" onclick="set_rate(20)"></i>
                                                        <i class="fa fa-star" onclick="set_rate(40)"></i>
                                                        <i class="fa fa-star" onclick="set_rate(60)"></i>
                                                        <i class="fa fa-star" onclick="set_rate(80)"></i>
                                                        <i class="fa fa-star" onclick="set_rate(100)"></i>
                                                    </li>
                                                </ul>
                                                <hr>
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-sm btn-info">Enviar</button>
                                                </div>
                                            </form>
                                        </div>'>
                                        Puntuar
                                    </button>
                                </div>
                            @endif
                            <div class="label-rating" title="Visto {{ $producto->vistas }} veces"> <span class="fa fa-eye"></span> {{ $producto->vistas }} </div>
                        </div>

                        {{-- Mostrar datos de costo de envío --}}
                        <br>
                        <div class="label-rating">
                            @php
                                $disponible = true;
                                // Obtener las ciudades en las que está disponible el producto
                                $ciudades = '<table width="100%">';
                                foreach ($localidades_disponibles as $item) {
                                    $precio = ($item->precio > 0) ? 'Bs. '.$item->precio : '<b><i>Gratis</i></b>';
                                    $ciudades .= '<tr><td>'.$item->ciudad.' '.$precio.'</td></tr>';
                                }
                                $ciudades .= '</table>';
                            @endphp
                            @if ($envio)
                                @if ($envio == 'no asignado')
                                    <i>No has elegido la ciudad en la que te encuentras, por favor ingresa <a href="#"><b>aquí</b></a> para editar tu información.</i>
                                @elseif ($envio == 'no definido')
                                    <i>El envío de este producto <b>no está</b> disponible en tu ciudad. <br>Para ver las ciudades en las que está disponible el envío de este producto presiona
                                        {{-- Mostrar todas las ciudades en las que está disponibles el producto --}}
                                        <a href="#" id="btn-costo_envios"
                                            data-toggle="popover" data-trigger="focus" data-html="true" title="Ciudades disponibles" data-placement="bottom" data-content='
                                            <div style="width:250px">
                                                @if($ciudades != '<table width="100%"></table>') {{$ciudades}} @else <h6 class="text-center">No disponible en ninguna ciudad.</h6> @endif
                                            </div>'><b>Aquí</b>
                                        </a>.
                                    </i>
                                    @php
                                        $disponible = false;
                                    @endphp
                                @else
                                    @if ($envio->precio == 0)
                                        <i>Este producto tiene envío <b>gratis</b> para {{$envio->localidad}}.</i>
                                    @else
                                        <i>Este producto tiene un costo de envío de <b> Bs. {{$envio->precio}}</b> para {{$envio->localidad}}.</i>
                                    @endif
                                @endif
                            @else
                                <i>Para ver las ciudades en las que está disponible el envío de este producto presiona
                                    <a href="#" id="btn-costo_envios"
                                        data-toggle="popover" data-trigger="focus" data-html="true" title="Ciudades disponibles" data-placement="bottom" data-content='
                                        <div style="width:250px">
                                            @if($ciudades != '<table width="100%"></table>') {{$ciudades}} @else <h6 class="text-center">No disponible en ninguna ciudad.</h6> @endif
                                        </div>'><b>Aquí</b>
                                    </a>.<br>
                                    {{-- Debes <a href="{{ route('login') }}"><b>Iniciar sesión</b></a> o <a href="{{ route('register') }}"><b>registrarte</b></a> para poder realizar un pedido. --}}
                                </i>
                            @endif
                        </div>

                        @if($disponible)
                        <hr>
                        <button style="margin:5px" type="button" id="btn-add_carrito" data-id="{{$id}}" class="btn btn-warning" onclick="cartAdd({{ $id }})"> <i class="fa fa-shopping-cart"></i> Agregar al carrito</button>
                        <a style="margin:5px" href="{{url('carrito/agregar/comprar').'/'.$id}}" class="btn  btn-outline-warning link-page"> Comprar ahora </a>
                        @endif
                        <hr>
                        <div class="clearfix"></div>
                        <table>
                            <tr>
                                <td>
                                    {{-- Compartir por Facebook --}}
                                    <div class="fb-like" data-href="{{route('detalle_producto_ecommerce', ['producto' => $producto->slug])}}" data-width="" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>
                                </td>
                                <td>
                                    {{-- Compartir por Whatsapp --}}
                                    <a style="margin-top:-1px" 
                                        @if($dispositivo=='pc') 
                                            href="https://api.whatsapp.com/send?phone=&text={{route('detalle_producto_ecommerce', ['producto' => $producto->slug])}}&source=&data="}}
                                        @else 
                                            href="whatsapp://send?text={{route('detalle_producto_ecommerce', ['producto' => $producto->slug])}}"
                                        @endif 
                                        title="Compartir vía WhatsApp" class="btn btn-success btn-sm" target="_blank">
                                        WhatsApp <i class="fab fa-whatsapp"></i>
                                    </a>
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
                    <h5 class="title">Descripción detallada del producto</h5>
                </a>
            </header>
            <div class="" id="collapse11" style="">
                <article class="card-body">
                        {!!$producto->descripcion_long!!}
                </article>
            </div>
        </div>
        @endif
        <div>
            <div class="card card-filter">
                <div class="fb-comments" data-href="{{route('detalle_producto_ecommerce', ['producto' => $producto->slug])}}" data-width="" data-numposts="5"></div>
            </div>
        </div>
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
                            <button class="btn btn-warning btn-sm" type="button" title="Agregar al carrito de compra" onclick="cartAdd({{ $item['id'] }})"> <i class="fa fa-shopping-cart"></i> </button>
                            <a href="{{ route('detalle_producto_ecommerce', ['id'=>$item['slug']]) }}" title="Detalles" class="btn btn-primary btn-sm link-page"> <i class="fa fa-list"></i> </a>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
        {{-- Div del evento --}}
        <br>
        <div class="card card-filter">
            <div class="fb-group" data-href="https://www.facebook.com/groups/443787396385175/" data-width="280" data-show-social-context="true" data-show-metadata="false"></div>
        </div>
    </aside>

@endsection
<script src="{{url('ecommerce_public/js/jquery-2.0.0.min.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover({ html : true });

        // cambiar imagen de muestra
        $('.img-gallery').click(function(){
            $('#loader-img').css('display', 'flex');
            let img_medium = $(this).data('img').replace('_small', '_medium');
            let img = $(this).data('img').replace('_small', '');
            $('#img-medium').attr('src', img_medium);
            $('#img-slider').attr('href', img);
            setTimeout(() => {
                $('#loader-img').css('display', 'none');
            }, 1000);
        });

        // Anular la acción predeterminada del link de costo de enviós
        $('#btn-costo_envios').click(function(e){
            e.preventDefault();
        });
    });
</script>

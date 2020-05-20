@extends('ecommerce.ecommerce_v1.layouts.master')

@section('meta-datos')
    <title>{{$producto->nombre}}</title>
    <meta property="og:url"           content="{{ route('detalle_producto_ecommerce', ['producto' => $producto->slug]) }}" />
    <meta property="og:type"          content="E-Commerce" />
    <meta property="og:title"         content="{{ $producto->nombre }}" />
    <meta property="og:description"   content=" {{ $producto->descripcion_small }}" />
    <meta property="og:image"         content="{{ ('storage').'/'.$producto->imagen }}" />

    {{-- Script del evento --}}
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v3.3&appId=302829090588863&autoLogAppEvents=1"></script>
@endsection

@section('plugins')
    <!-- plugin: fancybox  -->
    <script src="{{ url('ecommerce_public/plugins/fancybox/fancybox.min.js') }}" type="text/javascript"></script>
    <link href="{{ url('ecommerce_public/plugins/fancybox/fancybox.min.css') }}" type="text/css" rel="stylesheet">
@endsection

@section('chat_facebook')
    <!-- Your customer chat code -->
    <div class="fb-customerchat"
		attribution=setup_tool
		page_id="277693723065936"
		theme_color="#ffc300"
		logged_in_greeting="Hola! Te puedo ayudar ?"
		logged_out_greeting="Hola! Te puedo ayudar ?">
	</div>
    <!-- End your customer chat code -->
@endsection

@section('plugins')
    <!-- plugin: slickslider -->
    <link href="{{ url('ecommerce_public/templates/ecommerce_v1/plugins/slickslider/slick.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('ecommerce_public/templates/ecommerce_v1/plugins/slickslider/slick-theme.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ url('ecommerce_public/templates/ecommerce_v1/plugins/slickslider/slick.min.js') }}"></script>
    <!-- plugin: owl carousel  -->
    <link href="{{ url('ecommerce_public/templates/ecommerce_v1/plugins/owlcarousel/assets/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ url('ecommerce_public/templates/ecommerce_v1/plugins/owlcarousel/assets/owl.theme.default.css') }}" rel="stylesheet">
    <script src="{{ url('ecommerce_public/templates/ecommerce_v1/plugins/owlcarousel/owl.carousel.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            /////////////////  items slider. /plugins/slickslider/
            if ($('.slider-banner-slick').length > 0) { // check if element exists
                $('.slider-banner-slick').slick({
                      infinite: true,
                      autoplay: true,
                      slidesToShow: 1,
                      dots: false,
                      prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                         nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
                });
            } // end if
        
             /////////////////  items slider. /plugins/slickslider/
            if ($('.slider-custom-slick').length > 0) { // check if element exists
                $('.slider-custom-slick').slick({
                      infinite: true,
                      slidesToShow: 2,
                      dots: true,
                      prevArrow: $('.slick-prev-custom'),
                      nextArrow: $('.slick-next-custom')
                });
            } // end if
        
            /////////////////  items slider. /plugins/slickslider/
            if ($('.slider-items-slick').length > 0) { // check if element exists
                $('.slider-items-slick').slick({
                    infinite: true,
                    swipeToSlide: true,
                    slidesToShow: 4,
                    dots: true,
                    slidesToScroll: 2,
                    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                       nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1
                            }
                        }
                    ]
                });
            } // end if

            /////////////////  items slider. /plugins/owlcarousel/
            if ($('.slider-banner-owl').length > 0) { // check if element exists
                $('.slider-banner-owl').owlCarousel({
                    loop:true,
                    margin:0,
                    items: 1,
                    dots: false,
                    nav:true,
                    navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
                });
            } // end if 
        
            /////////////////  items slider. /plugins/owlslider/
            if ($('.slider-items-owl').length > 0) { // check if element exists
                $('.slider-items-owl').owlCarousel({
                    loop:true,
                    margin:10,
                    nav:true,
                    navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
                    responsive:{
                        0:{
                            items:1
                        },
                        640:{
                            items:3
                        },
                        1024:{
                            items:4
                        }
                    }
                })
            } // end if
        
            /////////////////  items slider. /plugins/owlcarousel/
            if ($('.slider-custom-owl').length > 0) { // check if element exists
                var slider_custom_owl = $('.slider-custom-owl');
                slider_custom_owl.owlCarousel({
                    loop: true,
                    margin:15,
                    items: 2,
                    nav: false,
                });
        
                // for custom navigation
                $('.owl-prev-custom').click(function(){
                    slider_custom_owl.trigger('prev.owl.carousel');
                });
        
                $('.owl-next-custom').click(function(){
                   slider_custom_owl.trigger('next.owl.carousel');
                });
        
            } // end if 
        }); 
    </script>
@endsection

@section('content')
<section class="section-content padding-y bg">
    <div class="container">
        <div class="card">
            <div class="row no-gutters">
                <aside class="col-md-6">
                    {{-- Loader de imagen --}}
                    <div id="loading-mask">
                        <div class="d-flex justify-content-center loader-text">
                            <div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>
                            <div style="padding: 5px 10px">Cargando...</div>
                        </div>
                    </div>
                                        
                    {{-- End loader de imagen --}}
                    <article class="gallery-wrap">
                        @php
                            $img = ($producto->imagen!='') ? str_replace('.', '_medium.', $producto->imagen) : 'productos/default.png';
                            $imagen = ($producto->imagen!='') ? $producto->imagen : 'productos/default.png';
                        @endphp
                        <div class="img-big-wrap">
                            <a id="img-slider" href="{{ url('storage/'.$imagen) }}" data-fancybox="slider1">
                                <img id="img-medium" class="img-thumbnail img-sm" src="{{url('storage').'/'.$img}}">
                            </a>
                        </div>
                        <div class="thumbs-wrap">
                            @foreach ($imagenes as $item)
                                @php
                                    $img = str_replace('.', '_small.', $item->imagen);
                                    $imagen = $item->imagen;
                                @endphp
                                <a href="#" class="item-thumb"> <img src="{{url('storage').'/'.$img}}" class="img-gallery" data-img="{{url('storage').'/'.$img}}"></a>
                            @endforeach
                        </div>
                    </article>
                </aside>
                <main class="col-md-6 border-left">
                    <article class="content-body">
                    
                        <h2 class="title">{{ $producto->nombre }}</h2>
                        @php
                            $puntuacion = number_format($puntuacion, 1, '.', '');
                        @endphp
                        <div class="rating-wrap my-3">
                            <ul class="rating-stars">
                                <li style="width:{{ $puntuacion*20 }}%" id="label-current-rate" class="stars-active"> 
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
                            @if((empty($habilitar_puntuar)))
                                <div class="label-rating">
                                    <button class="btn btn-info btn-sm" id="btn-rating" data-toggle="popover" data-trigger="click" data-html="true" title="Califíca el producto" data-placement="bottom" data-content='
                                        <div class="text-center" style="width:200px">
                                            <ul class="rating-stars" style="margin:10px 0px">
                                                <li style="width:0%" id="label-set-rate" class="stars-active">
                                                    <i class="fa fa-star" title="Malo" onclick="set_rate(20)"></i>
                                                    <i class="fa fa-star" title="Pobre" onclick="set_rate(40)"></i>
                                                    <i class="fa fa-star" title="Regular" onclick="set_rate(60)"></i>
                                                    <i class="fa fa-star" title="Bueno" onclick="set_rate(80)"></i>
                                                    <i class="fa fa-star" title="Excelente" onclick="set_rate(100)"></i>
                                                </li>
                                                <li>
                                                    <i class="fa fa-star" title="Malo" onclick="set_rate(20)"></i>
                                                    <i class="fa fa-star" title="Pobre" onclick="set_rate(40)"></i>
                                                    <i class="fa fa-star" title="Regular" onclick="set_rate(60)"></i>
                                                    <i class="fa fa-star" title="Bueno" onclick="set_rate(80)"></i>
                                                    <i class="fa fa-star" title="Excelente" onclick="set_rate(100)"></i>
                                                </li>
                                            </ul>
                                        </div>'>
                                        <span class="fa fa-star" data-toggle="tooltip" title="Puntuar"></span>
                                    </button>
                                </div>
                                @include('ecommerce.layouts.form-rating', ['id' => $id])
                            @endif
                            <small class="label-rating text-muted">{{ $producto->vistas }} vistas</small>
                            {{-- <small class="label-rating text-success"> <i class="fa fa-clipboard-check"></i> 154 orders </small> --}}
                        </div>
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
                        <div class="mb-3">
                            @if(!$oferta)
                                <var class="price h4">{{ $producto->moneda }} {{ number_format($precio_venta, 2, ',', '.') }}</var>
                            @else
                                <var class="price h4">{{ $producto->moneda }} {{ number_format($precio_actual, 2, ',', '.') }}</var>
                                <del class="price-old">{{$producto->moneda}} {{number_format($precio_venta, 2, ',', '.')}}</del>
                                @php
                                    $monto_ahorro = $precio_venta-$precio_actual;
                                    $porcentaje_ahorro = round(($monto_ahorro*100)/$precio_venta, 0, PHP_ROUND_HALF_UP);
                                @endphp
                                <dl class="row">
                                    <dt class="col-sm-3">Ahorras</dt>
                                    <dd class="col-sm-9 b text-danger">{{ $producto->moneda }} {{ number_format($monto_ahorro, '2', ',', '.') }} ({{ intval($porcentaje_ahorro) }}%)</dd>
                                    @if($oferta->fin!='')
                                    <dt class="col-md-12 b text-info">La oferta finaliza {{\Carbon\Carbon::parse($oferta->fin)->diffForHumans()}}</dt>
                                    @endif
                                </dl>
                            @endif
                        </div> 
                    
                        <p>{{ $producto->descripcion_small }}</p>
                        
                        <dl class="row">
                            <dt class="col-sm-3">Categoría</dt>
                            <dd class="col-sm-9">{{ $producto->subcategoria }}</dd>
                            
                            <dt class="col-sm-3">Marca</dt>
                            <dd class="col-sm-9">{{ $producto->marca }}</dd>
                            
                            {{-- <dt class="col-sm-3">Delivery</dt>
                            <dd class="col-sm-9">Russia, USA, and Europe </dd> --}}
                        </dl>
                        <hr>
                        {{-- <div class="form-row">
                            <div class="form-group col-md flex-grow-0">
                                <label>Quantity</label>
                                <div class="input-group mb-3 input-spinner">
                                <div class="input-group-prepend">
                                    <button class="btn btn-light" type="button" id="button-plus"> + </button>
                                </div>
                                <input type="text" class="form-control" value="1">
                                <div class="input-group-append">
                                    <button class="btn btn-light" type="button" id="button-minus"> &minus; </button>
                                </div>
                                </div>
                            </div>
                            <div class="form-group col-md">
                                <label>Select size</label>
                                <div class="mt-1">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="select_size" checked="" class="custom-control-input">
                                        <div class="custom-control-label">Small</div>
                                    </label>
                
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="select_size" class="custom-control-input">
                                        <div class="custom-control-label">Medium</div>
                                    </label>
                
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="select_size" class="custom-control-input">
                                        <div class="custom-control-label">Large</div>
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        {{-- Acciones del producto --}}
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
                        {{-- Mostrar datos de costo de envío --}}
                        <div class="mt-3">
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
                        <br>
                        <div class="clearfix"></div>
                        @if($disponible)
                            <a href="{{url('carrito/agregar/comprar').'/'.$id}}" class="btn btn-primary"> Comprar ahora </a>
                            <button type="button" id="btn-add_carrito" data-id="{{ $id }}" class="btn btn-outline-primary"><span class="text">Agregar al carrito</span> <i class="fas fa-shopping-cart"></i></button>
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
                                    <a style="margin-top:0px;padding:6px" 
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
                </main>
            </div>
        </div>
        <br>
        @if(!empty($producto->descripcion_long))
        <div class="card mb-3">
            <div class="card-body">
                {!!$producto->descripcion_long!!}
            </div>
        </div>
        @endif
    </div>

    {{-- @include('ecommerce.layouts.form-rating', ['id' => $id]) --}}

</section>
@endsection

@section('css')
    
@endsection

@section('script')
<script src="{{ url('js/ecommerce.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip()
        $('[data-toggle="popover"]').popover({ html : true });

        // cambiar imagen de muestra
        $('.img-gallery').click(function(e){
            e.preventDefault();
            $('#loading-mask').css('display', 'flex');
            let img_medium = $(this).data('img').replace('_small', '_medium');
            let img = $(this).data('img').replace('_small', '');
            $('#img-medium').attr('src', img_medium);
            $('#img-slider').attr('href', img);
            setTimeout(() => {
                $('#loading-mask').css('display', 'none');
            }, 500);
        });

        $('#btn-add_carrito').click(function(){
            let producto_id = $(this).data('id');
            addCart(producto_id, response =>{
                if(response==1){
                    count_cart();
                }
            });
        });

        // Anular la acción predeterminada del link de costo de enviós
        $('#btn-costo_envios').click(function(e){
            e.preventDefault();
        });
    });
</script>
@endsection
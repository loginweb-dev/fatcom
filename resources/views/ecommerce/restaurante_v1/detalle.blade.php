@extends('ecommerce.restaurante_v1.layouts.master')

@section('meta-datos')
    <title>{{$producto->nombre}}</title>
    <meta property="og:url"           content="{{ route('detalle_producto_ecommerce', ['producto' => $producto->slug]) }}" />
    <meta property="og:type"          content="E-Commerce" />
    <meta property="og:title"         content="{{$producto->nombre }}" />
    <meta property="og:description"   content=" {{$producto->descripcion_small }}" />
    <meta property="og:image"         content="{{ ('storage').'/'.$producto->imagen }}" />

    {{-- Script del evento --}}
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v3.3&appId=302829090588863&autoLogAppEvents=1"></script>
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

@section('navigation')
    @include('ecommerce.restaurante_v1.layouts.nav')
@endsection

@section('content')
<!-- Intro -->
<section>
<!-- Main Container -->
  <div class="container">
        <!-- Grid row -->
        <div class="row pt-4 mb-5">
            <!-- Content -->
            <div class="col-lg-12">
                <!-- Section: Product detail -->
                <section id="productDetails" class="pb-5">
                    <!-- News card -->
                    <div class="card mt-5 hoverable">
                        <div class="row mt-5">

                            <div class="col-lg-6 mb-4">
                                <div class="carousel-inner text-center text-md-left" role="listbox">
                                    @php
                                        $imagen = ($producto->imagen!='') ? str_replace('.', '_medium.', $producto->imagen) : 'productos/default.png';
                                    @endphp
                                    <div class="carousel-item active">
                                        <img id="producto-imagen" src="{{ url('storage/'.$imagen) }}" alt="{{ $producto->nombre }}" class="img-fluid">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 mr-3 text-center text-md-left">

                                <h2 class="h2-responsive text-center text-md-left product-name font-weight-bold dark-grey-text mb-1 ml-xl-0 ml-4"><strong>{{ $producto->nombre }}</strong></h2>
                                <!-- Rating -->
                                <div id="producto-puntos">
                                    <ul class="rating">
                                        @php
                                            $puntos = $producto->puntos ? intval($producto->puntos) : 0;
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
                                        @endfor
                                    </ul>
                                </div>
                                @if ($producto->nuevo)
                                    <span class="badge badge-danger product mb-4 ml-xl-0 ml-4">Nueva</span>
                                @endif

                                <h3 class="h3-responsive text-center text-md-left mb-5 ml-xl-0 ml-4" id="producto-precios">
                                    @php
                                        // Calcular precio de oferta si existe
                                        $precio_venta = $producto->precio_venta;
                                        $precio_actual = $precio_venta;
                                        if($oferta){
                                            if($oferta->tipo_descuento=='porcentaje'){
                                                $precio_venta -= ($precio_actual*($oferta->monto/100));
                                            }else{
                                                $precio_venta -= $oferta->monto;
                                            }
                                        }
                                    @endphp
                                    
                                    <span class="red-text font-weight-bold" id="producto-precio_venta"><strong>{{ $producto->moneda }} {{ number_format($precio_venta, 2, ',', '') }}</strong></span>
                                    <span class="grey-text"><small>
                                        <s id="producto-precio_antiguo">
                                            @if($oferta)
                                                {{ $producto->moneda }} {{ number_format($precio_actual, 2, ',', '') }}
                                            @endif
                                        </s>
                                    </small></span>
                                </h3>

                                <!-- Accordion wrapper -->
                                <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">

                                    <!-- Accordion card -->
                                    <div class="card">

                                        <!-- Card header -->
                                        <div class="card-header" role="tab" id="headingOne1">

                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
                                            <h5 class="mb-0">Detalles<i class="fas fa-angle-down rotate-icon"></i></h5>
                                        </a>

                                        </div>

                                        <!-- Card body -->
                                        <div id="collapseOne1" class="collapse show" role="tabpanel" aria-labelledby="headingOne1"
                                        data-parent="#accordionEx">

                                        <div class="card-body" id="producto-detalle">{{ $producto->descripcion_small }}</div>

                                        </div>

                                    </div>
                                    <!-- Accordion card -->

                                </div>
                                <!-- Accordion wrapper -->

                                <!-- Add to Cart -->
                                <section class="color">
                                    <div class="mt-5">
                                        {{-- <p class="grey-text">Choose your color</p> --}}
                                        <div class="row text-center text-md-left">
                                            @foreach ($presentaciones as $item)
                                            <div class="col-md-4 col-12 ">
                                                    <!-- Radio group -->
                                                <div class="form-group">
                                                    <input class="form-check-input check-presentacion" data-id="{{ $item->id }}" value="{{ $item->id }}"  name="check-presentacion" type="radio" id="radio{{ $item->id }}" @if($producto->id == $item->id) checked @endif  />
                                                    <label for="radio{{ $item->id }}" class="form-check-label dark-grey-text">{{ $item->subcategoria }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>  
                                        <div class="row mt-3 mb-4">
                                            <div class="col-md-12 text-center text-md-left text-md-right">
                                                <a  href="{{ url('/carrito/agregar/comprar').'/'.$id }}" id="btn-buy_now" class="btn btn-warning btn-rounded btn-sm"><i class="far fa-money-bill-alt mr-2" aria-hidden="true"></i> Comprar ahora</a>
                                                <button class="btn btn-primary btn-rounded btn-sm btn-cart_add"><i class="fas fa-cart-plus mr-2" aria-hidden="true"></i> Agregar</button>
                                            </div>
                                        </div>

                                    </div>
                                </section>
                                <!-- Add to Cart -->
                            </div>
                        </div>
                    </div>
                </section>
                <section>
                    <h4 class="font-weight-bold mt-4 dark-grey-text text-center"><strong>Productos similares</strong></h4>
                    <hr class="mb-5">
                    <!-- Grid row -->
                    <div class="row">
                        @php
                            $contador = 0;
                            // dd($recomendaciones);
                        @endphp
                        @foreach ($recomendaciones as $item)
                            @php
                                if($contador>3) break;
                                $contador++;
                            @endphp
                        <div class="col-lg-3 col-md-6 mb-4">
            
                            <!-- Card -->
                            <div class="card card-ecommerce">
                            @php
                                $img = ($item['imagen']!='') ? str_replace('.', '_small.', $item['imagen']) : 'productos/default.png';
                            @endphp
                            <!-- Card image -->
                            <div class="view overlay" style="min-height:150px;max-height:150px">
                                <img src="{{ url('storage').'/'.$img }}" class="img-fluid" alt="{{ $item['nombre'] }}">
                                <a href="{{ route('detalle_producto_ecommerce', ['id'=>$item['slug']]) }}"><div class="mask rgba-white-slight"></div></a>
                            </div>
                            <!-- Card image -->
            
                            <!-- Card content -->
                            <div class="card-body">
                                <!-- Category & Title -->
                                <h5 class="card-title mb-1">
                                <strong>
                                    <a href="{{ route('detalle_producto_ecommerce', ['id' => $item['slug']]) }}" class="dark-grey-text">{{ $item['nombre'] }}</a>
                                </strong>
            
                                </h5>
            
                                {{-- <span class="badge badge-danger mb-2">bestseller</span> --}}
            
                                <!-- Rating -->
                                <ul class="rating">
                                    @php
                                        $puntos = $item['puntos'] ? intval($item['puntos']) : 0;
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
                                    @endfor
                                </ul>
            
                                <!-- Card footer -->
                                {{-- <div class="card-footer pb-0">
            
                                    <div class="row mb-0">
                
                                        <span class="float-left">
                
                                        <strong>1439$</strong>
                
                                        </span>
                
                                        <span class="float-right">
                
                                        <a class="" data-toggle="tooltip" data-placement="top" title="Add to Cart">
                
                                            <i class="fas fa-shopping-cart ml-3"></i>
                
                                        </a>
                
                                        </span>
                
                                    </div>
            
                                </div> --}}
            
                            </div>
                            <!-- Card content -->
            
                            </div>
                            <!-- Card -->
            
                        </div>
                        @endforeach
                    </div>
                    <!-- Grid row -->
                </section>
            </div>
        </div>
        <!-- Grid row -->
  </div>
    <!-- Main Container -->
@endsection

@section('footer')
    @include('ecommerce.restaurante_v1.layouts.footer')
@endsection

@section('script')
    <script src="{{ url('js/ecommerce.js') }}"></script>
    <script>
        
        $(document).ready(function(){

            count_cart();

            // Cambiar la presentación
            $('.check-presentacion').click(function(){
                let id = $(this).data('id');
                $.get("{{ url('/detalle/producto/get_producto') }}/"+id, function(data){

                    let imagen = (data.imagen) ? data.imagen.replace('.', '_medium.') : 'productos/default.png';
                    $('#producto-imagen').attr('src', "{{ url('storage') }}/"+imagen)

                    $('#producto-detalle').text(data.descripcion);
                    $('#producto-precio_venta').text(data.moneda+' '+parseFloat(data.precio).toFixed(2).replace('.', ','));
                    if(data.precio != data.precio_antiguo){
                        $('#producto-precio_antiguo').text(data.moneda+' '+data.precio_antiguo);
                    }

                    // Puntuar
                    let puntos = parseInt(data.puntos);
                    let cont = 0;
                    let estrellas = '';
                    for (let index = 0; index < puntos; index++) {
                        estrellas += `<li><i class="fas fa-star gray-text"></i></li>`;
                        cont++;
                    }
                    for (let index = cont; index < 5; index++) {
                        estrellas += `<li><i class="fas fa-star grey-text"></i></li>`;
                    }
                    $('#producto-puntos').html(`<ul class="rating">${estrellas}</ul>`)
                });

                // Set id del producto a la ruta del boton de comprar ahora
                let url_buy_now = "{{ url('/carrito/agregar/comprar') }}";
                $('#btn-buy_now').attr('href', `${url_buy_now}/${id}`);
            });

            // Agregar producto al carrito
            $('.btn-cart_add').click(function(){
                let id = $('input:radio[name=check-presentacion]:checked').val()
                cartAdd(id);
            });
        });
    </script>
@endsection
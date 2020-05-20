@extends('ecommerce.restaurante_v1.layouts.master')

@section('meta-datos')
    <title>{{ setting('empresa.title') }}</title>
    <meta property="og:url"           content="{{ route('ecommerce_home')}}" />
    <meta property="og:type"          content="E-Commerce" />
    <meta property="og:title"         content="{{ setting('empresa.title') }}" />
    <meta property="og:description"   content="{{ setting('empresa.description') }}" />
    <meta property="og:image"         content="{{ url('storage').'/'.str_replace('\\', '/', setting('admin.social_image')) }}" />

    <meta name="description" content="{{ setting('empresa.description') }}">
    <meta name="keywords" content="ecommerce, e-commerce, loginweb, ventas, internet, trinidad, beni, tecnología">

@endsection

@section('navigation')
    @include('ecommerce.restaurante_v1.layouts.nav')
@endsection

@section('content')

    <!-- Main Container -->
    <div class="container" style="margin-top:100px">
        <div class="row pt-4 mb-5">
            <div class="col-lg-12">
                <!-- Section: Advertising -->
                <section>
                    <!-- Grid row -->
                    <div class="row">
                        <div class="card text-white bg-success col-md-8 offset-md-2">
                            <div class="card-body">
                                <h3 class="text-center card-title">Muchas gracias por su referencia!!!</h3>
                                <p class="card-text text-center text-white">Su pedido está siendo procesado, en un momento uno de nuestros deliverys se comunicará con usted.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Grid row -->
                    <div class="row">
                        <div class="col-md-12 text-center mt-5">
                            <a href="{{ route('pedidos_index', ['id'=>$venta_id]) }}" class="btn btn-primary">Ver detalles</a>
                        </div>
                    </div>
                </section>
                <!-- Section: Advertising -->

                <!-- Section products -->
                <section class="mt-5">
                    <br><br>
                    <div>
                        <h4 class="font-weight-bold mt-4 title-1">
                            <strong>Nuestros productos más populares</strong>
                        </h4>
                        <hr class="blue mb-5">
                    </div>
        
                    <!-- Grid row -->
                    <div class="row mb-5">
                        @php
                            $contador = 0;
                        @endphp
                        @foreach ($mas_vendidos as $item)
                            @php
                                if($contador>3) break;
                                $contador++;
                            
                                $img = ($item->imagen != '') ? str_replace('.', '_small.', $item->imagen) : 'productos/default.png';

                                // Obtener precio de oferta si existe
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
                            <!-- Grid column -->
                            <div class="col-lg-3 col-md-6 mb-4">
                                <!-- Card -->
                                <div class="card card-ecommerce">
                                    <!-- Card image -->
                                    <div class="view overlay" style="min-height:150px;max-height:150px">
                                    <img src="{{ url('storage').'/'.$img }}" class="img-fluid" alt="{{ $item->nombre }}">
                                    <a href="{{ route('detalle_producto_ecommerce', ['id' => $item->slug]) }}"><div class="mask rgba-white-slight"></div></a>
        
                                    </div>
                                    <!-- Card image -->
        
                                    <!-- Card content -->
                                    <div class="card-body">
        
                                    <!-- Category & Title -->
                                    <h5 class="card-title mb-1">
                                        <strong>
                                            <a href="{{ route('detalle_producto_ecommerce', ['id' => $item->slug]) }}" class="dark-grey-text">{{ $item->nombre }}</a>
                                        </strong>
                                    </h5>
        
                                    {{-- <span class="badge badge-info mb-2">new</span> --}}
        
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
        
                                    <!-- Card footer -->
                                    <div class="card-footer pb-0">
                                        <div class="row mb-0">
                                            <h5 class="mb-0 pb-0 mt-1 font-weight-bold">
                                                <span class="red-text"><strong>{{ $item->moneda }} {{ number_format($precio_venta, 2, ',', '.') }}</strong></span>
                                                @if($item->monto_oferta)
                                                    <span class="grey-text"><small><s>{{ $item->moneda }} {{ number_format($precio_actual, 2, ',', '.') }}</s></small></span>
                                                @endif
                                            </h5>
                                            {{-- <span class="float-right">
                                                <a class="" onclick="cartAdd({{ $item->id }})" data-toggle="tooltip" data-placement="top" title="Add to Cart">
                                                    <i class="fas fa-shopping-cart ml-3"></i>
                                                </a>
                                            </span> --}}
                                        </div>
                                    </div>
        
                                    </div>
                                    <!-- Card content -->
        
                                </div>
                                <!-- Card -->
                            </div>
                            <!-- Grid column -->
                        @endforeach
                    </div>
                    <!-- Grid row -->
    
                </section>
                <!-- Section products -->
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('ecommerce.restaurante_v1.layouts.footer')
@endsection

@section('script')
    <script src="{{ url('js/ecommerce.js') }}"></script>
    <script>
      count_cart();
    </script>
@endsection
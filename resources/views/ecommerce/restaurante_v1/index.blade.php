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
  <!-- Intro -->
  <section>
    @include('ecommerce.restaurante_v1.layouts.carrusel')
    <div style="position:absolute;top:80px;right:10px;z-index:1">
        <a href="tel:+591{{ setting('empresa.celular') }}" class="btn btn-success"> Llamar <span class="fa fa-phone"></span> </a>
    </div>
  </section>
  <!-- Intro -->
    <!-- Main Container -->
  <div class="container mt-4">
      <div class="row">
          <div class="col-md-8"></div>
          <div class="col-md-4">
            <!-- Search form -->
            <div class="md-form mt-0">
              <input class="form-control input-search_navbar" data-placement="result-navbar" type="text" placeholder="Buscar" aria-label="Buscar">
            </div>
            {{-- <div> --}}
              <ul class="list-group" id="result-navbar">
              </ul>
            {{-- </div> --}}
          </div>
      </div>

        <div class="row pt-4">
            <div class="col-lg-12">
              @if ($oferta_princial)              
                <!-- Section: Advertising -->
                <section>
                    <!-- Grid row -->
                    <div class="row">
                        <!-- Grid column -->
                        <div class="col-12">
                            <!-- Image -->
                            <div class="view  z-depth-1">
                                <img src="{{ url('storage/'.$oferta_princial->imagen) }}" style="width:30%" class="img-fluid" alt="{{ $oferta_princial->nombre }}">
                                <div class="mask rgba-stylish-slight">
                                    <div class="dark-grey-text text-right pt-lg-5 pt-md-1 mr-5 pr-md-4 pr-0">
                                        <div>
                                        <a><span class="badge badge-primary">Oferta especial</span></a>
                                        <h2 class="card-title font-weight-bold pt-md-3 pt-1">
                                            <strong>{{ $oferta_princial->nombre }}</strong>
                                        </h2>
                                        <p class="pb-lg-3 pb-md-1 clearfix d-none d-md-block">{{ $oferta_princial->descripcion }} </p>
                                        {{-- <a class="btn mr-0 btn-primary btn-rounded clearfix d-none d-md-inline-block">Read more</a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Image -->
                        </div>
                        <!-- Grid column -->
                    </div>
                    <!-- Grid row -->
                </section>
                <!-- Section: Advertising -->
              @endif
            </div>
        </div>

        <!-- Grid row -->
        <div class="row pt-5">
    
          <!-- Content -->
          <div class="col-lg-12">
    
            <!-- Section: Bestsellers & offers -->
            <section>
    
              <!-- Grid row -->
              <div class="row">
    
                <!-- Grid column -->
                <div class="col-12">
    
                  <!-- Nav tabs -->
                  <ul class="nav md-tabs nav-justified principal-color lighten-3 mx-0" role="tablist">
    
                    <li class="nav-item">
                      <a class="nav-link active text-white font-weight-bold" data-toggle="tab" href="#panel5" role="tab"> Más vendidas</a>
                    </li>
    
                    <li class="nav-item">
                      <a class="nav-link text-white font-weight-bold" data-toggle="tab" href="#panel6" role="tab">Populares</a>
                    </li>
    
                    {{-- <li class="nav-item">
                      <a class="nav-link text-white font-weight-bold" data-toggle="tab" href="#panel7" role="tab">Best rated</a>
                    </li> --}}
    
                  </ul>
    
                  <!-- Tab panels -->
                  <div class="tab-content px-0">
    
                    <!-- Panel 1 -->
                    <div class="tab-pane fade in show active " id="panel5" role="tabpanel">
                      <br>
                      <!-- Grid row -->
                      <div class="row">
                        @forelse ($mas_vendidos as $item)
                          @php
                              $imagen = !empty($item->imagen) ? $item->imagen : 'productos/default.png';

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
                          <div class="col-lg-4 col-md-12 mb-4">
                            <!-- Card -->
                            <div class="card card-ecommerce">
                              <!-- Card image -->
                              <div class="view overlay" style="min-height:220px;max-height:220px">
                                <img src="{{ url('storage/'.$imagen) }}" class="img-fluid" alt="{{ $item->nombre }}">
                                <a href="{{ route('detalle_producto_ecommerce', ['id' => $item->slug]) }}"><div class="mask rgba-white-slight"></div></a>
                              </div>
                              <!-- Card image -->
                              <!-- Card content -->
                              <div class="card-body">
                                <!-- Category & Title -->
                                <h5 class="card-title mb-1">
                                  <strong><a href="{{ route('detalle_producto_ecommerce', ['id' => $item->slug]) }}" class="dark-grey-text">{{ $item->nombre }}</a></strong><br>
                                  <small class="dark-grey-text">{{ $item->subcategoria }}</small>
                                </h5>
                                {{-- @if ($item->nuevo)
                                  <span class="badge badge-danger mb-2">Nueva</span>
                                @endif --}}
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
                                      <span class="float-right">
                                        <a class="" onclick="cartAdd({{ $item->id }})" data-toggle="tooltip" data-placement="top" title="Agregar a carrito">
                                          <i class="fas fa-shopping-cart ml-3"></i>
                                        </a>
                                      </span>
                                  </div>
                                </div>
                              </div>
                              <!-- Card content -->
                            </div>
                            <!-- Card -->
                          </div>
                        @empty
                            
                        @endforelse
                      </div>
                      <!-- Grid row -->
    
                    </div>
                    <!-- Panel 1 -->
    
                    <!-- Panel 2 -->
                    <div class="tab-pane fade" id="panel6" role="tabpanel">
                      <br>
                      <!-- Grid row -->
                      <div class="row mb-3">
    
                          @forelse ($populares as $item)
                          @php
                              $imagen = !empty($item->imagen) ? $item->imagen : 'productos/default.png';

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
                          <div class="col-lg-4 col-md-12 mb-4">
                            <!-- Card -->
                            <div class="card card-ecommerce">
                              <!-- Card image -->
                              <div class="view overlay"  style="min-height:220px;max-height:220px">
                                <img src="{{ url('storage/'.$imagen) }}" class="img-fluid" alt="{{ $item->nombre }}">
                                <a href="{{ route('detalle_producto_ecommerce', ['id' => $item->slug]) }}"><div class="mask rgba-white-slight"></div></a>
                              </div>
                              <!-- Card image -->
                              <!-- Card content -->
                              <div class="card-body">
                                <!-- Category & Title -->
                                <h5 class="card-title mb-1">
                                  <strong><a href="{{ route('detalle_producto_ecommerce', ['id' => $item->slug]) }}" class="dark-grey-text">{{ $item->nombre }}</a></strong><br>
                                  <small class="dark-grey-text">{{ $item->subcategoria }}</small>
                                </h5>
                                {{-- @if ($item->nuevo)
                                  <span class="badge badge-danger mb-2">Nueva</span>
                                @endif --}}
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
                                    <span class="float-right">
                                      <a class="" onclick="cartAdd({{ $item->id }})" data-toggle="tooltip" data-placement="top" title="Agregar a carrito">
                                        <i class="fas fa-shopping-cart ml-3"></i>
                                      </a>
                                    </span>
                                  </div>
                                </div>
                              </div>
                              <!-- Card content -->
                            </div>
                            <!-- Card -->
                          </div>
                        @empty
                            
                        @endforelse
    
                      </div>
                      <!-- Grid row -->
    
                    </div>
                    <!-- Panel 2 -->
    
                  </div>
    
                </div>
    
              </div>
    
              <!-- Grid row -->
            </section>
            <!-- Section: Bestsellers & offers -->
            <br>
            <hr>
            <h3 class="text-center">Todos nuestros productos</h3>
            <hr>
            <br>
    
            <!-- Section: product list -->
            <section class="mb-5">
    
              <div class="row">
    
                <!-- New Products -->
                <div class="col-lg-4 col-md-12 pt-3">
                    {{-- <aside class="col-lg-3 col-md-5 col-sm-12"> --}}
                        <div class="card card-filter">
                            <article class="card-group-item">
                                <header class="card-header principal-color">
                                    <a class="" aria-expanded="true" href="#" data-toggle="collapse" data-target="#collapse22">
                                        <h5 class="title text-white">Categorías</h5>
                                    </a>
                                </header>
                                <div class="filter-content collapse show panel-aside" id="collapse22">
                                    <div class="card-body">
                                        <div id="accordion">
                                            <ul class="list-unstyled list-lg">
                                                <a href="#" class="btn-search" data-tipo="categoria" data-id="">
                                                  <li class="list-item-title text-dark" style="margin-bottom:0px">
                                                      <h4>Todos</h4>
                                                  </li>
                                                </a>
                                                @forelse ($categorias as $categoria)
                                                  <a href="#" class="btn-search" data-tipo="categoria" data-id="{{ $categoria['id'] }}">
                                                    <li class="list-item-title text-dark" style="margin-bottom:0px">
                                                        <h4>{{ $categoria['nombre'] }}</h4>
                                                    </li>
                                                  </a>
                                                @empty
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <article class="card-group-item">
                                <header class="card-header principal-color">
                                    <a class="" aria-expanded="true" href="#" data-toggle="collapse" data-target="#collapse33">
                                        <h5 class="title text-white">Rango de precio</h5>
                                    </a>
                                </header>
                                <div class="filter-content collapse show" id="collapse33">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Min</label>
                                                <input class="form-control input-price" id="input-min" placeholder="Bs. 0" type="number" min="0" step="1">
                                            </div>
                                            <div class="form-group text-right col-md-6">
                                                <label>Max</label>
                                                <input class="form-control input-price" id="input-max" placeholder="Bs. 2.000" type="number" min="0" step="1">
                                            </div>
                                        </div>
                                        <button id="btn-price" class="btn btn-block btn-outline-primary">Aplicar</button>
                                    </div>
                                </div>
                            </article>
                            <article class="card-group-item" style="display:none">
                                <header class="card-header">
                                    <a href="#" data-toggle="collapse" data-target="#collapse44">
                                        <i class="icon-action fa fa-chevron-down"></i>
                                        <h6 class="title">Por Marca </h6>
                                    </a>
                                </header>
                                <div class="filter-content collapse show panel-aside" id="collapse44">
                                    <div class="card-body">
                                        <div class="custom-control custom-radio" style="margin:5px 0px">
                                            <input type="radio" checked name="marca" id="option" class="custom-control-input btn-search" data-tipo="marca" data-id="">
                                            <label class="custom-control-label" for="option">Todas</label>
                                        </div>
                                        {{-- @forelse ($marcas as $marca)
                                        <div class="custom-control custom-radio" style="margin:5px 0px">
                                            <input type="radio" name="marca" id="option{{$marca->id}}" class="custom-control-input btn-search" data-tipo="marca" data-id="{{$marca->id}}">
                                            <label class="custom-control-label" for="option{{$marca->id}}">{{$marca->nombre}}</label>
                                            <span class="float-right badge badge-secondary round">{{$marca->productos}}</span>
                                        </div>
                                        @empty
                
                                        @endforelse --}}
                                    </div>
                                </div>
                            </article>
                        </div>
                    {{-- </aside> --}}
                </div>
                <!-- New Products -->

                <!-- Products List -->
                <div class="col-lg-8 col-md-12 pt-3">
                  <div id="contenido"></div>
                </div>
                <!-- Products List -->
    
              </div>
    
            </section>
            <!-- Section: product list -->
    
          </div>
          <!-- Content -->
    
        </div>
        <!-- Grid row -->
    
      </div>
      <!-- Main Container -->
      <div style="height:300px;background:url('{{ url('ecommerce_public/templates/restaurante_v1/media/banner-footer1.jpg') }}');background-size: cover;">
        <div style="padding:50px">
          <br>
          <h2 class="text-white">Descarga Pizzeria Tatu en tu celular</h2><br>
          <a href="#">
              <img src="{{ url('ecommerce_public/templates/restaurante_v1/media/btn-google-play.png') }}" width="150px" alt="button google play">
          </a>
          <a href="#">
              <img src="{{ url('ecommerce_public/templates/restaurante_v1/media/btn-app-store.png') }}" width="150px" alt="button google play">
          </a>
        </div>
    </div>
@endsection

@section('footer')
    @include('ecommerce.restaurante_v1.layouts.footer')
@endsection

@section('script')
    <script src="{{ url('js/ecommerce.js') }}"></script>
    <script>
      buscar(1);
      cantidad_carrito();
    </script>
@endsection
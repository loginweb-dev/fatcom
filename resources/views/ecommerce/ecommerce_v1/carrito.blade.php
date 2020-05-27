@extends('ecommerce.ecommerce_v1.layouts.master')

@section('meta-datos')
<title>Carrito de compra | {{ setting('empresa.title') }}</title>
@endsection

@section('content')
    @php
        $section = Templates::section(19);
        $block = $section->blocks;
    @endphp
    <section class="section-pagetop bg" style="background-color: {{ $section ? $section->background : '#fff' }};">
    <div class="container">
        <h2 class="title-page" style="color: {{ $section ? $section->color : '#000' }}">{{ $block ? $block->titulo : 'Carrito de compra' }}</h2>
        <p class="lead" style="color: {{ $section ? $section->color : '#000' }}">{{ $block ? $block->descripcion : '' }}</p>
    </div>
    </section>
    <form id="form_carrito" name="form_carrito" action="{{ route('pedidos_store') }}" method="post">
        @csrf
        <input type="hidden" name="venta_tipo_id" value="3">
        <input type="hidden" name="cliente_id" value="{{ $cliente_id }}">
        <input type="hidden" name="sucursal_id" value="0">
        <section class="section-content padding-y">
            <div class="container">
                <div class="row">
                    <aside class="col-lg-7">
                        <div class="card">
                            <table class="table table-borderless table-shopping-cart">
                                <thead class="text-muted">
                                    <tr class="small text-uppercase">
                                        <th scope="col">Producto</th>
                                        <th scope="col" width="120">Cantidad</th>
                                        <th scope="col" width="120">Precio</th>
                                        <th scope="col" class="text-right" width="50"> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0;
                                        $cont = 0;
                                        $moneda = 'Bs.';
                                        $envio_disponible = 0;
                                    @endphp
                                    @forelse ($carrito as $item)
                                    @php
                                        $imagen = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : 'img/default.png';
                                        $costo_envio = '';
                                        foreach($disponibles as $envio){
                                            foreach ($envio as $reg) {
                                                if($item->id == $reg->id){
                                                    if(Auth::user()){
                                                        if(Auth::user()->localidad_id == $reg->localidad_id){
                                                            $costo_envio = $reg->costo_envio;
                                                            $envio_disponible++;
                                                        }
                                                    }else{
                                                        $costo_envio = $reg->costo_envio;
                                                        $envio_disponible++;
                                                    }
                                                }
                                            }
                                        }
                                    @endphp
                                    <tr id="tr-{{ $item->id }}">
                                        <td>
                                            <figure class="itemside align-items-center">
                                                <div class="aside"><img src="{{ url('storage/'.$imagen) }}" class="img-sm"></div>
                                                <figcaption class="info">
                                                    <a href="#" class="title text-dark">{{ $item->nombre }}</a>
                                                    <p class="small text-muted">
                                                        Categoría: {{ $item->subcategoria }}  <br>
                                                        Marca: {{ $item->marca }} <br>
                                                        Envío:
                                                        @if($costo_envio === '')
                                                        <label class="badge badge-danger">No disponible</label>
                                                        @else
                                                        {{ $costo_envio > 0 ? 'Bs. '.$costo_envio : 'Gratis' }}
                                                        @endif<br>
                                                    </p>
                                                    <input type="hidden" name="costo_envio[]" id="input-costo_envio{{$item->id}}" value="{{$costo_envio}}">
                                                </figcaption>
                                            </figure>
                                        </td>
                                        <td> 
                                            <div class="row">
                                                <span class="qty" id="label-cantidad-{{ $item->id }}" style="font-size:15;font-weight:bold;padding:5px 0px"> {{ $item->cantidad }} </span>
                                                <input type="hidden" value="{{ $item->cantidad }}" id="input-cantidad-{{ $item->id }}">
                                                <div class="btn-group radio-group ml-2" data-toggle="buttons">
                                                    <label class="btn btn-primary" onclick="cambiarCantidad('restar', '{{ $item->id }}')" style="padding:2px 5px">
                                                        <input type="hidden" name="options" id="option1">&mdash;
                                                    </label>
                                                    <label class="btn btn-primary" onclick="cambiarCantidad('sumar', '{{ $item->id }}')" style="padding:2px 8px">
                                                        <input type="hidden" name="options" id="option2">+
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        @php
                                            $precio_actual = $item->precio_venta;
                                            $precio_anterior = '';
                                            if($ofertas[$cont]){
                                                if($ofertas[$cont]->tipo_descuento=='porcentaje'){
                                                    $precio_actual -= ($precio_actual*($ofertas[$cont]->monto/100));
                                                }else{
                                                    $precio_actual -= $ofertas[$cont]->monto;
                                                }
                                                $precio_anterior = $item->moneda.' '.$item->precio_venta;
                                            }

                                            $envio = $costo_envio != '' ? $costo_envio : 0;
                                            $subtotal = ($precio_actual + $envio) * $item->cantidad;
                                            $total += $subtotal;
                                            $cont++;
                                        @endphp
                                        <td> 
                                            <div class="price-wrap"> 
                                                <var class="price label-subtotal" id="label-subtotal-{{ $item->id }}">Bs. {{ number_format($subtotal, 2, ',', '') }}</var> 
                                                <input type="hidden" class="input-subtotal" id="input-subtotal-{{ $item->id }}" value="{{ $subtotal }}">
                                                <small class="text-muted"> {{$item->moneda}} {{ $precio_actual }} C/U</small>
                                                <input type="hidden" id="input-precio-{{ $item->id }}" value="{{ $precio_actual }}">
                                            </div> <!-- price-wrap .// -->
                                        </td>
                                        <td class="text-right"> 
                                            <button data-original-title="Quitar" onclick="cartRemove({{ $item->id }})" type="button" title="" href="" class="btn btn-outline-danger" data-toggle="tooltip"> <i class="fa fa-trash"></i></button> 
                                            {{-- <a href="" class="btn btn-light btn-round"> Remove</a> --}}
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No se han agregado productos al carrito</td>
                                        </tr>
                                    @endforelse
                                    <tr>
                                        <td colspan="2"><b>Total</b></td>
                                        <td colspan="2"><h4 id="label-total">Bs. {{number_format($total, 2, '.', '')}}</h4></td>
                                        <input type="hidden" id="input-importe" name="importe" value="{{ $total }}">
                                    </tr>
                                </tbody>
                            </table>

                            {{-- <div class="card-body border-top">
                                <p class="icontext"><i class="icon text-success fa fa-truck"></i> Free Delivery within 1-2 weeks</p>
                            </div> --}}
                        </div>
                    </aside>
                    <aside class="col-lg-5">

                        <div class="card mb-3">
                            <div class="card-body">
                                @if(count($sucursales)>0)
                                    {{-- Mostrar opciones según dependiendo si el usuario está logueado o no --}}
                                    @if (Auth::user())
                                        @if (Auth::user()->localidad_id)
                                            @php
                                                $tipo_negocio = (setting('admin.modo_sistema') == 'restaurante') ? 'Restaurante' : 'Tienda' 
                                            @endphp
                                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link link-tab active" data-value="domicilio" id="pills-tab1-tab" data-toggle="pill" href="#pills-tab1" role="tab" aria-controls="pills-tab1" aria-selected="true">Entrega a Domicilio</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link link-tab" data-value="tienda" id="pills-tab2-tab" data-toggle="pill" href="#pills-tab2" role="tab" aria-controls="pills-tab2" aria-selected="false">Recoger en {{ $tipo_negocio }}</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-tab1" role="tabpanel" aria-labelledby="pills-tab1-tab">
                                                    @if(count($user_coords)>0)
                                                        <div style="margin-bottom:20px">
                                                            <h6 class="text-muted">Mis Ubicaciones:</h6>
                                                            @foreach ($user_coords as $item)
                                                                {{-- Si la descripcion es larga se edita la cadena --}}
                                                                @php
                                                                    $descripcion = $item->descripcion;
                                                                    if(strlen($descripcion)>30){
                                                                        $descripcion = substr($descripcion, 0, 30).'...';
                                                                    }
                                                                @endphp
                                                                <button type="button" class="btn btn-outline-primary btn-coor" data-id="{{ $item->id }}" data-lat="{{ $item->lat }}" data-lon="{{ $item->lon }}" data-descripcion="{{$item->descripcion}}" data-toggle="tooltip" data-placement="top" title="{{$item->descripcion}}">{{$descripcion}}</button>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span>No tiene ubicaciones, crea una.</span>
                                                    @endif
                                                    <div id="map"></div>
                                                    <input type="hidden" name="latitud" id="latitud" >
                                                    <input type="hidden" name="longitud" id="longitud">
                                                    <input type="hidden" name="coordenada_id" id="input-coordenada_id">
                                                    <input type="hidden" name="tipo_entrega" id="input-tipo_entrega" value="domicilio">
                                                    <textarea name="descripcion" class="form-control" id="input-descripcion" rows="2" maxlength="200" placeholder="Datos descriptivos de su ubicación..."></textarea>
                                                </div>
                                                <div class="tab-pane fade" id="pills-tab2" role="tabpanel" aria-labelledby="pills-tab2-tab">
                                                    <div class="card">
                                                        {{-- <div class="card-header">Featured</div> --}}
                                                        <div class="card-body">
                                                            <p>Elije la sucursal en la que quieras recoger tu pedido.</p>
                                                            <div id="contenedor_mapa">
                                                                <div id="map2"></div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                @php
                                                                    $checked = 'checked';
                                                                @endphp
                                                                @foreach ($sucursales as $item)
                                                                <label class="radio-inline">
                                                                <input type="radio" class="radio-sucursal" name="input-radio_sucursal" class="input-radio" value="{{ $item->id }}" data-lat="{{ $item->latitud }}" data-lon="{{ $item->longitud }}" {{ $checked   }}>{{ $item->nombre }}
                                                                </label>
                                                                @php
                                                                    $checked = '';
                                                                @endphp
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="card-footer text-muted">
                                                            <small>Puedes pasar en un momento por la sucursal elegida a recoger tu pedido.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-right" style="margin-top:20px">
                                                <button type="button" class="btn btn-outline-success" id="btn-pasarela">Realizar pedido <span class="fa fa-shopping-cart"></span> </button>
                                            </div>
                                        @else
                                            <i>No has elegido la ciudad en la que te encuentras, por favor ingresa <a href="#"><b>aquí</b></a> para editar tu información.</i>
                                        @endif
                                    @else
                                        <div class="card">
                                            {{-- <div class="card-header">Featured</div> --}}
                                            <div class="card-body">
                                                <h5 class="card-title">Oops!... aún no has iniciado sesión</h5>
                                                <p class="card-text">Para poder utilizar el servicio de pedidos en nuestra plataforma debes tener una sesión iniciada.</p>
                                                <div class="text-center">
                                                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Iniciar sesión</a> o <a href="{{ route('register') }}" class="btn btn-outline-dark">Registrarse</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                <div id="map" style="display:none"></div>
                                <div class="card">
                                    <div style="margin:20px">
                                        <div class="col-md-12 text-center">
                                            <div class="alert alert-info" role="alert">
                                                <h4 class="alert-heading">Aviso importante!</h4>
                                                <p>Nuestro horario de atención es a partir de las 6:30 pm, te pedimos un poco de paciencia por favor!</p>
                                                <hr>
                                                <p class="mb-0">Si tienes alguna consulta por favor comunícate con nosotros por medio de cualquier canal de comunicación descritos en la parte inferios de la página.<b></b>.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if(count($sucursales)>0)
                                {{-- Modal de confirmación --}}
                                @include('ecommerce.layouts.modal-payment', ['pasarela_pago' => $pasarela_pago])
                                {{-- /Modal de confirmación --}}
                                @endif
                            </div>
                        </div>
                    </aside>
                </div> 
            </div>
        </section>
    </form>
@endsection

@section('css')
    {{-- Mapa --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <style>
        #map, #map2 {
            height: 300px;
        }
        .img-wrap{
            cursor: pointer;
        }
        .radio-inline{
            margin-right: 20px;
            margin-top: 20px
        }
        .radio-sucursal{
            margin-right: 5px;
        }
    </style>
@endsection

@section('script')
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
    <script src="{{ url('js/ubicacion_cliente.js') }}" type="text/javascript"></script>
    <script src="{{ url('js/ecommerce.js') }}"></script>
    <script>
        var moneda = "{{ $moneda }}";
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            inicializarMapa(map, marcador);

            // Mostrar modal de pasarela de pago
            $('#btn-pasarela').click(function(){
                if({{ $envio_disponible }} == {{ count($carrito) }}){
                    let descripcion = $('#input-descripcion').val();
                    if(descripcion != '' || $('#input-tipo_entrega').val() == 'tienda'){
                        $('#modal_confirmar').modal();
                    }else{
                        $('#input-descripcion').focus()
                        Toast.fire({
                            icon: 'warning',
                            title: 'Debe proporcionar una descripción de su ubicación para su fácil localización'
                        });
                    }
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: 'Existe un producto en el carrito de compra que no está disponible en su ciudad'
                    });
                }
            });

            var iconDelivery;
            var MarkerTienda;

            // Ver ubicacion de la tienda
            $('#pills-tab2-tab').click(function(){
                @if(count($sucursales)>0)
                    map2.remove();
                    let lat = $('input:radio[name=input-radio_sucursal]:checked').data('lat');
                    let lon = $('input:radio[name=input-radio_sucursal]:checked').data('lon');
                    setTimeout(()=>{
                        $('#contenedor_mapa').html('<div id="map2"></div>');
                        map2 = L.map('map2').setView([lat, lon], 13);
                        var iconoBase = L.Icon.extend({ options: { iconSize: [40, 40], iconAnchor: [15, 35], popupAnchor: [0, -30] } });
                        iconDelivery = new iconoBase({iconUrl: "{{url('storage').'/'.str_replace('\\', '/', setting('empresa.logo'))}}"});
                        
                        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                            maxZoom: 20,
                            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                            id: 'mapbox.streets'
                        }).addTo(map2);

                        MarkerTienda = L.marker([lat, lon], {icon: iconDelivery}).addTo(map2)
                        .bindPopup("Ubicación de nuestra tienda").openPopup();
                    }, 400);
                @endif
            });

            $('.radio-sucursal').click(function(){
                map2.removeLayer(MarkerTienda)
                let id = $('input:radio[name=input-radio_sucursal]:checked').val();
                let lat = $('input:radio[name=input-radio_sucursal]:checked').data('lat');
                let lon = $('input:radio[name=input-radio_sucursal]:checked').data('lon');
                $('#form_carrito input[name=sucursal_id]').val(id);
                MarkerTienda = L.marker([lat, lon], {icon: iconDelivery}).addTo(map2)
            });
        });

        // Ver detalle de producto
        function ver_detalle(slug){
            window.location = '{{ url("detalle") }}/'+slug;
        }
    </script>
@endsection
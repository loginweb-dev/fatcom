@extends('ecommerce.restaurante_v1.layouts.master')

@section('meta-datos')
    <title>{{ setting('empresa.title') }} - Carrito de compra</title>
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

<!-- Main Layout -->
@section('content')
        <!-- Main Container -->
        <div class="container" style="margin-top:100px">
            <section class="section my-5 pb-5">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-ecommerce">
                            <div class="card-body">
                                <div class="row">
                                    <aside class="col-sm-6 border-right">
                                        <table class="table table-hover shopping-cart-wrap">
                                            <thead class="text-muted">
                                                <tr>
                                                    {{-- <th scope="col">Código</th> --}}
                                                    <th scope="col" id="head-detalle_pedido">
                                                        Detalles del pedido <span class="badge badge-{{ $ultimo_pedido->etiqueta_estado }}">{{ $ultimo_pedido->nombre_estado }}</span>
                                                    </th>
                                                    {{-- <th class="text-right">
                                                        @if($ultimo_pedido->venta_estado_id==5)
                                                        <button type="button" class="btn btn-sm btn-danger" title="Realizar el mismo pedido">Pedir <span class="fa fa-cart-plus"></span></button>
                                                        @endif
                                                    </th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $total = 0;
                                                @endphp
                                                @forelse ($detalle_pedido as $item)
                                                @php
                                                    $imagen = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : 'productos/default.png';
                                                @endphp
                                                <tr>
                                                    {{-- <td>{{$item->codigo}}</td> --}}
                                                    <td colspan="2">
                                                        <figure class="media">
                                                            <div class="img-wrap" style="margin-right:20px"><img src="{{url('storage').'/'.$imagen}}" class="img-thumbnail img-sm" width="80px"></div>
                                                            <figcaption class="media-body">
                                                                <h6 class="title text-truncate">{{ $item->nombre }}</h6>
                                                                <dl class="dlist-align">
                                                                    <dt>Precio</dt>
                                                                    <dd><var class="price">{{ $item->moneda }} {{ $item->precio_pedido }}</var></dd>
                                                                </dl>
                                                                <dl class="dlist-align">
                                                                    <dt>Cantidad</dt>
                                                                    <dd><var class="price">{{ intval($item->cantidad_pedido) }}</var></dd>
                                                                </dl>
                                                            </figcaption>
                                                        </figure>
                                                    </td>
                                                </tr>
                                                @php
                                                    $total += $item->precio_pedido * $item->cantidad_pedido;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="3" class="text-center"><span>No se han agregados productos al pedido.</span></td>
                                                </tr>
                                                @endforelse
                                                <tr>
                                                    <td>Total</td>
                                                    <td class="text-right"><strong id="label-total">Bs. {{number_format($total, 2, '.', '')}}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </aside>
                                    <aside class="col-sm-6">
                                        
                                            {!! $ultimo_pedido->venta_tipo_id == 3 ? '<h6 class="text-muted">Tu ubicación</h6>' : '<h6 class="text-muted">Ubicación para recoger tu pedido</h6>' !!}
                                            <div id="map"></div>
                                        
                                    </aside>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-ecommerce">
                            <div class="card-body" style="height:550px;overflow-y:auto">
                                <h6 class="text-muted">Ultimos Pedidos</h6>
                                <div class="filter-content">
                                    <div class="list-group">
                                        @php
                                            $cont = 0;
                                            // Si no se pasa el ID de un pedido se marca el primero como seleccionado
                                            $uri = explode('/', Request::path())[2];
                                            $style = ($uri == 'last') ? 'list-group-item-secondary' : '';
                                        @endphp
                                        @foreach ($pedidos as $item)
                                            @php
                                                $productos = '';
                                            @endphp
                                            @foreach ($productos_pedidos[$cont] as $item2)
                                                @php
                                                    $productos .= $item2->nombre.', ';
                                                @endphp
                                            @endforeach
                                            @php
                                                $productos = substr($productos, 0, -2);
                                                if(strlen($productos)>30){
                                                    $productos = substr($productos, 0, 30).'...';
                                                }
                                            @endphp
                                            <li class="list-group-item {{ $style }} @if($uri==$item->id) list-group-item-secondary @endif">
                                                <a href="{{route('pedidos_index', ['id' => $item->id])}}"  class="link-page">
                                                <article class="box pedidos-list" style="">
                                                    <div class="icontext" style="color:black">
                                                        @if($item->venta_estado_id<=4)
                                                        <i class="text-primary far fa-clock"></i>
                                                        @else
                                                        <i class="text-primary fa fa-check"></i>
                                                        @endif
                                                        <div class="text-wrap">
                                                            <div class="b">{{$productos}}</div>
                                                            <small>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</small>
                                                        </div>
                                                    </div>
                                                </article>
                                            </a>
                                            </li>
                                            
                                            @php
                                                $cont++;
                                                $style = '';
                                            @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

@endsection

@section('footer')
    @include('ecommerce.restaurante_v1.layouts.footer')
@endsection

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <style>
        #map {
            height: 350px;
        }
    </style>
@endsection

@section('script')
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function(){
            Notification.requestPermission();
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover({ html : true });
            
            var lat;
            var lon;
            var iconoBase = L.Icon.extend({ options: { iconSize: [40, 40], iconAnchor: [15, 35], popupAnchor: [0, -30] } });
            var iconDelivery = new iconoBase({iconUrl: "{{ url('img/delivery.png') }}"});
            var iconSucursal = new iconoBase({iconUrl: "{{url('storage').'/'.str_replace('\\', '/', setting('empresa.logo'))}}"});
            var marcador = {};
            //mapa

            // Obetener ubicación atual
            navigator.geolocation.getCurrentPosition(function(position) {
                lat =  position.coords.latitude;
                lon = position.coords.longitude;
            }, function(err) { console.error(err); });

            // Setear ubicacion del ultimo pedido, caso de que el pedido haya sido entregado se mostrará la ubicación actual
            @if($ultimo_pedido->venta_tipo_id == 2)
            lat = parseFloat('{{ $ultimo_pedido->latitud }}');
            lon = parseFloat('{{$ultimo_pedido->longitud}}');
            @else
            lat = parseFloat('{{ $mi_ubicacion->lat }}');
            lon = parseFloat('{{ $mi_ubicacion->lon }}');
            @endif

            var map = L.map('map').setView([lat, lon], 13);

            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 20,
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox.streets'
            }).addTo(map);

            L.marker([lat, lon] @if($ultimo_pedido->venta_tipo_id == 2), {icon: iconSucursal} @endif).addTo(map)
            .bindPopup("Ubicación actual").openPopup();

            // Laravel Echo
            // Escuchando el cambio de estado del pedido
            Echo.channel('PedidoEstadoClienteChannel{{ $ultimo_pedido->id }}')
            .listen('pedidoEstadoCliente', (e) => {
                if(Notification.permission==='granted'){
                    let notificacion = new Notification(`Pedido ${e.pedido.nombre}!`,{
                        icon: '{{ url("img/assets/info.png") }}'
                    });
                }
                $('#head-detalle_pedido').html(`Detalles del pedido <span class="badge badge-${e.pedido.etiqueta}">${e.pedido.nombre}</span>`);
            });

            // Escuchando ubicación actual del repartidor
            Echo.channel('UbicacionRepartidorChannel{{ $ultimo_pedido->id }}')
            .listen('ubicacionRepartidor', (e) => {
                get_ubicacion_repartidor(map, marcador, iconDelivery, e.ubicacion.lat, e.ubicacion.lon);
            });
        });
        
        // Nota: si se edita esta función, tambien debe editarse en la vista ver producto
        function get_ubicacion_repartidor(map, marcador, iconDelivery, lat, lon){
            map.removeLayer(marcador);       
            marcador = L.marker([parseFloat(lat), parseFloat(lon)], {icon: iconDelivery}).addTo(map).bindPopup('Tu pedido').openPopup();
            map.setView([lat, lon]);
        }
    </script>
@endsection

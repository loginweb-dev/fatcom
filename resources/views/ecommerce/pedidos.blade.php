@extends('ecommerce.layouts.master')

@section('meta-datos')
    <title>Mis pedidos - {{setting('admin.title')}}</title>
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
                    <table class="table table-hover shopping-cart-wrap">
                        <thead class="text-muted">
                            <tr>
                                {{-- <th scope="col">Código</th> --}}
                                <th scope="col" id="head-detalle_pedido">
                                    Detalles del pedido actual
                                </th>
                                <th class="text-right">
                                    @if($ultimo_pedido->venta_estado_id==5)
                                    <button type="button" class="btn btn-danger" title="Realizar el mismo pedido">Pedir <span class="fa fa-cart-plus"></span></button>
                                    @endif
                                </th>
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
                                        <div class="img-wrap"><img src="{{url('storage').'/'.$imagen}}" class="img-thumbnail img-sm"></div>
                                        <figcaption class="media-body">
                                            <h6 class="title text-truncate">{{$item->nombre}}</h6>
                                            <dl class="dlist-align">
                                                <dt>Precio</dt>
                                                <dd><var class="price">{{$item->moneda}} {{$item->precio_pedido}}</var></dd>
                                            </dl>
                                            <dl class="dlist-align">
                                                <dt>Cantidad</dt>
                                                <dd><var class="price">{{intval($item->cantidad_pedido)}}</var></dd>
                                            </dl>
                                        </figcaption>
                                    </figure>
                                </td>
                            </tr>
                            @php
                                $total += $item->precio_pedido;
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
                    <article class="card-body">
                        <div id="map"></div>
                    </article>
                </aside>
            </div>
        </div>
    </main>
    <aside class="col-md-3 col-sm-12">
        <div class="card" style="height:539px;overflow-y:auto">
            <article class="card-group-item">
                <header class="card-header"><h6 class="title">Ultimos Pedidos</h6></header>
                <div class="filter-content">
                    <div class="list-group list-group-flush">
                        @php
                            $cont = 0;
                            // Si no se pasa el ID de un pedido se marca el primero como seleccionado
                            $uri = explode('/', Request::path())[2];
                            $style = ($uri == 'last') ? 'background-color: #ddd;' : '';
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
                            <a href="{{route('pedidos_index', ['id' => $item->id])}}"  class="link-page">
                                <article class="box pedidos-list" style="{{$style}}@if($uri==$item->id) background-color: #ddd; @endif">
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
                            @php
                                $cont++;
                                $style = '';
                            @endphp
                        @endforeach
                    </div>
                </div>
            </article>
        </div>
    </aside>

    {{-- <article class="box col-md-3 col-sm-12">
        <div class="icontext  mb-4">
            <i class="fa fa-user"></i>
            <div class="text-wrap">
                <small>Some heading</small>
                <div class="b">Just any text here</div>
            </div>
        </div>
    </article> --}}

@endsection
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
<style>
    #map {
        height: 350px;
    }
    .pedidos-list:hover{
        background-color: #f8f8f8;
    }
</style>
<script src="{{url('ecommerce/js/jquery-2.0.0.min.js')}}" type="text/javascript"></script>
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover({ html : true });

        //mapa

        // Obetener ubicación atual
        navigator.geolocation.getCurrentPosition(function(position) {
            let lat_actual =  position.coords.latitude;
            let lon_actual = position.coords.longitude;
        }, function(err) { console.error(err); });

        // Setear ubicacion del ultimo pedido, caso de que el pedido haya sido entregado se mostrará la ubicación actual
        let lat = {{isset($mi_ubicacion->lat)}} ? {{$mi_ubicacion->lat}} : lat_actual;
        let lon = {{isset($mi_ubicacion->lon)}} ? {{$mi_ubicacion->lon}} : lon_actual;

        var map = L.map('map').setView([lat, lon], 13);
        var iconoBase = L.Icon.extend({ options: { iconSize: [40, 40], iconAnchor: [15, 35], popupAnchor: [0, -30] } });
        let iconDelivery = new iconoBase({iconUrl: "{{ voyager_asset('images/delivery.png') }}"});

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 20,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox.streets'
        }).addTo(map);

        L.marker([lat, lon] @if($ultimo_pedido->venta_estado_id==5), {draggable: true} @endif).addTo(map)
        .bindPopup("Ubicación actual").openPopup();

        // Obtener posicion de mi pedido
        setInterval(function(){
            get_estado_pedido({{$ultimo_pedido->id}}, map, iconDelivery)
        }, 5000);
        // setInterval(function(){
        //

        // }, 5000);
    });

    let estado_pedido = {{$ultimo_pedido->venta_estado_id}};
    let label_estado = [  '',
                    '<span class="badge badge-warning">Pedido realizado</span>',
                    '<span class="badge badge-info">En preparación</span>',
                    '<span class="badge badge-dark">Listo</span>',
                    '<span class="badge badge-success">Enviado</span>',
                    '<span class="badge badge-primary">Entregado</span>'];

    function get_estado_pedido(id, map, iconDelivery){
        if(estado_pedido<5){
            $.get("{{url('carrito/mis_pepdidos/get_estado_pedido')}}/"+id, function(estado){
                $('#head-detalle_pedido').html(`Detalles del pedido actual <span class="badge badge-${estado.etiqueta}">${estado.nombre}</span>`);
                if(estado_pedido == 4){
                    get_ubicacion(id, map, iconDelivery)
                }
            });
        }
    }
    
    // Nota: si se edita esta función, tambien debe editarse en la vista ver producto
    let marcador = {};
    function get_ubicacion(id, map, iconDelivery){
        $.ajax({
                url: '{{url("admin/repartidor/delivery/get_ubicacion")}}/'+id,
                type: 'get',
                success: function(data){
                    if(data.length){
                        map.removeLayer(marcador);
                        let lat = data[0].lat;
                        let lon = data[0].lon;
                        if(lat != '' && lon != ''){
                            marcador = L.marker([lat, lon], {icon: iconDelivery}).addTo(map).bindPopup('Tu pedido').openPopup();
                            map.setView([lat, lon]);
                        }
                    }
                }
            });
    }

</script>

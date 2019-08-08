@extends('voyager::master')
@section('page_title', 'Viendo pedido')

@if(auth()->user()->hasPermission('browse_ventasdelivery'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-harddrive"></i> Pedido de {{$pedido->razon_social}}
            @if(auth()->user()->hasPermission('delivery_close'))
            <a href="{{route('delivery_close', ['id' => $id])}}" class="btn btn-info btn-small">
                <i class="voyager-check"></i> <span>Entregado</span>
            </a>
            @endif
            <a href="{{route('delivery_index')}}" class="btn btn-warning btn-small">
                <i class="voyager-list"></i> <span>Volver a la lista</span>
            </a>
        </h1>
        <br>
    @stop
    @section('content')
        <div class="">
            <div class="">
                @include('voyager::alerts')
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-bordered">
                            <div class="panel-body" style="padding:5px 0px">
                                <div class="row">
                                    <div class="col-md-12">
                                        @php
                                            $total = 0;
                                        @endphp
                                        <div>
                                            {{-- <h5>Nombre del cliente</h5> --}}
                                            @if(!empty($pedido->movil))
                                                <div class="dropdown pull-right">
                                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Opciones<span class="caret"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="tel:+591{{$pedido->movil}}"><span>Llamar</span> <i class="voyager-phone"></i></a></li>
                                                        <li><a href="https://api.whatsapp.com/send?phone=591{{$pedido->movil}}&text=Su pedido se encuentra afuera de su domicilio." target="_blank"><span>Enviar mensaje</span> <i class="voyager-paper-plane"></i></a></li>
                                                    </ul>
                                                </div>
                                                <div class="clearfix"></div><br>
                                            @endif
                                        </div>

                                        <div class="table-responsive" style="max-height:390px;overflow-y:auto">
                                            <table class="table table-hover table-bordered">
                                                <tbody>
                                                    @forelse ($detalle_pedido as $item)
                                                    @php
                                                        $imagen = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : 'productos/default.png';
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <div class="img-wrap"><img src="{{url('storage').'/'.$imagen}}" width="100px" class="img-thumbnail img-sm"></div>
                                                        </td>
                                                        <td>
                                                            <h4 class="title text-truncate">{{$item->nombre}}</h4>
                                                            <dl class="dlist-align">
                                                                <dt>Precio : <var class="price">{{$item->moneda}} {{$item->precio_pedido}}</var></dt>
                                                            </dl>
                                                            <dl class="dlist-align">
                                                                <dt>Cantidad : <var class="price">{{intval($item->cantidad_pedido)}}</var></dt>
                                                            </dl>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center"><span>No se han agregados productos al pedido.</span></td>
                                                    </tr>
                                                    @endforelse
                                                    {{-- @if($pedido->cobro_adicional > 0) --}}
                                                    <tr>
                                                        <td><h4>Costo de envío</h4></td>
                                                        <td class="text-right"><h4> Bs. {{number_format($pedido->cobro_adicional, 2, '.', '')}}</h4></td>
                                                    </tr>
                                                    {{-- @endif --}}
                                                    <tr>
                                                        <td><h4>Descuento</h4></td>
                                                        <td class="text-right"><h4> Bs. {{number_format($pedido->descuento, 2, '.', '')}}</h4></td>
                                                    </tr>
                                                    <tr>
                                                        <td><h4>Total</h4></td>
                                                        <td class="text-right"><h4> Bs. {{number_format($pedido->importe_base, 2, '.', '')}}</h4></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-bordered">
                            <div class="panel-body" style="padding:5px 0px">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="dropdown pull-right">
                                            <a href="http://www.google.com/maps/place/{{$pedido->lat}},{{$pedido->lon}}" class="btn btn-dark btn-small" target="_blank">
                                                <i class="voyager-location"></i> <span>Google map</span>
                                            </a>
                                        </div>
                                        <div class="clearfix"></div><br>
                                        <div id="map"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop
    @section('css')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
        <style>
            #map {
                height: 390px;
            }
        </style>
    @stop
    @section('javascript')
        <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
        <script>
            $(document).ready(function(){
                // Variables para el para el mapa

                var map = L.map('map').setView([{{$pedido->lat}}, {{$pedido->lon}}], 13);
                var iconoBase = L.Icon.extend({ options: { iconSize: [40, 40], iconAnchor: [15, 35], popupAnchor: [0, -30] } });
                let iconDelivery = new iconoBase({iconUrl: "{{ voyager_asset('images/delivery.png') }}"});
                let marcador = {};

                navigator.geolocation.watchPosition(function(position) {
                    let id = "{{$repartidor_pedido->id}}";
                    let lat =  position.coords.latitude;
                    let lon = position.coords.longitude;
                    map.removeLayer(marcador);
                    marcador = L.marker([lat, lon], {icon: iconDelivery}).addTo(map).bindPopup('Mi ubicación');
                    $.ajax({
                        url: '{{url("admin/ventas/delivery/set_ubicacion")}}/'+id+'/'+lat+'/'+lon,
                        type: 'get',
                        success: function(data){
                        }
                    });
                }, function(err) {
                    console.error(err);
                }, {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                });


                //mapa
                L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                    maxZoom: 20,
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    id: 'mapbox.streets'
                }).addTo(map);

                L.marker([{{$pedido->lat}}, {{$pedido->lon}}]).addTo(map).bindPopup("{{$pedido->descripcion}}").openPopup();
                });


        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

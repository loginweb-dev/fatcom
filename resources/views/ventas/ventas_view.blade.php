@extends('voyager::master')
@section('page_title', 'Viendo venta')

@if(auth()->user()->hasPermission('read_ventas'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-basket"></i> Viendo Venta # {{str_pad($venta->id, 4, "0", STR_PAD_LEFT)}}
        </h1>
        {{-- @if(auth()->user()->hasPermission('edit_sucursales'))
        <a href="{{route('sucursales_edit', ['id'=>$id])}}" class="btn btn-primary btn-small">
            <i class="voyager-edit"></i> <span>Editar</span>
        </a>
        @endif --}}
        <a href="{{route('ventas_index')}}" class="btn btn-warning btn-small">
            <i class="voyager-list"></i> <span>Volver a la lista</span>
        </a>
        @if($venta->tipo == 'pedido' || $venta->tipo == 'domicilio')
        <button class="btn btn-success btn-small btn-mapa" data-toggle="modal" data-target="#modal_mapa"><i class="voyager-location"></i> <span>Ubicación</span></button>
        @endif
    @stop
    @section('content')
        <div class="page-content">
            <div class="page-content browse container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Cliente</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$venta->cliente}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">NIT o CI</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$venta->nit}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin:0;">
                                    <div class="row">
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Tipo</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$venta->tipo}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Estado</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>
                                                    @switch($venta->tipo_estado)
                                                        @case(1) <label class="label label-warning">Pedido realizado</label> @break
                                                        @case(2) <label class="label label-info">En preparación</label> @break
                                                        @case(3) <label class="label label-success">Listo</label> @break
                                                        @case(4) <label class="label label-dark">Enviado</label> @break
                                                        @case(5) <label class="label label-primary">Entregado</label> @break
                                                        @default
                                                    @endswitch
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>N&deg;</th>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $cont = 1;
                                                @endphp
                                                @foreach ($detalle as $item)
                                                    <tr>
                                                        <td>{{$cont}}</td>
                                                        <td>{{$item->producto}}</td>
                                                        <td>{{$item->precio}}</td>
                                                        <td>{{$item->cantidad}}</td>
                                                        <td>{{number_format($item->precio*$item->cantidad, 2, ',', '')}}</td>
                                                    </tr>
                                                    @php
                                                        $cont++;
                                                    @endphp
                                                @endforeach
                                                <tr>
                                                    <td colspan="4"><h4>TOTAL</h4></td>
                                                    <td><h4>{{number_format($venta->importe_base, 2, ',', '.')}} Bs.</h4></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal mapa --}}
        <div class="modal modal-primary fade" tabindex="-1" id="modal_mapa" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-location"></i> Ubicación del pedido</h4>
                    </div>
                    <div class="modal-body">
                        <div id="list-ubicaciones"></div>
                        <div id="contenedor_mapa">
                            <div id="map"></div>
                        </div>
                        <input type="hidden" name="lat" id="latitud" >
                        <input type="hidden" name="lon" id="longitud">
                        {{-- <textarea name="descripcion" class="form-control" id="input-descripcion" rows="2" maxlength="200" placeholder="Datos descriptivos de su ubicación..."></textarea> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
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
        <script src="{{url('js/ubicacion_cliente.js')}}" type="text/javascript"></script>
        <script>
            $(document).ready(function(){

            });
            //mapa
            @if($venta->tipo == 'pedido' || $venta->tipo == 'domicilio')
                let lat = -14.834622
                let lon = -64.903837;
                @if($ubicacion)
                lat = {{$ubicacion->lat}};
                lon = {{$ubicacion->lon}};
                @endif
                $('.btn-mapa').click(function(){
                    map.remove();
                        setTimeout(function(){
                            $('#contenedor_mapa').html('<div id="map"></div>');
                            map = L.map('map').setView([lat, lon], 13);
                            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                                maxZoom: 20,
                                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                                id: 'mapbox.streets'
                            }).addTo(map);

                            L.marker([lat, lon], {
                                draggable: true
                            }).addTo(map)
                            .bindPopup("Localización actual").openPopup()
                            .on('drag', function(e) {
                                $('#latitud').val(e.latlng.lat);
                                $('#longitud').val(e.latlng.lng);
                            });
                        }, 1000);
                });

            @endif
        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

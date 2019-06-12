@extends('voyager::master')
@section('page_title', 'Viendo Sucursal')

@if(auth()->user()->hasPermission('view_sucursales'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-home"></i> Viendo Sucursal
        </h1>
        @if(auth()->user()->hasPermission('edit_sucursales'))
        <a href="{{route('sucursales_edit', ['id'=>$id])}}" class="btn btn-primary btn-small">
            <i class="voyager-edit"></i> <span>Editar</span>
        </a>
        @endif
        <a href="{{route('sucursales_index')}}" class="btn btn-warning btn-small">
            <i class="voyager-list"></i> <span>Volver a la lista</span>
        </a>
    @stop
    @section('content')
        <div class="page-content">
            <div class="page-content browse container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                                {{-- <div class="panel-body strong-panel"> --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            {{-- <div class="col-md-12"> --}}
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Nombre</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$registro->nombre}}</p>
                                                </div>
                                                <hr style="margin:0;">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Telefono</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$registro->telefono}}</p>
                                                </div>
                                                <hr style="margin:0;">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Celular</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$registro->celular}}</p>
                                                </div>
                                                <hr style="margin:0;">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Dirección</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$registro->direccion}}</p>
                                                </div>
                                            {{-- </div> --}}
                                        </div>
                                        <div class="col-md-6">
                                            <div id="map"></div>
                                        </div>
                                    </div>
                                {{-- </div> --}}
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

            });
            //mapa
            // var map = L.map('map').fitWorld();
            var map = L.map('map').setView([{{$registro->latitud}}, {{$registro->longitud}}], 13);
            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 20,
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox.streets'
            }).addTo(map);

            L.marker([{{$registro->latitud}}, {{$registro->longitud}}]).addTo(map)
            .bindPopup("Localización actual").openPopup();
        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

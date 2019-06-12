@extends('voyager::master')
@section('page_title', 'Nueva Sucursal')

@if(auth()->user()->hasPermission('edit_sucursales'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-home"></i> Editar Sucursal
        </h1>
        {{-- <a href="{{route('sucursales_index')}}" class="btn btn-success btn-small">
            <i class="voyager-double-left"></i> <span>Atras</span>
        </a> --}}
    @stop
    @section('content')
        <div class="page-content">
            <div class="page-content browse container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <form action="{{route('sucursales_update')}}" method="post">
                                <input type="hidden" name="id" value="{{$registro->id}}">
                                @csrf
                                <div class="panel-body strong-panel">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Nombre</label>
                                                    <input type="text" name="nombre" value="{{$registro->nombre}}" class="form-control" placeholder="Nombre de la sucursal" required>
                                                    @error('nombre')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Telefono</label>
                                                    <input type="text" name="telefono" value="{{$registro->telefono}}" class="form-control" placeholder="Telefono">
                                                    @error('telefono')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Celular</label>
                                                    <input type="text" name="celular" value="{{$registro->celular}}" class="form-control" placeholder="Celular">
                                                    @error('celular')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Dirección</label>
                                                    <textarea name="direccion"class="form-control" rows="5">{{$registro->direccion}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Ubicaci&oacute;n de la sucursal</label>
                                            <div id="map"></div>
                                            <input type="hidden" value="{{$registro->latitud}}" name="latitud" id="latitud" >
                                            <input type="hidden" value="{{$registro->longitud}}" name="longitud" id="longitud" >
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </form>
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
                height: 340px;
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

            L.marker([{{$registro->latitud}}, {{$registro->longitud}}], {
                draggable: true
            }).addTo(map)
            .bindPopup("Localización actual").openPopup()
            .on('drag', function(e) {
                $('#latitud').val(e.latlng.lat);
                $('#longitud').val(e.latlng.lng);
            });
        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

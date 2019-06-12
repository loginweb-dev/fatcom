@extends('voyager::master')
@section('page_title', 'Nueva Sucursal')

@if(auth()->user()->hasPermission('add_sucursales'))
    @section('page_header')
        <div class="row" style="margin:0px">
            <h3>Añadir sucursal</h3><br>
        </div>
    @stop

    @section('content')
        <div class="movil-panel">
            <form action="{{route('sucursales_store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Nombre</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Nombre de la sucursal" required>
                            @error('nombre')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Telefono</label>
                            <input type="text" name="telefono" class="form-control" placeholder="Telefono">
                            @error('telefono')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Celular</label>
                            <input type="text" name="celular" class="form-control" placeholder="Celular">
                            @error('celular')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Dirección</label>
                            <textarea name="direccion"class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Ubicaci&oacute;n de la sucursal</label>
                            <div id="map"></div>
                            <input type="hidden" name="latitud" id="latitud" >
                            <input type="hidden" name="longitud" id="longitud" >
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
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
            var map = L.map('map').fitWorld();
            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 20,
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox.streets'
            }).addTo(map);

            function onLocationFound(e) {
                $('#latitud').val(e.latlng.lat);
                $('#longitud').val(e.latlng.lng);
                L.marker(e.latlng, {
                            draggable: true
                        }).addTo(map)
                        .bindPopup("Localización actual").openPopup()
                        .on('drag', function(e) {
                            $('#latitud').val(e.latlng.lat);
                            $('#longitud').val(e.latlng.lng);
                        });;
                        map.setView(e.latlng);
            }

            function onLocationError(e) {
                alert(e.message);
            }

            map.on('locationfound', onLocationFound);
            map.on('locationerror', onLocationError);

            map.locate();
            map.setZoom(13)
        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

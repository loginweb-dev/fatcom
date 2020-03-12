@extends('ecommerce.layouts.master')

@section('meta-datos')
    <title>Carrito de compra - {{setting('admin.title')}}</title>
@endsection

@section('banner')
    {{-- <section class="section-pagetop bg-secondary">
        <div class="container clearfix">
            <h2 class="title-page">{{setting('admin.title')}}</h2>
        </div>
    </section> --}}
@endsection

@section('content')
        <main class="col-md-12">
            <div class="card text-white bg-success col-md-6 offset-md-3">
                <div class="card-body text-center">
                    <h3 class="card-title">Muchas gracias por tu preferencia!!!</h3>
                    <p class="card-text">Tu pedido estará listo en un momento.</p>
                </div>
            </div>
            <br>
            <div class="col-md-8 offset-md-2 text-center">
                <a href="{{ route('pedidos_index', ['id'=>$venta_id]) }}" class="btn btn-primary">Ver detalles</a>
                {{-- <div id="map"></div> --}}
            </div>
        </main>
@endsection
{{-- <script>
    setTimeout(function(){
        window.location = "{{url('')}}";
    }, 5000);
</script> --}}
{{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
<style>
    #map {
        height: 400px;
    }
</style>
<script src="{{url('ecommerce/js/jquery-2.0.0.min.js')}}" type="text/javascript"></script>
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
<script>
    $(document).ready(function(){
        //mapa
        var map = L.map('map').setView([{{$sucursal->latitud}}, {{$sucursal->longitud}}], 15);
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 20,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox.streets'
        }).addTo(map);

        L.marker([{{$sucursal->latitud}}, {{$sucursal->longitud}}]).addTo(map)
        .bindPopup("Ubicación de nuestra tienda").openPopup();
        L.circle([{{$sucursal->latitud}}, {{$sucursal->longitud}}], 300).addTo(map);
    });
</script> --}}

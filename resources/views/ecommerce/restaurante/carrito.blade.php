@extends('ecommerce.master')

@section('meta-datos')
    <title>Carrito de compra - {{setting('empresa.title')}}</title>
@endsection

@section('banner')
    {{-- <section class="section-pagetop bg-secondary">
        <div class="container clearfix">
            <h2 class="title-page">{{setting('empresa.title')}}</h2>
        </div>
    </section> --}}
@endsection

@section('content')
    <main id="contenido" class="col-md-6">
        <div class="card">
            <div class="table-responsive">
                <form id="form_carrito" name="form_carrito" action="{{route('pedidos_store')}}" method="post">
                    @csrf
                    <table class="table table-hover shopping-cart-wrap">
                        <thead class="text-muted">
                        <tr>
                            {{-- <th scope="col">Código</th> --}}
                            <th scope="col">Productos</th>
                            <th scope="col" class="text-right" width="200">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                                $cont = 0;
                            @endphp
                            @forelse ($carrito as $item)
                            @php
                                $imagen = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : 'productos/default.png';
                            @endphp
                            <tr>
                                {{-- <td>{{$item->codigo}}</td> --}}
                                <td>
                                    <figure class="media">
                                        <div class="img-wrap"><img src="{{url('storage').'/'.$imagen}}" class="img-thumbnail img-sm"></div>
                                        <figcaption class="media-body">
                                            <h6 class="title text-truncate">{{$item->nombre}}</h6>
                                            @php
                                                $precio_actual = $precios[$cont]['precio'];
                                                $precio_anterior = '';
                                                $moneda = $precios[$cont]['moneda'];
                                                if($ofertas[$cont]){
                                                    if($ofertas[$cont]->tipo_descuento=='porcentaje'){
                                                        $precio_actual -= ($precio_actual*($ofertas[$cont]->monto/100));
                                                    }else{
                                                        $precio_actual -= $ofertas[$cont]->monto;
                                                    }
                                                    $precio_anterior = $moneda.' '.$precios[$cont]['precio'];
                                                }
                                            @endphp
                                            <dl class="dlist-align">
                                                <dt>Precio</dt>
                                                <dd>
                                                    {{-- <div class="price-wrap"> --}}
                                                        <var class="price">{{$moneda}} {{$precio_actual}} {{--<del class="price-old" style="font-size:15px">{{$precio_anterior}}</del>--}}</var>
                                                    {{-- </div> --}}
                                                    <input type="hidden" class="form-control" name="precio[]" value="{{$precio_actual}}" id="input-precio{{$cont}}">
                                                </dd>
                                            </dl>
                                            <dl class="dlist-align">
                                                <dt>Marca</dt>
                                                <dd><input type="number" style="width:100px" class="form-control" onchange="calcular_total()" onkeyup="calcular_total()" name="cantidad[]" id="input-cantidad{{$cont}}" value="1" min="1" step="1"></dd>
                                            </dl>
                                        </figcaption>
                                    </figure>
                                </td>
                                <td class="text-right">
                                    <a href="{{url('carrito/borrar').'/'.$item->id}}" class="btn btn-outline-danger"> <span class="fa fa-trash"></span></a>
                                </td>
                            </tr>
                            @php
                                $total += $precio_actual;
                                $cont++;
                            @endphp
                            @empty
                            <tr>
                                <td colspan="5" class="text-center"><span>No se han agregados productos al carro.</span></td>
                            </tr>
                            @endforelse
                            <tr>
                                <td>Total</td>
                                <td class="text-right"><strong id="label-total">Bs. {{number_format($total, 2, '.', '')}}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </main>
    <aside class="col-md-6">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-tab1-tab" data-toggle="pill" href="#pills-tab1" role="tab" aria-controls="pills-tab1" aria-selected="true">Entrega a domicilio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-tab2-tab" data-toggle="pill" href="#pills-tab2" role="tab" aria-controls="pills-tab2" aria-selected="false">Recoger en restaurante</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-tab1" role="tabpanel" aria-labelledby="pills-tab1-tab">
                <div id="map"></div>
                <input type="hidden" name="latitud" id="latitud" >
                <input type="hidden" name="longitud" id="longitud">
                <textarea name="detalle" class="form-control" id="" rows="2" placeholder="Datos descriptivos de su ubicación..."></textarea>
            </div>
            <div class="tab-pane fade" id="pills-tab2" role="tabpanel" aria-labelledby="pills-tab2-tab">...</div>
        </div>
        <hr>
        <div class="text-right">
            <button type="button" onclick="enviar_carrito()" class="btn btn-outline-success">Realizar pedido <span class="fa fa-shopping-cart"></span> </button>
        </div>
    </aside>
@endsection
<script>
    let cantidad = parseInt('{{$cont}}');
    function calcular_total(){
        let total = 0;
        for (let i = 0; i < cantidad; i++) {
            total += parseInt($('#input-cantidad'+i).val()) * $('#input-precio'+i).val();
        }
        $('#label-total').html('Bs. '+total.toFixed(2));
    }

    function enviar_carrito(){
        document.form_carrito.submit()
    }
</script>


{{-- Mapa --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <style>
        #map {
            height: 350px;
        }
    </style>
    <script src="{{url('ecommerce/js/jquery-2.0.0.min.js')}}" type="text/javascript"></script>
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
    <script>
        $(document).ready(function(){
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
        });
    </script>

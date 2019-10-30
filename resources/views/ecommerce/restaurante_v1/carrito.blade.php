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
    <form id="form_carrito" name="form_carrito" action="{{route('pedidos_store')}}" method="post">
        @csrf
        <input type="hidden" name="venta_tipo_id" value="3">
        <input type="hidden" name="cliente_id" value="{{$cliente_id}}">
        <input type="hidden" name="caja_id" value="{{ $caja_id ? $caja_id->id : NULL }}">
        <!-- Main Container -->
        <div class="container" style="margin-top:100px">
            <!-- Section cart -->
            <section class="section my-5 pb-5">
                <div class="card card-ecommerce">
                    <div class="card-body">
                        <!-- Shopping Cart table -->
                        <div class="table-responsive">
                            <table class="table product-table ">
                                <!-- Table head -->
                                <thead class="mdb-color lighten-5">
                                    <tr class="principal-color">
                                        <th class="font-weight-bold text-white"><strong>Producto</strong></th>
                                        <th class="font-weight-bold text-white"><strong>Cantidad</strong></th>
                                        <th class="font-weight-bold text-white"><strong>Monto</strong></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <!-- Table head -->
                                <!-- Table body -->
                                <tbody>
                                    <!-- First row -->
                                    @php
                                        $total = 0;
                                        $moneda = 'Bs.';
                                    @endphp
                                    @forelse ($carrito as $item)
                                    @php
                                        $imagen = !empty($item->imagen) ? $item->imagen : 'productos/default.png';
                                        $subtotal = $item->precio_venta * $item->cantidad;
                                        $total += $subtotal;
                                        $moneda = $item->moneda;
                                    @endphp
                                    <tr id="tr-{{ $item->id }}">
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <img src="{{ url('storage/'.$imagen) }}" alt="{{ $item->nombre }}" class="img-fluid z-depth-0">
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="mt-3"><strong>{{ $item->nombre }}</strong></h6>
                                                    <p class="text-muted">{{ $item->subcategoria }}</p>
                                                    <strong>{{ $item->moneda }} {{ number_format($item->precio_venta, 2, ',', '.') }}</strong>
                                                    <input type="hidden" id="input-precio-{{ $item->id }}" value="{{ $item->precio_venta }}">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="">
                                            <span class="qty" id="label-cantidad-{{ $item->id }}"> {{ $item->cantidad }} </span>
                                            <input type="hidden" value="{{ $item->cantidad }}" id="input-cantidad-{{ $item->id }}">
                                            <div class="btn-group radio-group ml-2" data-toggle="buttons">
                                                <label class="btn btn-sm btn-primary btn-rounded" onclick="cambiarCantidad('restar', '{{ $item->id }}')">
                                                    <input type="radio" name="options" id="option1">&mdash;
                                                </label>
                                                <label class="btn btn-sm btn-primary btn-rounded" onclick="cambiarCantidad('sumar', '{{ $item->id }}')">
                                                    <input type="radio" name="options" id="option2">+
                                                </label>
                                            </div>
                                        </td>
                                        <td class="font-weight-bold">
                                            <input type="hidden" class="input-subtotal" id="input-subtotal-{{ $item->id }}" value="{{ $subtotal }}">
                                            <strong id="label-subtotal-{{ $item->id }}">{{ $moneda }} {{ number_format($subtotal, 2, ',', '.') }}</strong>
                                        </td>
                                        <td>
                                            <button type="button" onclick="cartRemove({{ $item->id }})" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Quitar item"><span class="fa fa-trash"></span></button>
                                        </td>
                                    </tr>
                                    @empty
                                        
                                    @endforelse
                                    <!-- Fourth row -->
                                    <tr>
                                        <td colspan="2">
                                            <h4 class="mt-2"><strong>Total</strong></h4>
                                        </td>
                                        <td colspan="2">
                                            <h4 class="mt-2"><strong id="label-total">{{ $moneda }} {{ number_format($total, 2, ',', '.') }}</strong></h4>
                                            <input type="hidden" id="input-importe" name="importe" value="{{$total}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">
                                            <button type="button" @if($total > 0 && !$pedido_pendiente && $caja_id) data-toggle="modal" data-target="#modal_entrega"  id="btn-entrega" @else disabled @endif class="btn btn-primary btn-rounded">Completar compra
                                                <i class="fas fa-angle-right right"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Fourth row -->
                                </tbody>
                                <!-- Table body -->
                            </table>
                            @if(!$caja_id)
                            <div class="alert alert-info" role="alert">
                                <h4 class="alert-heading">Aviso importante!</h4>
                                <p>Nuestro horario de atención es a partir de las 6:30 pm, te pedimos un poco de paciencia por favor!</p>
                                <hr>
                                <p class="mb-0">Si tienes alguna consulta por favor comunícate con nosotros por medio de cualquier canal de comunicación descritos en la parte inferios de la página.<b></b>.</p>
                            </div>
                            @elseif($pedido_pendiente)
                            <div class="alert alert-warning" role="alert">
                                <h4 class="alert-heading">Aviso importante!</h4>
                                <p>Debido a que tienes un pedido pendiente y por politicas de nuestra empresa no puede solicitar otro pedido hasta que el actual sea entregado.</p>
                                <hr>
                                <p class="mb-0">Si tienes alguna consulta o modificación de tu pedido actual por favor comunícate con nosotros por medio de cualquier canal de comunicación descritos en la parte inferios de la página.<b></b>.</p>
                            </div>
                            @endif
                        </div>
                        <!-- Shopping Cart table -->
                    </div>
                </div>
            </section>
            <!-- Section cart -->
            
            <!-- Section products -->
            <section>
                <h4 class="font-weight-bold mt-4 title-1">
                    <strong>Quizas te interesen también</strong>
                </h4>
                <hr class="blue mb-5">

                <!-- Grid row -->
                <div class="row mb-5">
                    @php
                        $contador = 0;
                    @endphp
                    @foreach ($mas_vendidos as $item)
                        @php
                            if($contador>3) break;
                            $contador++;
                        
                            $img = ($item->imagen != '') ? str_replace('.', '_small.', $item->imagen) : 'productos/default.png';

                            // Obtener precio de oferta si existe
                            $precio_venta = $item->precio_venta;
                                $precio_actual = $precio_venta;
                                if($item->monto_oferta){
                                    if($item->tipo_descuento=='porcentaje'){
                                        $precio_venta -= ($precio_actual*($item->monto_oferta/100));
                                    }else{
                                        $precio_venta -= $item->monto_oferta;
                                    }
                                }
                        @endphp
                        <!-- Grid column -->
                        <div class="col-lg-3 col-md-6 mb-4">
                            <!-- Card -->
                            <div class="card card-ecommerce">
                                <!-- Card image -->
                                <div class="view overlay"  style="min-height:150px;max-height:150px">
                                <img src="{{ url('storage').'/'.$img }}" class="img-fluid" alt="{{ $item->nombre }}">
                                <a href="{{ route('detalle_producto_ecommerce', ['id' => $item->slug]) }}"><div class="mask rgba-white-slight"></div></a>
    
                                </div>
                                <!-- Card image -->
    
                                <!-- Card content -->
                                <div class="card-body">
    
                                <!-- Category & Title -->
                                <h5 class="card-title mb-1">
                                    <strong>
                                        <a href="{{ route('detalle_producto_ecommerce', ['id' => $item->slug]) }}" class="dark-grey-text">{{ $item->nombre }}</a>
                                    </strong>
                                </h5>
    
                                {{-- <span class="badge badge-info mb-2">new</span> --}}
    
                                <!-- Rating -->
                                <ul class="rating">
                                    @php
                                        $puntos = $item->puntos ? intval($item->puntos) : 0;
                                        $cont = 0;
                                    @endphp
                                    {{-- Estrellas obtenidas --}}
                                    @for ($i = 0; $i < $puntos; $i++)
                                        <li><i class="fas fa-star gray-text"></i></li>
                                        @php $cont++; @endphp
                                    @endfor
                                    {{-- Estrellas falantes --}}
                                    @for ($i = $cont; $i < 5; $i++)
                                        <li><i class="fas fa-star grey-text"></i></li>
                                        @php $cont++; @endphp
                                    @endfor
                                </ul>
    
                                <!-- Card footer -->
                                <div class="card-footer pb-0">
                                    <div class="row mb-0">
                                        <h5 class="mb-0 pb-0 mt-1 font-weight-bold">
                                            <span class="red-text"><strong>{{ $item->moneda }} {{ number_format($precio_venta, 2, ',', '.') }}</strong></span>
                                            @if($item->monto_oferta)
                                                <span class="grey-text"><small><s>{{ $item->moneda }} {{ number_format($precio_actual, 2, ',', '.') }}</s></small></span>
                                            @endif
                                        </h5>
                                        {{-- <span class="float-right">
                                            <a class="" onclick="cartAdd({{ $item->id }})" data-toggle="tooltip" data-placement="top" title="Add to Cart">
                                                <i class="fas fa-shopping-cart ml-3"></i>
                                            </a>
                                        </span> --}}
                                    </div>
                                </div>
    
                                </div>
                                <!-- Card content -->
    
                            </div>
                            <!-- Card -->
                        </div>
                        <!-- Grid column -->
                    @endforeach

                </div>
                <!-- Grid row -->

            </section>
            <!-- Section products -->
        </div>

        <!-- Modal tipo entrega -->
        <div class="modal fade cart-modal" id="modal_entrega" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <!-- Content -->
                <div class="modal-content">
                    <!-- Header -->
                    {{-- <div class="modal-header">
                        <h4 class="modal-title font-weight-bold dark-grey-text" id="myModalLabel"> <span class="fas fa-map-marker-alt"></span> Metodo de envío</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div> --}}
                    <!-- Body -->
                    <div class="modal-body">
                        <div style="margin-bottom:20px">
                            <ul class="nav nav-tabs nav-justified md-tabs principal-color" id="myTabJust" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-value="domicilio" onclick="ubicacionActual()" id="home-tab-just" data-toggle="tab" href="#home-just" role="tab" aria-controls="home-just" aria-selected="true">Entegar a domicilio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-value="tienda" onclick="ubicacionRestaurante()" id="profile-tab-just" data-toggle="tab" href="#profile-just" role="tab" aria-controls="profile-just"aria-selected="false">Recoger en Restaurante</a>
                                </li>
                            </ul>
                        </div>
                        <div style="margin:10px 0px" id="div-ubicaciones">
                            @if(count($user_coords)>0)
                                @foreach ($user_coords as $item)
                                    {{-- Si la descripcion es larga se edita la cadena --}}
                                    @php
                                        $descripcion = $item->descripcion;
                                        if(strlen($descripcion)>30){
                                            $descripcion = substr($descripcion, 0, 30).'...';
                                        }
                                    @endphp
                                    <button type="button" class="btn btn-outline-primary btn-coor" data-id="{{$item->id}}" data-lat="{{$item->lat}}" data-lon="{{$item->lon}}" data-descripcion="{{$item->descripcion}}" data-toggle="tooltip" data-placement="top" title="{{$item->descripcion}}">{{$descripcion}}</button>
                                @endforeach
                            @endif
                        </div>
                        <div id="map" style="height:300px"></div>
                        <input type="hidden" name="lat" id="latitud" >
                        <input type="hidden" name="lon" id="longitud">
                        <input type="hidden" name="coordenada_id" id="input-coordenada_id">
                        <input type="hidden" name="tipo_entrega" id="input-tipo_entrega" value="domicilio">
                        <textarea name="descripcion" class="form-control" id="input-descripcion" rows="2" maxlength="200" placeholder="Ingrese una descripción de su domicilio..."></textarea>
                    </div>
                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary btn-rounded">Realizar pedido <span class="fa fa-check"></span></button>
                    </div>
                </div>
                <!-- Content -->
            </div>
        </div>
        <!-- Modal tipo entrega -->
    </form>
@endsection

@section('footer')
    @include('ecommerce.restaurante_v1.layouts.footer')
@endsection

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
@endsection

@section('script')
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
    <script src="{{ url('js/ecommerce.js') }}"></script>
    <script>
        var entrega_select = false;
        var map = null;
        var marker = {};
        var moneda = "{{ $moneda }}";
        $(document).ready(function(){
            // Cargar mapa en modal
            $('#btn-entrega').click(function(){
                setTimeout(()=>{
                    rederMap();
                    if(!entrega_select){
                        // ubicacionRestaurante();
                        ubicacionActual();
                        entrega_select = true;
                    }
                }, 500);
            });

            // Cambiar tipo de entrega
            $('.nav-link').click(function(){
                let tipo_entrega =$(this).data('value');
                $('#input-tipo_entrega').val(tipo_entrega);
            });
        });

        buscar(1);
        cantidad_carrito();

        function cambiarCantidad(tipo, id){
            let cantidad = $(`#input-cantidad-${id}`).val();
            let precio = $(`#input-precio-${id}`).val();
            if(tipo == 'sumar'){
                cantidad++;
                $(`#input-cantidad-${id}`).val(cantidad);
            }else{
                if(cantidad > 1){
                    cantidad--;
                    $(`#input-cantidad-${id}`).val(cantidad);
                }
            }
            $(`#label-cantidad-${id}`).text(` ${cantidad} `);
            $(`#input-subtotal-${id}`).val(cantidad*precio);
            $(`#label-subtotal-${id}`).text(`${moneda} ${parseFloat(cantidad*precio).toFixed(2)}`);
            totalVenta();

            $.get(`carrito/editar/${id}/${cantidad}`, function(data){});
        }

        function rederMap(){
            if($('#map').html()== ''){
                map = L.map('map').fitWorld();
                L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                    maxZoom: 20,
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    id: 'mapbox.streets'
                }).addTo(map);
            }
        }

        function ubicacionRestaurante(){
            $('#div-ubicaciones').css('display', 'none');
            $('#input-descripcion').css('display', 'none');
            $('#input-descripcion').removeAttr('required');
            
            let ubicacion = {
                'id': '{{ $sucursal->id }}',
                'nombre': '{{ $sucursal->nombre }}',
                'lat': '{{ $sucursal->latitud }}',
                'lon': '{{ $sucursal->longitud }}'
            }
            
            $('#latitud').val('');
            $('#longitud').val('');
            $('#input-coordenada_id').val('');
            $('#input-descripcion').val('')
            
            map.removeLayer(marker);
            var iconoBase = L.Icon.extend({ options: { iconSize: [45, 45], iconAnchor: [15, 35], popupAnchor: [8, -35] } });
            let iconDelivery = new iconoBase({iconUrl: "{{ url('ecommerce_public/templates/restaurante_v1/media/logo.png') }}"});
            marker = new L.marker([ ubicacion.lat, ubicacion.lon], {icon: iconDelivery}).addTo(map).bindPopup("<b>{{ setting('empresa.title') }}</b>").openPopup();
            map.setView([ ubicacion.lat, ubicacion.lon]);
        }

        function ubicacionActual(){
            $('#div-ubicaciones').css('display', 'flex');
            $('#input-descripcion').css('display', 'flex');
            $('#input-descripcion').attr('required', true);

            function onLocationFound(e) {
                $('#latitud').val(e.latlng.lat);
                $('#longitud').val(e.latlng.lng);
                $('#input-coordenada_id').val('');
                $('#input-descripcion').val('')
                map.removeLayer(marker);
                marker = new L.marker(e.latlng, {
                                                draggable: true
                                            }).addTo(map)
                                            .bindPopup("Localización actual").openPopup()
                                            .on('drag', function(e) {
                                                $('#latitud').val(e.latlng.lat);
                                                $('#longitud').val(e.latlng.lng);
                                            });
                map.setView(e.latlng);
            }

            function onLocationError(e) {
                alert(e.message);
            }

            map.on('locationfound', onLocationFound);
            map.on('locationerror', onLocationError);

            map.locate();
            map.setZoom(13)
        }

        // CAmbiar coordenadas al pulsar en una ubicación ntigua
        $('.btn-coor').click(function(){
            map.removeLayer(marker);
            let id = $(this).data('id');
            let lat = $(this).data('lat');
            let lon = $(this).data('lon');
            let descripcion = $(this).data('descripcion');

            $('#input-coordenada_id').val(id);
            $('#input-descripcion').val(descripcion)

            map.removeLayer(marker);
            marker = new L.marker([lat, lon], {draggable: true}).addTo(map)
                        .bindPopup("Localización actual").openPopup()
                        .on('drag', function(e) {
                            $('#latitud').val(e.latlng.lat);
                            $('#longitud').val(e.latlng.lng);
                            $('#input-coordenada_id').val('');
                            $('#input-descripcion').val('')
                        });
            map.setView([lat, lon]);
        });

        // Calcular total
        function totalVenta(){
            let total = 0;
            $(".input-subtotal").each(function() {
                total += parseFloat($(this).val());
            });
            $('#label-total').text(`${moneda} ${total.toFixed(2)}`);
            $('#input-importe').val(total);
        }

    </script>
@endsection

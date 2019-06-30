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
    <form id="form_carrito" name="form_carrito" action="{{route('pedidos_store')}}" method="post">
        <div class="card">
            <div class="table-responsive">
                @csrf
                <input type="hidden" name="tipo" value="pedido">
                <table class="table table-hover shopping-cart-wrap">
                    <thead class="text-muted">
                    <tr>
                        {{-- <th scope="col">Código</th> --}}
                        <th scope="col">Productos</th>
                        <th scope="col" class="text-right" width="100">Acción</th>
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
                                            <dt>Cantidad</dt>
                                            <dd><input type="number" style="width:100px" class="form-control" onchange="calcular_total()" onkeyup="calcular_total()" name="cantidad[]" id="input-cantidad{{$cont}}" value="1" min="1" step="1"></dd>
                                        </dl>
                                    </figcaption>
                                </figure>
                            </td>
                            <td class="text-right">
                                <a href="{{url('carrito/borrar').'/'.$item->id}}" class="btn btn-outline-danger link-page"> <span class="fa fa-trash"></span></a>
                            </td>
                        </tr>
                        @php
                            $total += $precio_actual;
                            $cont++;
                        @endphp
                        @empty
                        <tr>
                            <td colspan="4" class="text-center"><span>No se han agregados productos al carro.</span></td>
                        </tr>
                        @endforelse
                        <tr>
                            <td>Total</td>
                            <td class="text-right"><strong id="label-total">Bs. {{number_format($total, 2, '.', '')}}</strong></td>
                            <input type="hidden" id="input-importe" name="importe" value="{{$total}}">
                        </tr>
                    </tbody>
                </table>
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
                <div style="margin:2px">
                    @if(count($user_coords)>0)
                        <h5 class="text-muted">Mis Ubicaciones:</h5>
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
                    @else
                    <span>No tiene ubicaciones, crea una.</span>
                    @endif
                </div>
                <div id="map"></div>
                <input type="hidden" name="lat" id="latitud" >
                <input type="hidden" name="lon" id="longitud">
                <input type="hidden" name="coordenada_id" id="input-coordenada_id">
                <textarea name="descripcion" class="form-control" id="input-descripcion" rows="2" maxlength="200" placeholder="Datos descriptivos de su ubicación..." required></textarea>
            </div>
            <div class="tab-pane fade" id="pills-tab2" role="tabpanel" aria-labelledby="pills-tab2-tab">...</div>
        </div>
        <hr>
        <div class="text-right">
            <button type="button" data-toggle="modal" data-target="#modal_confirmar" class="btn btn-outline-success">Realizar pedido <span class="fa fa-shopping-cart"></span> </button>
        </div>

        {{-- Modal de confirmación --}}
        <div class="modal modal-info fade" tabindex="-1" id="modal_confirmar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="fa fa-shopping-cart"></i> Elija la forma de pago
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <table width="100%" cellpadding="10">
                                    @php
                                        $checked = 'checked';
                                    @endphp
                                    @foreach ($pasarela_pago as $item)
                                    <tr>
                                        <td><input type="radio" {{$checked}} @if($item->estado == 0) disabled @endif name="tipo_pago"></td>
                                        <td><img src="{{url('storage').'/'.$item->icono}}" width="80px" alt="icono"></td>
                                        <td>{{$item->nombre}} <br> <b>{{$item->descripcion}}</b></td>
                                    </tr>
                                    @php
                                        $checked = '';
                                    @endphp
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-info pull-right delete-confirm"value="Confirmar">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- /Modal de confirmación --}}
    </form>
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
        $('#input-importe').val(total)
    }

    // function enviar_carrito(){
    //     document.form_carrito.submit()
    // }
</script>


    {{-- Mapa --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <style>
        #map {
            height: 300px;
        }
    </style>
    <script src="{{url('ecommerce/js/jquery-2.0.0.min.js')}}" type="text/javascript"></script>
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
    <script src="{{url('js/ubicacion_cliente.js')}}" type="text/javascript"></script>
    <script>
        let marcador = {};
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


@extends('voyager::master')

@section('page_header')
    {{-- <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-basket"></i> Nueva venta
        </h1>
    </div> --}}
@stop

@section('content')
<form id="form" action="{{route('ventas_store')}}" method="post">
    <div class="page-content browse container-fluid">
        @if(!$abierta)
        <div class="alert alert-warning">
            <strong>Atención:</strong>
            <p>No puede realizar ventas debido a que no se ha aperturado la caja.</p>
        </div>
        @endif
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="padding:0px">
                        <ul class="nav nav-tabs">
                            @php
                                $clase = 'active';
                            @endphp
                            @foreach ($categorias as $item)
                            <li class="li-item {{$clase}}" id="li-{{$item->id}}">
                                <a data-toggle="tab" href="#tab1" onclick="productos_categoria({{$item->id}})">{{$item->nombre}}</a>
                            </li>
                            @php
                                $clase = '';
                            @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            <div id="tab1" class="tab-pane fade in  active ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-bordered" style="height:400px">
                    <div class="panel-body">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="tipo" id="input-tipo" value="venta">
                            <input type="hidden" name="facturacion" value="{{setting('empresa.facturas')}}">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Nombre completo</label>
                                    <select name="cliente_id" class="form-control" id="select-cliente_id">
                                        <option value="1">--Ninguno--</option>
                                        @foreach ($clientes as $item)
                                        <option value="{{$item->id}}" data-nit="{{$item->nit}}">{{$item->razon_social}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>NIT/CI</label>
                                    <input type="number" name="nit" id="input-nit" class="form-control">
                                </div>
                            </div>
                            <hr style="margin-bottom:10px;margin-top:0px">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>¿Para llevar?</label><br>
                                    <input type="checkbox" id="check-llevar" name="llevar" data-toggle="toggle" data-on="Sí" data-off="No">
                                    <input type="hidden" name="fecha" class="form-control" value="{{date('Y-m-d')}}" required>
                                </div>
                                {{-- <div class="form-group col-md-4">
                                    <label>N&deg; de Mesa</label> --}}
                                    <input type="hidden" min="1" step="1" name="nro_mesa" id="input-nro_mesa" class="form-control" value="" required>
                                {{-- </div> --}}
                                <div class="form-group col-md-6">
                                    <label>A domicilio</label><br>
                                    <input type="checkbox" id="check-domicilio" name="llevar" data-toggle="toggle" data-onstyle="success" data-on="Sí" data-off="No">
                                </div>
                            </div>
                            <hr style="margin-bottom:10px;margin-top:0px">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Monto entregado</label>
                                    <input type="number" id="input-entregado" value="0" min="0" step="0.5" onchange="calcular_cambio()" onkeyup="calcular_cambio()" style="font-size:18px" name="monto_recibido" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Cambio</label>
                                    <input type="number" id="input-cambio" value="0" readonly style="font-size:18px" name="cambio" class="form-control" required>
                                </div>
                            </div>
                            <input type="hidden" name="caja_id" value="{{$caja_id}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="margin-top:-30px">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                    <th style="width:300px">Producto</th>
                                    <th>observación</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th colspan="2">Subtotal</th>
                                </thead>
                                <tbody>
                                    <tr id="detalle_venta">
                                        <td colspan="4" class="text-right"><h5>Costo de envío</h5></td>
                                        <td id="label-costo_envio" colspan="2">
                                            <div class="input-group">
                                                <input type="number" name="cobro_adicional" class="form-control" style="width:80px" onchange="total();calcular_cambio()" onkeyup="total();calcular_cambio()" min="0" value="0" id="input-costo_envio">
                                                <span class="input-group-addon">
                                                    <input type="checkbox" name="incluir_envio" data-toggle="tooltip" data-placement="bottom" title="Incluir costo de envío en factura">
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right"><h4>TOTAL</h4></td>
                                        <td id="label-total" colspan="2"><h4>0.00 Bs.</h4></td>
                                    </tr>
                                </tbody>
                            </table>
                            <textarea name="observaciones" id="" class="form-control" rows="3" placeholder="Observaciones del pedido..."></textarea>
                            <input type="hidden" name="importe" value="0" id="input-total">
                        </div>
                        <div class="col-md-12 text-right">
                            {{-- <button type="reset" id="btn-reset" class="btn btn-default">Vaciar</button> --}}
                            {{-- <input type="checkbox" id="check-factura" name="factura" data-toggle="toggle" data-on="Con factura" data-off="Sin factura" data-onstyle="success" data-offstyle="danger"> --}}
                            <button type="submit" @if(!$abierta) disabled @endif class="btn btn-primary" style="padding:20px">Vender <span class="voyager-basket"></span> </button>
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
                    <input type="hidden" name="coordenada_id" id="input-coordenada_id">
                    <textarea name="descripcion" class="form-control" id="input-descripcion" rows="2" maxlength="200" placeholder="Datos descriptivos de su ubicación..."></textarea>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary pull-right"value="Aceptar" data-dismiss="modal">
                    <button type="button" class="btn btn-default pull-right" id="btn-cancel-map" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

</form>
@include('partials.modal_load')
{{-- Variables PHP para inicializar la vista --}}
@php
    $categoria_id = 0;
    if(count($categorias)>0){
        $categoria_id = $categorias[0]->id;
    }
@endphp

@stop

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <style>
        #map {
            height: 340px;
        }
        .img-producto:hover{
            border: 5px solid #096FA9;
        }
        .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover{
            background:#fff !important;
            color:#62a8ea !important;
            border-bottom:1px solid #fff !important;
            top:-1px !important;
        }
    </style>
@stop

@section('javascript')
    <script src="{{url('js/ventas.js')}}"></script>
    <script src="{{url('js/loginweb.js')}}"></script>
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
    <script src="{{url('js/ubicacion_cliente.js')}}" type="text/javascript"></script>
    <script>
        let costo_envio = {{intval(setting('delivery.costo_envio'))}};
        let marcador = {};
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            inicializar_select2('cliente_id');
            productos_categoria({{$categoria_id}});

            // formulario de envio de venta
            $('#form').on('submit', function(e){
                $('#modal_load').modal('show');
                e.preventDefault();
                let datos = $(this).serialize();
                $.ajax({
                    url: "{{route('ventas_store')}}",
                    type: 'post',
                    data: datos,
                    success: function(data){
                        if(data){
                            let id = data;
                            toastr.success('Venta registrada correctamente.', 'Exito');
                            // Factura
                            window.open("{{url('admin/factura')}}/"+id, "Factura", `width=800, height=600`)
                            $('#form')[0].reset();
                            $('.tr-detalle').remove();
                            $(".label-subtotal").text('0.00');
                            $("#label-total").text('0.00 Bs.');

                            // resetear panel de productos
                            @if(count($categorias)>0)
                            $('.li-item').removeClass('active');
                            $('#li-'+{{$categoria_id}}).addClass('active');
                            productos_categoria({{$categoria_id}})
                            @endif
                        }else{
                            toastr.error('Ocurrio un error al ingresar la venta.', 'Error');
                        }
                        $('#modal_load').modal('hide');
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            });

            // anular o activar mesa si no es para llevar
            $('#check-llevar').change(function() {
                if($(this).prop('checked')){
                    $('#input-nro_mesa').val('');
                    $('#input-nro_mesa').attr('readonly', true);
                    // $('#input-nro_mesa').removeAttr('required');
                    $('#input-tipo').val('llevar');
                    $('#check-domicilio').bootstrapToggle('off')
                }else{
                    $('#input-nro_mesa').removeAttr('readonly');
                    // $('#input-nro_mesa').attr('required', true);
                    $('#input-tipo').val('venta');
                }
            });

            // Activar mapa para llevar a domicilio
            let cont = 0;
            $('#check-domicilio').change(function() {
                if($(this).prop('checked')){
                    $('#input-costo_envio').val(costo_envio);
                    // $('#check-llevar').removeAttr('checked');
                    $('#check-llevar').bootstrapToggle('off');
                    $('#modal_mapa').modal('show');
                    $('#input-tipo').val('domicilio');
                    let cliente_id = $('#select-cliente_id').val();
                    if(cliente_id > 1){
                        $.get('{{url("admin/ventas/get_ubicaciones_cliente")}}/'+cliente_id, function(data){
                            $('#list-ubicaciones').html('');
                            let datos = '';
                            data.forEach(item => {
                                let descripcion = item.descripcion;
                                if(item.descripcion.length>20){
                                    descripcion = descripcion.substring(0, 20)+'...';
                                }
                                datos += `<button type="button" class="btn btn-info" onclick="ubicacion_anterior(${item.id}, ${item.lat}, ${item.lon}, '${item.descripcion}')" data-toggle="tooltip" data-placement="top" title="${item.descripcion}">${descripcion}</button> `;
                            });
                            $('#list-ubicaciones').html(datos)
                        });
                    }

                    map.remove();
                    setTimeout(function(){
                        $('#contenedor_mapa').html('<div id="map"></div>');
                        map = L.map('map').fitWorld();
                        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                            maxZoom: 20,
                            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                            id: 'mapbox.streets'
                        }).addTo(map);

                        navigator.geolocation.getCurrentPosition(function(position) {
                            let lat =  position.coords.latitude;
                            let lon = position.coords.longitude;
                            $('#input-coordenada_id').val('');
                            $('#input-descripcion').val('')
                            map.removeLayer(marcador);
                            marcador = L.marker([lat, lon], {
                                            draggable: true
                                        }).addTo(map)
                                        .bindPopup("Localización actual")
                                        .openPopup()
                                        .on('drag', function(e) {
                                            $('#latitud').val(lat);
                                            $('#longitud').val(lon);
                                            $('#input-coordenada_id').val('');
                                            $('#input-descripcion').val('')
                                        });
                            map.setView([lat, lon], 13);
                        }, function(err) {
                            alert(err);
                        });
                    }, 1000);
                }else{
                    // $('#input-tipo').val('venta');
                    $('#input-costo_envio').val(0);
                }

                total();
                calcular_cambio();

            });

            $('#btn-cancel-map').click(function(){
                $('#check-domicilio').bootstrapToggle('off');
                $('#input-tipo').val('venta');
            });

        });

        var adicional_id = '';
        var adicional_nombre = '';
        function combinar_producto(id, nombre, precio, stock,){
            if(adicional_id==''){
                $('#producto-'+id).css('border', '5px solid #096FA9')
                adicional_id = id;
                adicional_nombre = ', '+nombre;
            }else{
                if(adicional_id==id){
                    $('#producto-'+adicional_id).css('border', 'none');
                    adicional_id = '';
                    adicional_nombre = '';
                }else{
                    $('#producto-'+adicional_id).css('border', 'none')
                    agregar_detalle_restaurante(id, nombre, precio, stock, adicional_id, adicional_nombre)
                    adicional_id = '';
                }
            }
        }

        // Agregar detalle de venta
        function agregar_detalle_restaurante(id, nombre, precio, stock, adicional_id, adicional_nombre){
            let cantidad = $('#input_cantidad-'+id).val();

            if(cantidad>stock){
                toastr.warning('La cantidad de producto ingresada sobrepasa la existente.', 'Atención');
                return false;
            }

            // recorer la lista para ver si el producto existe
            let existe = false;
            $(".tr-detalle").each(function(){
                if($(this).data('id')==id+'_'+adicional_id){
                    existe = true;
                }
            });


            if(existe){
                $(`#tr-${id}_${adicional_id} .label-precio`).html(`<input type="hidden" value="${cantidad}" name="cantidad[]">${cantidad}`);
                $(`#subtotal-${id}`).html(`<h5>${precio*cantidad} Bs.</h5>`);
            }else{
                $('#detalle_venta').before(`<tr class="tr-detalle" id="tr-${id}_${adicional_id}" data-id="${id}_${adicional_id}">
                                                <td><input type="hidden" value="${id}" name="producto_id[]"><input type="hidden" value="${adicional_id}" name="adicional_id[]">${nombre+adicional_nombre}</td>
                                                <td><input type="text" class="form-control" name="observacion[]"></td>
                                                <td><input type="hidden" value="${precio}" name="precio[]">${precio} Bs.</td>
                                                <td class="label-precio"><input type="hidden" value="${cantidad}" name="cantidad[]">${cantidad}</td>
                                                <td class="label-subtotal" id="subtotal-${id}"><h5>${precio*cantidad} Bs.</h5></td>
                                                <td width="40px"><label onclick="borrarTr('${id}_${adicional_id}')" class="text-danger" style="cursor:pointer;font-size:20px"><span class="voyager-trash"></span></label></td>
                                            <tr>`);
                toastr.remove();
                toastr.info('Producto agregar correctamente', 'Bien hecho!');
            }
            $('#input_cantidad-'+id).val('1');
            total();
            calcular_cambio();
        }

        // mostrar los productos de la categoria seleccionada
        function productos_categoria(id){
            $('#tab1').html(`  <div style="height:270px" class="text-center">
                                    <br><br><br>
                                    <img src="{{ voyager_asset('images/load.gif') }}" width="100px">
                                </div>`);
            $.ajax({
                url: `{{url('admin/ventas/crear/productos_categoria/${id}')}}`,
                type: 'get',
                success: function(data){
                    $('#tab1').html(data);
                },
                error: function(){console.log('Error');}
            });
        }

        function ubicacion_anterior(id, lat, lon, descripcion){
            map.removeLayer(marcador);
            $('#input-coordenada_id').val(id);
            $('#input-descripcion').val(descripcion)

            marcador = L.marker([lat, lon], {
                            draggable: true
                        }).addTo(map)
                        .bindPopup(descripcion).openPopup()
                        .on('drag', function(e) {
                            $('#latitud').val(e.latlng.lat);
                            $('#longitud').val(e.latlng.lng);
                            $('#input-coordenada_id').val('');
                            $('#input-descripcion').val('')
                        });;
            map.setView([lat, lon]);
        }

    </script>
@stop

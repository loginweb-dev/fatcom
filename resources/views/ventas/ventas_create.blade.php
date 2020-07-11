@extends('voyager::master')

@section('page_header')
    {{-- <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-basket"></i> Nueva venta
        </h1>
    </div> --}}
@stop
@if(auth()->user()->hasPermission('add_ventas'))
@section('content')
    <form id="form" action="{{route('ventas_store')}}" method="post">
        <div class="page-content browse container-fluid">
            <br>
            @if(!$abierta)
            <div class="alert alert-warning">
                <strong>Atención:</strong>
                <p>No puede realizar ventas debido a que no se ha aperturado la caja.</p>
                <p>Para realizar la apertura de la caja preciona <a href="{{ route('cajas_create') }}"><b style="color:blue">Aquí</b></a></p>
            </div>
            @endif
            @include('voyager::alerts')
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-bordered">
                        <div class="panel-body" id="panel-productos" style="padding:0px">
                            <div style="position:absolute;z-index:1;right:0px;margin:5px">
                                <a href="#" class="btn-nav" data-direccion="left" title="Izquierda"><span class="voyager-double-left"></span></a>
                                <a href="#" class="btn-nav" data-direccion="right" title="Derecha"><span class="voyager-double-right"></span></a>
                            </div>
                            <ul class="nav nav-tabs" style="width:2000px">
                                <li class="li-item active" id="li-0">
                                    <a data-toggle="tab" href="#tab1" onclick="productos_buscar()">Buscador <i class="voyager-search"></i></a>
                                </li>
                                @foreach ($categorias as $item)
                                <li class="li-item" id="li-{{$item->id}}" style="display:inline">
                                    <a data-toggle="tab" href="#tab1" onclick="lista_categorias({{$item->id}})">{{$item->nombre}}</a>
                                </li>
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
                    <div class="panel panel-bordered" style="@if(setting('delivery.activo')) height:450px @else height:380px @endif">
                        <div class="panel-body">
                            <div class="row">
                                @csrf
                                <input type="hidden" name="venta_tipo_id" id="input-venta_tipo_id" value="1">
                                <input type="hidden" name="facturacion" value="{{setting('empresa.facturas')}}">
                                <div class="row">
                                    <div class="form-group col-md-12 @if(!$cambiar_sucursal) hidden @else hola @endif">
                                        {{-- <label for="">Sucursal actual</label> --}}
                                        <select name="sucursal_id" id="select-sucursal_id" class="form-control">
                                            @foreach ($sucursales as $item)
                                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div style="@if(!setting('delivery.activo')) display:none @endif">
                                    <div class="row">
                                        <div class="form-group col-md-4 col-xs-4 text-center">
                                            <label>¿Para llevar?</label><br>
                                            <input type="checkbox" id="check-llevar" name="llevar" data-toggle="toggle" data-on="Sí" data-off="No">
                                            <input type="hidden" name="fecha" class="form-control" value="{{date('Y-m-d')}}" required>
                                        </div>
                                        {{-- Div auxiliar para mantener el estilo --}}
                                        <div class="form-group col-md-4 col-xs-4 text-center">
                                            <input type="hidden" min="1" step="1" name="nro_mesa" id="input-nro_mesa" class="form-control" value="" required>
                                        </div>
                                        <div class="form-group col-md-4 col-xs-4 text-center">
                                            <label>A domicilio</label><br>
                                            <input type="checkbox" id="check-domicilio" name="domicilio" data-toggle="toggle" data-onstyle="success" data-on="Sí" data-off="No">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        {{-- <label>Nombre completo</label> --}}
                                        <div class="input-group">
                                            <select name="cliente_id" class="form-control" id="select-cliente_id">
                                                <option value="1">Sin nombre</option>
                                            </select>
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" style="margin-top:0px;padding:8px" type="button" title="Crear nuevo" data-toggle="modal" data-target="#modal-nuevo_cliente" aria-expanded="true" aria-controls="collapseOne"><span class="voyager-person" aria-hidden="true"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <input type="number" name="nit" id="input-nit" class="form-control" placeholder="NIT/CI">
                                    </div>
                                </div>
                                <hr style="margin-bottom:10px;margin-top:0px">
                                <div class="row">
                                    <div class="form-group col-md-6 col-xs-6">
                                        <label>Monto entregado</label>
                                        <input type="number" id="input-entregado" value="0" min="0" step="0.01" onchange="calcular_cambio()" onkeyup="calcular_cambio()" style="font-size:18px" name="monto_recibido" class="form-control cero_default" required>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-6">
                                        <label>Cambio</label>
                                        <input type="number" id="input-cambio" value="0" step="0.01" readonly style="font-size:18px" name="cambio" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 col-xs-4 text-center">
                                        <input type="checkbox" id="check-efectivo" name="efectivo" data-toggle="toggle" data-on="Tarjeta" data-off="Efectivo">
                                    </div>
                                    <div class="form-group col-md-4 col-xs-4 text-center">
                                        @if(setting('ventas.ventas_credito'))
                                        <input type="checkbox" id="check-credito" name="credito" data-toggle="toggle" data-on="Crédito" data-off="Contado">
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4 col-xs-4 text-center">
                                        <input type="checkbox" id="check-factura" name="factura" data-toggle="toggle" data-on="Factura" data-off="Recibo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered" style="margin-top:-20px">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="font-size:15px">
                                        <thead>
                                            <th style="width:300px">Producto</th>
                                            @if (setting('admin.modo_sistema')=='restaurante')
                                                <th style="width:50px">Extras</th>
                                            @endif
                                            <th>observación</th>
                                            <th style="width:150px">Precio</th>
                                            <th style="width:100px">Cantidad</th>
                                            <th colspan="2">Subtotal</th>
                                        </thead>
                                        <tbody>
                                            <tr id="detalle_venta">
                                                <td colspan="4" class="text-right"><h5>Descuento</h5></td>
                                                <td id="label-descuento" colspan="2">
                                                    <div class="input-group">
                                                        <input type="number" name="descuento" class="form-control cero_default" style="width:80px" onchange="total()" onkeyup="total()" min="0" value="0" id="input-descuento">
                                                        <span class="input-group-addon">Bs.</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><h5>Costo de envío</h5></td>
                                                <td id="label-costo_envio" colspan="2">
                                                    <div class="input-group">
                                                        <input type="number" readonly name="cobro_adicional" class="form-control cero_default" style="width:80px" onchange="total()" onkeyup="total()" min="0" value="0" id="input-costo_envio">
                                                        <span class="input-group-addon">
                                                            <input type="checkbox" disabled id="check-cobro_adicional_factura" name="cobro_adicional_factura" data-toggle="tooltip" data-placement="bottom" title="Incluir costo de envío en factura">
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-right"><h5>TOTAL</h5></td>
                                                <td id="label-total" colspan="2"><h3>0.00 Bs.</h3></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <textarea name="observaciones" id="" class="form-control" rows="3" placeholder="Observaciones de la venta..."></textarea>
                                <input type="hidden" name="importe" value="0" id="input-total">
                            </div>
                            <div class="col-md-12 text-right">
                                {{-- <button type="reset" id="btn-reset" class="btn btn-default">Vaciar</button> --}}
                                {{-- <input type="checkbox" id="check-factura" name="factura" data-toggle="toggle" data-on="Con factura" data-off="Sin factura" data-onstyle="success" data-offstyle="danger"> --}}
                                <button type="submit" id="btn-vender" @if(!$abierta) disabled @endif class="btn btn-primary" style="padding:20px">Vender <span class="voyager-basket"></span> </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal mapa --}}
        <div class="modal modal-primary fade" tabindex="-1" id="modal_mapa" data-backdrop="static" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="voyager-location"></i> Ubicación del pedido</h4>
                    </div>
                    <div class="modal-body">
                        <div id="list-ubicaciones"></div>
                        <div id="map"></div>
                        <input type="hidden" name="latitud" id="latitud" >
                        <input type="hidden" name="longitud" id="longitud">
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

        {{-- Modal de lista extras --}}
        <div class="modal modal-primary fade" tabindex="-1" id="modal-lista_extras" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="voyager-list-add"></i> Lista de extras</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th colspan="2">Extra</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody id="table-extras"></tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @include('ventas.partials.modal_cliente_create')

        {{-- Modal de detalle de producto --}}
        <div class="modal modal-primary fade" tabindex="-1" id="modal-info_producto" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="voyager-harddrive"></i> Detalle de producto</h4>
                    </div>
                    <div class="modal-body" id="info_producto"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">cerrar</button>
                    </div>
                </div>
            </div>
        </div>

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
        </style>
    @stop

    @section('javascript')
    <script src="{{ url('js/rich_select.js') }}"></script>
    <script src="{{url('js/ventas.js')}}"></script>
    <script src="{{url('js/loginweb.js')}}"></script>
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
    <script src="{{url('js/ubicacion_cliente.js')}}" type="text/javascript"></script>
    <script>
        let costo_envio = {{ intval(setting('delivery.costo_envio')) }};
        let tab_active = '';
        let accordion_active = '';
        var sucursal_id = '{{ $sucursal_actual }}';
        $(document).ready(function(){
            productos_buscar();
            $('#select-sucursal_id').val({{ $sucursal_actual }});
            $('#select-sucursal_id').select2();

            $('[data-toggle="tooltip"]').tooltip();
            // Deshabilitar el boton del mapa por defecto
            // $('#check-domicilio').attr('disabled', true);

            // Cambiar sucursal actual
            $('#select-sucursal_id').change(function(){
                let id = $(this).val();
                window.location = '{{ url("admin/sucursales/cambiar/ventas_create") }}/'+id;
            });

            // Botones de desplazamiento
            let defecto = $('#panel-productos').offset();
            let posicion = 0;
            $('.btn-nav').click(function(){
                let direccion = $(this).data('direccion');
                if(direccion=='right'){
                    posicion += 100;
                }else{
                    posicion -= 100;
                }
                $(".nav-tabs").offset({left: '-'+posicion});
                if(posicion<=0){
                    posicion = 0;
                    $(".nav-tabs").offset({left: defecto.left});
                }
            });

            // si hay facturacion se habilita el boton de facturas
            @if(!$facturacion || !setting('empresa.facturas'))
                $('#check-factura').prop('checked', false).change()
                $('#check-factura').attr('disabled', true);
            @endif

            // formulario de nuevo cliente
            $('#form-nuevo_cliente').on('submit', function(e){
                e.preventDefault();
                $('#alert-cliente').html(`<h5 class="text-center">Guardando...</h5>`);
                let datos = $('#form-nuevo_cliente').serialize();
                $.ajax({
                    url: "{{url('admin/clientes/ventas/create')}}",
                    type: 'post',
                    data: datos,
                    success: function(data){
                        let id = data.id;
                        $.get('{{route("clientes_list")}}', function(data){
                            $('#alert-cliente').html(``);
                            $('#modal-nuevo_cliente').modal('hide');
                            toastr.success('Cliente registrado correctamente.', 'Exito');
                        });
                    },
                    error: () => console.log(error)
                });
            });

            // formulario de envio de venta
            $('#form').on('submit', function(e){
                $('#btn-vender').attr('disabled', true);
                $('#modal_load').modal('show');
                e.preventDefault();
                // return 0;
                let datos = $(this).serialize();
                $.ajax({
                    url: "{{route('ventas_store')}}",
                    type: 'post',
                    data: datos,
                    success: function(data){
                        if(data){
                            if(data=='error 1'){
                                toastr.error('Venta no realizada, el cliente seleccionado tiene un pedido pendiente.', 'Error');
                            }else{
                                let id = data;
                                toastr.success('Venta registrada correctamente.', 'Exito');
                                // Factura
                                @if($tamanio=='rollo')
                                    $.get("{{url('admin/venta/impresion/rollo')}}/"+id, function(){});
                                @else
                                    window.open("{{url('admin/venta/impresion/normal')}}/"+id, "Factura", `width=700, height=400`)
                                @endif
                                
                                $('#form')[0].reset();
                                $('.tr-detalle').remove();
                                $(".label-subtotal").text('0.00');
                                $("#label-total").text('0.00 Bs.');
                                $('#check-domicilio').bootstrapToggle('off');
                                $('#check-llevar').bootstrapToggle('off');
                                $('#check-factura').bootstrapToggle('off');
                                // inicializar_select2_simple('producto_id');
                                rich_select('select-producto_id');
                                // Reset select de clientes
                                $('#select-cliente_id').val('1');
                                $('#select-cliente_id').trigger('change');
                            }
                        }else{
                            toastr.error('Ocurrio un error al ingresar la venta.', 'Error');
                        }
                        $('#modal_load').modal('hide');
                        $('#btn-vender').removeAttr('disabled');
                    },
                    error: () => console.log(error)
                });
            });

            // anular o activar mesa si no es para llevar
            $('#check-llevar').change(function() {
                if($(this).prop('checked')){
                    $('#input-nro_mesa').val('');
                    $('#input-nro_mesa').attr('readonly', true);
                    // $('#input-nro_mesa').removeAttr('required');
                    $('#input-venta_tipo_id').val('2');
                    $('#check-domicilio').bootstrapToggle('off')
                }else{
                    $('#input-nro_mesa').removeAttr('readonly');
                    // $('#input-nro_mesa').attr('required', true);
                    $('#input-venta_tipo_id').val('1');
                }
                total();
            });

            // Anular casilla de factura y quitar propiedad min de monto entregado
            $('#check-credito').change(function() {
                if($(this).prop('checked')){
                    $('#input-entregado').prop('min', 0);
                    $('#check-factura').bootstrapToggle('off')
                }else{
                    
                }
            });
            
            // Activar mapa para llevar a domicilio
            let cont = 0;
            $('#check-domicilio').change(function() {
                if($(this).prop('checked')){
                    $('#input-costo_envio').val(costo_envio);
                    $('#input-costo_envio').removeAttr('readonly');
                    // $('#check-llevar').removeAttr('checked');
                    $('#check-llevar').bootstrapToggle('off');
                    $('#modal_mapa').modal('show');
                    $('#input-venta_tipo_id').val('4');
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

                    setTimeout(function(){
                        inicializarMapa(map, marcador);
                    }, 500);
                }else{
                    // $('#input-venta_tipo_id').val('1');
                    $('#input-costo_envio').attr('readonly', true);
                    $('#input-costo_envio').val(0);
                }

                total();
            });

            // anular o activar mesa si no es para llevar
            $('#check-factura').change(function() {
                if($(this).prop('checked')){
                    $('#check-cobro_adicional_factura').removeAttr('disabled');
                }else{
                    $('#check-cobro_adicional_factura').removeAttr('checked');
                    $('#check-cobro_adicional_factura').attr('disabled', true);
                }
            });

            $('#btn-cancel-map').click(function(){
                $('#check-domicilio').bootstrapToggle('off');
                $('#input-venta_tipo_id').val('1');
            });


            // Si existe una proforma obtenemos los datos y agregamos los productos
            @if($proforma_id)
            let proforma_id = {{$proforma_id}};
            $.get('{{ url("admin/proformas/detalle") }}/'+proforma_id, function(data){
                if(data){
                    data.forEach(element => {
                        agregar_producto(element.producto_id);
                    });
                }
            });
            @endif

        });

        function agregar_producto(id){
            $.get("{{ url('admin/productos/get_producto') }}/"+id, function(data){
                let stock = data.se_almacena ? data.stock : 1000;
                agregar_detalle_venta(data.id, data.nombre, data.precio, stock, '', '');
            });
        }

        var adicional_id = '';
        var adicional_nombre = '';
        function combinar_producto(id, nombre){
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
                    $.get("{{ url('admin/productos/get_producto') }}/"+id, function(data){
                        let stock = data.se_almacena ? data.stock : 1000;
                        agregar_detalle_venta(data.id, data.nombre, data.precio, stock, adicional_id, adicional_nombre);
                        adicional_id = '';
                    });
                }
            }
        }

        // Agregar detalle de venta
        function agregar_detalle_venta(id, nombre, precio, stock, adicional_id, adicional_nombre){
            if(stock<1){
                toastr.warning('La cantidad de producto ingresada sobrepasa la existente.', 'Atención');
                return false;
            }

            // recorer la lista para ver si el producto existe
            let existe = false;
            let index_tr = `${id}_${Math.floor(Math.random() * 1001)}`;
            $(".tr-detalle").each(function(){
                if($(this).data('id')==index_tr){
                    existe = true;
                }
            });

            // Si el usuario tiene permiso para editar productos puede editar el precio de venta
            let editar_precio = 'readonly';
            @if(auth()->user()->hasPermission('edit_productos'))
            editar_precio = '';
            @endif

            let buttonExtras = '';
            let url_extras = "{{ url('admin/ventas/crear/extras_producto') }}";
            
            @if (setting('admin.modo_sistema')=='restaurante')
                buttonExtras = `<td><a href="" data-toggle="modal" data-target="#modal-lista_extras" onclick="verExtras('${url_extras}', '${index_tr}', ${sucursal_id})" class="btn btn-success btn-sm btn-list_extras" style="text-decoration:none" title="Lista de extras"><i class="voyager-list-add"></i></a></td>`;                          
            @endif

            if(existe){
                toastr.warning('El producto ya se encuentra en la lista.', 'Atención');
            }else{
                $('#detalle_venta').before(`<tr class="tr-detalle" id="tr-${index_tr}" data-id="${index_tr}">
                                                <td>
                                                    <input type="hidden" value="${id}" name="producto_id[]">
                                                    <input type="hidden" value="${adicional_id}" name="adicional_id[]">
                                                    <button type="button" class="btn btn-link" title="Ver información" onclick="producto_info(${id})">${(nombre.length > 50 ? nombre.substr(0,50)+'...' : nombre)+adicional_nombre}</button>
                                                    <div id="extras_producto-${index_tr}"></div>
                                                </td>
                                                ${buttonExtras}
                                                <td><input type="text" class="form-control" name="observacion[]"></td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="number" ${editar_precio} id="input-precio_${index_tr}" min="0.01" step="0.01" data-precio="${precio}" value="${precio}" name="precio[]" class="form-control" onchange="subtotal('${index_tr}');" onkeyup="subtotal('${index_tr}')" required />
                                                        <span class="input-group-addon">Bs.</span>
                                                    </div>
                                                    <input type="hidden" id="input-extras_id_${index_tr}" name="extras_id[]" />
                                                    <input type="hidden" id="input-cantidad_extras_id_${index_tr}" name="cantidad_extras_id[]" />
                                                    <input type="hidden" id="input-precio_extras_id_${index_tr}" name="precio_extras_id[]" />
                                                    <input type="hidden" id="input-total_extras_${index_tr}" name="total_extras[]" value="0" />
                                                    <div class="text-center text-success"><small id="label-extras_${index_tr}"></small></div>
                                                </td>
                                                <td><input type="number" min="0.1" max="${stock}" step="0.1" class="form-control" id="input-cantidad_${index_tr}" value="1" name="cantidad[]" onchange="subtotal('${index_tr}')" onkeyup="subtotal('${index_tr}')" required></td>
                                                <td class="label-subtotal" id="subtotal-${index_tr}"><h4>${precio} Bs.</h4></td>
                                                <td width="40px"><label onclick="borrarDetalle('${index_tr}')" class="text-danger" style="cursor:pointer;font-size:20px"><span class="voyager-trash"></span></label></td>
                                            <tr>`);
                toastr.remove();
                toastr.info('Producto agregar correctamente', 'Bien hecho!');
            }
            $('#input_cantidad-'+id).val('1');
            total();
        }

        var loader = "{{ url('storage').'/'.str_replace('\\', '/', setting('admin.img_loader')) }}";
        var loader_request = `  <div style="@if(setting('delivery.activo')) height:370px @else height:300px @endif" class="text-center">
                                    <br><br><br>
                                    <img src="${loader}" width="100px">
                                    <p>Cargando...</p>
                                </div>`;

        // mostrar Buscador de productos
        function productos_buscar(id){
            if(tab_active!='search'){
                if(!sessionStorage.getItem(`SearchTab`)){
                    $('#tab1').html(loader_request);
                    $.ajax({
                        url: `{{url('admin/ventas/crear/productos_search')}}`,
                        type: 'get',
                        cache: true,
                        success: function(data){
                            $('#tab1').html(data);
                            sessionStorage.setItem(`SearchTab`, data);
                        },
                        error: function(){console.log('Error');}
                    });
                }else{
                    $('#tab1').html(sessionStorage.getItem(`SearchTab`));
                }
            }
            tab_active = 'search';
        }

        // mostrar los productos de la categoria seleccionada
        function lista_categorias(id){
            if(tab_active!=id){
                if(!sessionStorage.getItem(`Category${id}`)){
                    $('#tab1').html(loader_request);
                    $.ajax({
                        url: `{{url('admin/ventas/crear/ventas_categorias/${id}')}}`,
                        type: 'get',
                        cache: true,
                        success: function(data){
                            $('#tab1').html(data);
                            sessionStorage.setItem(`Category${id}`, data);
                        },
                        error: function(){console.log('Error');}
                    });
                }else{
                    $('#tab1').html(sessionStorage.getItem(`Category${id}`));
                }
            }
            tab_active = id;
        }

        function ubicacion_anterior(id, lat, lon, descripcion){
            map.removeLayer(marcador);
            $('#latitud').val(lat);
            $('#longitud').val(lon);
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

        function producto_info(id){
            $('#modal-info_producto').modal();
            $('#info_producto').html('<br><h4 class="text-center">Cargando...</h4>');
            $.get('{{url("admin/productos/ver/informacion")}}/'+id, function(data){
                $('#info_producto').html(data);
            });
        }

        function borrarDetalle(num){
            $(`#tr-${num}`).remove();
            subtotal();
        }
    </script>
@stop
@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif
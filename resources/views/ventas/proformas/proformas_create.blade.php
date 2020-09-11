@extends('voyager::master')
@section('page_title', 'Nueva proforma o pedidos')

@if(auth()->user()->hasPermission('add_compras'))
    @section('page_header')
        <div class="container-fluid">
            <h1 class="page-title">
                <i class="voyager-certificate"></i> Nueva proforma/pedidos
            </h1>
        </div>
    @stop

    @section('content')
    <form id="form" action="{{route('proformas_store')}}" method="post">
        @csrf
        <div class="page-content browse container-fluid">
            @include('voyager::alerts')
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="row" style="overflow-y: auto;height:280px">
                                <div class="col-md-12">
                                    <div id="div-select_producto"  >
                                        <div class="row">
                                            <div class="col-md-12" style="margin:0px">
                                                <div id="accordion">
                                                    <div class="card">
                                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                            <div class="card-body" style="padding:0px">
                                                                <div class="row">
                                                                    <div class="form-group col-md-4">
                                                                        <label class="text-primary" for=""><b>Categoria</b></label><br>
                                                                        <select id="select-categoria_id" class="form-control select-filtro" data-tipo="subcategorias" data-destino="subcategoria_id">
                                                                            <option value="">Todas</option>
                                                                            @foreach($categorias as $item)
                                                                            <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label class="text-primary" for=""><b>Subcategoria</b></label><br>
                                                                        <select id="select-subcategoria_id" class="form-control select-filtro" data-tipo="marcas" data-destino="marca_id">
                                                                            <option value="">Todas</option>
                                                                            <option disabled value="">Debe seleccionar una categoría</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label class="text-primary" for=""><b>Marca</b></label><br>
                                                                        <select id="select-marca_id" class="form-control select-filtro" data-tipo="tallas" data-destino="talla_id">
                                                                            <option value="">Todas</option>
                                                                            <option disabled value="">Debe seleccionar una subcategoria</option>
                                                                        </select>
                                                                    </div>
                    
                                                                    <div style="@if(setting('delivery.activo')) display:none @endif">
                                                                        <div class="form-group col-md-4">
                                                                            <label class="text-primary" for=""><b>Tallas</b></label><br>
                                                                            <select id="select-talla_id" class="form-control select-filtro" data-tipo="generos" data-destino="genero_id">
                                                                                <option value="">Todas</option>
                                                                                <option disabled value="">Debe seleccionar una marca</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label class="text-primary" for=""><b>Genero</b></label><br>
                                                                            <select id="select-genero_id" class="form-control select-filtro" data-tipo="colores" data-destino="color_id">
                                                                                <option value="">Todos</option>
                                                                                <option disabled value="">Debe seleccionar una marca</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label class="text-primary" for=""><b>Color</b></label><br>
                                                                            <select id="select-color_id" class="form-control select-filtro">
                                                                                <option value="">Todos</option>
                                                                                <option disabled value="">Debe seleccionar una genero</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div  class="col-md-12" style="margin:0px">
                                                <div class="input-group">
                                                    <select name="select_producto" class="form-control" id="select-producto_id" onchange="seleccionar_producto()">
                                                        <option selected disabled value="">Seleccione una opción</option>
                                                        @foreach ($productos as $item)
                                                            @php
                                                                $imagen = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : '../img/default.png';
                                                            @endphp
                                                            <option value="{{ $item->id }}"
                                                                    data-imagen="{{ url('storage').'/'.$imagen }}"
                                                                    data-categoria="{{ $item->categoria }}"
                                                                    data-subcategoria="{{ $item->subcategoria }}"
                                                                    data-marca="{{ $item->marca }}"
                                                                    data-talla="{{ $item->talla }}"
                                                                    data-color="{{ $item->color }}"
                                                                    data-genero="{{ $item->genero }}"
                                                                    data-precio="{{ $item->moneda }} {{ $item->precio_venta }}"
                                                                    data-precio_minimo="{{ $item->moneda }} {{ $item->precio_minimo }}"
                                                                    data-detalle="{{ $item->descripcion_small }}">
                                                                @if(setting('admin.modo_sistema') != 'restaurante')
                                                                    @if($item->codigo_interno)
                                                                    #{{ str_pad($item->codigo_interno, 2, "0", STR_PAD_LEFT) }}
                                                                    @else
                                                                    {{ $item->codigo }} - 
                                                                    @endif 
                                                                @endif
                                                                {{ $item->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-primary" style="margin-top:0px;padding:8px" type="button" title="Ver filtros" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Filtros <span class="voyager-params" aria-hidden="true"></span></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-12" style="margin:0px">
                                                <div id="div-carga"></div>
                                            </div>
                                        </div>
                                        </div>
                                        <div id="div-loader"></div>
                                        <div id="div-barras_producto" style="display:none">
                                            <input type="text" class="form-control" autocomplete="off" id="input-barras_producto" name="barras_producto">
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="row" style="overflow-y: auto;height:280px">
                                <div class="form-group">
                                    <label>NIT/CI</label>
                                    <input type="number" name="nit" id="input-nit" class="form-control" placeholder="NIT/CI">
                                </div>
                                <div class="form-group">
                                    <label>Nombre completo</label>
                                    <div class="input-group">
                                        <select name="cliente_id" class="form-control select2" id="select-cliente_id">
                                        </select>
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" style="margin-top:0px;padding:8px" type="button" title="Ver filtros" data-toggle="modal" data-target="#modal-nuevo_cliente" aria-expanded="true" aria-controls="collapseOne"><span class="voyager-person" aria-hidden="true"></span></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detalles de la prodorma --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered" style="margin-top:-30px">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <table class="table table-bordered" style="font-size:18px">
                                    <thead>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th style="width:150px">Cantidad</th>
                                        <th colspan="2">Subtotal</th>
                                    </thead>
                                    <tbody>
                                        <tr id="detalle_venta">
                                            <td colspan="3" class="text-right"><h4>TOTAL</h4></td>
                                            <td id="label-total" colspan="2"><h4>0.00 Bs.</h4></td>
                                            {{-- Datos auxiliares para poder usar la funcion de calcular total del archivo ventas.js --}}
                                            <input type="hidden" name="descuento" value="0" id="input-descuento">
                                            <input type="hidden" name="cobro_adicional" value="0" id="input-costo_envio">
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Generar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal de detalle de producto --}}
        <div class="modal modal-primary fade" tabindex="-1" id="modal-info_producto" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="voyager-harddrive"></i> Detalle de producto</h4>
                    </div>
                    <div class="modal-body" id="info_producto"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-right" id="btn-cancel-map" data-dismiss="modal">cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @include('ventas.partials.modal_cliente_create')
    @stop

    @section('css')
        <style>
            
        </style>
    @stop

    @section('javascript')
        <script src="{{url('js/loginweb.js')}}"></script>
        <script src="{{ asset('js/rich_select.js') }}"></script>
        <script src="{{url('js/ventas.js')}}"></script>
        <script src="{{url('js/inventarios/productos.js')}}"></script>
        <script>
            // cargar vista de detalle de compra según tipo
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover();
                $('[data-toggle="tooltip"]').tooltip();

                // Obtener lista de clientes
                $.get('{{route("clientes_list")}}', function(data){
                    select2_reload_simple('cliente_id', data, false, 1)
                });

                // $('#select-producto_id').select2();
                rich_select('select-producto_id');

                // Cuando se abre el acordeon se inizializan los select2 que tiene dentro
                $('#accordion').on('show.bs.collapse', function () {
                    setTimeout(function(){
                        $('#select-categoria_id').select2();
                        $('#select-subcategoria_id').select2();
                        $('#select-marca_id').select2();
                        $('#select-talla_id').select2();
                        $('#select-genero_id').select2();
                        $('#select-color_id').select2();
                    }, 100);
                });

                // realizar filtro
                $('.select-filtro').change(function(){
                    let tipo = $(this).data('tipo');
                    let destino = $(this).data('destino');

                    if(tipo){
                        obtener_lista(tipo, '{{url("admin/productos/list")}}', destino);
                    }
                    
                    filtro('{{url("admin/ofertas/filtros/filtro_simple/all")}}', '{{ setting('admin.modo_sistema') }}');
                });

                // formulario de nuevo cliente
                $('#form-nuevo_cliente').on('submit', function(e){
                    e.preventDefault();
                    let datos = $('#form-nuevo_cliente').serialize();
                    $.ajax({
                        url: "{{url('admin/clientes/ventas/create')}}",
                        type: 'post',
                        data: datos,
                        success: function(data){
                            let id = data.id;
                            $.get('{{route("clientes_list")}}', function(data){
                                select2_reload('cliente_id', data, false, id);
                                $('#modal-nuevo_cliente').modal('hide');
                                toastr.success('Cliente registrado correctamente.', 'Exito');
                            });
                        },
                        error: () => console.log(error)
                    });
                });
                
            });

            function seleccionar_producto(){
                let id = $('#select-producto_id').val();
                $.get("{{url('admin/productos/get_producto')}}/"+id, function(data){
                    agregar_detalle_venta(data.id, data.nombre, data.precio);
                    $('#select-producto_id').select2('destroy');
                    $('#select-producto_id').val('');
                    // $('#select-producto_id').select2();
                    rich_select('select-producto_id');
                });
            }

            function agregar_detalle_venta(id, nombre, precio){

                // recorer la lista para ver si el producto existe
                let existe = false;
                $(".tr-detalle").each(function(){
                    if($(this).data('id')==id){
                        existe = true;
                    }
                });

                if(existe){
                    toastr.warning('El producto ya se encuentra en la lista.', 'Atención');
                }else{
                    $('#detalle_venta').before(`<tr class="tr-detalle" id="tr-${id}" data-id="${id}">
                                                    <td><input type="hidden" value="${id}" name="producto_id[]"><button type="button" class="btn btn-link" title="Ver información" onclick="producto_info(${id})">${nombre}</button></td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="number" id="input-precio_${id}" min="1" step="0.01" value="${precio}" name="precio[]" class="form-control" onchange="subtotal('${id}');" onkeyup="subtotal('${id}');" required />
                                                            <span class="input-group-addon">Bs.</span>
                                                        </div>
                                                    </td>
                                                    <td><input type="number" min="1" step="0.01" class="form-control" id="input-cantidad_${id}" value="1" name="cantidad[]" onchange="subtotal('${id}');" onkeyup="subtotal('${id}');" required></td>
                                                    <td class="label-subtotal" id="subtotal-${id}"><h4>${precio} Bs.</h4></td>
                                                    <td width="40px"><label onclick="borrarProducto('${id}')" class="text-danger" style="cursor:pointer;font-size:20px"><span class="voyager-trash"></span></label></td>
                                                <tr>`);
                    toastr.remove();
                    toastr.info('Producto agregar correctamente', 'Bien hecho!');
                }
                $('#input_cantidad-'+id).val('1');
                total();
            }

            function producto_info(id){
                $('#modal-info_producto').modal();
                $('#info_producto').html('<br><h4 class="text-center">Cargando...</h4>');
                $.get('{{url("admin/productos/ver/informacion")}}/'+id, function(data){
                    $('#info_producto').html(data);
                });
            }

            function borrarProducto(num){
                $(`#tr-${num}`).remove();
                total();
            }
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endcan

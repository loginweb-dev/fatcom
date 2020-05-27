@extends('voyager::master')
@section('page_title', 'Viendo Deposito')

@if(auth()->user()->hasPermission('read_depositos'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-archive"></i> {{ $deposito->nombre }}
        </h1>
        {{-- El permiso "add_producto_depositos" se usa tanto para agregar productos al almacen, como para agregar extras e insumos --}}
        @if(auth()->user()->hasPermission('add_producto_depositos') && setting('admin.modo_sistema') == 'restaurante')
        <div class="dropdown" style="display:inline">
            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown" style="margin-top:1px" title="Usar esta opción en caso estar realizando inventario."><i class="voyager-list-add"></i> Agregar
            <span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="#" data-toggle="modal" data-target="#modal_extras" id="btn-add_extras">Extras</a></li>
              <li><a href="#" data-toggle="modal" data-target="#modal_insumos" id="btn-add_insumos">Insumos</a></li>
            </ul>
        </div>
        @endif
        @if(auth()->user()->hasPermission('add_producto_depositos'))
            <a class="btn btn-primary btn-add-new btn-traspaso" data-toggle="modal" data-target="#modal_traspaso">
                <i class="voyager-forward"></i> <span>Traspaso</span>
            </a>
        @endif
        @if ($deposito->inventario)
            @if(auth()->user()->hasPermission('add_producto_depositos'))
            <div class="dropdown" style="display:inline">
                <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" style="margin-top:1px" title="Usar esta opción en caso estar realizando inventario."><i class="voyager-data"></i> Inventariar
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="#" data-toggle="modal" data-target="#modal_add_producto" id="btn-add-exist">Producto existente</a></li>
                  <li><a href="{{ route('depositos_create_producto', ['id' => $id]) }}">Nuevo producto</a></li>
                </ul>
            </div>
            @endif
        @endif
        <a href="{{route('depositos_index')}}" class="btn btn-warning btn-add-new">
            <i class="voyager-list"></i> <span>Ir a la lista</span>
        </a>
    @stop
    @section('content')
        <div class="page-content">
            <div class="page-content browse container-fluid">
                @include('voyager::alerts')
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="panel-heading">
                                <h4 class="panel-title">Costo total del inventario</h4>
                                <div class="panel-actions">
                                    <a class="panel-action panel-collapsed voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                                </div>
                            </div>
                            <div class="panel-body collapse">
                                <table class="table table-hover">
                                    <tr>
                                        <td><h5>Monto a precio de compra</h5></td>
                                        <td><h4>{{ number_format($total_compra, 2, ',', '.') }} Bs.</h4></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Monto a precio de venta</h5></td>
                                        <td><h4>{{ number_format($total_venta, 2, ',', '.') }} Bs.</h4></td>
                                    </tr>
                                    <tr>
                                        <td><h4>Ganancia neta</h4></td>
                                        <td><h3>{{ number_format($total_venta - $total_compra, 2, ',', '.') }} Bs.</h3></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-8"></div>
                                        <form id="form-search" class="form-search">
                                            <div class="input-group col-md-4">
                                                <input type="text" id="search_value" class="form-control" name="s" value="{{$value}}" placeholder="Ingresar busqueda...">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" style="margin-top:0px;padding:5px 10px" type="submit">
                                                        <i class="voyager-search"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <ul class="nav nav-tabs">
                                        <li class="li-items_type active" data-value="productos"><a href="#"><b style="font-size:18px">Productos</b></a></li>
                                        @if (setting('admin.modo_sistema') == 'restaurante')
                                        <li class="li-items_type" data-value="insumos"><a href="#"><b style="font-size:18px">Insumos</b></a></li>
                                        <li class="li-items_type" data-value="extras"><a href="#"><b style="font-size:18px">Extras</b></a></li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="row" id="lista-items"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal agregar extras --}}
        <form action="{{route('deposito_registro_extra')}}" method="POST">
            <div class="modal modal-primary fade" tabindex="-1" id="modal_extras" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-list-add"></i> Agregar extras
                            </h4>
                        </div>
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="">Extras</label>
                                <select name="extra_id" class="form-control" id="select-extra_id" required>
                                    <option value="">Seleccione los extras</option>
                                    @foreach ($extras as $item)
                                    <option value="{{ $item->id }}" data-precio="{{ $item->precio }}" data-ultimo_precio="{{ $item->ultimo_precio }}" data-nombre="{{ $item->nombre }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="table-responsive" style="max-height:350px;overflow-y:auto">
                                <table id="dataTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Extra</th>
                                            <th style="width:120px">Cantidad</th>
                                            <th style="width:120px">Precio de elaboración</th>
                                            <th style="width:120px">Precio de venta</th>
                                            <th style="width:50px"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="extras-selected">
                                        <tr><td colspan="5" class="text-center">No se ha seleccionado ninguna opción</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <input type="checkbox" name="verificar" id="input-verificar-1" required>
                                <label for="input-verificar-1">Confirmar registro</label>
                            </div>
                            <input type="hidden" name="deposito_id" value="{{ $id }}">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" disabled class="btn btn-primary" id="btn-extras" value="Registrar">
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Modal agregar insumos --}}
        <form action="{{route('deposito_registro_insumo')}}" method="POST">
            <div class="modal modal-primary fade" tabindex="-1" id="modal_insumos" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-list-add"></i> Agregar insumos
                            </h4>
                        </div>
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="">Insumos</label>
                                <select name="extra_id" class="form-control" id="select-insumo_id" required>
                                    <option value="">Seleccione los insumo</option>
                                    @foreach ($insumos as $item)
                                    <option value="{{ $item->id }}" data-precio="{{ $item->precio }}" data-nombre="{{ $item->nombre }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="table-responsive" style="max-height:350px;overflow-y:auto">
                                <table id="dataTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Insumo</th>
                                            <th style="width:120px">Cantidad</th>
                                            <th style="width:120px">Precio</th>
                                            <th style="width:50px"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="insumos-selected">
                                        <tr><td colspan="4" class="text-center">No se ha seleccionado ninguna opción</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <input type="checkbox" name="verificar" id="input-verificar-2" required>
                                <label for="input-verificar-2">Confirmar registro</label>
                            </div>
                            <input type="hidden" name="deposito_id" value="{{ $id }}">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" disabled class="btn btn-primary" id="btn-insumos" value="Registrar">
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- modal agregar producto --}}
        @if ($deposito->inventario)
        <form action="{{route('depositos_store_producto')}}" method="POST">
            <div class="modal modal-success fade" tabindex="-1" id="modal_add_producto" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-list-add"></i> Agregar producto existente
                            </h4>
                        </div>
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <input type="hidden" name="deposito_id" value="{{ $id }}">
                            <div class="form-group">
                                <label for="">Producto</label>
                                <select name="producto_id" class="form-control" id="select-producto_id" required>
                                    <option selected disabled value="">Seleccione una opción</option>
                                    @foreach ($productos_faltantes as $item)
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
                            </div>
                            <div class="form-group">
                                <label for="">Stock</label>
                                <input type="number" name="stock" class="form-control" min="0.1" step="1" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-success pull-right"value="Guardar">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endif

        {{-- Modal traspaso de productos --}}
        <form action="{{route('deposito_traspaso_items')}}" method="POST">
            <div class="modal modal-info fade" tabindex="-1" id="modal_traspaso" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-forward"></i> Traspaso de productos
                            </h4>
                        </div>
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="">Deposito de destino</label>
                                <select name="deposito_receptor_id" class="form-control" id="select-deposito_id" required>
                                    <option value="" disabled>Seleccione el deposito de destino</option>
                                    @foreach ($depositos as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="radio-inline">
                                    <input class="radio-traspaso" type="radio" name="optradio" checked value="productos">Productos
                                </label>
                                @if (setting('admin.modo_sistema') == 'restaurante')
                                <label class="radio-inline">
                                    <input class="radio-traspaso" type="radio" name="optradio" value="insumos">Insumos
                                </label>
                                <label class="radio-inline">
                                    <input class="radio-traspaso" type="radio" name="optradio" value="extras">Extras
                                </label>
                                @endif
                            </div>
                            <div class="form-group div-traspaso" id="div-select-productos">
                                <select name="" class="form-control select-traspaso" id="select-productos">
                                    <option selected disabled value="">Seleccione una opción</option>
                                    @foreach ($productos_almacen as $item)
                                        @if ($item->cantidad>0)
                                        <option value="{{ $item->id }}" data-nombre="{{ $item->nombre }}" data-stock="{{ $item->cantidad }}" data-subtitle="{{ $item->subcategoria }}">{{ $item->nombre }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group div-traspaso" id="div-select-insumos" style="display:none">
                                <select name="" class="form-control select-traspaso" id="select-insumos">
                                    <option selected disabled value="">Seleccione una opción</option>
                                    @foreach ($insumos as $item)
                                        <option value="{{ $item->id }}" data-nombre="{{ $item->nombre }}" data-stock="{{ $item->stock }}" data-subtitle="{{ $item->precio.' Bs.' }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group div-traspaso" id="div-select-extras" style="display:none">
                                <select name="" class="form-control select-traspaso" id="select-extras">
                                    <option selected disabled value="">Seleccione una opción</option>
                                    @foreach ($extras as $item)
                                        <option value="{{ $item->id }}" data-nombre="{{ $item->nombre }}" data-stock="{{ $item->stock }}" data-subtitle="{{ $item->precio.' Bs.' }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="table-responsive" style="max-height:350px;overflow-y:auto">
                                <table id="dataTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Stock actual</th>
                                            <th style="width:120px">Cantidad a enviar</th>
                                            <th style="width:50px"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="items-selected">
                                        <tr><td colspan="4" class="text-center">No se ha seleccionado ninguna opción</td></tr>
                                    </tbody>
                                </table>
                            </div>
                            <textarea name="observacion" class="form-control" rows="3" placeholder="Observaciones"></textarea>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <input type="checkbox" name="verificar" id="input-verificar" required>
                                <label for="input-verificar">Confirmar traspaso</label>
                            </div>
                            <input type="hidden" name="deposito_id" value="{{ $id }}">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" disabled class="btn btn-primary" id="btn-enviar_traspaso" value="Traspasar">
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Modal de edicion --}}
        <form action="{{route('depositos_update_producto')}}" method="POST">
            <div class="modal modal-info fade" tabindex="-1" id="modal_edit_producto" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-list-add"></i> Editar producto en almacen
                            </h4>
                        </div>
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <input type="hidden" name="deposito_id" value="{{ $id }}">
                            <input type="hidden" name="producto_id">
                            <div class="alert alert-warning">
                                <strong>Atención:</strong>
                                <p>Tenga en cuenta que al editar el stock del producto en este almacen de forma manual, no coincidirá con el sus datos de compra y ventas del mismo.</p>
                            </div>
                            <div class="form-group">
                                <label for="">Stock actual</label>
                                <input type="number" name="stock" class="form-control" min="1" step="0.1" required>
                                <input type="hidden" name="stock_actual">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary pull-right"value="Guardar">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Modal de eliminación --}}
        <form action="{{route('depositos_delete_producto')}}" method="POST">
            <div class="modal modal-danger fade" tabindex="-1" id="modal_delete_producto" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-list-add"></i> Eliminar producto de almacen
                            </h4>
                        </div>
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <input type="hidden" name="deposito_id" value="{{ $id }}">
                            <input type="hidden" name="producto_id">
                            <div class="alert alert-danger">
                                <strong>Atención:</strong>
                                <p>Tenga en cuenta que al eliminar el stock del producto de este almacen de forma manual, no coincidirá con el sus datos de compra y ventas del mismo.</p>
                            </div>
                            <input type="hidden" name="stock_actual">
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-danger pull-right"value="Eliminar">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    @stop
    @section('css')
        <link href="{{url('ecommerce_public/plugins/fancybox/fancybox.min.css')}}" type="text/css" rel="stylesheet">
        <style>
            
        </style>
    @stop
    @section('javascript')
        <script src="{{ asset('js/rich_select.js') }}"></script>
        <script src="{{ asset('js/rich_select_simple.js') }}"></script>
        <script src="{{url('ecommerce_public/plugins/fancybox/fancybox.min.js')}}" type="text/javascript"></script>
        <script>
            var loader = "{{ url('storage').'/'.str_replace('\\', '/', setting('admin.img_loader')) }}";
            var loader_request = `  <div style="height:300px" class="text-center">
                                        <br><br><br>
                                        <img src="${loader}" width="100px">
                                    </div>`;
            var list_items = 'productos';
            $(document).ready(function() {

                // Inicializar select2
                $('#btn-add-exist').click(function(){
                    setTimeout(()=> rich_select('select-producto_id'), 300);
                });
                $('.btn-traspaso').click(function(){
                    setTimeout(()=> $('#select-deposito_id').select2(), 500);
                    setTimeout(()=> rich_select_simple('select-productos'), 300);
                });
                $('#btn-add_extras').click(function(){
                    setTimeout(()=> $('#select-extra_id').select2(), 300);
                });
                $('#btn-add_insumos').click(function(){
                    setTimeout(()=> $('#select-insumo_id').select2(), 300);
                });
                // ==================

                listItems(list_items, 1);

                // Agregar extra al seleccionarlo
                $('#select-extra_id').change(function(){
                    let id = $(this).val();
                    let nombre = $('#select-extra_id option:selected').data('nombre');
                    let precio = $('#select-extra_id option:selected').data('precio');
                    let ultimo_precio = $('#select-extra_id option:selected').data('ultimo_precio');
                    let cantidad = $('#extras-selected').find('.li-extras').length;
                    if($('#extras-selected').find(`#li-extras-${id}`).length==0){
                        let option = `
                            <tr class="li-extras" id="li-extras-${id}">
                                <td>${nombre}<input type="hidden" name="extras_id[]" value="${id}" /></td>
                                <td><input type="number" min="0.1" step="0.1" name="cantidad[]" class="form-control" required /></td>
                                <td><input type="number" step="0.1" name="precio_compra[]" value="${ultimo_precio}" class="form-control" required /></td>
                                <td><input type="number" min="0.1" step="0.1" name="precio_venta[]" value="${precio}" class="form-control" required /></td>
                                <td>
                                    <button type="button" class="btn btn-link btn-sm btn-danger" onclick="removeExtraTr(${id})">
                                        <i class="voyager-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        if(cantidad>0){
                            $('#extras-selected').append(option);
                        }else{
                            $('#extras-selected').html(option);
                        }
                        $('#btn-extras').removeAttr('disabled');
                    }else{
                        toastr.remove();
                        toastr.warning('El extra selccionado ya se encuentra en la lista.','Advertencia');
                    }
                    
                });

                // Agregar insumo al seleccionarlo
                $('#select-insumo_id').change(function(){
                    let id = $(this).val();
                    let nombre = $('#select-insumo_id option:selected').data('nombre');
                    let precio = $('#select-insumo_id option:selected').data('precio');
                    let cantidad = $('#insumos-selected').find('.li-insumos').length;
                    if($('#insumos-selected').find(`#li-insumos-${id}`).length==0){
                        let option = `
                            <tr class="li-insumos" id="li-insumos-${id}">
                                <td>${nombre}<input type="hidden" name="insumo_id[]" value="${id}" /></td>
                                <td><input type="number" min="0.1" step="0.1" name="cantidad[]" class="form-control" required /></td>
                                <td><input type="number" min="0.1" step="0.1" name="precio_venta[]" value="${precio}" class="form-control" required /></td>
                                <td>
                                    <button type="button" class="btn btn-link btn-sm btn-danger" onclick="removeInsumoTr(${id})">
                                        <i class="voyager-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        if(cantidad>0){
                            $('#insumos-selected').append(option);
                        }else{
                            $('#insumos-selected').html(option);
                        }
                        $('#btn-insumos').removeAttr('disabled');
                    }else{
                        toastr.remove();
                        toastr.warning('El insumo selccionado ya se encuentra en la lista.','Advertencia');
                    }
                    
                });

                // Agregar producto al seleccionarlo en modal de traspaso
                $('.select-traspaso').change(function(){
                    let id = $(this).val();
                    let type = $('.radio-traspaso:checked').val();
                    let nombre = $(`#select-${type} option:selected`).data('nombre');
                    let subtitle = $(`#select-${type} option:selected`).data('subtitle');
                    let stock = $(`#select-${type} option:selected`).data('stock');
                    let cantidad = $('#items-selected').find('.li-items').length;
                    if($('#items-selected').find(`#li-items-${id}`).length==0){
                        let option = `
                            <tr class="li-items" id="li-items-${id}">
                                <td>${nombre}<br><small>${subtitle}</small><input type="hidden" name="item_id[]" value="${id}" /></td>
                                <td>${stock}</td>
                                <td><input type="number" min="0.1" step="0.1" max="${stock}" name="cantidad_envio[]" class="form-control" required /></td>
                                <td>
                                    <button type="button" class="btn btn-link btn-sm btn-danger" onclick="removeItemTr(${id})">
                                        <i class="voyager-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        if(cantidad>0){
                            $('#items-selected').append(option);
                        }else{
                            $('#items-selected').html(option);
                        }
                        $('#btn-enviar_traspaso').removeAttr('disabled');
                    }else{
                        toastr.remove();
                        toastr.warning('El producto selccionado ya se encuentra en la lista.','Advertencia');
                    }
                });

                // set valor de update
                $('.btn-edit').click(function(){
                    $('#modal_edit_producto input[name="producto_id"]').val($(this).data('id'));
                    $('#modal_edit_producto input[name="stock"]').val($(this).data('cantidad'));
                    $('#modal_edit_producto input[name="stock_actual"]').val($(this).data('cantidad'));
                });

                // set valor de delete
                $('.btn-delete').click(function(){
                    $('#modal_delete_producto input[name="producto_id"]').val($(this).data('id'));
                    $('#modal_delete_producto input[name="stock_actual"]').val($(this).data('cantidad'));
                });

                // enviar formulario de busqueda
                $('#form-search').on('submit', function(e){
                    e.preventDefault();
                    listItems(list_items, 1);
                });

                // Cambiar lista de elementos
                $('.li-items_type').click(function(e){
                    e.preventDefault();
                    list_items_act = $(this).data('value');
                    if(list_items != list_items_act){
                        $('.li-items_type').removeClass('active');
                        $(this).addClass('active');
                        list_items = list_items_act;
                        listItems(list_items, 1);
                    }
                });

                // Cambiar la lista deplegable según opción de traspaso
                $('.radio-traspaso').click(function(){
                    let type = $('.radio-traspaso:checked').val();
                    $('.div-traspaso').css('display', 'none');
                    $(`#div-select-${type}`).css('display', 'block');
                    rich_select_simple(`select-${type}`);
                    $('#items-selected').html(`<tr><td colspan="4" class="text-center">No se ha seleccionado ninguna opción</td></tr>`);
                });
            });

            function listItems(type, page){
                let search = $('#search_value').val();
                let id = "{{ $id }}";
                $('#lista-items').html(loader_request);
                $.get("{{ url('admin/depositos/ver/list') }}/"+type+"/"+id+"/"+search+"?page="+page, function(data){
                    $('#lista-items').html(data);
                });
            }

            function removeExtraTr(id){
                $(`#li-extras-${id}`).remove();
                if($('#extras-selected').find('.li-extras').length==0){
                    $('#extras-selected').append(`<tr><td colspan="5" class="text-center">No se ha seleccionado ninguna opción</td></tr>`);
                    $('#btn-extras').attr('disabled', 'disabled')
                }
            }
            function removeInsumoTr(id){
                $(`#li-insumos-${id}`).remove();
                if($('#insumos-selected').find('.li-insumos').length==0){
                    $('#insumos-selected').append(`<tr><td colspan="4" class="text-center">No se ha seleccionado ninguna opción</td></tr>`);
                    $('#btn-insumos').attr('disabled', 'disabled')
                }
            }
            function removeItemTr(id){
                $(`#li-items-${id}`).remove();
                console.log($('#items-selected').find('.li-items').length==0)
                if($('#items-selected').find('.li-items').length==0){
                    $('#items-selected').append(`<tr><td colspan="4" class="text-center">No se ha seleccionado ninguna opción</td></tr>`);
                    $('#btn-enviar_traspaso').attr('disabled', 'disabled')
                }
            }
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

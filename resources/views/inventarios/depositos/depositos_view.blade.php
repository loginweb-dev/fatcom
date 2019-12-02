@extends('voyager::master')
@section('page_title', 'Viendo Deposito')

@if(auth()->user()->hasPermission('read_depositos'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-archive"></i> {{ $deposito->nombre }}
        </h1>
        @if ($deposito->inventario)
            @if(auth()->user()->hasPermission('add_producto_depositos'))
            <a href="{{route('depositos_create_producto', ['id' => $id])}}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>Añadir nuevo producto</span>
            </a>
            @endif
            @if(auth()->user()->hasPermission('add_producto_depositos'))
            <a href="#" data-toggle="modal" data-target="#modal_add_producto" class="btn btn-info btn-add-new" id="btn-add-exist">
                <i class="voyager-plus"></i> <span>Añadir producto existente</span>
            </a>
            @endif
        @endif
        
        <a href="{{route('depositos_index')}}" class="btn btn-warning" style="margin-top:3px">
            <i class="voyager-list"></i> <span>Volver a la lista</span>
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
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th>Categoria</th>
                                                <th>Precio</th>
                                                <th>Stock</th>
                                                <th>Imagen</th>
                                                @if ($deposito->inventario)
                                                <th class="actions text-right">Acciones</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $cont = 0;
                                            @endphp
                                            @forelse ($registros as $item)
                                                @php
                                                    $img = ($item->imagen != '') ? str_replace('.', '_small.', $item->imagen) : 'productos/default.png';
                                                    $imagen = $item->imagen ?? 'productos/default.png';

                                                @endphp
                                                <tr>
                                                    <td>{{ $item->codigo }}</td>
                                                    <td>{{ $item->nombre }}</td>
                                                    <td>{{ $item->subcategoria }}</td>
                                                    <td>{{ $item->precio_venta }}</td>
                                                    <td>{{ $item->cantidad }}</td>
                                                    <td><a href="{{ url('storage').'/'.$imagen }}" data-fancybox="galeria1" data-caption="{{ $item->nombre }}"><img src="{{ url('storage').'/'.$img }}" width="50px" alt=""></a></td>
                                                    @if ($deposito->inventario)
                                                    <td class="no-sort no-click text-right" id="bread-actions">
                                                        @if(auth()->user()->hasPermission('edit_productos'))
                                                        <a href="#" title="Editar" class="btn btn-sm btn-primary edit">
                                                            <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span>
                                                        </a>
                                                        @endif
                                                    </td>
                                                    @endif
                                                </tr>
                                                @php
                                                    $cont++;
                                                @endphp
                                            @empty
                                            <tr>
                                                <td colspan="7"><p class="text-center"><br>No hay registros para mostrar.</p></td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-6" style="overflow-x:auto">
                                        @if(count($registros)>0)
                                            <p class="text-muted">Mostrando del {{$registros->firstItem()}} al {{$registros->lastItem()}} de {{$registros->total()}} registros.</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6" style="overflow-x:auto">
                                        <nav class="text-right">
                                            {{ $registros->links() }}
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal delete --}}
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
                                    @foreach ($productos as $item)
                                        @php
                                            $imagen = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : 'productos/default.png';
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
                                <input type="number" name="stock" class="form-control" min="1" step="1" id="" required>
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
    @stop
    @section('css')
        <link href="{{url('ecommerce_public/plugins/fancybox/fancybox.min.css')}}" type="text/css" rel="stylesheet">
        <style>

        </style>
    @stop
    @section('javascript')
        <script src="{{ asset('js/rich_select.js') }}"></script>
        <script src="{{url('ecommerce_public/plugins/fancybox/fancybox.min.js')}}" type="text/javascript"></script>
        <script>
            $(document).ready(function() {

                // set valor de delete
                $('.btn-delete').click(function(){
                    $('#modal_delete input[name="id"]').val($(this).data('id'));
                });

                $('#btn-add-exist').click(function(){
                    setTimeout(()=> rich_select('select-producto_id'), 300);
                });

                // enviar formulario de busqueda
                $('#form-search').on('submit', function(e){
                    e.preventDefault();
                    let value = (escape($('#search_value').val())!='') ? escape($('#search_value').val()) : 'all';
                    window.location = '{{url("admin/depositos/ver/".$id."/buscar")}}/'+value;
                });
            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

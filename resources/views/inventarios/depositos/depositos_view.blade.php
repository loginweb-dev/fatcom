@extends('voyager::master')
@section('page_title', 'Viendo Deposito')

@if(auth()->user()->hasPermission('view_depositos'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-archive"></i> Viendo Depositos
        </h1>
        @if(auth()->user()->hasPermission('add_producto_depositos'))
        <a href="{{route('depositos_create_producto', ['id' => $id])}}" class="btn btn-success btn-add-new">
            <i class="voyager-plus"></i> <span>Añadir nuevo producto</span>
        </a>
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
                                                <th class="actions text-right">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $cont = 0;
                                            @endphp
                                            @forelse ($registros as $item)
                                                @php
                                                    $img = ($imagenes[$cont]['nombre']!='') ? str_replace('.', '_small.', $imagenes[$cont]['nombre']) : 'productos/default.png';
                                                    $imagen = ($imagenes[$cont]['nombre']!='') ? $imagenes[$cont]['nombre'] : 'productos/default.png';

                                                @endphp
                                                <tr>
                                                    <td>{{$item->codigo}}</td>
                                                    <td>{{$item->nombre}}</td>
                                                    <td>{{$item->subcategoria}}</td>
                                                    <td>{{$precios[$cont]['precio']}}</td>
                                                    <td>{{$item->cantidad}}</td>
                                                    <td><a href="{{url('storage').'/'.$imagen}}" data-fancybox="galeria1" data-caption="{{$item->nombre}}"><img src="{{url('storage').'/'.$img}}" width="50px" alt=""></a></td>
                                                    <td class="no-sort no-click text-right" id="bread-actions">
                                                        {{-- @if(auth()->user()->hasPermission('edit_productos'))
                                                        <a href="{{route('productos_edit', ['id'=>$item->id])}}" title="Editar" class="btn btn-sm btn-primary edit">
                                                            <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span>
                                                        </a>
                                                        @endif
                                                        @if(auth()->user()->hasPermission('delete_productos'))
                                                        <a href="#" title="Borrar" class="btn btn-sm btn-danger btn-delete" data-id="{{$item->id}}" data-toggle="modal" data-target="#modal_delete">
                                                            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                                                        </a>
                                                        @endif --}}
                                                    </td>
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
        <form action="{{route('productos_delete')}}" method="POST">
            <div class="modal modal-danger fade" tabindex="-1" id="modal_delete" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-trash"></i> Estás seguro que quieres borrar el siguiente registro?
                            </h4>
                        </div>

                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="">
                            <input type="submit" class="btn btn-danger pull-right delete-confirm"value="Sí, bórralo!">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @stop
    @section('css')
        <link href="{{url('landing_page/plugins/fancybox/fancybox.min.css')}}" type="text/css" rel="stylesheet">
        <style>

        </style>
    @stop
    @section('javascript')
        <script src="{{url('landing_page/plugins/fancybox/fancybox.min.js')}}" type="text/javascript"></script>
        <script>
            $(document).ready(function() {

                // set valor de delete
                $('.btn-delete').click(function(){
                    $('#modal_delete input[name="id"]').val($(this).data('id'));
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

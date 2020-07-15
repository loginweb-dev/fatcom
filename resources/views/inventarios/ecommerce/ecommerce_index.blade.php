@extends('voyager::master')
@section('page_title', 'Ecommerce')

@if(auth()->user()->hasPermission('browse_ecommerce'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-basket"></i>Productos agregados al E-Commerce
        </h1>
        @if(auth()->user()->hasPermission('add_ecommerce'))
        <a href="{{route('ecommerce_create')}}" class="btn btn-success btn-add-new">
            <i class="voyager-plus"></i> <span>Añadir nuevo</span>
        </a>
        @endif
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
                                                <input type="text" id="search_value" class="form-control" name="s" value="{{$value}}" placeholder="Producto o categoría">
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
                                                <th>Estado</th>
                                                <th>Nombre</th>
                                                <th>Subcategoria</th>
                                                <th>Tags</th>
                                                <th>última modificación</th>
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
                                                    $img = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : '../img/default.png';
                                                    $imagen = ($item->imagen!='') ? $item->imagen : '../img/default.png';
                                                @endphp
                                                <tr>
                                                    <td>
                                                    <input type="checkbox" class="check-estado" @if($item->activo) checked @endif data-id="{{ $item->ecommerce_id }}" data-toggle="toggle" data-on="Activo" data-off="Inactivo">
                                                    </td>
                                                    <td>{{$item->nombre}}</td>
                                                    <td>{{$item->subcategoria}}</td>
                                                    <td>@php echo str_replace(',', '<br>', $item->tags); @endphp</td>
                                                    <td>{{date('d-m-Y', strtotime($item->updated_at))}} <br> <small>{{\Carbon\Carbon::parse($item->updated_at)->diffForHumans()}}</small> </td>
                                                    <td><a href="{{url('storage').'/'.$imagen}}" data-fancybox="galeria1" data-caption="{{$item->nombre}}"><img src="{{url('storage').'/'.$img}}" width="50px" alt=""></a></td>
                                                    <td class="no-sort no-click text-right" id="bread-actions">
                                                        {{-- @if(auth()->user()->hasPermission('read_ecommerce'))
                                                        <a href="{{route('ecommerce_view', ['id' => $item->id])}}" title="Ver" class="btn btn-sm btn-warning view">
                                                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                                                        </a>
                                                        @endif --}}
                                                        @if(auth()->user()->hasPermission('edit_ecommerce'))
                                                        <a href="{{route('ecommerce_edit', ['id'=>$item->ecommerce_id])}}" title="Editar" class="btn btn-sm btn-primary edit">
                                                            <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span>
                                                        </a>
                                                        @endif
                                                        @if(auth()->user()->hasPermission('delete_ecommerce'))
                                                        <a href="#" title="Borrar" class="btn btn-sm btn-danger btn-delete" data-id="{{$item->ecommerce_id}}" data-toggle="modal" data-target="#modal_delete">
                                                            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                                                        </a>
                                                        @endif
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
        <form action="{{route('ecommerce_delete')}}" method="POST">
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
        <link href="{{url('ecommerce_public/plugins/fancybox/fancybox.min.css')}}" type="text/css" rel="stylesheet">
        <style>

        </style>
    @stop
    @section('javascript')
        <script src="{{url('ecommerce_public/plugins/fancybox/fancybox.min.js')}}" type="text/javascript"></script>
        <script>
            $(document).ready(function() {
                $('[data-toggle="popover"]').popover({ html : true });
                $('[data-toggle="tooltip"]').tooltip();
                // set valor de delete
                $('.btn-delete').click(function(){
                    $('#modal_delete input[name="id"]').val($(this).data('id'));
                });

                // enviar formulario de busqueda
                $('#form-search').on('submit', function(e){
                    e.preventDefault();
                    let value = (escape($('#search_value').val())!='') ? escape($('#search_value').val()) : 'all';
                    window.location = '{{url("admin/ecommerce/buscar")}}/'+value;
                });

                // Cambiar estado del producto
                $('.check-estado').change(function(){
                    let id = $(this).data('id');
                    let status = $(this).prop('checked') ? 1 : 0;
                    $.get("{{ url('admin/ecommerce/editar_estado') }}/"+id+'/'+status, function(data){
                        if(data.success){
                            toastr.success(data.success, 'Bien hecho!');
                        }else{
                            toastr.error(data.error, 'Error!');
                        }
                    })
                })
            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

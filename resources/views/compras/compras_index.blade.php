@extends('voyager::master')
@section('page_title', 'Compras')

@if(auth()->user()->hasPermission('browse_compras'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-buy"></i> Compras
        </h1>
        @if(auth()->user()->hasPermission('add_compras'))
        <a href="{{route('compras_create')}}" class="btn btn-success btn-add-new">
            <i class="voyager-plus"></i> <span>Añadir nueva</span>
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
                                {{-- <div class="row">
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
                                </div> --}}
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nro</th>
                                                <th>Usuario</th>
                                                <th>Fecha de compra</th>
                                                <th>Razón social</th>
                                                <th>N&deg; de factura</th>
                                                <th>Código de control</th>
                                                <th>Total</th>
                                                <th>Productos</th>
                                                <th class="actions text-right">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $cont = 0;
                                                setlocale(LC_ALL, "es_ES");
                                            @endphp
                                            @forelse ($compras as $item)
                                                <tr>
                                                    <td>{{ str_pad($item->id, 4, "0", STR_PAD_LEFT) }}</td>
                                                    <td> {{$item->user->name}}</td>
                                                    <td>{{ strftime("%d de %B de %Y", strtotime($item->fecha)) }} <br> <small>Registrado {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small></td>
                                                    <td>{{ $item->razon_social }} <br> <small>{{ $item->nit }}</small></td>
                                                    <td>{{ $item->nro_factura }}</td>
                                                    <td>{{ $item->codigo_control }}</td>
                                                    <td>{{ $item->importe_base }}</td>
                                                    <td>
                                                        @foreach($item->detalle as $detail)
                                                          * {{$detail->producto->text}} <br>
                                                        @endforeach
                                                    </td>
                                                    <td class="no-sort no-click text-right" id="bread-actions">
                                                        @if(auth()->user()->hasPermission('read_compras'))
                                                        <a href="{{ route('compras_read', ['id' => $item->id]) }}" title="Ver" class="btn btn-sm btn-warning view">
                                                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                                                        </a>
                                                        @endif
                                                        {{-- @if(auth()->user()->hasPermission('edit_compras'))
                                                        <a href="{{route('productos_edit', ['id'=>$item->id])}}" title="Editar" class="btn btn-sm btn-primary edit">
                                                            <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span>
                                                        </a>
                                                        @endif
                                                        @if(auth()->user()->hasPermission('delete_compras'))
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
                                    <div class="col-md-4" style="overflow-x:auto">
                                        @if(count($compras)>0)
                                            <p class="text-muted">Mostrando del {{ $compras->firstItem() }} al {{ $compras->lastItem() }} de {{ $compras->total() }} compras.</p>
                                        @endif
                                    </div>
                                    <div class="col-md-8" style="overflow-x:auto">
                                        <nav class="text-right">
                                            {{ $compras->links() }}
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
        <style>

        </style>
    @stop
    @section('javascript')
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
                    window.location = ''+value;
                });
            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

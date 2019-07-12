@extends('voyager::master')
@section('page_title', 'Ventas')

@if(auth()->user()->hasPermission('browse_ventas'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-basket"></i> Ventas
        </h1>
        @if(auth()->user()->hasPermission('add_ventas'))
        <a href="{{route('ventas_create')}}" class="btn btn-success btn-add-new">
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
                                                <th>Ticket</th>
                                                <th>Fecha</th>
                                                <th>Cliente</th>
                                                {{-- <th>N&deg; de factura</th>
                                                <th>Código de control</th> --}}
                                                <th>Total</th>
                                                <th>Tipo</th>
                                                <th>Estado</th>
                                                <th>Opción</th>
                                                <th class="actions text-right">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $cont = 0;
                                            @endphp
                                            @forelse ($registros as $item)
                                                <tr>
                                                    <td>#{{$item->id}}</td>
                                                    <td>{{date('d-m-Y', strtotime($item->fecha))}} <br> <small>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</small> </td>
                                                    <td>{{$item->cliente}}</td>
                                                    {{-- <td>{{$item->nro_factura}}</td>
                                                    <td>{{$item->codigo_control}}</td> --}}
                                                    <td>{{$item->importe_base}}</td>
                                                    {{-- Mostrar etiqueta del tipo de la venta --}}
                                                    <td>
                                                        @switch($item->tipo)
                                                            @case('venta') <label class="label label-primary">Venta</label> @break
                                                            @case('llevar') <label class="label label-info">Para llevar</label> @break
                                                            @case('pedido' || 'domicilio') <label class="label label-success">Pedido</label> @break
                                                            @default
                                                        @endswitch
                                                    </td>
                                                    {{-- Calcular si el cluente debe --}}
                                                    @php
                                                        $debe = false;
                                                        $deuda = '';
                                                        if($item->importe_base > $item->monto_recibido){
                                                            $debe = true;
                                                            $deuda = number_format($item->importe_base - $item->monto_recibido, 2, ',', '');
                                                        }
                                                    @endphp
                                                    {{-- Mostrar etiqueta del estado de la venta --}}
                                                    <td>
                                                        @switch($item->tipo_estado)
                                                            @case(1) <label class="label label-warning">Pedido realizado</label> @break
                                                            @case(2) <label class="label label-info">En preparación</label> @break
                                                            @case(3) <label class="label label-success">Listo</label> @if($debe) <label class="label label-danger" data-toggle="tooltip" data-placement="bottom" title="El cliente tiene una deuda de {{$deuda}} Bs.">Debe Bs. {{$deuda}}</label>@endif @break
                                                            @case(4) <label class="label label-dark">Enviado</label> @break
                                                            @case(5) <label class="label label-primary">Entregado</label> @break
                                                            @default
                                                        @endswitch
                                                    </td>
                                                    <td>
                                                        {{-- Mostrar boton de opciones --}}
                                                        @switch($item->tipo)
                                                            @case('llevar')
                                                                @switch($item->tipo_estado)
                                                                    @case(2)
                                                                        <a href="{{route('estado_update', ['id' => $item->id, 'valor' => $item->tipo_estado+1])}}" title="Listo" class="btn btn-sm btn-success">
                                                                            <span class="hidden-xs hidden-sm">Listo</span> <i class="voyager-check"></i>
                                                                        </a>
                                                                        @break
                                                                    @case(3)
                                                                        <a href="{{route('estado_update', ['id' => $item->id, 'valor' => $item->tipo_estado+2])}}" title="Listo" class="btn btn-sm btn-dark">
                                                                            <span class="hidden-xs hidden-sm">Entregar</span> <i class="voyager-basket"></i>
                                                                        </a>
                                                                    @break
                                                                    @default

                                                                @endswitch
                                                                @break
                                                            @case('pedido' || 'domicilio')
                                                                @switch($item->tipo_estado)
                                                                    @case(1)
                                                                        <a href="{{route('estado_update', ['id' => $item->id, 'valor' => $item->tipo_estado+1])}}" title="Preparar" class="btn btn-sm btn-info">
                                                                            <span class="hidden-xs hidden-sm">Preparar</span> <i class="voyager-alarm-clock"></i>
                                                                        </a>
                                                                        @break
                                                                    @case(2)
                                                                        <a href="{{route('estado_update', ['id' => $item->id, 'valor' => $item->tipo_estado+1])}}" title="Listo" class="btn btn-sm btn-success">
                                                                            <span class="hidden-xs hidden-sm">Listo</span> <i class="voyager-check"></i>
                                                                        </a>
                                                                        @break
                                                                    @case(3)
                                                                        <a href="#" data-toggle="modal" data-target="#modal_delivery" data-id="{{$item->id}}" title="Enviar" class="btn btn-sm btn-dark btn-delivery">
                                                                            <span class="hidden-xs hidden-sm">Enviar</span> <i class="voyager-rocket"></i>
                                                                        </a>
                                                                        @break
                                                                    @case(4)
                                                                        {{-- <a href="{{route('estado_update', ['id' => $item->id, 'valor' => $item->tipo_estado+1])}}" title="Entregado" class="btn btn-sm btn-primary">
                                                                            <span class="hidden-xs hidden-sm">Entregado</span> <i class="voyager-basket"></i>
                                                                        </a> --}}
                                                                        @break
                                                                    @default

                                                                @endswitch
                                                                @break

                                                            @default

                                                        @endswitch
                                                    </td>
                                                    <td class="no-sort no-click text-right" id="bread-actions">
                                                        <a href="{{route('ventas_view', ['id' => $item->id])}}" title="Ver" class="btn btn-sm btn-warning view">
                                                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                                                        </a>
                                                        {{-- @if(auth()->user()->hasPermission('read_ventas'))
                                                        <a href="{{route('productos_view', ['id' => $item->id])}}" title="Ver" class="btn btn-sm btn-warning view">
                                                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                                                        </a>
                                                        @endif
                                                        @if(auth()->user()->hasPermission('edit_ventas'))
                                                        <a href="{{route('productos_edit', ['id'=>$item->id])}}" title="Editar" class="btn btn-sm btn-primary edit">
                                                            <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span>
                                                        </a>
                                                        @endif
                                                        @if(auth()->user()->hasPermission('delete_ventas'))
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
                                                <td colspan="8"><p class="text-center"><br>No hay registros para mostrar.</p></td>
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
                                <i class="voyager-refresh"></i> Estás seguro que quieres cambiar el estado de la venta?
                            </h4>
                        </div>
                        <form action="" method="POST">
                        <div class="modal-body">
                            <p>Si anula una venta ya no podra cambiar el estado de la misma.</p>
                            <select name="tipo" class="form-control select2" id="">
                                <option value="V">Valida</option>
                                <option value="E">Extraviada</option>
                                <option value="N">No autorizada</option>
                                <option value="C">Emitida en contingencia</option>
                                <option value="A">Anulada</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="">
                                <input type="hidden" name="total" value="">
                                <input type="hidden" name="factura" value="">
                                <input type="submit" class="btn btn-primary pull-right delete-confirm"value="Sí, cambialo!">

                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </form>

        {{-- modal repartidor --}}
        <form action="{{route('asignar_repartidor')}}" method="POST">
            <div class="modal modal-info fade" tabindex="-1" id="modal_delivery" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-truck"></i> Elija al repartidor
                            </h4>
                        </div>
                        <form action="" method="POST">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="">
                            <select name="repartidor_id" class="form-control select2" id="select-repartidor_id" required>
                                <option value="">--Seleccione al repartidor--</option>
                                @foreach ($delivery as $item)
                                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary pull-right delete-confirm"value="Sí, elegir!">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </form>
    @stop
    @section('css')
        <style>
            .select2{
                border: 1px solid #ddd
            }
        </style>
    @stop
    @section('javascript')
        <script>
            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
                // set valor de delete
                $('.btn-delete').click(function(){
                    $('#modal_delete input[name="id"]').val($(this).data('id'));
                });

                // Set valor de asignar repartidor
                $('.btn-delivery').click(function(){
                    $('#modal_delivery input[name="id"]').val($(this).data('id'));
                });

                // enviar formulario de busqueda
                $('#form-search').on('submit', function(e){
                    e.preventDefault();
                    let value = (escape($('#search_value').val())!='') ? escape($('#search_value').val()) : 'all';
                    window.location = '{{url("admin/productos/buscar")}}/'+value;
                });
            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

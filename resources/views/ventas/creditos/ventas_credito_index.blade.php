@extends('voyager::master')
@section('page_title', 'Cuentas por cobrar')

@if(auth()->user()->hasPermission('browse_ventascredito'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-dollar"></i>Cuentas por cobrar
        </h1>
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
                                                <input type="text" id="search_value" class="form-control" name="s" value="{{$value}}" placeholder="Nombre del cliente">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" style="margin-top:0px;padding:8px" type="submit">
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
                                                <th>Cliente</th>
                                                <th>Monto entregado</th>
                                                <th>Deuda</th>
                                                <th>Fecha de registro</th>
                                                <th class="actions text-right">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($registros as $item)
                                                <tr>
                                                    <td>{{$item->razon_social}}</td>
                                                    <td>{{$item->monto_recibido}}</td>
                                                    <td>{{$item->importe - $item->monto_recibido}} Bs.</td>
                                                    <td>{{date('d-m-Y', strtotime($item->created_at))}} <br> <small>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</small> </td>
                                                    <td class="no-sort no-click text-right" id="bread-actions">
                                                        <button data-toggle="modal" data-target="#modal_detalle" onclick="ver_detalle({{$item->id}})" title="Detalle de compra" class="btn btn-sm btn-warning">
                                                            <i class="voyager-list"></i> <span class="hidden-xs hidden-sm">Detalles</span>
                                                        </button>
                                                        <button data-toggle="modal" data-target="#modal_pago" data-id="{{$item->id}}" data-deuda="{{$item->importe - $item->monto_recibido}}" title="Realizar pago" class="btn btn-sm btn-primary btn-pagar">
                                                            <i class="voyager-dollar"></i> <span class="hidden-xs hidden-sm">Pagar</span>
                                                        </button>
                                                        <button data-toggle="modal" data-target="#modal_detalle" onclick="ver_pagos({{$item->id}})" title="Historial de pagos" class="btn btn-sm btn-dark">
                                                            <i class="voyager-list"></i> <span class="hidden-xs hidden-sm">historial</span>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5"><p class="text-center"><br>No hay registros para mostrar.</p></td>
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

        <div class="modal modal-primary fade" tabindex="-1" id="modal_detalle" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal pago --}}
        <form action="{{route('ventas_credito_store')}}" method="POST">
            <div class="modal modal-primary fade" tabindex="-1" id="modal_pago" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-dollar"></i> Agregar pago
                            </h4>
                        </div>

                        <div class="modal-body">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="">
                            <div class="form-group">
                                <label for="">Caja</label>
                                <select name="caja_id" class="form-control" id="select-caja_id" required>
                                    @foreach ($cajas as $item)
                                        <option value="{{$item->id}}">{{$item->sucursal}} - {{$item->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Monto</label>
                                <input type="number" min="1" step="1" name="monto" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="">Observaciones</label>
                                <textarea name="observacion" id="" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary pull-right delete-confirm"value="pagar">
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
                $('.btn-pagar').click(function(){
                    $('#modal_pago input[name="id"]').val($(this).data('id'));
                    $('#modal_pago input[name="monto"]').val($(this).data('deuda'));
                    $('#modal_pago input[name="monto"]').prop('max', $(this).data('deuda'));
                    setTimeout(()=>$('#select-caja_id').select2(), 500);
                });

                // enviar formulario de busqueda
                $('#form-search').on('submit', function(e){
                    e.preventDefault();
                    let value = (escape($('#search_value').val())!='') ? escape($('#search_value').val()) : 'all';
                    window.location = '{{url("admin/ventas/credito/buscar")}}/'+value;
                });
            });

            // Ver detalle de la venta
            function ver_detalle(id){
                $('#modal_detalle .modal-title').html('<i class="voyager-list"></i> Detalles de la venta');
                $('#modal_detalle .modal-body').html('<br><h4 class="text-center">Cargando...</h4>');
                $.get('{{url("admin/ventas/detalles")}}/'+id, function(data){
                    $('#modal_detalle .modal-body').html(data);
                });
            }

            // Ver historial de pagos
            function ver_pagos(id){
                $('#modal_detalle .modal-title').html('<i class="voyager-dollar"></i> Historial de pagos');
                $('#modal_detalle .modal-body').html('<br><h4 class="text-center">Cargando...</h4>');
                $.get('{{url("admin/ventas/credito/detalles")}}/'+id, function(data){
                    $('#modal_detalle .modal-body').html(data);
                });
            }
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

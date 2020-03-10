@extends('voyager::master')
@section('page_title', 'Delivery')

@if(auth()->user()->hasPermission('browse_repartidordelivery'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-harddrive"></i> Pedidos asignados
        </h1>
    @stop
    @section('content')
        <div class="">
            <div class="">
                @include('voyager::alerts')
                <div class="row">
                    <div class="">
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
                                                <th>Cliente</th>
                                                {{-- <th>Monto</th> --}}
                                                <th>Fecha de pedido</th>
                                                <th>Estado</th>
                                                {{-- <th class="actions text-right">Acciones</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody id="pedidosList">
                                            @forelse ($registros as $item)
                                                <tr onclick="verDetalle('{{$item->id}}')" class="tr-registro" title="Ver detalles">
                                                    <td>{{$item->razon_social}}</td>
                                                    {{-- <td>{{$item->importe_base}}</td> --}}
                                                    <td>{{date('d-m-Y', strtotime($item->created_at))}} <br> <small>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</small> </td>
                                                    <td>
                                                        @switch($item->estado)
                                                            @case(1) <label class="label label-dark">Enviado</label> @break
                                                            @case(2) <label class="label label-primary">Entregado</label> @break
                                                            @default
                                                        @endswitch
                                                    </td>
                                                    {{-- <td class="no-sort no-click text-right" id="bread-actions">
                                                        <a href="{{route('delivery_view', ['id' => $item->id])}}" title="Ver" class="btn btn-sm btn-warning view">
                                                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                                                        </a>
                                                    </td> --}}
                                                </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7"><p class="text-center"><br>No hay registros para mostrar.</p></td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {{-- <div class="col-md-12">
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
                                </div> --}}
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
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @stop
    @section('css')
        <style>
            .tr-registro{
                cursor: pointer;
            }
        </style>
    @stop
    @section('javascript')
        <script>
            // Pedir autorización para mostrar notificaciones
            Notification.requestPermission();
            
            $(document).ready(function() {

                // set valor de delete
                $('.btn-delete').click(function(){
                    $('#modal_delete input[name="id"]').val($(this).data('id'));
                });

                // enviar formulario de busqueda
                $('#form-search').on('submit', function(e){
                    e.preventDefault();
                    let value = (escape($('#search_value').val())!='') ? escape($('#search_value').val()) : 'all';
                    window.location = '{{url("admin/repartidor/delivery/buscar")}}/'+value;
                });
            });

            function verDetalle(id){
                window.location = "{{url('admin/repartidor/delivery/view/')}}/"+id;
            }
        </script>

        {{-- Laravel Echo --}}
        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            
            Echo.channel('deliveryChannel{{ Auth::user()->id }}')
            .listen('pedidoAsignado', (e) => {
                if(Notification.permission==='granted'){
                    let notificacion = new Notification('Nuevo pedido!',{
                        body: 'Se le asignó un nuevo pedido.',
                        icon: '{{ url("img/assets/info.png") }}'
                    });
                }
                newPedido(e.pedido);
            });

            function newPedido(pedido){
                var n_pedidos = $('.table').find('.tr-registro').length;
                let nuevo_pedido = `<tr onclick="verDetalle(${pedido.id})" class="tr-registro" title="Ver detalles">
                                        <td>${pedido.razon_social}</td>
                                        <td>${pedido.created_at} <br> <small>hace unos segundos</small> </td>
                                        <td>
                                            ${pedido.estado == 1 ? '<label class="label label-dark">Enviado</label>' : '<label class="label label-primary">Entregado</label>'}
                                        </td>
                                    </tr>`;
                n_pedidos > 0 ? $('#pedidosList').append(nuevo_pedido) : $('#pedidosList').html(nuevo_pedido);
            }
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

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
                                                <th>Tipo</th>
                                                <th>Fecha</th>
                                                <th>Cliente</th>
                                                <th>Total</th>
                                                <th>Estado</th>
                                                <th>Opción</th>
                                                <th class="actions text-right">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="lista-ventas">
                                            @php
                                                $cont = 0;
                                            @endphp
                                            @forelse ($registros as $item)
                                                <tr>
                                                    <td>#{{$item->id}}</td>
                                                    <td><ins class="text-{{$item->tipo_etiqueta}}" style="font-weight:bold">{{$item->tipo_nombre}}</ins></td>
                                                    <td>{{date('d-m-Y', strtotime($item->fecha))}} {{date('H:i', strtotime($item->created_at))}} <br> <small>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</small> </td>
                                                    <td>{{$item->cliente}}</td>
                                                    <td>{{$item->importe_base}}</td>
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
                                                        @if($item->estado == 'A')
                                                            <label class="label label-danger">Anulada</label>
                                                        @else
                                                            <label class="label label-{{$item->estado_etiqueta}}">{{$item->estado_nombre}}</label>
                                                            {{-- Si debe y el estado es LISTO se muestra la deuda --}}
                                                            @if($debe && $item->estado_id == 3) <label class="label label-danger" data-toggle="tooltip" data-placement="bottom" title="El cliente tiene una deuda de {{$deuda}} Bs.">Debe Bs. {{$deuda}}</label>@endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($item->estado == 'V')
                                                            @if($siguiente_estado[$cont])
                                                                <a  title="{{$siguiente_estado[$cont]->nombre}}" class="btn btn-cambiar_estado btn-delivery btn-{{$siguiente_estado[$cont]->etiqueta}}"
                                                                    @if($siguiente_estado[$cont]->id == 4)
                                                                        href="#" data-toggle="modal" data-target="#modal_delivery" data-id="{{$item->id}}"
                                                                    @else
                                                                    href="{{route('estado_update', ['id' => $item->id, 'valor' => $siguiente_estado[$cont]->id])}}"
                                                                    @endif
                                                                >
                                                                    <i class="{{$siguiente_estado[$cont]->icono}}"></i> <span class="hidden-xs hidden-sm">{{$siguiente_estado[$cont]->nombre}}</span>
                                                                </a>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td class="no-sort no-click text-right" id="bread-actions">
                                                        @if(auth()->user()->hasPermission('read_ventas'))
                                                        <a href="{{route('ventas_view', ['id' => $item->id])}}" title="Ver" class="btn btn-sm btn-warning view">
                                                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                                                        </a>

                                                            @if($item->estado == 'V')
                                                            <a title="Imprimir" data-id="{{$item->id}}" class="btn btn-sm btn-primary btn-print">
                                                                <i class="voyager-polaroid"></i> <span class="hidden-xs hidden-sm">Imprimir</span>
                                                            </a>
                                                            @endif
                                                        @endif
                                                        @if(auth()->user()->hasPermission('delete_ventas') && $item->estado == 'V')
                                                        <a href="#" title="Borrar" class="btn btn-sm btn-danger btn-delete" data-id="{{$item->id}}" data-importe="{{$item->importe_base}}" data-caja_id="{{$item->caja_id}}" data-toggle="modal" data-target="#modal_delete">
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
        <form action="{{route('venta_delete')}}" method="POST">
            <div class="modal modal-danger fade" tabindex="-1" id="modal_delete" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-trash"></i> Estás seguro que quieres anular la venta?
                            </h4>
                        </div>
                        <form action="" method="POST">
                        <div class="modal-body">
                            <p>Si anula una venta ya no podra cambiar el estado de la misma.</p>
                            <select name="tipo" style="display:none" class="form-control" id="">
                                <option value="A">Anulada</option>
                                <option value="V">Valida</option>
                                <option value="E">Extraviada</option>
                                <option value="N">No autorizada</option>
                                <option value="C">Emitida en contingencia</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="">
                            <input type="hidden" name="importe" value="">
                            <input type="hidden" name="caja_id" value="">
                            <input type="submit" class="btn btn-danger pull-right delete-confirm"value="Sí, borrar!">
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
                    </div>
                </div>
            </div>
        </form>

        {{-- Audio --}}
        <audio id="alert" src="{{url('audio/alert.mp3')}}" preload="auto"></audio>
    @stop
    @section('css')
        <style>
            .select2{
                border: 1px solid #ddd
            }
            .btn-cambiar_estado{
                padding: 3px 10px
            }
        </style>
    @stop
    @section('javascript')
        <script>
            let ultima_venta = {{$ultima_venta}};
            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
                // set valor de delete
                $('.btn-delete').click(function(){
                    $('#modal_delete input[name="id"]').val($(this).data('id'));
                    $('#modal_delete input[name="importe"]').val($(this).data('importe'));
                    $('#modal_delete input[name="caja_id"]').val($(this).data('caja_id'));
                });

                // Set valor de asignar repartidor
                $('.btn-delivery').click(function(){
                    $('#modal_delivery input[name="id"]').val($(this).data('id'));
                });

                // enviar formulario de busqueda
                $('#form-search').on('submit', function(e){
                    e.preventDefault();
                    let value = (escape($('#search_value').val())!='') ? escape($('#search_value').val()) : 'all';
                    window.location = '{{url("admin/ventas/buscar")}}/'+value;
                });

                // Reimprimir factura/recibo
                $('.btn-print').click(function(){
                    let id = $(this).data('id');
                    @if($tamanio=='rollo')
                        $.get("{{url('admin/venta/impresion/rollo')}}/"+id, function(){});
                    @else
                        window.open("{{url('admin/venta/impresion/normal')}}/"+id, "Factura", `width=700, height=400`)
                    @endif
                });

                setInterval(function(){
                    get_nuevo_pedido();
                }, 5000);

            });

            function get_nuevo_pedido(){
                $.get("{{url('admin/ventas/lista_nuevos_pedidos')}}/"+ultima_venta, function(data){
                    if(data.length>0){
                        ultima_venta = data[0].id
                        data.forEach(item => {
                            // Parametros
                            let fecha = new Date(item.fecha).toLocaleDateString();
                            let estado_etiqueta = item.estado_etiqueta;
                            let estado_nombre = item.estado_nombre;
                            let url_estado = "{{url('admin/ventas/update/estado')}}/"+item.id+"/2";
                            let url_ver = "{{url('admin/ventas/ver')}}/"+item.id;

                            $('#lista-ventas').prepend(`
                                <tr>
                                    <td>#${item.id}</td>
                                    <td><ins class="text-danger" style="font-weight:bold">Pedido</ins></td>
                                    <td>${fecha} <br> <small>Hace unos segundos</small></td>
                                    <td>${item.cliente}</td>
                                    <td>${item.importe_base}</td>
                                    <td><label class="label label-${estado_etiqueta}">${estado_nombre}</label></td></td>
                                    <td>
                                        <a title="En preparación" class="btn btn-cambiar_estado btn-info" href="${url_estado}">
                                            <i class="voyager-alarm-clock"></i> <span class="hidden-xs hidden-sm">En preparación</span>
                                        </a>
                                    </td>
                                    <td class="no-sort no-click text-right" id="bread-actions">
                                        <a href="${url_ver}" title="Ver" class="btn btn-sm btn-warning view">
                                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                                        </a>
                                    </td>
                                    <tr>
                                </tr>
                            `);
                        });
                        toastr.info('Se han realizado nuevos pedidos.', 'Información');
                        $('#alert')[0].play();
                    }
                });
            }
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

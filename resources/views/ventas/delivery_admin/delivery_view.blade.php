@extends('voyager::master')
@section('page_title', 'Viendo repartidor')

@if(auth()->user()->hasPermission('browse_administraciondelivery'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-person"></i> Pedido asignados a {{$registros[0]->nombre}}
            <a href="{{route('delivery_admin_index')}}" class="btn btn-warning btn-small">
                <i class="voyager-list"></i> <span>Volver a la lista</span>
            </a>
            @if(auth()->user()->hasPermission('delivery_close'))
            <a href="#" data-toggle="modal" data-target="#modal_close" class="btn btn-info btn-small">
                <i class="voyager-check"></i> <span>Cerrar</span>
            </a>
            @endif
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
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Ticket</th>
                                                <th>Fecha</th>
                                                <th>Cliente</th>
                                                <th>Monto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $cont = 0;
                                                $total = 0;
                                            @endphp
                                            @forelse ($registros as $item)
                                                <tr>
                                                    <td>
                                                        #{{$item->nro_venta}} 
                                                        @switch($item->estado)
                                                            @case(1) <label class="label label-dark">Pendiente</label> @break
                                                            @case(2) <label class="label label-primary">Entregado</label> @break
                                                            @default
                                                        @endswitch
                                                    </td>
                                                    <td>{{date('d-m-Y H:i', strtotime($item->created_at))}} <br> <small>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</small> </td>
                                                    <td>{{$item->razon_social}}</td>
                                                    <td>{{$item->monto}}</td>
                                                </tr>
                                                @php
                                                    $cont++;
                                                    $total += $item->monto;
                                                @endphp
                                            @empty
                                            <tr>
                                                <td colspan="7"><p class="text-center"><br>No hay registros para mostrar.</p></td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                    <div class="text-right">
                                        <h2> <small>Total: </small> {{number_format($total, 2, ',', '')}} Bs.</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- modal delete --}}
        <form action="{{ route('delivery_admin_close') }}" method="POST">
            <div class="modal modal-primary fade" tabindex="-1" id="modal_close" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-check"></i> Estás seguro que quieres cerrar todos los pedidos?
                            </h4>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label>Caja</label>
                                <select name="caja_id" class="form-control" required>
                                    <option selected disabled value="">Elige una caja</option>
                                    @foreach($cajas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }} - {{ $item->sucursal }}</option>
                                    @endforeach
                                </select>
                                <p class="text-muted">Todos los registros de venta se registrarán en la caja seleccionada.</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="submit" class="btn btn-primary pull-right delete-confirm"value="Sí, cerrar!">
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

            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif


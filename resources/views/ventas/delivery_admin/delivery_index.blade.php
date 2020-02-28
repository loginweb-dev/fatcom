@extends('voyager::master')
@section('page_title', 'Repartidores')

@if(auth()->user()->hasPermission('browse_administraciondelivery'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-truck"></i> Repartidores con pedidos pendientes
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
                                                <th>Repartidor</th>
                                                <th>Movil</th>
                                                <th>Dirección</th>
                                                <th>Pedidos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $cont = 0;
                                            @endphp
                                            @forelse ($registros as $item)
                                                <tr onclick="verDetalle('{{$item->id}}')" class="tr-registro" title="Ver detalles">
                                                    <td>{{$item->nombre}}</td>
                                                    <td>{{$item->movil}}</td>
                                                    <td>{{$item->direccion}}</td>
                                                    <td>{{$item->pedidos}}</td>
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
            $(document).ready(function() {
                
            });
            function verDetalle(id){
                window.location = "{{url('admin/administracion/delivery/detalle')}}/"+id;
            }
        </script>

        {{-- Laravel Echo --}}
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/events/events.js') }}"></script>
        <script>
            let icon = '{{ url("storage/".setting("empresa.logo")) }}';
            listenNeewPedido(icon, '{{ Auth::user()->id }}')
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif


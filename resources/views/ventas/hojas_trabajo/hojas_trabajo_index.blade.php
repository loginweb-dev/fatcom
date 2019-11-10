@extends('voyager::master')
@section('page_title', 'Hojas de trabajo')

@if(auth()->user()->hasPermission('browse_proformas'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-news"></i>Hojas de trabajo
        </h1>
        <a href="{{route('hojas_trabajos_create')}}" class="btn btn-success btn-add-new">
            <i class="voyager-plus"></i> <span>Añadir nueva</span>
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
                                                <input type="text" id="search_value" class="form-control" name="s" value="{{$value}}" placeholder="Nombre del empleado, Código de hoja de trabajo">
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
                                                <th>Código</th>
                                                <th>Empleado</th>
                                                <th>Fecha</th>
                                                <th>Estado</th>
                                                <th class="actions text-right">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($registros as $item)
                                            @php
                                                $estado = $item->estado == 1 ? 'Pendiente' : 'Cerrada';
                                                $estado_label = $item->estado == 1 ? 'success' : 'danger';
                                            @endphp
                                                <tr>
                                                    <td>{{ $item->codigo }}</td>
                                                    <td>{{ $item->nombre }}</td>
                                                    <td>{{date('d-m-Y', strtotime($item->created_at))}} <br> <small>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</small> </td>
                                                    <td><label class="label label-{{ $estado_label }}">{{ $estado }}</label></td>
                                                    <td class="no-sort no-click text-right" id="bread-actions">
                                                        @if($item->estado == 1)
                                                        <a title="Realizar venta" href="{{ route('hojas_trabajos_details', ['id' => $item->id])}}" class="btn btn-sm btn-warning">
                                                            <i class="voyager-list"></i> <span class="hidden-xs hidden-sm">Detalles</span>
                                                        </a>
                                                        @endif
                                                        <a title="Imprimir" data-id="{{$item->id}}" class="btn btn-sm btn-danger btn-print">
                                                            <i class="voyager-polaroid"></i> <span class="hidden-xs hidden-sm">Imprimir</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4"><p class="text-center"><br>No hay registros para mostrar.</p></td>
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

        </style>
    @stop
    @section('javascript')
        <script>
            $(document).ready(function() {

                // set valor de delete
                $('.btn-pagar').click(function(){
                    $('#modal_pago input[name="id"]').val($(this).data('id'));
                });

                // enviar formulario de busqueda
                $('#form-search').on('submit', function(e){
                    e.preventDefault();
                    let value = (escape($('#search_value').val())!='') ? escape($('#search_value').val()) : 'all';
                    window.location = '{{url("admin/hojastrabajo/buscar")}}/'+value;
                });
            });

            // imprimir proforma
            $('.btn-print').click(function(){
                let id = $(this).data('id');
                window.open("{{url('admin/hojastrabajo/impresion')}}/"+id, "Factura", `width=700, height=400`)
            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

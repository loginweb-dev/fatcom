@extends('voyager::master')
@section('page_title', 'Proformas y pedidos')

@if(auth()->user()->hasPermission('browse_proformas'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-certificate"></i>Proformas y pedidos
        </h1>
        <a href="{{route('proformas_create')}}" class="btn btn-success btn-add-new">
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
                                                <input type="text" id="search_value" class="form-control" name="s" value="{{$value}}" placeholder="Nombre del cliente, Código de proforma">
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
                                    <table id="dataTable" class="table table-bordered table-hover" style="margin-bottom:50px">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Cliente</th>
                                                <th>Fecha</th>
                                                <th class="actions text-right">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($registros as $item)
                                                <tr>
                                                    <td>{{$item->codigo}}</td>
                                                    <td>{{$item->razon_social}}</td>
                                                    <td>{{date('d-m-Y', strtotime($item->created_at))}} <br> <small>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</small> </td>
                                                    <td class="no-sort no-click text-right" id="bread-actions">
                                                        <a title="Realizar venta" href="{{url('admin/ventas/crear').'?proforma='.$item->id}}" class="btn btn-sm btn-success">
                                                            <i class="voyager-basket"></i> <span class="hidden-xs hidden-sm">Vender</span>
                                                        </a>
                                                        <div class="dropdown" style="display:inline">
                                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" title="Exportar"><i class="voyager-polaroid"></i> Generar
                                                            <span class="caret"></span></button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="#" title="Imprimir" data-id="{{ $item->id }}" class="btn-print" >Impresión</a></li>
                                                                <li><a href="{{ url('admin/proformas/impresion/normal/'.$item->id.'/true') }}" target="_blank">PDF</a></li>
                                                            </ul>
                                                            <a href="#" title="Anular" class="btn btn-sm btn-danger btn-delete" data-id="{{ $item->id }}"  data-toggle="modal" data-target="#modal_delete">
                                                                   <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Anular</span>
                                                            </a>
                                                        </div>
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
        {{-- modal delete --}}
        <form id="form-delete" action="{{route('proforma_delete')}}" method="POST">
            <div class="modal modal-danger fade" tabindex="-1" id="modal_delete" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-trash"></i> Estás seguro que quieres anular la proforma?
                            </h4>
                        </div>
                        <div class="modal-body">
                            <p>Si anula una proforma ya no podra cambiar el estado de la misma.</p>
                            
                        </div>
                        <div class="modal-footer">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="">
                            <input type="submit" class="btn btn-danger pull-right delete-confirm"value="Sí, anular!">
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
                });

                // enviar formulario de busqueda
                $('#form-search').on('submit', function(e){
                    e.preventDefault();
                    let value = (escape($('#search_value').val())!='') ? escape($('#search_value').val()) : 'all';
                    window.location = '{{url("admin/proformas/buscar")}}/'+value;
                });
            });

            // imprimir proforma
            $('.btn-print').click(function(e){
                e.preventDefault();
                let id = $(this).data('id');
                @if($tamanio=='rollo')
                    $.get("{{url('admin/proformas/impresion/rollo')}}/"+id, function(){});
                @else
                    window.open("{{url('admin/proformas/impresion/normal')}}/"+id, "Factura", `width=700, height=400`)
                @endif
            });

            $('.btn-delete').click(function(){
                let id = $(this).data('id');
                $('#form-delete input[name="id"]').val(id);
            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

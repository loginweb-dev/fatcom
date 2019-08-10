@extends('voyager::master')
@section('page_title', 'Registros')

@if(auth()->user()->hasPermission('browse_asientos'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-dollar"></i> Registros
        </h1>
        @if(auth()->user()->hasPermission('add_asientos'))
        <a href="{{route('asientos_create')}}" class="btn btn-success btn-add-new">
            <i class="voyager-plus"></i> <span>Añadir nuevo</span>
        </a>
        @endif
        @include('voyager::multilingual.language-selector')
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
                                                <input type="date" id="search_value" class="form-control" name="s" value="{{$value}}">
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
                                    <table id="dataTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th><a href="#"></a></th>
                                                <th><a href="#">Usuario</a></th>
                                                <th><a href="#">Tipo</a></th>
                                                <th><a href="#">Concepto</a></th>
                                                <th><a href="#">Fecha</a></th>
                                                <th><a href="#">Monto</a></th>
                                                <th class="text-right">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php setlocale(LC_ALL, 'es_ES'); @endphp
                                            @forelse($asientos as $item)
                                            <tr>
                                                <td>{{$item->id}}</td>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->tipo}}</td>
                                                <td>{{$item->concepto}}</td>
                                                <td>{{ strftime('%d-%B-%Y %H:%M', strtotime($item->fecha.' '.$item->hora)) }}<br><small>{{  \Carbon\Carbon::parse($item->fecha.' '.$item->hora)->diffForHumans() }}</small></td>
                                                <td>{{$item->monto}} Bs.</td>
                                                <td class="no-sort no-click text-right" id="bread-actions">
                                                    @if(auth()->user()->hasPermission('delete_asientos'))
                                                        @if($item->deleted_at == null)
                                                            @if($item->venta_id == null && $item->compra_id == null)
                                                            <a href="#" @if(!$item->abierta) onclick="mensaje_error()" @else data-toggle="modal" data-target="#delete_modal" data-id="{{$item->id}}" data-caja_id="{{$item->caja_id}}" data-tipo="{{$item->tipo}}" data-monto="{{$item->monto}}" @endif class="btn btn-danger btn-delete delete"><span class="voyager-trash"> Anular</span></a>
                                                            @endif
                                                        @else
                                                        <label class="label label-danger">Eliminado</label>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="8"><br><center><h5>No existen registros.</h5></center></td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                <div class="col-md-4">
                                    <p class="text-muted">Mostrando del {{$asientos->firstItem()}} al {{$asientos->lastItem()}} de {{$asientos->total()}} registros.</p>
                                </div>
                                <div class="col-md-8">
                                    <nav class="text-right">
                                        {{ $asientos->links() }}
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
        <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-trash"></i> Estás seguro que quieres anular el registo?
                            </h4>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <form action="{{route('asientos_delete')}}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="">
                                <input type="hidden" name="caja_id" value="">
                                <input type="hidden" name="monto" value="">
                                <input type="hidden" name="tipo" value="">
                                <input type="submit" class="btn btn-danger pull-right delete-confirm"value="Sí, ¡Anular!">
                            </form>
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">
                                Cancelar
                            </button>
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
                $('#search_key').select2();

                // obtenet id de anulacion
                $('.btn-delete').click(function(){
                    $('#delete_modal input[name="id"]').val($(this).data('id'));
                    $('#delete_modal input[name="caja_id"]').val($(this).data('caja_id'));
                    $('#delete_modal input[name="monto"]').val($(this).data('monto'));
                    $('#delete_modal input[name="tipo"]').val($(this).data('tipo'));
                });
            });

            // enviar formulario de busqueda
            $('#form-search').on('submit', function(e){
                e.preventDefault();
                let value = $("#search_value").val();
                if(value==''){
                    value = 'all';
                }
                window.location = `{{url('admin/asientos/buscar/${value}')}}`;
            });

            // error al eliminar un ingreso si la caja ya cerro
            function mensaje_error(){
                toastr.error('No puede anular el ingreso debido a que esta registrado a una caja que se encuentra cerrada.', 'Error');
            }
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endcan

@extends('voyager::master')
@section('page_title', 'Cajas')

@if(auth()->user()->hasPermission('browse_cajas'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-treasure"></i> Cajas
        </h1>
        @if(!$abiertas)
            @if(auth()->user()->hasPermission('add_cajas'))
            <a  href="{{route('cajas_create')}}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>Añadir nueva</span>
            </a>
            @endif
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
                                                <input type="date" id="search_value" class="form-control" name="s" value="{{$value}}">
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
                                                <th><a href="#"></a></th>
                                                <th><a href="#">Descripción</a></th>
                                                {{-- <th><a href="#">Monto inicial</a></th> --}}
                                                <th><a href="#">Ingresos</a></th>
                                                <th><a href="#">Egresos</a></th>
                                                {{-- <th><a href="#">Monto final</a></th> --}}
                                                <th><a href="#">Apertura</a></th>
                                                <th><a href="#">Cierre</a></th>
                                                {{-- <th><a href="#">Observaciones</a></th> --}}
                                                <th class="text-right">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php setlocale(LC_ALL, 'es_ES'); @endphp
                                            @forelse($cajas as $item)
                                            <tr>
                                                <td>{{$item->id}}</td>
                                                <td>{{$item->nombre}}</td>
                                                {{-- <td>{{$item->monto_inicial}} Bs.</td> --}}
                                                <td>{{$item->total_ingresos}} Bs.</td>
                                                <td>{{$item->total_egresos}} Bs.</td>
                                                {{-- <td>{{$item->monto_final}} Bs.</td> --}}
                                                <td>{{ strftime('%d-%B-%Y %H:%M', strtotime($item->fecha_apertura.' '.$item->hora_apertura)) }}<br><small>{{  \Carbon\Carbon::parse($item->fecha_apertura.' '.$item->hora_apertura)->diffForHumans() }}</small></td>
                                                @if($item->abierta == 1)
                                                <td><b>No definido</b></td>
                                                @else
                                                <td>{{ strftime('%d-%B-%Y %H:%M', strtotime($item->fecha_cierre.' '.$item->hora_cierre)) }}<br><small>{{  \Carbon\Carbon::parse($item->fecha_cierre.' '.$item->hora_cierre)->diffForHumans() }}</small></td>
                                                @endif
                                                {{-- <td>{{$item->observaciones}}</td> --}}
                                                <td class="no-sort no-click text-right" id="bread-actions">
                                                    @if($item->abierta == 1)
                                                        <span class="label label-primary">Abierta</span>
                                                    @else
                                                        <span class="label label-danger">Cerrada</span>
                                                    @endif
                                                    @if(auth()->user()->hasPermission('read_cajas'))
                                                    <a href="{{route('cajas_view', ['id' => $item->id])}}" title="Ver" class="btn btn-sm btn-warning view">
                                                        <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="12"><br><center><h5>No existen cajas registradas.</h5></center></td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                <div class="col-md-4">
                                    <p class="text-muted">Mostrando del {{$cajas->firstItem()}} al {{$cajas->lastItem()}} de {{$cajas->total()}} registros.</p>
                                </div>
                                <div class="col-md-8">
                                    <nav class="text-right">
                                        {{ $cajas->links() }}
                                    </nav>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- @include('cajas.modal_cerrar') --}}
    @stop
    @section('css')
        <style>
            .select2{
                width: 200px
            }
        </style>
    @stop
    @section('javascript')
        <script>
            $(document).ready(function() {
                $('#search_key').select2();

                // enviar formulario de busqueda
                $('#form-search').on('submit', function(e){
                    e.preventDefault();
                    let valor = $("#search_value").val();
                    if(valor==''){
                        valor = 'all';
                    }
                    window.location = `{{url('admin/cajas/buscar/${valor}')}}`;
                });

                // set valor de cerrar caja
                $('.btn-close').click(function(){
                    $('#modal_close input[name="id"]').val($(this).data('id'));
                });

            });

            // error al eliminar un ingreso si la caja ya cerro
            function mensaje_error(){
                toastr.error('No puede anular el egreso debido a que esta registrado a una caja que se encuentra cerrada.', 'Error');
            }
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endcan

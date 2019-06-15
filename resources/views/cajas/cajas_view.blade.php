@extends('voyager::master')
@section('page_title', 'Viendo Caja')

@if(auth()->user()->hasPermission('view_cajas'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-treasure"></i> Viendo Caja
        </h1>

        @if($caja->abierta == 1)
            @if(auth()->user()->hasPermission('close_cajas'))
            <button class="btn btn-danger btn-small btn-close" data-id="{{$caja->id}}" data-toggle="modal" data-target="#modal_close">
                <i class="voyager-x"></i> <span>Cerrar</span>
            </button>
            @else
            <button type="button" class="btn btn-success btn-small">Abierta</button>
            @endif
        @else
        <button type="button" class="btn btn-danger btn-small">Cerrada</button>
        @endif
        <a href="{{route('cajas_index')}}" class="btn btn-warning btn-small">
            <i class="voyager-list"></i> <span>Volver a la lista</span>
        </a>
    @stop

    @section('content')
        <div class="page-content">
            {{-- <form action="{{route('cajas_close')}}" method="post"> --}}
                <div class="page-content browse container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bordered">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Monto de apertura</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$caja->monto_inicial}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Monto de cierre</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$caja->monto_final}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="margin:0;">
                                        <div class="row">
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Monto total de ingresos</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$caja->total_egresos}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Monto total de egresos</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$caja->total_ingresos}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Observaciones</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$caja->observaciones}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bordered">
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <div class="table-responsive" style="height:300px">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Hora</th>
                                                        <th>Concepto</th>
                                                        <th>Monto</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $total_egreso = 0;
                                                        $cont = 1;
                                                    @endphp
                                                    @forelse($egresos as $item)
                                                    <tr>
                                                        <td>{{$cont}}</td>
                                                        <td>{{$item->hora}}</td>
                                                        <td>{{$item->concepto}}</td>
                                                        <td>{{$item->monto}} Bs.</td>
                                                    </tr>
                                                    @php
                                                        $total_egreso+= $item->monto;
                                                        $cont++;
                                                    @endphp
                                                    @empty
                                                    <tr>
                                                        <td colspan="4"><br><center><h5>No existen egresos registrados.</h5></center></td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-right">
                                            <h4>Total egresos: {{number_format($total_egreso, 2, ',', '')}} Bs.</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="table-responsive" style="height:300px">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Hora</th>
                                                        <th>Concepto</th>
                                                        <th>Monto</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $total_ingreso = 0;
                                                        $cont = 1;
                                                    @endphp
                                                    @forelse($ingresos as $item)
                                                    <tr>
                                                        <td>{{$cont}}</td>
                                                        <td>{{$item->hora}}</td>
                                                        <td>{{$item->concepto}}</td>
                                                        <td>{{$item->monto}} Bs.</td>
                                                    </tr>
                                                    @php
                                                        $total_ingreso+= $item->monto;
                                                        $cont++;
                                                    @endphp
                                                    @empty
                                                    <tr>
                                                        <td colspan="4"><br><center><h5>No existen ingresos registrados.</h5></center></td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-right">
                                            <h4>Total ingresos: {{number_format($total_ingreso, 2, ',', '')}} Bs.</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- </form> --}}
        </div>
        @include('cajas.modal_cerrar')
    @stop
    @section('css')
        <style>

        </style>
    @stop
    @section('javascript')
        <script>
            $(document).ready(function(){

                // set valor de cerrar caja
                $('.btn-close').click(function(){
                    $('#modal_close input[name="id"]').val($(this).data('id'));
                });
            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endcan

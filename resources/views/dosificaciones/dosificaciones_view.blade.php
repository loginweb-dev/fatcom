@extends('voyager::master')
@section('page_title', 'Viendo Dosificación')

@if(auth()->user()->hasPermission('read_dosificaciones'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-key"></i> Viendo Dosificación
        </h1>
        <a href="{{route('dosificaciones_index')}}" class="btn btn-warning btn-small">
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
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">N&deg; de autorización</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$dosificacion->nro_autorizacion}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Llave de dosificación</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$dosificacion->llave_dosificacion}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="margin:0;">
                                        <div class="row">
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">N&deg; inicial</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$dosificacion->numero_inicial}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">N&deg; actual</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$dosificacion->numero_actual}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="margin:0;">
                                        <div class="row">
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Fecha límite de emisión</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$dosificacion->fecha_limite}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Estado</h3>
                                                </div>
                                                @php
                                                    $estado = ($dosificacion->activa == 1) ? '<label class="label label-success">Activa</label>' : '<label class="label label-danger">Inactiva</label>';
                                                @endphp
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>@php echo $estado; @endphp</p>
                                                </div>
                                            </div>
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

            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endcan

@extends('voyager::master')
@section('page_title', 'Añadir Caja')

@if(auth()->user()->hasPermission('add_cajas'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-treasure"></i> Añadir Caja
        </h1>
    @stop

    @section('content')
        <div class="page-content">
            <div class="page-content browse container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('cajas_store')}}" method="post">
                            @csrf
                            <div class="panel panel-bordered">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Fecha de apertura</label>
                                                <input type="date" class="form-control" value="{{date('Y-m-d')}}" name="fecha" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Hora</label>
                                                <input type="time" class="form-control" name="hora" value="{{date('H:i')}}" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Descripción</label>
                                                <input type="text" class="form-control" name="nombre" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Monto de apertura</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="monto" value="0" required>
                                                    <span class="input-group-addon">Bs.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <button type="submit" class="btn btn-primary save">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @stop
    @section('css')
        <style>
            .btn-option{
                padding: 0px;
                text-decoration: none;
            }
        </style>
    @stop
    @section('javascript')
        <script>

        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endcan

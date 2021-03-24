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
                        <form action="{{ route('cajas_store') }}" method="post">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                            <div class="panel panel-bordered">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Sucursal</label>@if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Sucursal en la que se esta aperturando la caja. Este campo es obligatorio."></span> @endif
                                            <select name="sucursal_id" class="form-control select2" id="" required>
                                                @foreach ($sucursales as $item)
                                                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-muted">En caso de no tener ninguna sucursal en la lista es porque tienes una caja sin cerrar</span>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Fecha de apertura</label>@if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Fecha de apertura de la caja. Este campo es obligatorio."></span> @endif
                                                <input type="date" class="form-control" value="{{date('Y-m-d')}}" name="fecha" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Hora</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Hora de apertura de la caja. Este campo es obligatorio."></span> @endif
                                                <input type="time" class="form-control" name="hora" value="{{date('H:i')}}" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Descripción</label>@if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Descripción de la caja. Este campo es obligatorio."></span> @endif
                                                <input type="text" class="form-control" name="nombre" placeholder="caja 1" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Monto de apertura</label>@if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Monto de apertura de la caja, en caso de abrir la caja sin efectivo ingresar 0. Este campo es obligatorio."></span> @endif
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
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endcan

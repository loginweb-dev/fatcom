@extends('voyager::master')
@section('page_title', 'Añadir Ingreso')

@if(auth()->user()->hasPermission('add_asientos'))
    @section('page_header')
        <h1 class="page-title">
            Añadir Registro
        </h1>
    @stop

    @section('content')
        <div class="page-content">
            <div class="page-content browse container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('asientos_store')}}" method="post">
                            @csrf
                            <div class="panel panel-bordered">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Caja</label>
                                            <select name="caja_id" class="form-control select2" id="" required>
                                                @foreach ($cajas as $item)
                                                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Tipo</label>
                                                <select name="tipo" class="form-control select2" id="" required>
                                                    <option value="ingreso">Ingreso</option>
                                                    <option value="egreso">Egreso</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Monto</label>
                                                <input type="number" class="form-control" name="monto" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Fecha</label>
                                                <input type="date" class="form-control" name="fecha" value="{{date('Y-m-d')}}" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Hora</label>
                                                <input type="time" class="form-control" name="hora" value="{{date('H:i')}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Concepto</label>
                                            <textarea class="form-control" name="concepto" required rows="5"></textarea>
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

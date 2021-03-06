@extends('voyager::master')
@section('page_title', 'Editar Dosificación')

@if(auth()->user()->hasPermission('edit_dosificaciones'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-key"></i> Editar Dosificación
        </h1>
        {{-- <a href="{{route('depositos_index')}}" class="btn btn-success btn-small">
            <i class="voyager-double-left"></i> <span>Atras</span>
        </a> --}}
    @stop
    @section('content')
        <div class="page-content">
            <div class="page-content browse container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <form action="{{route('dosificaciones_update')}}" method="post">
                                <div class="panel-body strong-panel">
                                    <input type="hidden" name="id" value="{{$dosificacion->id}}">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">N&deg; de autorización</label>
                                            <input type="text" name="nro_autorizacion" value="{{$dosificacion->nro_autorizacion}}" class="form-control" placeholder="Número de autorización" required>
                                            @error('nro_autorizacion')
                                            <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Fecha límite de emisión</label>
                                            <input type="date" name="fecha_limite" value="{{$dosificacion->fecha_limite}}" class="form-control" required>
                                            @error('fecha_limite')
                                            <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="">Llave de dosificación</label>
                                            <textarea name="llave_dosificacion" class="form-control">{{ $dosificacion->llave_dosificacion }}</textarea>
                                            @error('llave_dosificacion')
                                            <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="">Numero inicial</label>
                                            <input type="number" min="1" step="0.01" readonly name="numero_inicial" value="{{ $dosificacion->numero_inicial }}" class="form-control" required>
                                            @error('numero_inicial')
                                            <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="">Estado</label><br>
                                            <input type="checkbox" id="check-activa" name="estado" data-toggle="toggle" data-on="Activa" data-off="Inactiva">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </form>
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
                if('{{$dosificacion->activa}}'=='1'){
                    $('#check-activa').bootstrapToggle('on')
                }
            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

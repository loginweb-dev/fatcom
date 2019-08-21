@extends('voyager::master')
@section('page_title', 'Editar Deposito')

@if(auth()->user()->hasPermission('edit_depositos'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-archive"></i> Editar Deposito
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
                            <form action="{{route('depositos_update')}}" method="post">
                                <input type="hidden" name="id" value="{{$registro->id}}">
                                @csrf
                                <div class="panel-body strong-panel">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group col-md-10 col-sm-8">
                                                <label for="">Nombre</label>@if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Nombre que se asigno al deposito, en caso de solo existir un deposito ingresar Deposito casa matriz. Este campo es obligatorio."></span> @endif
                                                <input type="text" name="nombre" value="{{$registro->nombre}}" class="form-control" placeholder="Nombre del almacen" required>
                                                @error('nombre')
                                                <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-2 col-sm-4">
                                                <label for="">Estado</label>@if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Estado del deposito, si se encuentra abierto se puede agregar inventario de productos al almacen. Este campo es obligatorio."></span> @endif<br>
                                                <input type="checkbox" id="check-estado_inventario" name="inventario" data-toggle="toggle" data-on="Abierto" data-off="Cerrado">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">Dirección</label>@if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Dirección del deposito. Este campo no es obligatorio."></span> @endif
                                        <textarea name="direccion"class="form-control" rows="5">{{$registro->direccion}}</textarea>
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
                $('[data-toggle="tooltip"]').tooltip();
                if('{{$registro->inventario}}'=='1'){
                    $('#check-estado_inventario').bootstrapToggle('on')
                }
            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

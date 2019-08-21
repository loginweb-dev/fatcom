@extends('voyager::master')
@section('page_title', 'Añadir Deposito')

@if(auth()->user()->hasPermission('add_depositos'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-archive"></i> Añadir Deposito
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
                            <form action="{{route('depositos_store')}}" method="post">
                                <div class="panel-body strong-panel">
                                    @csrf
                                    <div class="form-group col-md-12">
                                        <label for="">Nombre</label>@if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Nombre que se asigno al deposito, en caso de solo existir un deposito ingresar Deposito casa matriz. Este campo es obligatorio."></span> @endif
                                        <input type="text" name="nombre" class="form-control" placeholder="Nombre del almacen" required>
                                        @error('nombre')
                                        <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">Dirección</label>@if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Dirección del deposito. Este campo es obligatorio."></span> @endif
                                        <textarea name="direccion"class="form-control" rows="5"></textarea>
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
            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

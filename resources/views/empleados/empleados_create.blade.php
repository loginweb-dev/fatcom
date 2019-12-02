@extends('voyager::master')
@section('page_title', 'Añadir Empleado')

@if(auth()->user()->hasPermission('add_empleados'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-people"></i> Añadir Empleado
        </h1>
        {{-- <a href="{{route('sucursales_index')}}" class="btn btn-success btn-small">
            <i class="voyager-double-left"></i> <span>Atras</span>
        </a> --}}
    @stop

    @section('content')
        <div class="page-content">
            <div class="page-content browse container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <form action="{{route('empleados_store')}}" method="post">
                                <div class="panel-body strong-panel">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="">Nombre completo</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Nombre completo del empleado. este campo es obligatorio."></span> @endif
                                                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Nombre completo del empleado" required>
                                                    @error('nombre')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="">Movil</label> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Número de celular del empleado. este campo no es obligatorio."></span> @endif
                                                    <input type="number" name="movil" class="form-control" value="{{ old('movil') }}" placeholder="Número celular" maxlength="20" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <label for="">Dirección</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Dirección de domicilio del empleado. este campo no es obligatorio."></span> @endif
                                                    <textarea name="direccion" id="" class="form-control" maxlength="150" required>{{ old('direccion') }}</textarea>
                                                    @error('direccion')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="">Nickname</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Nombre del empleado que se visualizará cuando ingrese al sistema. este campo es obligatorio."></span> @endif
                                                    <input type="text" name="nickname" class="form-control" value="{{ old('nickname') }}" placeholder="Nick name del empleado" maxlength="20" required>
                                                    @error('nickname')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="">Rol del empleado</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Rol del acceso al sistema que tendrá el empleado. este campo es obligatorio."></span> @endif
                                                    <select name="rol_id" id="select-rol_id" class="form-control" required>
                                                        <option value="">Selecciona el rol</option>
                                                        @foreach ($roles as $item)
                                                        <option value="{{$item->id}}">{{$item->display_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="">Email</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Email del empleado que servirá para que ingrese al sistema. este campo es obligatorio."></span> @endif
                                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email" maxlength="50" required>
                                                    @error('email')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="">Password</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Contraseña del empleado que servirá para que ingrese al sistema. este campo es obligatorio."></span> @endif
                                                    <input type="password" name="password" class="form-control" placeholder="Password" maxlength="20" required>
                                                    @error('password')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
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
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
                $('#select-rol_id').select2();
            });
        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

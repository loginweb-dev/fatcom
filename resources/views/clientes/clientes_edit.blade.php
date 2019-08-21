@extends('voyager::master')
@section('page_title', 'Editar Cliente')

@if(auth()->user()->hasPermission('edit_clientes'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-people"></i> Editar Cliente
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
                            <form action="{{route('clientes_update')}}" method="post">
                                <div class="panel-body strong-panel">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$cliente->id}}">
                                    <input type="hidden" name="user_id" value="{{$user ? $user->id : ''}}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="">Nombre o razón social</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Nombre o razón social del cliente. Este campo es obligatorio."></span> @endif
                                                    <input type="text" name="razon_social" class="form-control" value="{{$cliente->razon_social}}" placeholder="Nombre o razón social del cliente" required>
                                                    @error('razon_social')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="">NIT o CI</label> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="NIT o CI del cliente. Este campo no es obligatorio."></span> @endif
                                                    <input type="text" name="nit" class="form-control" value="{{$cliente->nit}}" placeholder="NIT o CI">
                                                    @error('nit')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="">Movil</label> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Número de celular del cliente. Este campo no es obligatorio."></span> @endif
                                                    <input type="number" name="movil" class="form-control" value="{{$cliente->movil}}" placeholder="Número celular" maxlength="20">
                                                    @error('movil')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="">Ninkname</label> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Nombre corto que se mostrará cuando el usuario inicie sesión. Este campo no es obligatorio."></span> @endif
                                                    <input type="text" name="nickname" class="form-control" value="{{$user ? $user->name : ''}}" placeholder="Nombre para mostrar" maxlength="20">
                                                    @error('nickname')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="">Email</label> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Email del cliente para iniciar sesión en el sistema. Este campo solo es obligatorio si se va a crear una cuenta al cliente."></span> @endif
                                                    <input type="email" name="email" class="form-control" value="{{$user ? $user->email : ''}}" placeholder="Email" maxlength="50">
                                                    @error('email')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="">Password</label> <small>(Dejar vacío para mantener el mismo)</small> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Contraseña del cliente para iniciar sesión en el sistema, el usuario tiene la opción de cambiar su contraseña cuando desee. Este campo solo es obligatorio si se va a crear una cuenta al cliente."></span> @endif
                                                    <input type="password" name="password" class="form-control" placeholder="Password" maxlength="20">
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
            });
        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

@extends('voyager::master')
@section('page_title', 'Añadir Cliente')

@if(auth()->user()->hasPermission('add_clientes'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-people"></i> Añadir Cliente
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
                            <form action="{{route('clientes_store')}}" method="post">
                                <div class="panel-body strong-panel">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="">Nombre o razón social</label>
                                                    <input type="text" name="razon_social" class="form-control" value="{{ old('razon_social') }}" placeholder="Nombre o razón social del cliente" required>
                                                    @error('razon_social')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="">NIT o CI</label>
                                                    <input type="text" name="nit" class="form-control" value="{{ old('nit') }}" placeholder="NIT o CI" required>
                                                    @error('nit')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="">Movil</label>
                                                    <input type="number" name="movil" class="form-control" value="{{ old('movil') }}" placeholder="Número celular" maxlength="20" required>
                                                    @error('movil')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="">Ninkname</label>
                                                    <input type="text" name="nickname" class="form-control" value="{{ old('nickname') }}" placeholder="Nombre para mostrar" maxlength="20" required>
                                                    @error('nickname')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="">Email</label>
                                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email" maxlength="20" required>
                                                    @error('email')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="">Password</label>
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

            });
        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

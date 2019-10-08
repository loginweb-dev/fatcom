@extends('layouts.app')

@section('nombre_pagina')
    <title>Registrarse</title>
@endsection

@section('content')
<div class="container">

    <div class="col-md-6 offset-md-3">
        <div class="card">
            <header class="card-header">
                <a href="{{ route('login') }}" class="float-right btn btn-outline-primary mt-1">Iniciar sesión</a>
                <h4 class="card-title mt-2">Registrarse</h4>
            </header>
            <article class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-row">
                        <div class="col form-group">
                            <label>Nombre Completo</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col form-group">
                            <label>N&deg; de Celular</label>
                            <input type="text" name="celular" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">Nunca compartiremos tu correo electrónico con nadie más..</small>
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Repetir contraseña</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="option1">
                        <span class="form-check-label"> Masculino </span>
                        </label>
                        <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="option2">
                        <span class="form-check-label"> Femenino</span>
                        </label>
                    </div>
                    @php
                        $localidades = \App\Localidade::where('deleted_at', NULL)->select('*')->get();
                    @endphp
                    <div class="form-group">
                        <label>Ubicación <small>(En caso de que tu ciudad no este en la lista agregar presione el boton <b>+</b> )</small></label>
                        <select name="localidad_id" class="form-control" id="select-localidad_id" required>
                            @foreach ($localidades as $item)
                            <option value="{{$item->id}}">{{$item->departamento}} - {{$item->localidad}}</option>
                            @endforeach
                        </select>
                    </div><br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> Registrarse </button>
                    </div>
                    <small class="text-muted">Al hacer clic en el botón "Registrarse", usted confirma que acepta nuestros Términos de uso y Política de privacidad.</small>
                </form>
            </article>
            <div class="border-top card-body text-center">Tienes una cuenta? <a href="{{ route('login') }}">Iniciar sesión</a></div>
        </div>
    </div>

</div>
@endsection

@section('script')
    <script src="{{url('js/loginweb.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#select-localidad_id').select2();
        });
    </script>
@endsection
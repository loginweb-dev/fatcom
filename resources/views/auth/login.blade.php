@extends('layouts.app')

@section('nombre_pagina')
    <title>Iniciar sesión</title>
@endsection

@section('content')
<div class="container">
    <br>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="col-md-4 offset-md-4">
            <div class="card">
                <header class="card-header">
                    <a href="{{ route('register') }}" class="float-right btn btn-outline-primary">Registrarse</a>
                    <h4 class="card-title mb-4 mt-1">Iniciar sesión</h4>
                </header>
                <article class="card-body">
                    <p>
                        <a href="{{ url('login/google') }}" class="btn btn-block btn-danger btn-link-page"> <i class="fab fa-google"></i> &nbsp; Login via Google</a>
                        <a href="{{ url('login/facebook') }}" class="btn btn-block btn-facebook btn-link-page"> <i class="fab fa-facebook-f"></i> &nbsp; Login via facebook</a>
                    </p>
                    <hr>
                    <form>
                    <div class="form-group input-icon">
                        <i class="fa fa-user"></i>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group input-icon">
                        <i class="fa fa-lock"></i>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> <!-- form-group// -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block btn-link-page"> Inicicar sesión  </button>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            @if (Route::has('password.request'))
                                <a class="small" href="{{ route('password.request') }}">
                                    Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>
                    </div> <!-- .row// -->
                </article>
            </div> <!-- card.// -->
        </div>
    </form>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('.btn-link-page').click(function(){
                $(this).append(' <i class="fas fa-circle-notch fa-spin"></i>');
            });
        });
    </script>
@endsection

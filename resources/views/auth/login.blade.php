@extends('layouts.app')

@section('nombre_pagina')
    <link rel="shortcut icon" href="{{ voyager_asset('images/logo-icon.png') }}" type="image/x-icon">
    <title>Iniciar sesión</title>
@endsection

@section('content')
<div class="container">
    {{-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
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
                        <a href="{{url('login/google')}}" class="btn btn-block btn-danger btn-link-page"> <i class="fab fa-google"></i> &nbsp; Login via Google</a>
                        <a href="{{url('login/facebook')}}" class="btn btn-block btn-facebook btn-link-page"> <i class="fab fa-facebook-f"></i> &nbsp; Login via facebook</a>
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

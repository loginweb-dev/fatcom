@extends('ecommerce.restaurante_v1.layouts.master')

@section('meta-datos')
    <title>{{ setting('empresa.title') }} - Iniciar sesión</title>
@endsection

@section('navigation')
    @include('ecommerce.restaurante_v1.layouts.nav')
@endsection

@section('content')

    <!-- Main Container -->
    <div class="container" style="margin-top:100px">
        <div class="row pt-4 mb-5">
            <div class="col-lg-12">
                <!-- Section: Advertising -->
                <section>
                    <!-- Grid row -->
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            {{-- <div class="card-body">
                                <h3 class="text-center card-title">Muchas gracias por su referencia!!!</h3>
                                <p class="card-text text-center text-white">Su pedido está siendo procesado, en un momento uno de nuestros deliverys se comunicará con usted.</p>
                            </div> --}}
                            <!-- Default form login -->
                            <form class="text-center border border-light p-5" action="{{ route('login') }}" method="POST">
                                @csrf
                                <p class="h4 mb-4">Iniciar sesión</p>
                                <!-- Email -->
                                <input type="email" id="defaultLoginFormEmail" class="form-control mb-4 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="E-mail" required>
                                {{-- @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror --}}
                            
                                <!-- Password -->
                                <input type="password" id="defaultLoginFormPassword" class="form-control mb-4 @error('password') is-invalid @enderror" name="password" placeholder="Contraseña" autocomplete="current-password" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span><br><br>
                                @enderror
                                {{-- @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror --}}
                            
                                <div class="d-flex justify-content-around">
                                    <div>
                                        <!-- Remember me -->
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="defaultLoginFormRemember">
                                            <label class="custom-control-label" for="defaultLoginFormRemember">Recuerdame</label>
                                        </div>
                                    </div>
                                    <div>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}">
                                                Olvidaste tu contraseña?
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            
                                <!-- Sign in button -->
                                <button class="btn principal-color btn-block my-4" type="submit">Iniciar sesión</button>
                            
                                <!-- Register -->
                                <p>No eres usuario?
                                    <a href="{{ route('register') }}">Regístrate</a>
                                </p>
                            
                                <!-- Social login -->
                                <p>o inicia sesión desde:</p>
                                <a href="{{url('login/facebook')}}" class="btn btn-outline-primary waves-effect">
                                    <i class="fab fa-facebook-f"></i> Desde Facebook
                                </a>
                                <a href="{{url('login/google')}}" class="btn btn-outline-danger waves-effect">
                                    <i class="fab fa-google"></i> Desde google
                                </a>
                            
                                {{-- <a href="#" class="mx-2" role="button"><i class="fab fa-facebook-f fa-2x text-principal-color"></i></a>
                                <a href="#" class="mx-2" role="button"><i class="fab fa-google fa-2x text-principal-color"></i></a> --}}
                                {{-- <a href="#" class="mx-2" role="button"><i class="fab fa-twitter text-principal-color"></i></a>
                                <a href="#" class="mx-2" role="button"><i class="fab fa-linkedin-in text-principal-color"></i></a>
                                <a href="#" class="mx-2" role="button"><i class="fab fa-github text-principal-color"></i></a> --}}
                            
                            </form>
                            <!-- Default form login -->
                        </div>
                        <!-- Default form register -->
                    </div>
                </section>
                <!-- Section: Advertising -->
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('ecommerce.restaurante_v1.layouts.footer')
@endsection
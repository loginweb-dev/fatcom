@extends('ecommerce.restaurante_v1.layouts.master')

@section('meta-datos')
    <title>{{ setting('empresa.title') }} - Registrarse</title>
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
                            <form class="text-center border border-light p-5" method="POST" action="{{ route('register') }}">
                                @csrf
                                    <p class="h4 mb-4">Registarse</p>
                                
                                    <input type="text" id="defaultRegisterFormFirstName" class="form-control mb-4 @error('name') is-invalid @enderror" placeholder="Nombre" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <input type="number" id="defaultRegisterPhonePassword" class="form-control mb-4 @error('celular') is-invalid @enderror" placeholder="Número de celular" name="celular" value="{{ old('celular') }}" aria-describedby="defaultRegisterFormPhoneHelpBlock">
                                    @error('celular')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                
                                    <!-- E-mail -->
                                    <input type="email" id="defaultRegisterFormEmail" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" name="email" value="{{ old('email') }}" required autocomplete="email" aria-describedby="defaultRegisterFormEmailHelpBlock">
                                    <small id="defaultRegisterFormEmailHelpBlock" class="form-text text-muted mb-4">
                                        Nunca compartiremos tu correo electrónico con nadie.
                                    </small>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                
                                    <!-- Password -->
                                    <input type="password" id="defaultRegisterFormPassword" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña" aria-describedby="defaultRegisterFormPasswordHelpBlock" name="password" required autocomplete="new-password">
                                    <small id="defaultRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
                                        Debe tener al menos 8 caracteres.
                                    </small>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <input type="password" id="password-confirm" class="form-control @error('password') is-invalid @enderror" placeholder="Repetir contraseña" name="password_confirmation" required autocomplete="new-password">
                                
                                    <!-- Newsletter -->
                                    {{-- <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="defaultRegisterFormNewsletter">
                                        <label class="custom-control-label" for="defaultRegisterFormNewsletter">Subscribe to our newsletter</label>
                                    </div> --}}
                                
                                    <!-- Sign up button -->
                                    <button class="btn principal-color my-4 btn-block" type="submit">Registarse</button>
                                
                                    <!-- Social register -->
                                    <p>o regístrate con:</p>
                                
                                    <a href="{{url('login/facebook')}}" class="btn btn-outline-primary waves-effect">
                                        <i class="fab fa-facebook-f"></i> Desde Facebook
                                    </a>
                                    <a href="{{url('login/google')}}" class="btn btn-outline-danger waves-effect">
                                        <i class="fab fa-google"></i> Desde google
                                    </a>
                                
                                    <hr>
                                
                                    <!-- Terms of service -->
                                    <p>
                                        Al registrame acepto los terminos de licencia
                                        <a href="{{ url('policies') }}" target="_blank">términos de registro</a>
                                    </p>
                                
                                </form>
                                <!-- Default form register -->
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
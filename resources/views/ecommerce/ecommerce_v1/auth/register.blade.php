@extends('ecommerce.ecommerce_v1.layouts.master')

@section('meta-datos')
<title>Bienvenido | {{ setting('empresa.title') }}</title>
@endsection

@section('plugins')
    <!-- plugin: slickslider -->
    <link href="{{ url('ecommerce_public/templates/ecommerce_v1/plugins/slickslider/slick.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('ecommerce_public/templates/ecommerce_v1/plugins/slickslider/slick-theme.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ url('ecommerce_public/templates/ecommerce_v1/plugins/slickslider/slick.min.js') }}"></script>
    <!-- plugin: owl carousel  -->
    <link href="{{ url('ecommerce_public/templates/ecommerce_v1/plugins/owlcarousel/assets/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ url('ecommerce_public/templates/ecommerce_v1/plugins/owlcarousel/assets/owl.theme.default.css') }}" rel="stylesheet">
    <script src="{{ url('ecommerce_public/templates/ecommerce_v1/plugins/owlcarousel/owl.carousel.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            /////////////////  items slider. /plugins/slickslider/
            if ($('.slider-banner-slick').length > 0) { // check if element exists
                $('.slider-banner-slick').slick({
                      infinite: true,
                      autoplay: true,
                      slidesToShow: 1,
                      dots: false,
                      prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                         nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
                });
            } // end if
        
             /////////////////  items slider. /plugins/slickslider/
            if ($('.slider-custom-slick').length > 0) { // check if element exists
                $('.slider-custom-slick').slick({
                      infinite: true,
                      slidesToShow: 2,
                      dots: true,
                      prevArrow: $('.slick-prev-custom'),
                      nextArrow: $('.slick-next-custom')
                });
            } // end if
        
            /////////////////  items slider. /plugins/slickslider/
            if ($('.slider-items-slick').length > 0) { // check if element exists
                $('.slider-items-slick').slick({
                    infinite: true,
                    swipeToSlide: true,
                    slidesToShow: 4,
                    dots: true,
                    slidesToScroll: 2,
                    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                       nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 640,
                            settings: {
                                slidesToShow: 1
                            }
                        }
                    ]
                });
            } // end if

            /////////////////  items slider. /plugins/owlcarousel/
            if ($('.slider-banner-owl').length > 0) { // check if element exists
                $('.slider-banner-owl').owlCarousel({
                    loop:true,
                    margin:0,
                    items: 1,
                    dots: false,
                    nav:true,
                    navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
                });
            } // end if 
        
            /////////////////  items slider. /plugins/owlslider/
            if ($('.slider-items-owl').length > 0) { // check if element exists
                $('.slider-items-owl').owlCarousel({
                    loop:true,
                    margin:10,
                    nav:true,
                    navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
                    responsive:{
                        0:{
                            items:1
                        },
                        640:{
                            items:3
                        },
                        1024:{
                            items:4
                        }
                    }
                })
            } // end if
        
            /////////////////  items slider. /plugins/owlcarousel/
            if ($('.slider-custom-owl').length > 0) { // check if element exists
                var slider_custom_owl = $('.slider-custom-owl');
                slider_custom_owl.owlCarousel({
                    loop: true,
                    margin:15,
                    items: 2,
                    nav: false,
                });
        
                // for custom navigation
                $('.owl-prev-custom').click(function(){
                    slider_custom_owl.trigger('prev.owl.carousel');
                });
        
                $('.owl-next-custom').click(function(){
                   slider_custom_owl.trigger('next.owl.carousel');
                });
        
            } // end if 
        }); 
    </script>
@endsection

@section('content')
<section class="section-conten padding-y" style="min-height:84vh">

    <div class="card mx-auto" style="max-width:520px; margin-top:40px;">
        <article class="card-body">
            <header class="mb-4"><h4 class="card-title">Registrarse</h4></header>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-row">
                    <label>Nombre completo</label>
                    <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="John Doe" autofocus required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="john.doe@example.com" value="{{ old('email') }}" required autocomplete="email">
                    <small class="form-text text-muted">Nunca compartimos tu email a nadie.</small>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- <div class="form-group">
                    <label class="custom-control custom-radio custom-control-inline">
                    <input class="custom-control-input" checked="" type="radio" name="gender" value="option1">
                    <span class="custom-control-label"> Male </span>
                    </label>
                    <label class="custom-control custom-radio custom-control-inline">
                    <input class="custom-control-input" type="radio" name="gender" value="option2">
                    <span class="custom-control-label"> Female </span>
                    </label>
                </div> --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Crear contraseña</label>
                        <input class="form-control" name="password" type="password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> <!-- form-group end.// --> 
                    <div class="form-group col-md-6">
                        <label>Repetir contraseña</label>
                        <input class="form-control" name="password_confirmation" type="password">
                    </div> <!-- form-group end.// -->  
                </div>
                <div class="form-group">
                    <label>Ciudad</label>
                    <select id="inputState" class="form-control">
                        @foreach (\App\Localidade::where('deleted_at', NULL)->select('*')->get() as $item)
                        <option value="{{$item->id}}">{{$item->departamento}} - {{$item->localidad}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>N&deg; de celular</label>
                    <input type="tel" name="celular" class="form-control">
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block"> Registrarse  </button>
                </div> <!-- form-group// -->      
                <div class="form-group"> 
                    <label class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" checked="" required> <div class="custom-control-label"> Estoy de acuerdo con los <a href="#">terminos y condiciones</a>  </div> </label>
                </div> <!-- form-group end.// -->           
            </form>
        </article><!-- card-body.// -->
    </div> <!-- card .// -->
    <p class="text-center mt-4">Tienes una cuenta? <a href="">Iniciar sesión</a></p>
</section>
@endsection
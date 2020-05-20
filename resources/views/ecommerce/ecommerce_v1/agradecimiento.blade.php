@extends('ecommerce.ecommerce_v1.layouts.master')

@section('meta-datos')
<title>Gracias | {{ setting('empresa.title') }}</title>
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
<section class="section-content padding-y bg">
    <div class="container">
        <main class="col-md-12">
            <div class="card text-white bg-success col-md-6 offset-md-3">
                <div class="card-body text-center">
                    <h3 class="card-title">Muchas gracias por tu preferencia!!!</h3>
                    <p class="card-text">Tu pedido estará listo en un momento.</p>
                </div>
            </div>
            <br>
            {{-- <div class="col-md-8 offset-md-2 text-center">
                <a href="{{ route('pedidos_index', ['id'=>$venta_id]) }}" class="btn btn-primary">Ver detalles</a>
            </div> --}}
        </main>
    </div>
@endsection
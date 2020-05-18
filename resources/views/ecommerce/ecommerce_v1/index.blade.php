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

@section('banner')
    <section class="section-intro padding-y-sm">
        <div class="container">
            <aside class="col-md-12">
                <div id="carousel1_indicator" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @php
                            $active = 'active';
                        @endphp
                        @foreach (\App\Section::where('id', 1)->with(['blocks.inputs'])->first()->blocks as $item)
                        <div class="carousel-item {{ $active }}">
                            <img class="d-block w-100" src="{{ url('storage/'.$item->inputs->first()->value) }}"> 
                        </div>
                        @php
                            $active = '';
                        @endphp
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carousel1_indicator" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel1_indicator" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>	
            </aside>
        </div>
    </section>
@endsection

@section('content')
    <section class="section-content padding-y-sm">
        <div class="container">
            <article class="card card-body">
                <div class="row">
                    @foreach (\App\Section::where('id', 2)->with(['blocks.inputs'])->first()->blocks as $item)
                    <div class="col-md-4">
                        <figure class="item-feature">
                            <span class="text-primary"><i class="{{ $item->inputs[0]->value }} fa-2x"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title">{{ $item->inputs[1]->value }}</h5>
                                <p>{{ $item->inputs[2]->value }}</p>
                            </figcaption>
                        </figure>
                    </div>
                    @endforeach
                </div>
            </article>
        </div>
    </section>

    <section class="section-content">
        <div class="container">
            <header class="section-heading">
                <a href="#" class="btn btn-outline-primary float-right">Ver todos</a>
                <h3 class="section-title">Productos populares</h3>
            </header>
            <div class="slider-items-slick row" data-slick='{"slidesToShow": 4, "slidesToScroll": 1}'>
                @forelse ($populares as $item)
                    <div class="item-slide p-2">
                        <figure class="card card-product-grid mb-0">
                            <div class="img-wrap"> 
                                @if ($item->nuevo)
                                    <span class="badge badge-danger"> Nuevo </span>
                                @endif
                                <img src="{{ url('storage/'.$item->imagen) }}">
                            </div>
                            <figcaption class="info-wrap text-center">
                                <h6 class="title text-truncate"><a href="#">{{ $item->nombre }}</a></h6>
                            </figcaption>
                        </figure> 
                    </div>
                @empty
                    
                @endforelse
            </div>
        </div>
    </section>

    @if (count($mas_vendidos)>0)
        <section class="section-content" style="margin-top: 50px">
            <div class="container">
                <header class="section-heading">
                    <a href="#" class="btn btn-outline-primary float-right">Ver todos</a>
                    <h3 class="section-title">Productos más vendidos</h3>
                </header>
                <div class="slider-items-slick row" data-slick='{"slidesToShow": 4, "slidesToScroll": 1}'>
                    @forelse ($mas_vendidos as $item)
                        <div class="item-slide p-2">
                            <figure class="card card-product-grid mb-0">
                                <div class="img-wrap"> 
                                    @if ($item->nuevo)
                                        <span class="badge badge-danger"> Nuevo </span>
                                    @endif
                                    <img src="{{ url('storage/'.$item->imagen) }}">
                                </div>
                                <figcaption class="info-wrap text-center">
                                    <h6 class="title text-truncate"><a href="#">{{ $item->nombre }}</a></h6>
                                </figcaption>
                            </figure> 
                        </div>
                    @empty
                        
                    @endforelse
                </div>
            </div>
    </section>
    @endif
    

    <section class="section-name bg padding-y-sm" style="margin-top: 100px">
        <div class="container">
            <header class="section-heading">
                <h3 class="section-title">Nuestras marcas</h3>
            </header>
            <div class="slider-items-slick row padding-y-sm" data-slick='{"slidesToShow": 5, "slidesToScroll": 1}'>
                @foreach ($marcas as $item)
                    @if ($item->logo != '')
                    <div class="item-slide p-2">
                        <figure class="box item-logo">
                            <a href="#" title="{{ $item->nombre }}"><img src="{{ url('storage/'.$item->logo) }}"><br></a>
                            <figcaption class="border-top pt-2">{{ $item->productos }} Productos</figcaption>
                        </figure>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection
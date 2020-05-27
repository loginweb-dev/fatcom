{{-- @php
    use App\Http\Controllers\TemplatesController;
@endphp --}}
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
    @php
        $section = Templates::section(3);
    @endphp
    <section class="section-intro padding-y-sm" style="display: {{ $section->visible }}">
        <div class="container">
            <aside class="col-md-12">
                <div id="carousel1_indicator" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @php
                            $active = 'active';
                        @endphp
                        @foreach ($section->blocks as $item)
                        <div class="carousel-item {{ $active }}">
                            <div class="dark-mask"></div>
                            <img class="d-block w-100" src="{{ url('storage/'.$item->imagen) }}">
                            <article class="carousel-caption d-none d-md-block">
                                <h4>{{ $item->titulo }}</h4>
                                <p>{{ $item->descripcion }}</p>
                            </article>
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
    @php
        $section = Templates::section(5);
    @endphp
    <section class="section-content padding-y-sm" style="display: {{ $section->visible }}">
        <div class="container">
            <article class="card card-body">
                <div class="row">
                    @foreach ($section->blocks as $item)
                    <div class="col-md-4">
                        <figure class="item-feature">
                            <span class="text-primary"><i class="{{ $item->icono }} fa-2x"></i></span>
                            <figcaption class="pt-3">
                                <h5 class="title">{{ $item->titulo }}</h5>
                                <p>{{ $item->descripcion }}</p>
                            </figcaption>
                        </figure>
                    </div>
                    @endforeach
                </div>
            </article>
        </div>
    </section>

    @if (count($ofertas)>0)
        @php
            $section = Templates::section(6);
            $block = $section->blocks;
        @endphp
        <section class="section-content padding-y" style="background-color: {{ $section ? $section->background  : '#000' }}; display: {{ $section->visible }}">
            <div class="container">
                <header class="section-heading">
                    {{-- <a href="#" class="btn btn-outline-primary float-right">Ver todos</a> --}}
                    <h3 class="section-title" style="color: {{ $block ? $section->color  : '#fff' }}">{{ $block ? $block->titulo : 'Ofertas' }}</h3>
                </header>
                <div class="slider-items-slick row" data-slick='{"slidesToShow": 5, "slidesToScroll": 1}'>
                    @forelse ($ofertas as $item)
                    @php
                        $img = ($item->imagen!='') ? str_replace('.', '_medium.', $item->imagen) : '../img/default.png';
                    @endphp
                    <div class="item-slide p-2">
                        <a href="{{ route('detalle_producto_ecommerce', ['producto'=>$item->slug]) }}">
                            <figure class="card card-product-grid mb-0">
                                <div class="img-wrap"> 
                                    @if ($item->nuevo)
                                        <span class="badge badge-danger"> Nuevo </span>
                                    @endif
                                    <img src="{{ url('storage/'.$img) }}">
                                </div>
                                <figcaption class="info-wrap text-center">
                                    <h6 class="title text-truncate">{{ $item->nombre }}</h6>
                                </figcaption>
                            </figure>
                        </a>
                    </div>
                    @empty
                        
                    @endforelse
                </div>
            </div>
        </section>
    @endif

    @php
        $section = Templates::section(7);
        $block = $section->blocks;
    @endphp
        <section class="section-content padding-y" style="background-color: {{ $section ? $section->background  : '#000' }}; display: {{ $section->visible }}">
            <div class="container">
            <header class="section-heading">
                <a href="{{ url('filtro') }}" class="btn btn-outline-primary float-right">Ver todo</a>
                <h3 class="section-title" style="color: {{ $block ? $section->color  : '#000' }}">{{ $block ? $block->titulo : 'Productos populares' }}</h3>
            </header>
            <div class="slider-items-slick row" data-slick='{"slidesToShow": 5, "slidesToScroll": 1}'>
                @forelse ($populares as $item)
                    @php
                        $img = ($item->imagen!='') ? str_replace('.', '_medium.', $item->imagen) : '../img/default.png';
                    @endphp
                    <div class="item-slide p-2">
                        <a href="{{ route('detalle_producto_ecommerce', ['producto'=>$item->slug]) }}">
                        <figure class="card card-product-grid mb-0">
                            <div class="img-wrap"> 
                                @if ($item->nuevo)
                                    <span class="badge badge-danger"> Nuevo </span>
                                @endif
                                <img src="{{ url('storage/'.$img) }}">
                            </div>
                            <figcaption class="info-wrap text-center">
                                <h6 class="title text-truncate"><a href="#">{{ $item->nombre }}</a></h6>
                            </figcaption>
                        </figure>
                        </a>
                    </div>
                @empty
                    
                @endforelse
            </div>
        </div>
    </section>

    @php
        $section = Templates::section(8);
        $block = $section->blocks;
    @endphp
    @if ($block)
    <section class="section-content padding-y-sm" style="display: {{ $section->visible }}">
        <div class="container">
            <div class="card mb-3" style="background-color: {{ $section->background ?? '#fff' }}">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        <img src="{{ url('storage/'.$block->imagen) }}" class="card-img" alt="...">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body m-5" style="color: {{ $section->color ?? '#000' }}">
                            <h4 class="card-title">{{ $block->titulo ?? 'Titulo' }}</h4>
                            <p class="card-text">{{ $block->descripcion ?? 'Detalles' }}</p>
                            <p class="card-text"><small>{{ $block->footer ?? 'Footer' }}</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @if (count($mas_vendidos)>0)
        @php
            $section = Templates::section(9);
            $block = $section->blocks;
        @endphp
        <section class="section-content padding-y" style="background-color: {{ $section ? $section->background : '#fff' }}; display: {{ $section->visible }}">
            <div class="container">
                <header class="section-heading" style="color: {{ $section ? $section->color : '#000' }}">
                    {{-- <a href="#" class="btn btn-outline-primary float-right">Ver todos</a> --}}
                    <h3 class="section-title">{{ $block ? $block->titulo : 'Productos más vendidos' }}</h3>
                </header>
                <div class="slider-items-slick row" data-slick='{"slidesToShow": 5, "slidesToScroll": 1}'>
                    @forelse ($mas_vendidos as $item)
                    @php
                        $img = ($item->imagen!='') ? str_replace('.', '_medium.', $item->imagen) : '../img/default.png';
                    @endphp
                    <div class="item-slide p-2">
                        <a href="{{ route('detalle_producto_ecommerce', ['producto'=>$item->slug]) }}">
                            <figure class="card card-product-grid mb-0">
                                <div class="img-wrap"> 
                                    @if ($item->nuevo)
                                        <span class="badge badge-danger"> Nuevo </span>
                                    @endif
                                    <img src="{{ url('storage/'.$img) }}">
                                </div>
                                <figcaption class="info-wrap text-center">
                                    <h6 class="title text-truncate">{{ $item->nombre }}</h6>
                                </figcaption>
                            </figure>
                        </a>
                    </div>
                    @empty
                        
                    @endforelse
                </div>
            </div>
    </section>
    @endif

    <section class="section-content padding-y-lg">
        <div class="container" id="list-products"></div>
    </section>

    @php
        $section = Templates::section(11);
        $block = $section->blocks;
    @endphp
    @if ($block)
    <section class="section-content padding-y-sm">
        <div class="container">
            <div class="card mb-3" style="background-color: {{ $section->background ?? '#fff' }}; display: {{ $section->visible }}">
                <div class="row no-gutters">
                
                    <div class="col-md-7">
                        <div class="card-body m-5" style="color: {{ $section->color ?? '#000' }}">
                            <h4 class="card-title">{{ $block->titulo ?? 'Titulo' }}</h4>
                            <p class="card-text">{{ $block->descripcion ?? 'Detalles' }}</p>
                            <p class="card-text"><small>{{ $block->footer ?? 'Footer' }}</small></p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <img src="{{ url('storage/'.$block->imagen) }}" class="card-img" alt="...">
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @php
        $section = Templates::section(10);
        $block = $section->blocks;
    @endphp
    <section class="section-name bg padding-y" style="background-color: {{ $section ? $section->background : '#fff' }}; display: {{ $section->visible }}">
        <div class="container">
            <header class="section-heading" style="color: {{ $section ? $section->color : '#000' }}">
                <h3 class="section-title">{{ $block ? $block->titulo : 'Nuestras marcas' }}</h3>
            </header>
            <div class="slider-items-slick row padding-y-sm" data-slick='{"slidesToShow": 6, "slidesToScroll": 1}'>
                @foreach ($marcas as $item)
                    @if ($item->logo != '')
                    <div class="item-slide p-2">
                        <figure class="box">
                            <a href="{{ url('filtro?brand='.$item->slug) }}" title="{{ $item->nombre }}"><img src="{{ url('storage/'.$item->logo) }}"><br></a>
                            <figcaption class="border-top pt-2 text-center">{{ $item->productos }} Productos</figcaption>
                        </figure>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-name">
        <div id="map"></div></div>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
    <style>
        .dark-mask {
            content:"";
            position:absolute;
            top:0;
            bottom:0;
            left:0;
            right:0;
            background:rgba(0,0,0,0.5);
        }
        #map {
            height: 400px;
        }
    </style>
@endsection

@section('script')
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
    <script>
        list(1)
        let sucursales = @json($sucursales);
        let center = sucursales.length > 0 ? [sucursales[0].latitud, sucursales[0].longitud] : [-14.833232, -64.897004];
        var map = L.map('map').setView(center, 14);
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 20,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox.streets'
        }).addTo(map);
        sucursales.map(sucursal => {
            L.marker([sucursal.latitud, sucursal.longitud]).addTo(map).bindPopup(`<h6>${sucursal.nombre}</h6><small>${sucursal.direccion ? sucursal.direccion : ''}</small>`).openPopup();
        });
    </script>
@endsection
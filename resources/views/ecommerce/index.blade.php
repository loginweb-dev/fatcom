@extends('ecommerce.layouts.master')

@section('meta-datos')
    <title>{{setting('admin.title')}}</title>
    <meta property="og:url"           content="{{url('')}}" />
    <meta property="og:type"          content="E-Commerce" />
    <meta property="og:title"         content="{{setting('admin.title')}}" />
    <meta property="og:description"   content="{{setting('admin.description')}}" />
    <meta property="og:image"         content="{{ url('storage').'/'.str_replace('\\', '/', setting('admin.social_image')) }}" />

    <meta name="description" content="{{setting('admin.description')}}">
    <meta name="keywords" content="ecommerce, e-commerce, loginweb, ventas, internet, trinidad, beni, tecnología">

@endsection

@section('banner')
    <section class="section-intro bg-img padding-y-lg">
        <div class="row">
            <div class="col-sm-6 mx-auto">
                <article class="white text-center mb-5">
                    <h1 class="display-3">{{ setting('admin.title') }}</h1>
                    <p class="display-6">{{ setting('admin.description') }}</p>
                </article>
            </div>
        </div>
        <div style="margin-bottom:-40px;margin-right:100px" class="text-right">
            <div class="fb-like" data-href="{{ url('') }}" data-width="" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>
        </div>
    </section>
@endsection

@section('content')
    <aside class="col-lg-3 col-md-5 col-sm-12 mt-3">
        <div class="card card-filter">
            <article class="card-group-item">
                <header class="card-header">
                    <a class="" aria-expanded="true" href="#" data-toggle="collapse" data-target="#collapse22">
                        <i class="icon-action fa fa-chevron-down"></i>
                        <h6 class="title">Categoría</h6>
                    </a>
                </header>
                <div class="filter-content collapse show panel-aside" id="collapse22">
                    <div class="card-body">
                        <div id="accordion">
                            <ul class="list-unstyled list-lg">
                                <li class="list-item-title text-secondary btn-search" data-tipo="subcategoria" data-id="" style="margin-bottom:0px" aria-expanded="true">Todas</li>
                                @forelse ($categorias as $categoria)
                                    <li class="list-item-title text-secondary" style="margin-bottom:0px" id="heading{{ $categoria->id }}" data-toggle="collapse" data-target="#collapse{{ $categoria->id }}" aria-expanded="true" aria-controls="collapse{{ $categoria->id }}">
                                        {{ $categoria->nombre }}
                                    </li>
                                    <div id="collapse{{ $categoria->id }}" class="collapse sublist-body" aria-labelledby="heading{{ $categoria->id }}" data-parent="#accordion">
                                        <ul class="list-unstyled list-lg sublist">
                                            @foreach ($categoria->subcategorias as $subcategoria)
                                                <li><button class="btn btn-link btn-search" data-tipo="subcategoria" data-id="{{ $subcategoria->id }}" > <b>{{ $subcategoria->nombre }}</b> <span class="float-right badge badge-secondary round"></span></button></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </article>
            <article class="card-group-item">
                <header class="card-header">
                    <a href="#" data-toggle="collapse" data-target="#collapse44">
                        <i class="icon-action fa fa-chevron-down"></i>
                        <h6 class="title">Marcas</h6>
                    </a>
                </header>
                <div class="filter-content collapse show panel-aside" id="collapse44">
                    <div class="card-body">
                        <div class="custom-control custom-radio" style="margin:5px 0px">
                            <input type="radio" checked name="marca" id="option" class="custom-control-input btn-search" data-tipo="marca">
                            <label class="custom-control-label" for="option">Todas</label>
                        </div>
                        @forelse ($marcas as $marca)
                        <div class="custom-control custom-radio" style="margin:5px 0px">
                            <input type="radio" name="marca" id="option{{ $marca->id }}" class="custom-control-input btn-search" data-tipo="marca" data-id="{{ $marca->id }}">
                            <label class="custom-control-label" for="option{{ $marca->id }}">{{ $marca->nombre }}</label>
                            <span class="float-right badge badge-secondary round">{{ $marca->productos }}</span>
                        </div>
                        @empty

                        @endforelse
                    </div>
                </div>
            </article>
            <article class="card-group-item">
                <header class="card-header">
                    <a class="" aria-expanded="true" href="#" data-toggle="collapse" data-target="#collapse33">
                        <i class="icon-action fa fa-chevron-down"></i>
                        <h6 class="title">Rango de precios</h6>
                    </a>
                </header>
                <div class="filter-content collapse show" id="collapse33">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Min</label>
                                <input class="form-control input-price" id="input-min" placeholder="$0" type="number" min="0" step="0.01">
                            </div>
                            <div class="form-group text-right col-md-6">
                                <label>Max</label>
                                <input class="form-control input-price" id="input-max" placeholder="$1.0000" type="number" min="0" step="0.01">
                            </div>
                        </div>
                        <button id="btn-price" class="btn btn-block btn-outline-primary">Aplicar</button>
                    </div>
                </div>
            </article>
        </div>
    </aside>

    <main id="contenido" class="col-lg-9 col-md-7 col-sm-12 mt-3" style="margin-bottom:70px">
        @if(count($ofertas)>0)
            @php
                $cantidad = count($ofertas)<4 ? count($ofertas) : 4;
                $size_image = count($ofertas) >=3 ? '_small.' : '_medium.';
            @endphp
            <br>
            <h4 class="display-6">Productos en Oferta <small> <a href="{{ route('ofertas_ecommerce') }}" class="link-page">(Ver más)</a></small> </h4><br>
            <div class="owl-carousel owl-init slide-items" data-items="{{ $cantidad }}" data-margin="20" data-dots="false" data-nav="false">
                @foreach ($ofertas as $oferta)
                    @php
                        $imagen = ($oferta->imagen!='') ? str_replace('.', $size_image, $oferta->imagen) : '../img/default.png';
                    @endphp
                    <div class="item-slide link-page" style="cursor:pointer" onclick="window.location='{{route('detalle_producto_ecommerce', ['producto'=>$oferta->slug])}}'">
                        <figure class="card card-product">
                            @if(!empty($item->nuevo))
                            <span class="badge-new bg-info"> Nuevo </span>
                            @endif
                            <span class="badge-offer"><b>-{{$oferta->descuento}}@if($oferta->tipo_descuento=='porcentaje')%@else {{$oferta->moneda}}@endif</b></span>
                            <div class="card-banner card-producto" style="background: url('{{url('storage').'/'.$imagen}}') center;background-size:cover">
                                <article class="overlay bottom text-center">
                                    <h6>{{$oferta->nombre}}</h6>
                                </article>
                            </div>
                        </figure>
                    </div>
                @endforeach
            </div>
        @endif

        <hr>
        @forelse ($subcategoria_productos as $subcategoria)
            <h4 class="display-6">{{ $subcategoria['nombre'] }} <small> <a href="{{route('subcategorias_ecommerce', ['subcategoria' => $subcategoria['slug']])}}" class="link-page">(Ver más)</a></small> </h4><br>
            @php
                $cantidad = count($subcategoria['productos'])<4 ? count($subcategoria['productos']) : 4;
                $size_image = count($subcategoria['productos']) >= 3 ? '_small.' : '_medium.';
            @endphp
            <div class="owl-carousel owl-init slide-items" data-items="{{ $cantidad }}" data-margin="20" data-dots="false" data-nav="false">
                @forelse ($subcategoria['productos'] as $producto)
                    @php
                        $img = ($producto->imagen!='') ? str_replace('.', $size_image, $producto->imagen) : '../img/default.png';
                    @endphp
                    <div class="item-slide link-page" style="cursor:pointer" onclick="window.location='{{route('detalle_producto_ecommerce', ['producto'=>$producto->slug])}}'">
                        <figure class="card card-product">
                            @if(!empty($producto->nuevo))
                            <span class="badge-new bg-info"> Nuevo </span>
                            @endif
                            <div class="card-banner card-producto" style="background: url('{{url('storage').'/'.$img}}') center;background-size:cover">
                                <article class="overlay bottom text-center">
                                    <h6>{{$producto->nombre}}</h6>
                                </article>
                            </div>
                        </figure>
                    </div>
                @empty
                @endforelse
            </div>
            <hr>
        @empty
            <div class="col-md-12 text-center bg-white padding-y-lg">
                <h1 class="display-4">OOPS!</h1>
                <h2 class="display-6">No se encontraron resultados.</h2>
            </div>
        @endforelse
    </main>
@endsection

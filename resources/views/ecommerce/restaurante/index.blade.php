@extends('ecommerce.master')

@section('meta-datos')
    <title>{{setting('empresa.title')}}</title>
    <meta property="og:url"           content="{{url('')}}" />
    <meta property="og:type"          content="E-Commerce" />
    <meta property="og:title"         content="{{setting('empresa.title')}}" />
    <meta property="og:description"   content="{{setting('empresa.description')}}" />
    <meta property="og:image"         content="{{ url('storage').'/'.str_replace('\\', '/', setting('admin.social_image')) }}" />

    <meta name="description" content="{{setting('empresa.description')}}">
    <meta name="keywords" content="ecommerce, e-commerce, loginweb, ventas, internet, trinidad, beni, tecnología">

@endsection

@section('banner')
    <section class="section-intro bg-img padding-y-lg">
        <div class="row">
            <div class="col-sm-6 mx-auto">
                <article class="white text-center mb-6">
                    <h1 class="display-2">{{setting('empresa.title')}}</h1>
                    <p class="display-5">{{setting('empresa.description')}}</p>
                </article>
            </div>
        </div>
        <div style="margin-bottom:-40px;margin-right:100px" class="text-right">
            <div class="fb-like" data-href="{{url('')}}" data-width="" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>
        </div>
    </section>
@endsection

@section('content')
    <aside class="col-lg-3 col-md-5 col-sm-12">
        <div class="card card-filter">
            <article class="card-group-item">
                <header class="card-header">
                    <a class="" aria-expanded="true" href="#" data-toggle="collapse" data-target="#collapse22">
                        <i class="icon-action fa fa-chevron-down"></i>
                        <h6 class="title">Por Categoría</h6>
                    </a>
                </header>
                <div class="filter-content collapse show panel-aside" id="collapse22">
                    <div class="card-body">
                        <div id="accordion">
                            <ul class="list-unstyled list-lg">
                                @php
                                    $cont = 0;
                                @endphp
                                <li class="list-item-title text-secondary btn-search" data-tipo="subcategoria" data-id="" style="margin-bottom:0px" aria-expanded="true">Todas</li>
                                @forelse ($categorias as $item)
                                    <li class="list-item-title text-secondary" style="margin-bottom:0px" id="heading{{$item->id}}" data-toggle="collapse" data-target="#collapse{{$item->id}}" aria-expanded="true" aria-controls="collapse{{$item->id}}">
                                        {{$item->nombre}}
                                    </li>
                                    <div id="collapse{{$item->id}}" class="collapse sublist-body" aria-labelledby="heading{{$item->id}}" data-parent="#accordion">
                                        <ul class="list-unstyled list-lg sublist">
                                            @foreach ($subcategorias[$cont]['subcategoria'] as $item2)
                                            <li><a href="#" class="btn-search" data-tipo="subcategoria" data-id="{{$item2->id}}" > {{$item2->nombre}} <span class="float-right badge badge-secondary round"></span></a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @php
                                        $cont++;
                                    @endphp
                                @empty
                                @endforelse
                            </ul>
                        </div>
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
                                <input class="form-control input-price" id="input-min" placeholder="$0" type="number" min="0" step="1">
                            </div>
                            <div class="form-group text-right col-md-6">
                                <label>Max</label>
                                <input class="form-control input-price" id="input-max" placeholder="$1.0000" type="number" min="0" step="1">
                            </div>
                        </div>
                        <button id="btn-price" class="btn btn-block btn-outline-primary">Aplicar</button>
                    </div>
                </div>
            </article>
            <article class="card-group-item" style="display:none">
                <header class="card-header">
                    <a href="#" data-toggle="collapse" data-target="#collapse44">
                        <i class="icon-action fa fa-chevron-down"></i>
                        <h6 class="title">Por Marca </h6>
                    </a>
                </header>
                <div class="filter-content collapse show panel-aside" id="collapse44">
                    <div class="card-body">
                        <div class="custom-control custom-radio" style="margin:5px 0px">
                            <input type="radio" checked name="marca" id="option" class="custom-control-input btn-search" data-tipo="marca" data-id="">
                            <label class="custom-control-label" for="option">Todas</label>
                        </div>
                        @forelse ($marcas as $item)
                        <div class="custom-control custom-radio" style="margin:5px 0px">
                            <input type="radio" name="marca" id="option{{$item->id}}" class="custom-control-input btn-search" data-tipo="marca" data-id="{{$item->id}}">
                            <label class="custom-control-label" for="option{{$item->id}}">{{$item->nombre}}</label>
                            <span class="float-right badge badge-secondary round">{{$item->productos}}</span>
                        </div>
                        @empty

                        @endforelse
                    </div>
                </div>
            </article>
        </div>
    </aside>

    <main id="contenido" class="col-lg-9 col-md-7 col-sm-12" style="margin-bottom:70px">
        @if(count($ofertas)>0)
            @php
                $cantidad = count($ofertas)<4 ? count($ofertas) : 4;
                $size_image = count($ofertas)>=2 ? '_small.' : '_medium.';
            @endphp
            <br>
            <h4 class="display-6">Ofertas <small> <a href="{{ route('ofertas_ecommerce') }}" class="link-page">(Ver más)</a></small> </h4><br>
            <!-- ============== slick slide items  ============= -->
            <div class="owl-carousel owl-init slide-items" data-items="{{ $cantidad }}" data-margin="20" data-dots="false" data-nav="false">
                @php
                    $cont = 0;
                @endphp
                @foreach ($ofertas as $item)
                    @php
                        $imagen = ($item->imagen!='') ? str_replace('.', $size_image, $item->imagen) : 'productos/default.png';
                    @endphp
                    <div class="item-slide">
                        <figure class="card card-product">
                            @if(!empty($item->nuevo))
                            <span class="badge-new bg-info"> Nuevo </span>
                            @endif
                            <span class="badge-offer"><b>-{{$item->descuento}}@if($item->tipo_descuento=='porcentaje')%@else {{$item->moneda}}@endif</b></span>
                            <div class="card-banner card-producto" style="background: url('{{url('storage').'/'.$imagen}}') center;background-size:cover">
                                <article class="overlay bottom text-center">
                                    <h6 class="card-title">{{$item->nombre}}</h6>
                                    <a href="{{route('detalle_producto_ecommerce', ['producto'=>$item->slug])}}" class="btn btn-warning btn-sm link-page"> Ver detalles </a>
                                </article>
                            </div>
                        </figure>
                    </div>
                    @php
                        $cont++;
                    @endphp
                @endforeach
            </div>
        @endif

        <!-- ============== slick slide items .end // ============= -->
        <hr>
        @php
            $cont = 0;
        @endphp
        @forelse ($subcategoria_productos as $item)
            <h4 class="display-6">{{ $item->nombre }} <small> <a href="{{route('subcategorias_ecommerce', ['subcategoria'=>$item->slug])}}" class="link-page">(Ver más)</a></small> </h4><br>
            <!-- ============== slick slide items  ============= -->
            @php
                $cantidad = count($productos_categoria[$cont])<4 ? count($productos_categoria[$cont]) : 4;
            @endphp
            <div class="owl-carousel owl-init slide-items" data-items="{{ $cantidad }}" data-margin="20" data-dots="false" data-nav="false">
                @forelse ($productos_categoria[$cont] as $item2)
                    @php
                        $img = ($item2->imagen!='') ? str_replace('.', '_medium.', $item2->imagen) : 'productos/default.png';
                    @endphp
                    <div class="item-slide">
                        <figure class="card card-product">
                            @if(!empty($item2->nuevo))
                            <span class="badge-new bg-info"> Nuevo </span>
                            @endif
                            <div class="card-banner card-producto" style="background: url('{{url('storage').'/'.$img}}') center;background-size:cover">
                                <article class="overlay bottom text-center">
                                    <h6 class="card-title">{{$item2->nombre}}</h6>
                                    <a href="{{route('detalle_producto_ecommerce', ['producto'=>$item2->slug])}}" class="btn btn-warning btn-sm link-page"> Ver detalles </a>
                                </article>
                            </div>
                        </figure>
                    </div>
                @empty
                    <div class="col-md-12 text-center bg-white padding-y-lg">
                        <h1 class="display-4">OOPS!</h1>
                        <h2 class="display-6">No se encontraron resultados.</h2>
                    </div>
                @endforelse
            </div>
            @php
                $cont++;
            @endphp
            <hr>
        @empty
            <div class="col-md-12 text-center bg-white padding-y-lg">
                <h1 class="display-4">OOPS!</h1>
                <h2 class="display-6">No se encontraron resultados.</h2>
            </div>
        @endforelse
    </main>
@endsection

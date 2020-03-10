@extends('voyager::master')
@section('page_title', 'Viendo Producto')

@if(auth()->user()->hasPermission('read_productos'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-home"></i> Viendo Producto
        </h1>
        @if(auth()->user()->hasPermission('edit_productos'))
        <a href="{{route('productos_edit', ['id'=>$id])}}" class="btn btn-primary btn-small">
            <i class="voyager-edit"></i> <span>Editar</span>
        </a>
        @endif
        <a href="{{route('productos_index')}}" class="btn btn-warning btn-small">
            <i class="voyager-list"></i> <span>Volver a la lista</span>
        </a>
    @stop
    @section('content')
        <div class="page-content">
            <div class="page-content browse container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Código</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$producto->codigo}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Nombre</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$producto->nombre}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin:0;">
                                    <div class="row">
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Subcategoría</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$producto->subcategoria}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Marca</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$producto->marca}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin:0;">
                                    <div class="row">
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Estante</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$producto->estante}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Bloque</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$producto->bloque}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin:0;">
                                    <div class="row">
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Stock actual</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$producto->stock}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Stock mínimo</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$producto->stock_minimo}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin:0;">
                                    <div class="row">
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Precio(s) de venta</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                @foreach ($precios_venta as $item)
                                                    <p><b>{{number_format($item->precio, 2, ',', '.')}} {{$producto->moneda}} mínimo {{$item->cantidad_minima}}</p>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-6"  style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Precio(s) de compra</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                @forelse ($precios_compra as $item)
                                                    <p><b>{{number_format($item->monto, 2, ',', '.')}} {{$producto->moneda}} mínimo {{$item->cantidad_minima}}</p>
                                                @empty
                                                <p class="text-center">No defino</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin:0;">
                                    <div class="row">
                                        <div class="col-md-12" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Descripción</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$producto->descripcion_small}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <article class="gallery-wrap">
                                        <div class="img-big-wrap" style="text-align:center">
                                            @php
                                                $img = ($producto->imagen!='') ? str_replace('.', '_medium.', $producto->imagen) : 'productos/default.png';
                                                $img_big = ($producto->imagen!='') ? $producto->imagen : 'productos/default.png';
                                            @endphp
                                            <a id="img-slider" href="{{url('storage').'/'.$img_big}}" data-fancybox="slider1">
                                                <img id="img-medium" class="img-thumbnail img-sm" src="{{url('storage').'/'.$img}}">
                                            </a>
                                        </div>
                                        <div class="img-small-wrap">
                                            @foreach ($imagenes as $item)
                                                @php
                                                    $img = str_replace('.', '_small.', $item->imagen);
                                                    $imagen_big = $item->imagen;
                                                @endphp
                                                <div class="item-gallery"><img src="{{url('storage').'/'.$img}}" class="img-thumbnail img-sm img-gallery" data-img="{{url('storage').'/'.$imagen_big}}"></div>
                                            @endforeach
                                        </div>
                                    </article>
                                </div>
                                <div class="col-md-12">
                                    <div class="panel-heading" style="border-bottom:0;">
                                        <h3 class="panel-title">Descripción para E-Commerce</h3>
                                    </div>
                                    <hr style="margin:0;">
                                    <div class="panel-body" style="margin:30px 50px">
                                        {!! $producto->descripcion_long !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop

    @section('css')
        <link href="{{url('ecommerce_public/plugins/fancybox/fancybox.min.css')}}" type="text/css" rel="stylesheet">
        <!-- custom style -->
        <link href="{{url('ecommerce_public/css/ui.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('ecommerce_public/css/responsive.css')}}" rel="stylesheet" media="only screen and (max-width: 1200px)" />
    @stop

    @section('javascript')
        <script src="{{url('ecommerce_public/plugins/fancybox/fancybox.min.js')}}" type="text/javascript"></script>
        <script>
            $(document).ready(function(){

                // cambiar imagen de muestra
                $('.img-gallery').click(function(){
                    let img_medium = $(this).data('img').replace('_small', '_medium');
                    let img = $(this).data('img').replace('_small', '');
                    $('#img-medium').attr('src', img_medium);
                    $('#img-slider').attr('href', img);
                });
            });
        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

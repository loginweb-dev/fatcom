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
                                                    <h3 class="panel-title">Descripción</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$producto->descripcion_small}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6"  style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Precio(s) de venta</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    @foreach ($precios as $item)
                                                        <p><b>{{$item->unidad}}</b> a {{number_format($item->precio, 2, ',', '.')}} Bs.</p>
                                                    @endforeach
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
                                                    <h3 class="panel-title">Color</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$producto->color}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="margin:0;">
                                        <div class="row">
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Genero</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$producto->genero}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="margin:0px">
                                                <div class="panel-heading" style="border-bottom:0;">
                                                    <h3 class="panel-title">Uso</h3>
                                                </div>
                                                <div class="panel-body" style="padding-top:0;">
                                                    <p>{{$producto->uso}}</p>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="col-md-6">
                                    @php
                                        $img = $imagen ?  str_replace('.', '_medium.', $imagen->imagen) : 'productos/default.png';
                                    @endphp
                                    <article class="gallery-wrap">
                                            <div class="img-big-wrap">
                                                <div> <a href="{{url('storage').'/'.$img}}" data-fancybox="" data-caption="{{$producto->nombre}}"><img src="{{url('storage').'/'.$img}}" width="100%" alt=""></a></div>
                                            </div> <!-- slider-product.// -->
                                            {{-- <div class="img-small-wrap">
                                                <div class="item-gallery"> <a href="{{url('storage').'/'.$img}}"><img data-fancybox="galeria1" src="{{url('storage').'/'.$img}}"></a></div>
                                                <div class="item-gallery"> <a href="{{url('storage').'/'.$img}}"><img data-fancybox="galeria1" src="{{url('storage').'/'.$img}}"></a></div>
                                                <div class="item-gallery"> <a href="{{url('storage').'/'.$img}}"><img data-fancybox="galeria1" src="{{url('storage').'/'.$img}}"></a></div>
                                                <div class="item-gallery"> <a href="{{url('storage').'/'.$img}}"><img data-fancybox="galeria1" src="{{url('storage').'/'.$img}}"></a></div>
                                            </div> <!-- slider-nav.// --> --}}
                                    </article> <!-- gallery-wrap .end// -->
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
        <link href="{{url('landing_page/plugins/fancybox/fancybox.min.css')}}" type="text/css" rel="stylesheet">
        <!-- custom style -->
        <link href="{{url('landing_page/css/ui.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('landing_page/css/responsive.css')}}" rel="stylesheet" media="only screen and (max-width: 1200px)" />
    @stop

    @section('javascript')
        <script src="{{url('landing_page/plugins/fancybox/fancybox.min.js')}}" type="text/javascript"></script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

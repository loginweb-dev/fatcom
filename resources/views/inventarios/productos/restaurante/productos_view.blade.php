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
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Categoría</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$producto->categoria}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Subcategoría</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$producto->subcategoria}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin:0;">
                                    <div class="row">
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Nombre</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$producto->nombre}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Precio(s) de venta</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                @foreach ($precios_venta as $item)
                                                    <p><b>{{number_format($item->precio, 2, ',', '.')}} {{$producto->moneda}}</p>
                                                @endforeach
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
                                    {{-- <hr style="margin:0;"> --}}
                                    @if (count($insumos_productos)>0)
                                    <div class="row">
                                        <div class="col-md-12" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Insumos</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <div class="col-md-12" style="margin:0px;max-height:200px;overflow-y:auto">
                                                    <table class="table table-bordered table-hover" >
                                                        <thead>
                                                            <tr>
                                                                <th>N&deg;</th>
                                                                <th>Insumo</th>
                                                                <th>Cantidad</th>
                                                                <th>Unid.</th>
                                                            </tr>
                                                            <tbody>
                                                                @php
                                                                    $cont = 1;
                                                                @endphp
                                                                @foreach ($insumos_productos as $item)
                                                                <tr>
                                                                    <td>{{$cont}}</td>
                                                                    <td>{{$item->nombre}}</td>
                                                                    <td>{{$item->cantidad}}</td>
                                                                    <td>{{$item->unidad}}</td>
                                                                </tr>
                                                                @php
                                                                    $cont++;
                                                                @endphp
                                                                @endforeach
                                                            </tbody>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-5">
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
                                        <h3 class="panel-title">Descripción para delivery</h3>
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

@extends('voyager::master')
@section('page_title', 'Viendo Ofertas')

@if(auth()->user()->hasPermission('read_ofertas'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-certificate"></i> Viendo Oferta
        </h1>
        @if(auth()->user()->hasPermission('edit_ofertas'))
        <a href="{{route('ofertas_edit', ['id'=>$id])}}" class="btn btn-primary btn-small">
            <i class="voyager-edit"></i> <span>Editar</span>
        </a>
        @endif
        <a href="{{route('ofertas_index')}}" class="btn btn-warning btn-small">
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
                                                <h3 class="panel-title">Nombre</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$oferta->nombre}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Detalle</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{$oferta->descripcion}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin:0;">
                                    <div class="row">
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Inicio</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{date('d-m-Y', strtotime($oferta->inicio))}} <br> <small>{{\Carbon\Carbon::parse($oferta->inicio)->diffForHumans()}}</small></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Fin</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                @if($oferta->fin!='')
                                                <p>{{date('d-m-Y', strtotime($oferta->fin))}} <br> <small>{{\Carbon\Carbon::parse($oferta->fin)->diffForHumans()}}</small></p>
                                                @else
                                                <p>No definido</p>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin:0;"><br>
                                    <div class="col-md-12" style="max-height:210px;overflow-y:auto">
                                        <div class="table table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Producto</th>
                                                        <th>Precio actual</th>
                                                        <th>Descuento</th>
                                                        <th>Precio final</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $cont = 0;
                                                    @endphp
                                                    @foreach ($detalle as $item)
                                                        <tr>
                                                            <td>{{ $item->nombre }}</td>
                                                            <td>{{ $precios[$cont]['precio'] }} {{ $item->moneda }}</td>
                                                            <td>
                                                                {{ $item->monto }}
                                                                @if($item->tipo_descuento=='porcentaje')
                                                                    %
                                                                    @php
                                                                        $precio_final = $precios[$cont]['precio'] - ($precios[$cont]['precio']*($item->monto/100));
                                                                    @endphp
                                                                @else
                                                                    {{ $item->moneda }}
                                                                    @php
                                                                        $precio_final = $precios[$cont]['precio'] - $item->monto;
                                                                    @endphp
                                                                @endif
                                                            </td>
                                                            <td>{{ $precio_final }} {{ $item->moneda }}</td>
                                                        </tr>
                                                        @php
                                                            $cont++;
                                                        @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $img = ($oferta->imagen!='') ? $oferta->imagen : 'ofertas/default.png';
                                @endphp
                                <div class="col-md-6">
                                    <article class="gallery-wrap">
                                        <div class="img-big-wrap card-banner">
                                            <article class="overlay top text-center">
                                                <h4 class="title mb-0">Portada de la campaña</h4>
                                            </article>
                                            <a id="img-slider" href="{{url('storage').'/'.$img}}" data-fancybox="slider1">
                                                <img id="img-medium" class="img-thumbnail img-sm" src="{{url('storage').'/'.$img}}">
                                            </a>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop

    @section('css')
        <link href="{{url('ecommerce/plugins/fancybox/fancybox.min.css')}}" type="text/css" rel="stylesheet">
        <!-- custom style -->
        <link href="{{url('ecommerce/css/ui.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('ecommerce/css/responsive.css')}}" rel="stylesheet" media="only screen and (max-width: 1200px)" />
    @stop

    @section('javascript')
        <script src="{{url('ecommerce/plugins/fancybox/fancybox.min.js')}}" type="text/javascript"></script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

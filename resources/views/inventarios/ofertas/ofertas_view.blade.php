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
                                                {!! $oferta->estado=='1'?'<label class="label label-success">Activa</label>':'<label class="label label-danger">Inactiva</label>' !!}
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
                                            @switch($oferta->tipo_duracion)
                                                @case('rango')
                                                    <div class="panel-heading" style="border-bottom:0;">
                                                        <h3 class="panel-title">Inicio</h3>
                                                    </div>
                                                    <div class="panel-body" style="padding-top:0;">
                                                        <p>{{date('d-m-Y', strtotime($oferta->inicio))}} <br> <small>{{\Carbon\Carbon::parse($oferta->inicio)->diffForHumans()}}</small></p>
                                                    </div>
                                                    @break
                                                @case('semanal')
                                                    <div class="panel-heading" style="border-bottom:0;">
                                                        <h3 class="panel-title">Tipo</h3>
                                                    </div>
                                                    <div class="panel-body" style="padding-top:0;">
                                                        <p>{{ucwords($oferta->tipo_duracion)}}</p>
                                                    </div>
                                                    @break
                                                @case('mensual')
                                                    <div class="panel-heading" style="border-bottom:0;">
                                                        <h3 class="panel-title">Tipo</h3>
                                                    </div>
                                                    <div class="panel-body" style="padding-top:0;">
                                                        <p>{{ucwords($oferta->tipo_duracion)}}</p>
                                                    </div>
                                                    @break
                                                @default
                                            @endswitch
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            @switch($oferta->tipo_duracion)
                                                @case('rango')
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
                                                    @break
                                                @case('semanal')
                                                    <div class="panel-heading" style="border-bottom:0;">
                                                        <h3 class="panel-title">Concurrecia</h3>
                                                    </div>
                                                    <div class="panel-body" style="padding-top:0;">
                                                        @php
                                                            $dia = array('', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
                                                        @endphp
                                                        <p>Cada {{$dia[$oferta->dia]}}</p>
                                                    </div>
                                                    @break
                                                @case('mensual')
                                                    <div class="panel-heading" style="border-bottom:0;">
                                                        <h3 class="panel-title">Concurrecia</h3>
                                                    </div>
                                                    <div class="panel-body" style="padding-top:0;">
                                                        <p>Cada {{$oferta->dia}}</p>
                                                    </div>
                                                    @break
                                                @default
                                            @endswitch
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
                                <div class="col-md-6 text-center">
                                    <div class="card">
                                        <div class="card-body" style="padding: 0px">
                                          <h4 class="card-title">Portada de la oferta</h4>
                                        </div>
                                        <a id="img-slider" href="{{url('storage').'/'.$img}}" data-fancybox="slider1">
                                            <img src="{{ url('storage').'/'.$img }}" class="card-img-top" alt="img_portada">
                                        </a>
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
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

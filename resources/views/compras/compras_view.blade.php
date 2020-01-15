@extends('voyager::master')
@section('page_title', 'Viendo compra')

@php
    setlocale(LC_ALL, "es_ES");
@endphp

@if(auth()->user()->hasPermission('read_compras'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-basket"></i> Viendo compra #{{ str_pad($compra->id, 4, "0", STR_PAD_LEFT) }}
        </h1>
        {{-- @if(auth()->user()->hasPermission('edit_sucursales'))
        <a href="{{route('sucursales_edit', ['id'=>$id])}}" class="btn btn-primary btn-small">
            <i class="voyager-edit"></i> <span>Editar</span>
        </a>
        @endif --}}
        <a href="{{route('compras_index')}}" class="btn btn-warning btn-small">
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
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Proveedor</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{ $compra->razon_social }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">NIT o CI</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{ $compra->nit ?? 'No definido' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin:0;">
                                    {{-- Verificar si la compra se realizó con factura --}}
                                    @if($compra->tipo_compra)
                                    <div class="row">
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Nro de factura</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{ $compra->nro_factura }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Nro de DUI</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{ $compra->nro_dui }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin:0;">
                                    <div class="row">
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Nro de autorización</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{ $compra->nro_autorizacion }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Código de control</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{ $compra->codigo_control }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin:0;">
                                    <div class="row">
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Importe</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{ $compra->importe_compra }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Monto exento</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{ $compra->monto_exento }} Bs.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin:0;">
                                    <div class="row">
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Sub total</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{ $compra->sub_total }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Descuento</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{ $compra->descuento }} Bs.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="margin:0;">
                                    @endif
                                    <div class="row">
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Fecha</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <p>{{ strftime("%d de %B de %Y", strtotime($compra->fecha)) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin:0px">
                                            <div class="panel-heading" style="border-bottom:0;">
                                                <h3 class="panel-title">Importe</h3>
                                            </div>
                                            <div class="panel-body" style="padding-top:0;">
                                                <label class="label label-primary" style="font-size:15px">{{ $compra->importe_base }} Bs.</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>N&deg;</th>
                                                    <th></th>
                                                    <th>Producto</th>
                                                    <th>Precio</th>
                                                    <th>Cantidad</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $cont = 1;
                                                @endphp
                                                @foreach ($compra_detalle as $item)
                                                @php
                                                    $imagen = $item->imagen == 'productos/default.png' ? $item->imagen : str_replace('.', '_small.', $item->imagen);
                                                @endphp
                                                    <tr>
                                                        <td>{{$cont}}</td>
                                                        <td><a href="{{ url('storage').'/'.$item->imagen }}" data-fancybox="galeria1" data-caption="{{ $item->producto_id }}"><img src="{{url('storage').'/'.$imagen}}" width="50px" alt=""></a></td>
                                                        <td>{{ $item->producto_id }}</td>
                                                        <td>{{ $item->precio }}</td>
                                                        <td>{{ $item->cantidad }}</td>
                                                        <td>{{ number_format($item->precio*$item->cantidad, 2, ',', '') }}</td>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @stop

    @section('css')
        <link href="{{url('ecommerce_public/plugins/fancybox/fancybox.min.css')}}" type="text/css" rel="stylesheet">
    @stop

    @section('javascript')
        <script src="{{url('ecommerce_public/plugins/fancybox/fancybox.min.js')}}" type="text/javascript"></script>
        <script>
            $(document).ready(function(){
                
            });
        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

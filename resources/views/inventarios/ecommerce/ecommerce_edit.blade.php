@extends('voyager::master')
@section('page_title', 'Editar producto del E-Commerce')

@if(auth()->user()->hasPermission('edit_ecommerce'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-basket"></i> Editar producto
        </h1>
        {{-- <a href="{{route('sucursales_index')}}" class="btn btn-success btn-small">
            <i class="voyager-double-left"></i> <span>Atras</span>
        </a> --}}
    @stop

    @section('content')
        <div class="page-content">
            <form name="form" action="{{route('ecommerce_update')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$ecommerce->id}}">
                <input type="hidden" name="producto_id" value="{{$ecommerce->producto_id}}">
                <div class="page-content browse container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bordered">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="">Producto</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Producto que se agregará al E-Commerce. Este campo es obligatorio."></span> @endif
                                            <h4>{{$ecommerce->nombre}}</h4>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <input type="text" id="input-tags" data-role="tagsinput" class="form-control" name="tags" value="{{$ecommerce->tags}}" placeholder="Etiquetas">
                                                <span class="input-group-addon" style="margin-top:0px;padding:7px">
                                                    @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="left" title="Palabras claves que asociarán el producto con otros para hacer recomendaciones a la hora de buscar en el E-Commerce. Este campo no es obligatorio."></span> @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h4>Costos de envío @if(setting('admin.tips')) <span style="font-size:15px" class="voyager-question text-default" data-toggle="tooltip" data-placement="right" title="Costos de envío del producto a las diferentes localidades, si el producto no se envía a esa localidad dejar el campo vacío y si el envío es gratis ingresar 0. Este campo no es obligatorio."></span> @endif</h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Departamento</th>
                                                            <th>Localidad</th>
                                                            <th style="width:200px">Precio</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($localidades as $item)

                                                        @php
                                                            $costo = '';
                                                            foreach ($envios as $envio) {
                                                                if($envio->localidad_id == $item->id){
                                                                    $costo = $envio->precio;
                                                                }
                                                            }
                                                        @endphp

                                                        <tr>
                                                            <td>
                                                                {{$item->departamento}}
                                                                <input type="hidden" name="localidad_id[]" value="{{$item->id}}" class="form-control">
                                                            </td>
                                                            <td>{{$item->localidad}}</td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="number" name="precio[]" value="{{$costo}}" class="form-control">
                                                                    <span class="input-group-addon" style="margin-top:0px;padding:7px">Bs.</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <button type="button" id="btn-submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @include('partials.modal_load')
    @stop

    @section('css')
        <link rel="stylesheet" href="{{url('js/input-multiple/bootstrap-tagsinput.css')}}">
        <link rel="stylesheet" href="{{url('js/input-multiple/app.css')}}">
        <style>
            .popover{
                width: 300px;
            }
        </style>
    @stop

    @section('javascript')
        <script src="{{url('js/input-multiple/bootstrap-tagsinput.js')}}"></script>
        <script src="{{url('js/input-multiple/app.js')}}"></script>
        <script src="{{url('js/loginweb.js')}}"></script>
        <script>
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover({ html : true });
                $('[data-toggle="tooltip"]').tooltip();
                $('#input-tags').tagsinput({});

                $('#btn-submit').click(function(){
                    document.form.submit();
                });
            });
        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

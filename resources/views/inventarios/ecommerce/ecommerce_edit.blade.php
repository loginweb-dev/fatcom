@extends('voyager::master')
@section('page_title', 'Editar producto de E-Commerce')

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
                <div class="page-content browse container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bordered">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Producto</label> @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="right" title="Producto que se agregará al E-Commerce. Este campo es obligatorio."></span> @endif
                                            <input type="text" class="form-control" disabled value="{{$ecommerce->nombre}}">
                                            <input type="hidden" name="id" value="{{$ecommerce->id}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Mostrar escasez</label> @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="bottom" title="Cuando el stock del producto sea menor o igual al número ingresado en este campo, se mostrará un mensaje en el E-Commerce haciendo notar que hay pocas unidades del producto. Este campo no es obligatorio."></span> @endif
                                            <input type="number" min="0" step="1" class="form-control" id="input-escasez" name="escasez" value="{{$ecommerce->escasez}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Costo envío</label> @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="bottom" title="Costo de envío del producto en caso de que la compra sea en la ciudad actual. Este campo no es obligatorio."></span> @endif
                                            <input type="number" min="0" step="0.1" class="form-control" id="input-envio" name="envio" value="{{$ecommerce->precio_envio}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Costo envío rápido</label> @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="bottom" title="Costo de envío rápido del producto en caso de que la compra sea en la ciudad actual. Este campo no es obligatorio."></span> @endif
                                            <input type="number" min="0" step="0.1" class="form-control" id="input-envio_rapido" name="envio_rapido" value="{{$ecommerce->precio_envio_rapido}}">
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <input type="text" id="input-tags" data-role="tagsinput" class="form-control" name="tags" value="{{$ecommerce->tags}}" placeholder="Etiquetas">
                                                <span class="input-group-addon">
                                                        @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="left" title="Palabras claves que asociarán el producto con otros para hacer recomendaciones a la hora de buscar en el E-Commerce. Este campo no es obligatorio."></span> @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
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
        <link rel="stylesheet" href="{{url('input-multiple/bootstrap-tagsinput.css')}}">
        <link rel="stylesheet" href="{{url('input-multiple/app.css')}}">
        <style>
            .popover{
                width: 300px;
            }
        </style>
    @stop

    @section('javascript')
        <script src="{{url('image-preview/image-preview.js')}}"></script>
        <script src="{{url('input-multiple/bootstrap-tagsinput.js')}}"></script>
        <script src="{{url('input-multiple/app.js')}}"></script>
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

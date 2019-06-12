@extends('voyager::master')
@section('page_title', 'Editar Producto')

@if(auth()->user()->hasPermission('edit_productos'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-harddrive"></i> editar producto
        </h1>
        {{-- <a href="{{route('sucursales_index')}}" class="btn btn-success btn-small">
            <i class="voyager-double-left"></i> <span>Atras</span>
        </a> --}}
    @stop

    @section('content')
        <div class="page-content">
            <form id="form" action="{{route('productos_update')}}" method="post" enctype="multipart/form-data">
                <div class="page-content browse container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bordered">
                                <input type="hidden" name="moneda_id" value="1">
                                <input type="hidden" name="id" value="{{$producto->id}}">
                                <input type="hidden" name="producto_unidad_id" value="{{$precio->id}}">
                                @csrf
                                <div class="panel-body strong-panel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="">Nombre</label>
                                                    <input type="text" name="nombre" value="{{$producto->nombre}}" class="form-control" placeholder="Nombre del producto" required>
                                                    @error('nombre')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Precio de venta</label>
                                                    <input type="number" min="1" step="0.1" name="precio_venta" value="{{$precio->precio}}" class="form-control" placeholder="Precio de venta" required>
                                                    @error('precio_venta')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">precio mínimo</label> <label class="text-primary" @if(setting('admin.tips')) data-toggle="tooltip" data-placement="top" title="Este campo no necesita ser llenado" @endif>(Opcional)</label>
                                                    <input type="number" min="0" step="0.1" name="precio_minimo" value="{{$precio->precio_minimo}}" class="form-control" placeholder="Precio mínimo de venta">
                                                    @error('precio_minimo')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Descripción</label>
                                                    <textarea name="descripcion_small" class="form-control" id="" rows="10" placeholder="Descripción corta del producto" required>{{$producto->descripcion_small}}</textarea>
                                                    @error('descripcion_small')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                @php
                                                    $img = $imagen ?  str_replace('.', '_small.', $imagen->imagen) : 'productos/default.png';
                                                @endphp
                                                <div class="col-md-6">
                                                    <label for="">Imagen</label>  <label class="text-primary" @if(setting('admin.tips')) data-toggle="tooltip" data-placement="top" title="Este campo no necesita ser llenado" @endif>(Opcional)</label>
                                                    <div class="content_uploader" style="height: 220px;">
                                                        <div class="box" style="background-image:url('{{url('storage').'/'.$img}}')">
                                                            <input class="filefield" style="display:none" accept="image/*" type="file" name="imagen">
                                                            <p class="select_bottom">Seleccionar imagen</p>
                                                            <div class="spinner"></div>
                                                            <div class="overlay_uploader"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Sub categoría</label>
                                                    <div id="div-select_subcategorias">
                                                        <select name="subcategoria_id" id="select-subcategoria_id" class="form-control" required>
                                                            @foreach($subcategorias as $item)
                                                            <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Marca</label>
                                                    <select name="marca_id" id="select-marca_id" class="form-control" required>
                                                        @foreach($marcas as $item)
                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Talla</label>
                                                    <select name="talla_id" id="select-talla_id" class="form-control" required>
                                                        @foreach($tallas as $item)
                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Color</label>
                                                    <select name="color_id" id="select-color_id" class="form-control" required>
                                                        @foreach($colores as $item)
                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Unidad</label>
                                                    <select name="unidad_id" id="select-unidad_id" class="form-control" required>
                                                        @foreach($unidades as $item)
                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Uso</label>
                                                    <select name="uso_id" id="select-uso_id" class="form-control" required>
                                                        @foreach($usos as $item)
                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Genero</label>
                                                    <select name="genero_id" id="select-genero_id" class="form-control" required>
                                                        @foreach($generos as $item)
                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Stok mínimo</label> <label class="text-primary" @if(setting('admin.tips')) data-toggle="tooltip" data-placement="top" title="Este campo no necesita ser llenado" @endif>(Opcional)</label>
                                                    <input type="number" min="0" step="1" name="stock_minimo" value="{{$producto->stock_minimo}}" class="form-control" placeholder="Cantidad mínima en stock">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">N&deg; de estante</label>  <label class="text-primary" @if(setting('admin.tips')) data-toggle="tooltip" data-placement="top" title="Este campo no necesita ser llenado" @endif>(Opcional)</label>
                                                    <input type="text" name="estante" class="form-control" value="{{$producto->estante}}" data-toggle="popover" data-trigger="focus" data-html="true" title="Información" data-placement="top" data-content="Estante en el que se encuentra el producto.">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">N&deg; de bloque</label> <label class="text-primary" @if(setting('admin.tips')) data-toggle="tooltip" data-placement="top" title="Este campo no necesita ser llenado" @endif>(Opcional)</label>
                                                    <input type="text" name="bloque" class="form-control" value="{{$producto->bloque}}" data-toggle="popover" data-trigger="focus" data-html="true" title="Información" data-placement="top" data-content="Bloque del estante en el que se encuentra el producto.">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bordered">
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Descripción para E-Commerce <label class="text-primary" style="font-size:14px" @if(setting('admin.tips')) data-toggle="tooltip" data-placement="top" title="Este campo no necesita ser llenado" @endif>(Opcional)</label></h4>
                                    <div class="panel-actions">
                                        <a class="panel-action panel-collapsed voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                                    </div>
                                </div>
                                <div class="panel-body collapse">
                                    <div class="form-group">
                                        <textarea class="form-control richTextBox" name="descripcion_long" row="3">{{$producto->descripcion_long}}</textarea>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
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
        <link rel="stylesheet" href="{{url('image-preview/image-preview.css')}}">
        <style>

        </style>
    @stop

    @section('javascript')
    <script src="{{url('image-preview/image-preview.js')}}"></script>
    <script src="{{url('js/inicializar_select2_producto.js')}}"></script>
        <script>
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover({ html : true });
                $('[data-toggle="tooltip"]').tooltip();

                $('#select-subcategoria_id').val('{{$producto->subcategoria_id}}');
                $('#select-marca_id').val('{{$producto->marca_id}}');
                $('#select-talla_id').val('{{$producto->talla_id}}');
                $('#select-color_id').val('{{$producto->color_id}}');
                $('#select-unidad_id').val('{{$precio->unidad_id}}');
                $('#select-uso_id').val('{{$producto->uso_id}}');
                $('#select-genero_id').val('{{$producto->genero_id}}');

                $('#select-subcategoria_id').select2();
                $('#select-marca_id').select2();
                $('#select-talla_id').select2();
                $('#select-color_id').select2();
                $('#select-unidad_id').select2();
                $('#select-uso_id').select2();
                $('#select-genero_id').select2();

                // mostrar pantalla de carga al guardar un producto
                $('#form').on('submit', function(){
                    $('#modal_load').modal('show');
                });

            });
        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

@extends('voyager::master')
@section('page_title', 'Añadir Producto')

@if(auth()->user()->hasPermission('add_productos'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-harddrive"></i> Añadir producto a inventario
        </h1>
        <a href="{{route('depositos_view', ['id' => $deposito_id])}}" class="btn btn-warning btn-small">
            <i class="voyager-list"></i> <span>Volver a la lista</span>
        </a>
    @stop

    @section('content')
        <div class="page-content">
            <form id="form" action="{{route('depositos_store_producto')}}" method="post" enctype="multipart/form-data">
                <div class="page-content browse container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bordered">
                                @csrf
                                <input type="hidden" name="stock" value="0">
                                <input type="hidden" name="deposito_id" value="{{$deposito_id}}">
                                <input type="hidden" name="moneda_id" value="1">
                                <input type="hidden" name="codigo_grupo" value="{{$codigo_grupo}}">
                                <div class="panel-body strong-panel">
                                    {{-- alerta al guardar un producto --}}
                                    <div id="alerta-store" class="alert" style="display:none">
                                        <ul>
                                            <li id="mensaje-store"></li>
                                        </ul>
                                    </div>
                                    {{-- /alerta al guardar un producto --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="">Nombre</label>
                                                    <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" required>
                                                    @error('nombre')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Precio de venta</label>
                                                    <input type="number" min="1" step="0.1" name="precio_venta" class="form-control" placeholder="Precio de venta" required>
                                                    @error('precio_venta')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">precio mínimo</label> <label class="text-primary" @if(setting('admin.tips')) data-toggle="tooltip" data-placement="top" title="Este campo no necesita ser llenado" @endif>(Opcional)</label>
                                                    <input type="number" min="0" step="0.1" name="precio_minimo" class="form-control" placeholder="Precio mínimo de venta">
                                                    @error('precio_minimo')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Cantidad inicial</label>
                                                        <input type="number" min="0" step="1" name="cantidad" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Descripción</label>
                                                        <textarea name="descripcion_small" class="form-control" id="" rows="6" placeholder="Descripción corta del producto" required></textarea>
                                                        @error('descripcion_small')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Imagen</label>  <label class="text-primary" @if(setting('admin.tips')) data-toggle="tooltip" data-placement="top" title="Este campo no necesita ser llenado" @endif>(Opcional)</label>
                                                    <div class="content_uploader" style="height: 220px;">
                                                        <div class="box" style="background-image:url('{{url('storage/productos/default.png')}}')">
                                                            <input class="filefield" style="display:none" accept="image/*" type="file" name="imagen[]" multiple value="">
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
                                                    <input type="number" min="0" step="1" name="stock_minimo" class="form-control" placeholder="Cantidad mínima en stock">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">N&deg; de estante</label>  <label class="text-primary" @if(setting('admin.tips')) data-toggle="tooltip" data-placement="top" title="Este campo no necesita ser llenado" @endif>(Opcional)</label>
                                                    <input type="text" name="estante" class="form-control" @if(setting('admin.tips')) data-toggle="popover" data-trigger="focus" data-html="true" title="Información" data-placement="top" data-content="Estante en el que se encuentra el producto." @endif>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">N&deg; de bloque</label> <label class="text-primary" @if(setting('admin.tips')) data-toggle="tooltip" data-placement="top" title="Este campo no necesita ser llenado" @endif>(Opcional)</label>
                                                    <input type="text" name="bloque" class="form-control" @if(setting('admin.tips')) data-toggle="popover" data-trigger="focus" data-html="true" title="Información" data-placement="top" data-content="Bloque del estante en el que se encuentra el producto." @endif>
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
                                        <textarea class="form-control richTextBox" name="descripcion_long" row="3"></textarea>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <input type="checkbox" checked id="check-clear" name="clear">
                                    <label for="check-clear">Limpiar el formulario.</label>
                                    <br><br>
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
            .select2{
                border: 1px solid #f1f1f1;
            }
        </style>
    @stop

    @section('javascript')
        <script src="{{url('image-preview/image-preview.js')}}"></script>
        <script src="{{url('js/inicializar_select2_producto.js')}}"></script>
        <script>
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover({ html : true });
                $('[data-toggle="tooltip"]').tooltip();



                // *******************codigo adicional*******************
                $('#form').on('submit', function(e){
                    e.preventDefault();
                    $('#modal_load').modal('show');
                    $("html,body").animate({scrollTop: $('#alerta-store').offset().top}, 1000);

                    let formData = new FormData(document.getElementById("form"));
                    formData.append("dato", "valor");
                    $.ajax({
                        url: '{{route("depositos_store_producto")}}',
                        type: 'post',
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data){
                            if(data==1){
                                $('#mensaje-store').html('Producto guardado exitosamente.');
                                $('#alerta-store').css('display', 'block');
                                $('#alerta-store').addClass('alert-success');
                                setInterval(function(){
                                    $('#alerta-store').fadeOut( "slow");
                                }, 5000);
                            }else{
                                $('#mensaje-store').html('Ocurrio un error al guardar el producto');
                                $('#alerta-store').css('display', 'block');
                                $('#alerta-store').addClass('alert-danger');
                                setInterval(function(){
                                    $('#alerta-store').fadeOut( "slow");
                                }, 5000);
                            }
                            $('#modal_load').modal('hide');
                        }
                    });
                });
                // *******************/script adicional*******************
            });
        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

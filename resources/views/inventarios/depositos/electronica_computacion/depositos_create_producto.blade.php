@extends('voyager::master')
@section('page_title', 'Nuevo Producto')

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
                                {{-- datos por defecto --}}
                                <input type="hidden" name="unidad_id" value="1">
                                <input type="hidden" name="talla_id" value="1">
                                <input type="hidden" name="color_id" value="1">
                                <input type="hidden" name="genero_id" value="1">
                                <input type="hidden" name="uso_id" value="1">
                                {{-- </datos por defecto> --}}

                                <input type="hidden" name="se_almacena" value="1">
                                <input type="hidden" name="deposito_id" value="{{$deposito_id}}">
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
                                        <div class="col-md-6" style="margin-bottom:0px">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="">Nombre</label>
                                                    <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Código</label>
                                                    <input type="text" name="codigo_interno" class="form-control" placeholder="Código del producto" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Stock</label>
                                                    <input type="number" min="1" step="1" name="stock" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Precio de venta</label>
                                                    <input type="number" min="1" step="0.1" name="precio_venta" class="form-control" placeholder="Precio de venta" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">precio mínimo</label> <label class="text-primary" @if(setting('admin.tips')) data-toggle="tooltip" data-placement="top" title="Este campo no necesita ser llenado" @endif>(Opcional)</label>
                                                    <input type="number" min="0" step="0.1" name="precio_minimo" class="form-control" placeholder="Precio mínimo de venta">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Moneda</label>
                                                    <select name="moneda_id" id="select-moneda_id" class="form-control select2" required>
                                                        @foreach($monedas as $item)
                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
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
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Marca</label>
                                                    <select name="marca_id" id="select-marca_id" class="form-control" required>
                                                        @foreach($marcas as $item)
                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Modelo</label>
                                                    <input type="text" name="modelo" class="form-control" placeholder="Modelo del producto" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Garantía</label>
                                                    <input type="text" name="garantia" class="form-control" placeholder="12 meses">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Catálogo</label>
                                                    <input type="file" name="catalogo" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin-bottom:0px">
                                            <label for="">Imagen(s)</label>  <label class="text-primary" @if(setting('admin.tips')) data-toggle="tooltip" data-placement="right" title="Este campo no necesita ser llenado" @endif>(Opcional)</label>
                                            <div class="content_uploader" style="height: 500px;">
                                                <div class="box" style="background-image:url('{{url('storage/productos/default.png')}}')">
                                                    <input class="filefield" style="display:none" accept="image/*" type="file" name="imagen[]" multiple>
                                                    <p class="select_bottom">Seleccionar imagen</p>
                                                    <div class="spinner"></div>
                                                    <div class="overlay_uploader"></div>
                                                </div>
                                            </div>
                                         </div>
                                         <div class="form-group col-md-12">
                                                <label for="">Descripción</label>
                                                <textarea name="descripcion_small" class="form-control" id="" rows="3" placeholder="Descripción corta del producto" required></textarea>
                                                @error('descripcion_small')
                                                <strong class="text-danger">{{ $message }}</strong>
                                                @enderror
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

        </style>
    @stop

    @section('javascript')
        <script src="{{url('js/image-preview/image-preview.js')}}"></script>
        <script src="{{url('js/loginweb.js')}}"></script>
        <script>
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover({ html : true });
                $('[data-toggle="tooltip"]').tooltip();

                // inicializar select2
                inicializar_select2('subcategoria_id');
                inicializar_select2('marca_id');
                // =======================

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
                        success: function(response){
                            let res = JSON.parse(response);
                            if(res.success===1){
                                toastr.success('Producto guardado exitosamente.', 'Bien hecho');
                            }else{
                                toastr.error('Ocurrio un error al guardar el producto', 'Error');
                            }
                            $('#modal_load').modal('hide');
                            
                            // Si se hace check en limpiar formulario
                            if(res.reload){
                                toastr.warning('El formulario se actualizara, espere...', 'Aviso');
                                setTimeout(()=>{
                                    location.reload();
                                }, 2000);
                            }
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

@extends('voyager::master')
@section('page_title', 'Editar Producto')

@if(auth()->user()->hasPermission('edit_productos'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-harddrive"></i> editar producto
        </h1>
    @stop

    @section('content')
        <div class="page-content">
            <form id="form" action="{{route('productos_update')}}" method="post" enctype="multipart/form-data">
                <div class="page-content browse container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bordered">
                                @csrf
                                {{-- datos por defecto --}}
                                <input type="hidden" name="talla_id" value="1">
                                <input type="hidden" name="color_id" value="1">
                                <input type="hidden" name="genero_id" value="1">
                                <input type="hidden" name="uso_id" value="1">
                                <input type="hidden" name="moneda_id" value="2">
                                <input type="hidden" name="se_almacena" value="1">
                                {{-- </datos por defecto> --}}
                                <input type="hidden" name="id" value="{{$producto->id}}">
                                {{-- <input type="hidden" name="producto_unidad_id" value="{{$precio->id}}"> --}}
                                <div class="panel-body strong-panel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="">Nombre comercial</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Nombre comercial del producto. Este campo es obligatorio."></span> @endif
                                                    <input type="text" name="nombre" value="{{$producto->nombre}}" class="form-control" placeholder="Nombre del producto" required>
                                                    @error('nombre')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                    <div  style="position:absolute;right:15px;top:27px">
                                                        <input type="checkbox" id="input-nuevo" name="nuevo" data-toggle="toggle" data-on="<span class='voyager-check'></span> Nuevo" data-off="<span class='voyager-x'></span> Nuevo">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Categoría</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Categoría a la que pertenece el producto. Este campo es obligatorio."></span> @endif
                                                    <select name="categoria_id" id="select-categoria_id" class="form-control select2" required>
                                                        @foreach($categorias as $item)
                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Sub categoría</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Sub categoría del producto. las subcategorías se despliegan en base a la categoría seleccionada previamente. Este campo es obligatorio."></span> @endif
                                                    <div id="div-select_subcategorias">
                                                        <select name="subcategoria_id" id="select-subcategoria_id" class="form-control select2" required>
                                                            @foreach($subcategorias as $item)
                                                            <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="">Marca</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Marca del producto. Este campo es obligatorio."></span> @endif
                                                    <select name="marca_id" id="select-marca_id" class="form-control" required>
                                                        @foreach($marcas as $item)
                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Stock mínimo</label> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Cantidad mínima de productos en stock para mostrar notificación de escasez. Este campo no es obligatorio."></span> @endif
                                                    <input type="number" name="stock_minimo" class="form-control" value="{{$producto->stock_minimo}}" min="0" step="0.01">
                                                    @error('stock')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="">Estante</label> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Nombre o número del estante en el que se almacena el producto. Este campo no es obligatorio."></span> @endif
                                                    <input type="text" name="estante" maxlength="20" class="form-control" value="{{$producto->estante}}" placeholder="Estante A">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="">Bloque</label> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Número o letra de bloque del estante en el que se almacena el producto. Este campo no es obligatorio."></span> @endif
                                                    <input type="text" name="bloque" maxlength="20" class="form-control" value="{{$producto->bloque}}" placeholder="Bloque 1">
                                                </div>
                                            </div>
                                            {{-- <div class="row">

                                            </div> --}}
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-12" style="">
                                                <div class="row">
                                                    <div class="col-md-12" style="">
                                                        <label for="">Imagen(es)</label> @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="left" title="Imagen o imagenes que se mostrarán del producto. Este campo no es obligatorio."></span> @endif
                                                        <div class="img-small-wrap" style="height:110px;overflow-y:auto;border:3px solid #096FA9;padding:5px">
                                                            <div class="" id="img-preview"></div>
                                                            {{-- <input type="file" name="imagen[]" style="display:none" accept="image/png, image/jpeg" multiple id="gallery-photo-add"> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="" id="label-descripcion"></label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Descripción breve del producto, no debe exceder los 255 caracteres. Este campo es obligatorio."></span> @endif
                                                        <textarea name="descripcion_small" class="form-control" id="text-descripcion" maxlength="255" rows="6" placeholder="Descripción corta del producto" required>{{$producto->descripcion_small}}</textarea>
                                                        @error('descripcion_small')
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                        @enderror
                                                    </div>
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
                            <div class="panel panel-bordered" style="margin-top:-30px">
                                <div class="panel-heading">
                                    <h3 class=""><i class="icon wb-image"></i> Precio(s) de venta <button type="button" class="btn btn-success btn-small" id="btn-add_venta" title="Agregar precio"><span class="voyager-plus"></span></button></h3>
                                    <div class="panel-actions">
                                        <a class="panel-action voyager-angle-up" data-toggle="panel-collapse" aria-hidden="true"></a>
                                    </div>
                                </div>
                                @php
                                    $unidad_primaria = '';
                                    if(count($precio_venta)){
                                        $precio_unidad = $precio_venta[0];
                                        $unidad = \App\Unidade::find($precio_unidad->unidad_id);
                                        $unidad_primaria = $unidad->nombre;
                                    }
                                @endphp
                                <div class="panel-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th>Precio @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Precio de venta del producto. Este campo es obligatorio."></span> @endif</th>
                                            <th>Precio mínimo @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Precio mínimo de venta del producto. Este campo no es obligatorio."></span> @endif</th>
                                            <th>Unidad de medida<span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="unidad de medida."></span></th>
                                            <th id="label-unidad">Cantidad en {{ $unidad_primaria }} <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title=""></span></th>
                                            <th></th>
                                        </thead>
                                        <tbody id="tr-precioVenta">
                                            @php
                                                $indiceVenta = 0;
                                            @endphp
                                            @for ($i = 0; $i < count($precio_venta); $i++)
                                                @if ($i==0)
                                                <tr>
                                                    <td><input type="number" min="0.01" step="0.01" class="form-control" value="{{$precio_venta[$i]->precio}}" name="precio_venta[]" required></td>
                                                    <td><input type="number" min="0" step="0.01" class="form-control" value="{{$precio_venta[$i]->precio_minimo}}" name="precio_minimo[]"></td>
                                                    <td>
                                                        <select name="unidad_id[]" class="form-control" id="select-unidad_id-0">
                                                            @foreach(\App\Unidade::orderBy('nombre')->pluck('nombre','id') as $id => $unidad)
                                                                <option {{($precio_venta[$i]->unidad_id == $id) ? 'selected' : ''}} value="{{ $id }}">{{ $unidad }} </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="number" min="0" step="0.01" class="form-control" name="cantidad_unidad[]" value="{{$precio_venta[$i]->cantidad_unidad}}"></td>
                                                    <td style="padding-top:15px"><span class="voyager-x text-secondary"></span></td>
                                                </tr>
                                                @else
                                                    <tr id="tr-precioVenta{{$indiceVenta}}">
                                                        <td><input type="number" min="0.01" step="0.01" class="form-control" value="{{$precio_venta[$i]->precio}}" name="precio_venta[]" required></td>
                                                        <td><input type="number" min="0" step="0.01" class="form-control" value="{{$precio_venta[$i]->precio_minimo}}" name="precio_minimo[]"></td>
                                                        <td>
                                                            <select name="unidad_id[]" class="form-control" id="select-unidad_id-{{ $indiceVenta }}">
                                                                @foreach(\App\Unidade::orderBy('nombre')->pluck('nombre','id') as $id => $unidad)
                                                                    <option {{($precio_venta[$i]->unidad_id == $id) ? 'selected' : ''}} value="{{ $id }}">{{ $unidad }} </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td><input type="number" min="0" step="0.01" class="form-control" name="cantidad_unidad[]" value="{{$precio_venta[$i]->cantidad_unidad}}"></td>
                                                        <td style="padding-top:15px"><span onclick="borrarTr({{$indiceVenta}}, 'Venta')" class="voyager-x text-danger"></span></td>
                                                    </tr>
                                                @endif
                                                @php
                                                    $indiceVenta++;
                                                @endphp
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bordered">
                                <div class="panel-heading">
                                        <h4 class="panel-title"> Descripción para E-Commerce @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="right" title="Descripción del producto que será visualizada por sus clientes cuando se encuentre agregada al E-Commerca. Este campo no es obligatorio."></span> @endif</h4>
                                    <div class="panel-actions">
                                        <a class="panel-action panel-collapsed voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                                    </div>
                                </div>
                                <div class="panel-body @if($producto->descripcion_long == '') collapse @endif">
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
        @include('inventarios.productos.partials.modales', ['producto_id' => $producto->id])
    @stop

    @section('css')
        <!-- custom style -->
        <link href="{{url('ecommerce_public/css/ui.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{url('ecommerce_public/css/responsive.css')}}" rel="stylesheet" media="only screen and (max-width: 1200px)" />
        <link rel="stylesheet" type="text/css" href="{{asset('dropzone/dropzone.css')}}">
    @stop

    @section('javascript')
    <script src="{{url('js/image-preview/image-preview.js')}}"></script>
    <script src="{{url('js/loginweb.js')}}"></script>
    <script src="{{url('js/inventarios/productos.js')}}"></script>
    <script src="{{asset('js/dropzone/dropzone.js')}}" type="text/javascript"></script>
        <script>
            const unidades = @json($unidades);
            Dropzone.autoDiscover = false;
            // Dropzone
            var myDropzone = new Dropzone(".dropzone",{
                maxFilesize: 5,  // 3 mb
                acceptedFiles: ".jpeg,.jpg,.png",
            });
            myDropzone.on("success", function(file, res) {
                if(res.data === 'success'){
                    toastr.success('Imagen agregada correctamente.', 'Bien hecho!');
                    imagesList();
                }else{
                    toastr.error('Ocurrio un error al agragar la imagen.', 'Error!')
                }
            });
            // ===================

            $(document).ready(function(){

                // Obtener lista de imagenes
                imagesList();

                $('[data-toggle="popover"]').popover({ html : true });
                $('[data-toggle="tooltip"]').tooltip();

                if('{{$producto->nuevo}}'=='1'){
                    $('#input-nuevo').bootstrapToggle('on')
                }

                if('{{$producto->se_almacena}}'=='1'){
                    $('#input-se_almacena').bootstrapToggle('on')
                }

                $('#label-descripcion').text(`Descripción (${$('#text-descripcion').val().length}/255)`)

                $('#select-categoria_id').val('{{$producto->categoria_id}}');
                $('#select-subcategoria_id').val('{{$producto->subcategoria_id}}');
                $('#select-marca_id').val('{{$producto->marca_id}}');
                $('#select-unidad_id').val('{{$producto->unidad_id}}');
                $('#select-moneda_id').select2();

                inicializar_select2('categoria_id');
                inicializar_select2('subcategoria_id');
                inicializar_select2('marca_id');
                inicializar_select2('unidad_id');

                // cambiar imagen principal
                $('.img-gallery').click(function(){
                    let img_medium = $(this).data('img').replace('_small', '_medium');
                    let img = $(this).data('img').replace('_small', '');

                    let id = $(this).data('id');
                    let producto_id = {{$producto->id}};
                    let url = "{{url('admin/productos/cambiar_imagen_principal')}}/"+producto_id+'/'+id
                    change_background(img_medium, img, id, url)
                });

                // Eliminar imagen
                $('#form-delete_imagen').on('submit', function(e){
                    e.preventDefault();
                    let datos = $(this).serialize();
                    delete_imagen("{{route('delete_imagen')}}", datos);
                });

                let indice_venta = {{$indiceVenta}};
                $('#btn-add_venta').click(function(){
                    add_precio_venta(indice_venta,unidades)
                    indice_venta++;
                });

                // ================

                $('#select-unidad_id-0').change(function(){
                    let unidad = $('#select-unidad_id-0 option:selected').text();
                    $('#label-unidad').text(`Cantidad en ${unidad}`);
                });

            });

            function imagesList(){
                $.get('{{ url("admin/productos/lista_imagenes/".$producto->id) }}', function(data){
                    $('#img-preview').html(data);
                });
            }
        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

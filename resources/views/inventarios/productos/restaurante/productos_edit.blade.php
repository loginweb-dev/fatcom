@extends('voyager::master')
@section('page_title', 'Editar Producto')

@if(auth()->user()->hasPermission('add_productos'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-harddrive"></i> Editar producto
        </h1>
        <button type="button" data-toggle="modal" data-target="#modal_insumos" class="btn btn-success">Insumos <span class="voyager-list"></span> </button>
        <button type="button" data-toggle="modal" data-target="#modal_extras" class="btn btn-primary">Extras <span class="voyager-list"></span> </button>
    @stop

    @section('content')
        <div class="page-content">
            @php
                $cont_insumos = 1;
            @endphp
            <form id="form" action="{{route('productos_update')}}" method="post" enctype="multipart/form-data">
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
                                <input type="hidden" name="moneda_id" value="2">
                                <input type="hidden" name="codigo_interno" value="">
                                <input type="hidden" name="marca_id" value="1">
                                <input type="hidden" name="precio_minimo[]" value="0">
                                <input type="hidden" name="cantidad_minima_venta[]" value="1">
                                {{-- </datos por defecto> --}}
                                <input type="hidden" name="id" value="{{ $producto->id }}">
                                <div class="panel-body strong-panel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="">Nombre comercial</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Nombre comercial del producto. Este campo es obligatorio."></span> @endif
                                                    <input type="text" name="nombre" class="form-control" value="{{$producto->nombre}}" placeholder="Nombre del producto" required>
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
                                                    <label for="">Categoría</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Categoría a la que pertenece el producto, en caso de no existir ninguna puede crearla escribiendo el nombre y presionando la tecla ENTER. Este campo es obligatorio."></span> @endif
                                                    <select name="categoria_id" id="select-categoria_id" class="form-control" required>
                                                        @foreach($categorias as $item)
                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Sub categoría</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Sub categoría del producto. las subcategorías se despliegan en base a la categoría seleccionada previamente, en caso de no existir ninguna puede crearla escribiendo el nombre y presionando la tecla ENTER. Este campo es obligatorio."></span> @endif
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
                                                <div class="form-group col-md-12">
                                                    <label for="">Precio de venta</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Precio de venta del producto. Este campo es obligatorio."></span> @endif
                                                    <div class="input-group">
                                                        <input type="number" name="precio_venta[]" value="{{$precio_venta[0]->precio}}" class="form-control" min="1" step="0.1" required>

                                                        <span class="input-group-addon">Bs.</span>
                                                    </div>
                                                    @error('precio_venta')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- <div class="row">
                                                
                                            </div> --}}
                                        </div>
                                        <div class="col-md-6">
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
                                                    <label for="" id="label-descripcion">Descripción (0/255)</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Descripción breve del producto, no debe exceder los 255 caracteres. Este campo es obligatorio."></span> @endif
                                                    <textarea name="descripcion_small" class="form-control" id="text-descripcion" maxlength="255" rows="2" placeholder="Descripción corta del producto" required>{{$producto->descripcion_small}}</textarea>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bordered">
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Descripción para la página de delivery @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="right" title="Descripción del producto que será visualizada por sus clientes cuando se encuentre agregada a la página de delivery. Este campo no es obligatorio."></span> @endif</h4>
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
                {{-- Modales de extras e insumos --}}
                @include('inventarios.productos.restaurante.modal')
            </form>
        </div>
        @include('partials.modal_load')
        @include('inventarios.productos.partials.modales', ['producto_id' => $producto->id])

    @stop

    @section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('dropzone/dropzone.css')}}">
    @stop

    @section('javascript')
        {{-- <script src="{{url('image-preview/image-preview.js')}}"></script> --}}
        <script src="{{asset('dropzone/dropzone.js')}}" type="text/javascript"></script>
        <script src="{{url('js/loginweb.js')}}"></script>
        <script src="{{url('js/inventarios/productos.js')}}"></script>
        <script>
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

            let insumo_indice = {{$cont_insumos}};
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover({ html : true });
                $('[data-toggle="tooltip"]').tooltip();

                // Incrementar el indice de la tabla de insumos
                let insumo_indice = {{$cont_insumos}};

                // Obtener lista de imagenes
                imagesList();

                if('{{$producto->nuevo}}'=='1'){
                    $('#input-nuevo').bootstrapToggle('on')
                }

                if('{{$producto->se_almacena}}'=='1'){
                    $('#input-se_almacena').bootstrapToggle('on')
                }

                $('#select-categoria_id').val('{{$producto->categoria_id}}');
                $('#select-subcategoria_id').val('{{$producto->subcategoria_id}}');

                // $('#select-categoria_id').select2();
                // $('#select-subcategoria_id').select2();
                inicializar_select2('categoria_id');
                inicializar_select2('subcategoria_id');

                $('#label-descripcion').text(`Descripción (${$('#text-descripcion').val().length}/255)`);

                // Eliminar imagen
                $('#form-delete_imagen').on('submit', function(e){
                    e.preventDefault();
                    let datos = $(this).serialize();
                    delete_imagen("{{route('delete_imagen')}}", datos);
                });

            });

            function borrarTr(num){
                $(`#tr-${num}`).remove();
            }

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

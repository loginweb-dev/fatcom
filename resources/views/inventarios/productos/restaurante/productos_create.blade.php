@extends('voyager::master')
@section('page_title', 'Añadir Producto')

@if(auth()->user()->hasPermission('add_productos'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-harddrive"></i> Añadir producto
        </h1>
        <button type="button" data-toggle="modal" data-target="#modal_insumos" class="btn btn-success">Insumos <span class="voyager-list"></span> </button>
        <button type="button" data-toggle="modal" data-target="#modal_extras" class="btn btn-primary">Extras <span class="voyager-list"></span> </button>
    @stop

    @section('content')
        <div class="page-content">
            <form id="form" action="{{route('productos_store')}}" method="post" enctype="multipart/form-data">
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
                                <input type="hidden" name="deposito_id" value="{{($depositos) ? $depositos->id : ''}}">
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
                                                    <label for="">Nombre comercial</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Nombre comercial del producto. Este campo es obligatorio."></span> @endif
                                                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Nombre del producto" required>
                                                    @error('nombre')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                    <div  style="position:absolute;right:15px;top:27px">
                                                        <input type="checkbox" name="nuevo" data-toggle="toggle" data-on="Nuevo <span class='voyager-check'></span>" data-off="Nuevo <span class='voyager-x'></span>">
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
                                                        <input type="number" name="precio_venta[]" class="form-control" value="{{ old('precio_venta') }}" min="1" step="0.01" required>
                                                        <span class="input-group-addon">Bs.</span>
                                                    </div>
                                                    @error('precio_venta')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="">Imagen(es)</label> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Imagen o imagenes que se mostrarán del producto. Este campo no es obligatorio."></span> @endif
                                                    <div class="img-small-wrap" style="height:110px;overflow-y:auto;border:3px solid #096FA9;padding:5px">
                                                        <div class="item-gallery" id="img-preview">
                                                            <button type="button" class="btn" title="Agregar imagen(es)" onclick="add_img()">
                                                                <h1 style="font-size:40px;margin:10px"><span class="voyager-plus"></span></h1>
                                                            </button>
                                                        </div>
                                                        <input type="file" name="imagen[]" style="display:none" accept="image/png, image/jpeg" multiple id="gallery-photo-add">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="" id="label-descripcion">Descripción (0/255)</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Descripción breve del producto, no debe exceder los 255 caracteres. Este campo es obligatorio."></span> @endif
                                                    <textarea name="descripcion_small" class="form-control" id="text-descripcion" maxlength="255" rows="2" placeholder="Descripción corta del producto" required>{{ old('descripcion_small') }}</textarea>
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
                                        <textarea class="form-control richTextBox" name="descripcion_long" row="3">{{ old('descripcion_long') }}</textarea>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <input type="checkbox" checked id="permanecer" name="permanecer">
                                    <label for="permanecer">Guardar y permanecer aqui.</label>
                                    <br><br>
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
    @stop

    @section('css')
    @stop

    @section('javascript')
        <script src="{{url('js/image-preview/image-preview.js')}}"></script>
        <script src="{{url('js/loginweb.js')}}"></script>
        <script src="{{url('js/inventarios/productos.js')}}"></script>
        <script>
            let insumo_indice = 1;
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover({ html : true });
                $('[data-toggle="tooltip"]').tooltip();

                inicializar_select2('categoria_id');
                inicializar_select2('subcategoria_id');

                // *******************codigo adicional*******************
                $('#form').on('submit', function(e){
                    e.preventDefault();
                    $('#modal_load').modal('show');
                    $("html,body").animate({scrollTop: $('#alerta-store').offset().top}, 1000);

                    let formData = new FormData(document.getElementById("form"));
                    formData.append("dato", "valor");
                    store_product(formData, '{{ route("productos_store") }}');
                });
                // *******************/script adicional*******************

            });

            function borrarTr(num){
                $(`#tr-${num}`).remove();
            }
        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

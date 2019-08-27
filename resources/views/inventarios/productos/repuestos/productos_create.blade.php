@extends('voyager::master')
@section('page_title', 'Añadir Producto')

@if(auth()->user()->hasPermission('add_productos'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-harddrive"></i> Añadir producto
        </h1>
        {{-- <a href="{{route('sucursales_index')}}" class="btn btn-success btn-small">
            <i class="voyager-double-left"></i> <span>Atras</span>
        </a> --}}
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
                                <input type="hidden" name="talla_id" value="1">
                                <input type="hidden" name="color_id" value="1">
                                <input type="hidden" name="genero_id" value="1">
                                <input type="hidden" name="uso_id" value="1">
                                <input type="hidden" name="moneda_id" value="2">
                                <input type="hidden" name="se_almacena" value="1">
                                {{-- </datos por defecto> --}}
                                <input type="hidden" name="deposito_id" value="{{($depositos) ? $depositos->id : ''}}">
                                <input type="hidden" name="codigo_grupo" value="{{$codigo_grupo}}">
                                <div class="panel-body strong-panel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="">Nombre comercial</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Nombre comercial del producto. Este campo es obligatorio."></span> @endif
                                                    <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" required>
                                                    @error('nombre')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                    <div  style="position:absolute;right:15px;top:27px">
                                                        <input type="checkbox" name="nuevo" data-toggle="toggle" data-on="<span class='voyager-check'></span> Nuevo" data-off="<span class='voyager-x'></span> Nuevo">
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
                                                <div class="form-group col-md-6">
                                                    <label for="">Marca</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Marca del producto, en caso de no existir ninguna puede crearla escribiendo el nombre y presionando la tecla ENTER. Este campo es obligatorio."></span> @endif
                                                    <select name="marca_id" id="select-marca_id" class="form-control" required>
                                                        @foreach($marcas as $item)
                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Unidad</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Unidad de almacenamiento del producto. Este campo es obligatorio."></span> @endif
                                                    <select name="unidad_id" id="select-unidad_id" class="form-control" required>
                                                        @foreach($unidades as $item)
                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Stock</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Cantidad de productos en stock. Este campo es obligatorio."></span> @endif
                                                    <input type="number" name="stock" class="form-control" @if($depositos && $depositos->inventario) value="{{ old('stock') ? old('stock') : 0 }}"  @else value="0" readonly @endif min="0" step="1" required>
                                                    @error('stock')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Stock mínimo</label> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Cantidad mínima de productos en stock para mostrar notificación de escasez. Este campo no es obligatorio."></span> @endif
                                                    <input type="number" name="stock_minimo" class="form-control" value="{{ old('stock_minimo') ? old('stock_minimo') : 0 }}" min="0" step="1" >
                                                    @error('stock')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Estante</label> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Nombre o número del estante en el que se almacena el producto. Este campo no es obligatorio."></span> @endif
                                                    <input type="text" name="estante" maxlength="20" class="form-control" placeholder="Estante A">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Bloque</label> @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Número o letra de bloque del estante en el que se almacena el producto. Este campo no es obligatorio."></span> @endif
                                                    <input type="text" name="bloque" maxlength="20" class="form-control" placeholder="Bloque 1">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="" id="label-descripcion">Descripción (0/255)</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Descripción breve del producto, no debe exceder los 255 caracteres. Este campo es obligatorio."></span> @endif
                                                    <textarea name="descripcion_small" class="form-control" id="text-descripcion" maxlength="255" rows="2" placeholder="Descripción corta del producto" required></textarea>
                                                    @error('descripcion_small')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" style="">
                                                    {{-- <label for="">Imagenes</label> --}}
                                                    <div class="img-small-wrap" style="height:120px;overflow-y:auto;border:3px solid #096FA9;padding:5px">
                                                        <div class="item-gallery" id="img-preview">
                                                            <button type="button" class="btn" title="Agregar imagen(es)" onclick="add_img()">
                                                                <h1 style="font-size:50px;margin:10px"><span class="voyager-plus"></span></h1>
                                                            </button>
                                                        </div>
                                                        <input type="file" name="imagen[]" style="display:none" accept="image/png, image/jpeg" multiple id="gallery-photo-add">
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
                        <div class="col-md-6">
                            <div class="panel panel-bordered" style="margin-top:-30px">
                                <div class="panel-heading">
                                    <h4 class=""><i class="icon wb-image"></i> Precio(s) de compra <button type="button" class="btn btn-success btn-small" id="btn-add_compra" title="Agregar precio"><span class="voyager-plus"></span></button></h4>
                                    <div class="panel-actions">
                                        <a class="panel-action voyager-angle-up" data-toggle="panel-collapse" aria-hidden="true"></a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th>Precio @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Precio de compra del producto. Este campo no es obligatorio."></span> @endif</th>
                                            <th>Cantidad mínima @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Cantidad mínima de compra para tener dicho precio. Este campo no es obligatorio."></span> @endif</th>
                                            <th></th>
                                        </thead>
                                        <tbody id="tr-precioCompra">
                                            <tr>
                                                <td><input type="number" min="1" step="0.1" class="form-control" name="monto[]" ></td>
                                                <td><input type="number" min="1" step="1" class="form-control" name="cantidad_minima_compra[]" ></td>
                                                <td style="padding-top:15px"><span class="voyager-x text-secondary"></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-bordered" style="margin-top:-30px">
                                <div class="panel-heading">
                                    <h4 class=""><i class="icon wb-image"></i> Precio(s) de venta <button type="button" class="btn btn-success btn-small" id="btn-add_venta" title="Agregar precio"><span class="voyager-plus"></span></button></h4>
                                    <div class="panel-actions">
                                        <a class="panel-action voyager-angle-up" data-toggle="panel-collapse" aria-hidden="true"></a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th>Precio @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Precio de venta del producto. Este campo es obligatorio."></span> @endif</th>
                                            <th>Precio mínimo @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Precio mínimo de venta del producto. Este campo no es obligatorio."></span> @endif</th>
                                            <th>Cantidad mínima @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Cantidad mínima de venta para tener dicho precio. Este campo es obligatorio."></span> @endif</th>
                                            <th></th>
                                        </thead>
                                        <tbody id="tr-precioVenta">
                                            <tr>
                                                <td><input type="number" min="1" step="0.1" class="form-control" name="precio_venta[]" required></td>
                                                <td><input type="number" min="1" step="0.1" class="form-control" name="precio_minimo[]"></td>
                                                <td><input type="number" min="1" step="1" class="form-control" name="cantidad_minima_venta[]" value="1" required></td>
                                                <td style="padding-top:15px"><span class="voyager-x text-secondary"></span></td>
                                            </tr>
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
                                <div class="panel-body collapse">
                                    <div class="form-group">
                                        <textarea class="form-control richTextBox" name="descripcion_long" row="3"></textarea>
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
            </form>
        </div>
        @include('partials.modal_load')
    @stop

    @section('css')
    @stop

    @section('javascript')
        <script src="{{url('image-preview/image-preview.js')}}"></script>
        <script src="{{url('js/loginweb.js')}}"></script>
        <script src="{{url('js/inventarios/productos.js')}}"></script>
        <script>
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover({ html : true });
                $('[data-toggle="tooltip"]').tooltip();

                inicializar_select2('categoria_id');
                inicializar_select2('subcategoria_id');
                inicializar_select2('marca_id');
                inicializar_select2('unidad_id');

                $('#select-categoria_id').change(function(){
                    let id = $(this).val();
                    if(!isNaN(id)){
                        $.ajax({
                            url: '{{url("admin/subcategorias/list/categoria")}}/'+id,
                            type: 'get',
                            success: function(response){
                                select2_reload('subcategoria_id', response, false, '');
                            }
                        });
                    }else{
                        $('#select-subcategoria_id').html('');
                        inicializar_select2('subcategoria_id');
                    }
                });

                // agregar precios
                let indice_compra = 1;
                $('#btn-add_compra').click(function(){
                    add_precio_compra(indice_compra)
                    indice_compra++;
                });

                let indice_venta = 1;
                $('#btn-add_venta').click(function(){
                    add_precio_venta(indice_venta)
                    indice_venta++;
                });

                // ================
            });
        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

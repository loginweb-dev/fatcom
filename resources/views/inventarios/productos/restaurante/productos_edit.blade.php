@extends('voyager::master')
@section('page_title', 'Editar Producto')

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
                                <input type="hidden" name="id" value="{{$producto->id}}">
                                <div class="panel-body strong-panel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="">Nombre comercial</label> @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="right" title="Nombre comercial del producto. Este campo es obligatorio."></span> @endif
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
                                                    <label for="">Categoría</label> @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="right" title="Categoría a la que pertenece el producto, en caso de no existir ninguna puede crearla escribiendo el nombre y presionando la tecla ENTER. Este campo es obligatorio."></span> @endif
                                                    <select name="categoria_id" id="select-categoria_id" class="form-control" required>
                                                        @foreach($categorias as $item)
                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Sub categoría</label> @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="right" title="Sub categoría del producto. las subcategorías se despliegan en base a la categoría seleccionada previamente, en caso de no existir ninguna puede crearla escribiendo el nombre y presionando la tecla ENTER. Este campo es obligatorio."></span> @endif
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
                                                    <label for="">Precio de venta</label> @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="right" title="Precio de venta del producto. Este campo es obligatorio."></span> @endif
                                                    <div class="input-group">
                                                        <input type="number" name="precio_venta[]" value="{{$precio_venta[0]->precio}}" class="form-control" min="1" step="0.1" required>

                                                        <span class="input-group-addon">Bs.</span>
                                                    </div>
                                                    @error('precio_venta')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Cantidad</label> @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="right" title="Cantidad de productos en stock. Este campo es obligatorio."></span> @endif
                                                    <input type="number" name="stock" readonly class="form-control" value="{{$producto->stock}}" min="0" step="1" required>
                                                    <div  style="position:absolute;right:15px;top:27px">
                                                        <input type="checkbox" id="input-se_almacena" name="se_almacena" data-toggle="toggle" data-on="<small>Se almacena</small> <span class='voyager-check'></span>" data-off="<small>Se almacena</small> <span class='voyager-x'></span>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="" id="label-descripcion">Descripción (0/255)</label> @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="right" title="Descripción breve del producto, no debe exceder los 255 caracteres. Este campo es obligatorio."></span> @endif
                                                    <textarea name="descripcion_small" class="form-control" id="text-descripcion" maxlength="255" rows="6" placeholder="Descripción corta del producto" required>{{$producto->descripcion_small}}</textarea>
                                                    @error('descripcion_small')
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12" style="">
                                                    <label for="">Imagen(es)</label> @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="right" title="Imagen o imagenes que se mostrarán del producto. Este campo no es obligatorio."></span> @endif
                                                    <div class="img-small-wrap" style="height:120px;overflow-y:auto;border:3px solid #096FA9;padding:5px">
                                                        <div class="" id="img-preview">
                                                            <button type="button" class="btn col-md-3" title="Agregar imagen(es)" onclick="add_img()">
                                                                <h1 style="font-size:50px;margin:10px"><span class="voyager-plus"></span></h1>
                                                            </button>
                                                                @php
                                                                    $style = ($producto->imagen!='') ? 'border:3px solid #2ECC71' : '';
                                                                    $titulo = 'Imagen principal';
                                                                @endphp
                                                                @foreach ($imagen as $item)
                                                                    @php
                                                                        $img = str_replace('.', '_small.', $item->imagen);
                                                                        $img_big = $item->imagen;
                                                                    @endphp
                                                                    <div class="col-md-3" id="marco-{{$item->id}}">
                                                                        <div style="position:absolute;z-index:1;">
                                                                            <label class="label label-danger btn-delete_img" data-toggle="modal" data-id="{{$item->id}}" data-target="#modal_delete" style="cursor:pointer;@if(!empty($style)) display:none @endif"><span class="voyager-x"></span></label>
                                                                        </div>
                                                                        <img src="{{url('storage').'/'.$img}}" style="width:100%;cursor:pointer;{{ $style }}" id="image-{{$item->id}}" title="{{$titulo}}" class="img-thumbnail img-sm img-gallery item-gallery" data-id="{{$item->id}}" data-img="{{url('storage').'/'.$img_big}}">
                                                                    </div>
                                                                    @php
                                                                        $style = '';
                                                                        $titulo = 'Establecer como imagen principal';
                                                                    @endphp
                                                                @endforeach
                                                            {{-- </div> --}}
                                                        </div>
                                                        <input type="file" name="imagen[]" style="display:none" accept="image/*" multiple id="gallery-photo-add">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="">Insumos</label> @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="right" title="Inusumos necesarios para la elaboración del producto. Este campo no es obligatorio."></span> @endif
                                                    <div class="input-group">
                                                        <select id="select-insumo_id" class="form-control select2">
                                                            @foreach($insumos as $item)
                                                            <option data-unidad="{{$item->unidad}}" value="{{$item->id}}" >{{$item->nombre}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-primary" id="btn-add" style="margin-top:0px" type="button"><span class="voyager-plus" aria-hidden="true"></span> Agregar</button>
                                                        </span>
                                                    </div>
                                                    <div style="max-height:200px;overflow-y:auto">
                                                        <table class="table table-bordered table-hover" >
                                                            <thead>
                                                                <tr>
                                                                    <th>Insumo</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Unid.</th>
                                                                    <th></th>
                                                                </tr>
                                                                <tbody id="lista-insumos">
                                                                    @php
                                                                        $cont_insumos = 1;
                                                                    @endphp
                                                                    @foreach ($insumos_productos as $item)
                                                                    <tr id="tr-{{$cont_insumos}}">
                                                                        <td>{{$item->nombre}}</td>
                                                                        <td>
                                                                            <input type="hidden" name="insumo_id[]" class="input-insumo" value="{{$item->id}}">
                                                                            <input type="number" class="form-control" name="cantidad_insumo[]" value="{{$item->cantidad}}" min="0.1" step="0.1" required>
                                                                        </td>
                                                                        <td>{{$item->unidad}}</td>
                                                                        <td><span class="voyager-x text-danger" onclick="borrarTr({{$cont_insumos}})"></span></td>
                                                                    </tr>
                                                                    @php
                                                                        $cont_insumos++;
                                                                    @endphp
                                                                    @endforeach
                                                                </tbody>
                                                            </thead>
                                                        </table>
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
            </form>
        </div>
        @include('partials.modal_load')
        @include('inventarios.productos.partials.modales')

    @stop

    @section('css')
    @stop

    @section('javascript')
        <script src="{{url('image-preview/image-preview.js')}}"></script>
        <script src="{{url('js/loginweb.js')}}"></script>
        <script src="{{url('js/inventarios/productos.js')}}"></script>
        <script>
            let insumo_indice = {{$cont_insumos}};
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover({ html : true });
                $('[data-toggle="tooltip"]').tooltip();

                // Incrementar el indice de la tabla de insumos
                let insumo_indice = {{$cont_insumos}};

                if('{{$producto->nuevo}}'=='1'){
                    $('#input-nuevo').bootstrapToggle('on')
                }

                if('{{$producto->se_almacena}}'=='1'){
                    $('#input-se_almacena').bootstrapToggle('on')
                }

                $('#select-categoria_id').val('{{$producto->categoria_id}}');
                $('#select-subcategoria_id').val('{{$producto->subcategoria_id}}');

                $('#select-categoria_id').select2();
                $('#select-subcategoria_id').select2();

                $('#label-descripcion').text(`Descripción (${$('#text-descripcion').val().length}/255)`)

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

                $('#select-categoria_id').change(function(){
                    let id = $(this).val();
                    if(!isNaN(id)){
                        $.ajax({
                            url: '{{url("admin/subcategorias/list/categoria")}}/'+id,
                            type: 'get',
                            success: function(response){
                                select2_reload('subcategoria_id', response, false);
                            }
                        });
                    }else{
                        $('#select-subcategoria_id').html('');
                        inicializar_select2('subcategoria_id');
                    }
                });

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

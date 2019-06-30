@extends('voyager::master')
@section('page_title', 'Editar Oferta')

@if(auth()->user()->hasPermission('add_ofertas'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-certificate"></i> Editar oferta
        </h1>
        {{-- <a href="{{route('sucursales_index')}}" class="btn btn-success btn-small">
            <i class="voyager-double-left"></i> <span>Atras</span>
        </a> --}}
    @stop

    @section('content')
        <div class="page-content">
            <form id="form" action="{{route('ofertas_update')}}" method="post" enctype="multipart/form-data">
                <div class="page-content browse container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bordered">
                                @csrf
                                <input type="hidden" name="id" value="{{$oferta->id}}">
                                <div class="panel-body strong-panel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="">Nombre</label>  @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="right" title="Nombre o título de la campaña de ofertas. Este campo es obligatorio."></span> @endif
                                                    <input type="text" name="nombre" class="form-control" placeholder="Nombre de la campaña" value="{{$oferta->nombre}}" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="" id="label-descripcion">Descripción (0/255)</label> @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="right" title="Descripción corta de la campaña, no debe exceder los 255 caracteres. Este campo es obligatorio."></span> @endif
                                                    <textarea name="descripcion" id="text-descripcion" class="form-control" maxlength="255" rows="5" placeholder="Descripción de la campaña de oferta" required>{{$oferta->descripcion}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Inicio</label>  @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="right" title="Fecha de inicio de la campaña. Este campo es obligatorio."></span> @endif
                                                    <input type="date" name="inicio" class="form-control" value="{{date('Y-m-d', strtotime($oferta->inicio))}}" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Fin</label>  @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="right" title="Fecha de finalización de la campaña. Este campo no es obligatorio."></span> @endif
                                                    <input type="date" name="fin" @if(!empty($oferta->fin)) value="{{date('Y-m-d', strtotime($oferta->fin))}}" @endif class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="">Seleccionar imagen</label>  @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="right" title="Imagen de la campaña, esta imagen será la portada de las publicaciones en redes solciales. Este campo no es obligatorio."></span> @endif
                                                    <div class="img-small-wrap" style="height:120px;overflow-y:auto;border:3px solid #096FA9;padding:5px">
                                                        <div class="item-gallery" id="img-preview">
                                                            <button type="button" class="btn" title="Agregar imagen" onclick="add_img()">
                                                                <h1 style="font-size:50px;margin:10px"><span class="voyager-plus"></span></h1>
                                                            </button>
                                                            @if(!empty($oferta->imagen))
                                                            <img src="{{url('storage').'/'.$oferta->imagen}}" style="height:100px" class="img-thumbnail img-sm img-gallery">
                                                            @endif
                                                        </div>
                                                        <input type="file" name="imagen" style="display:none" id="gallery-photo-add">
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
                                    <h4 class="panel-title" style="padding:0px 15px"> Lista de productos </label>
                                        <button type="button" style="font-size:20px" class="btn btn-link" title="Ver filtros" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <span class="voyager-params"></span>
                                        </button>
                                    </h4>
                                </div>
                                <div class="panel-body" style="padding-top:0px">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="accordion">
                                                <div class="card">
                                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    <label for="">Categoria</label>
                                                                    <select id="select-categoria_id" class="form-control select2 select-filtro">
                                                                        <option value="">Todas</option>
                                                                        @foreach($categorias as $item)
                                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">Sub categoria</label>
                                                                    <select id="select-subcategoria_id" class="form-control select2 select-filtro">
                                                                        <option value="">Todas</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label for="">Marca</label>
                                                                    <select id="select-marca_id" class="form-control select2 select-filtro">
                                                                        <option value="">Todas</option>
                                                                        @foreach($marcas as $item)
                                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="">Producto</label>  @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="right" title="Producto que se va agregar a la campaña. Este campo es obligatorio."></span> @endif
                                            <select class="form-control select2" id="select-producto_id">
                                                @foreach($productos as $item)
                                                <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Monto</label>  @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="bottom" title="Monto de descuento que se aplicará al producto. Este campo es obligatorio."></span> @endif
                                            <input type="text" class="form-control" id="input-monto" >
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Tipo de descuento</label>  @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="bottom" title="Tipo de descuento que se aplicará al producto Porcentaje/Monto fijo. Este campo es obligatorio."></span> @endif
                                            <select class="form-control select2" id="select-tipo">
                                                <option value="porcentaje">Porcentaje (%)</option>
                                                <option value="monto">Monto fijo</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button style="margin-top:27px" id="btn-agregar" type="button" class="btn btn-success">Agregar <span class="voyager-plus"></span></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Producto</th>
                                                            <th>Precio(s)</th>
                                                            <th width="200px">Monto</th>
                                                            <th width="200px">Tipo de descuento</th>
                                                            <th width="50px">Quitar</th>
                                                        </tr>
                                                    </thead>
                                                    @php
                                                        $cont = 0;
                                                    @endphp
                                                    <tbody id="lista_productos">
                                                        @foreach ($detalle_oferta as $item)
                                                        <tr id="tr-{{$cont}}">
                                                            <td><input type="hidden" class="input-producto_id" name="producto_id[]" value="{{$item->producto_id}}">{{$item->producto}}</td>
                                                            <td><span id="precios-{{$cont}}">{{$precios[$cont]['precio']}} {{$precios[$cont]['moneda']}} mínimo {{$precios[$cont]['cantidad_minima']}}</span></td>
                                                            <td><input type="number" min="1" step="1" class="form-control" name="monto[]" value="{{$item->monto}}" required></td>
                                                            <td>
                                                                <select name="tipo[]" class="form-control" id="select-tipo{{$cont}}">
                                                                    <option @if($item->tipo_descuento=='porcentaje') selected @endif value="porcentaje">Porcentaje (%)</option>
                                                                    <option  @if($item->tipo_descuento=='monto') selected @endif value="monto">Monto fijo</option>
                                                                </select>
                                                            </td>
                                                            <td style="padding-top:15px"><span onclick="borrarTr({{$cont}})" class="voyager-x text-danger"></span></td>
                                                        </tr>
                                                        @php
                                                            $cont++;
                                                        @endphp
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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
        <style>

        </style>
    @stop

    @section('javascript')
        <script src="{{url('image-preview/image-preview.js')}}"></script>
        <script src="{{url('js/loginweb.js')}}"></script>
        <script src="{{url('js/inventarios/ofertas.js')}}"></script>
        <script>
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover({ html : true });
                $('[data-toggle="tooltip"]').tooltip();

                // Calcular longitud de textarea "descripció"
                $('#text-descripcion').keyup(function(e){
                    $('#label-descripcion').text(`Descripción (${$(this).val().length}/255)`)
                });

                @error('producto_id')
                toastr.error('Debe agregar al menos 1 producto a la lista.', 'Error');
                @enderror

                // Obtener subcategorias de una categoria
                $('#select-categoria_id').change(function(){
                    let id = $(this).val();
                    subcategorias(id, '{{url("admin/subcategorias/list/categoria")}}');
                });

                // realizar filtro
                $('.select-filtro').change(function(){
                    filtro('{{url("admin/ofertas/filtros/filtro_simple")}}');
                });

                // agregar productos
                let indice = {{$cantidad_productos}};
                $('#btn-agregar').click(function(){
                    add_producto(indice, '{{url("admin/productos/obtener/precios_venta")}}');
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
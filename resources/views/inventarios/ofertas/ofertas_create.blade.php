@extends('voyager::master')
@section('page_title', 'Añadir Oferta')

@if(auth()->user()->hasPermission('add_ofertas'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-certificate"></i> Añadir oferta
        </h1>
        {{-- <a href="{{route('sucursales_index')}}" class="btn btn-success btn-small">
            <i class="voyager-double-left"></i> <span>Atras</span>
        </a> --}}
    @stop

    @section('content')
        <div class="page-content">
            <form id="form" action="{{route('ofertas_store')}}" method="post" enctype="multipart/form-data">
                <div class="page-content browse container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bordered">
                                @csrf
                                <div class="panel-body strong-panel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="">Nombre</label>  @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Nombre o título de la campaña de ofertas. Este campo es obligatorio."></span> @endif
                                                    <input type="text" name="nombre" class="form-control" placeholder="Nombre de la campaña" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="">Duración</label>  @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Tipo y tiempo de duración de la oferta. Este campo es obligatorio."></span> @endif
                                                </div>
                                                <div class="clearfix"></div>
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a class="tab-duracion" data-toggle="tab" data-value="rango" href="#Rango">Rango de fecha</a></li>
                                                    <li><a class="tab-duracion" data-toggle="tab" data-value="semanal" href="#semanal">Semanal</a></li>
                                                    <li><a class="tab-duracion" data-toggle="tab" data-value="mensual" href="#mensual">Mensual</a></li>
                                                </ul>    
                                                <div class="tab-content">
                                                    <div id="Rango" class="tab-pane fade in active">
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="">Inicio</label>  @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Fecha de inicio de la campaña. Este campo es obligatorio."></span> @endif
                                                                <input type="date" name="inicio" id="input-inicio" class="form-control" value="{{date('Y-m-d')}}" required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">Fin</label>  @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Fecha de finalización de la campaña. Este campo no es obligatorio."></span> @endif
                                                                <input type="date" name="fin" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="semanal" class="tab-pane fade">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="">Día</label>  @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Día de la semana en que se realizará la camáña periódicamente. Este campo es obligatorio."></span> @endif
                                                                <select name="dia_semana" class="form-control" id="select-dia">
                                                                    <option value="1">Lunes</option>
                                                                    <option value="2">Martes</option>
                                                                    <option value="3">Miércoles</option>
                                                                    <option value="4">Jueves</option>
                                                                    <option value="5">Viernes</option>
                                                                    <option value="6">Sábado</option>
                                                                    <option value="7">Domingo</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="mensual" class="tab-pane fade">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="">Día del mes</label>  @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Día de la semana en que se realizará la camáña periódicamente. Este campo es obligatorio."></span> @endif
                                                                <input type="number" id="input-dia" min="1" max="31" step="1" class="form-control" name="dia_mes" value="1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="tipo_duracion" id="input-tipo_duracion" value="rango">
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <input type="hidden" name="tipo_oferta" value="1" id="input-tipo_oferta">
                                                    <input type="checkbox" checked name="estado" data-toggle="toggle" data-onstyle="success" data-on="Activa" data-off="Inactiva">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="" id="label-descripcion">Descripción (0/255)</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Descripción corta de la campaña, no debe exceder los 255 caracteres. Este campo es obligatorio."></span> @endif
                                                    <textarea name="descripcion" id="text-descripcion" class="form-control" maxlength="255" rows="5" placeholder="Descripción de la campaña de oferta" required></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="">Seleccionar imagen</label>  @if(setting('admin.tips')) <span class="voyager-question text-default pull-right" data-toggle="tooltip" data-placement="left" title="Imagen de la campaña, esta imagen será la portada de las publicaciones en redes solciales. Este campo no es obligatorio."></span> @endif
                                                    <div class="img-small-wrap" style="height:120px;overflow-y:auto;border:3px solid #096FA9;padding:5px">
                                                        <div class="item-gallery" id="img-preview">
                                                            <button type="button" class="btn" title="Agregar imagen" onclick="add_img()">
                                                                <h1 style="font-size:50px;margin:10px"><span class="voyager-plus"></span></h1>
                                                            </button>
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
                                                        <div class="card-body" style="padding-bottom:0px">
                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    <label class="text-primary" for=""><b>Categoria</b></label><br>
                                                                    <select id="select-categoria_id" class="form-control select-filtro" data-tipo="subcategorias" data-destino="subcategoria_id">
                                                                        <option value="">Todas</option>
                                                                        @foreach($categorias as $item)
                                                                        <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label class="text-primary" for=""><b>Subcategoria</b></label><br>
                                                                    <select id="select-subcategoria_id" class="form-control select-filtro" data-tipo="marcas" data-destino="marca_id">
                                                                        <option value="">Todas</option>
                                                                        <option disabled value="">Debe seleccionar una categoría</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-4">
                                                                    <label class="text-primary" for=""><b>Marca</b></label><br>
                                                                    <select id="select-marca_id" class="form-control select-filtro" data-tipo="tallas" data-destino="talla_id">
                                                                        <option value="">Todas</option>
                                                                        <option disabled value="">Debe seleccionar una subcategoria</option>
                                                                    </select>
                                                                </div>
    
                                                                <div style="@if(setting('admin.modo_sistema') != 'boutique') display:none @endif">
                                                                    <div class="form-group col-md-4">
                                                                        <label class="text-primary" for=""><b>Tallas</b></label><br>
                                                                        <select id="select-talla_id" class="form-control select-filtro" data-tipo="generos" data-destino="genero_id">
                                                                            <option value="">Todas</option>
                                                                            <option disabled value="">Debe seleccionar una marca</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label class="text-primary" for=""><b>Genero</b></label><br>
                                                                        <select id="select-genero_id" class="form-control select-filtro" data-tipo="colores" data-destino="color_id">
                                                                            <option value="">Todos</option>
                                                                            <option disabled value="">Debe seleccionar una marca</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label class="text-primary" for=""><b>Color</b></label><br>
                                                                        <select id="select-color_id" class="form-control select-filtro">
                                                                            <option value="">Todos</option>
                                                                            <option disabled value="">Debe seleccionar una genero</option>
                                                                        </select>
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
                                            <label for="">Producto</label>  @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Producto que se agregará a la campaña. Este campo es obligatorio."></span> @endif
                                            <select class="form-control" id="select-producto_id" onchange="add_producto()">
                                                <option value="">Todos</option>
                                                @foreach ($productos as $item)
                                                    @php
                                                        $imagen = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : '../img/default.png';
                                                    @endphp
                                                    <option value="{{ $item->id }}"
                                                            data-imagen="{{ url('storage').'/'.$imagen }}"
                                                            data-categoria="{{ $item->subcategoria }}"
                                                            data-marca="{{ $item->marca }}"
                                                            data-precio="{{ $item->moneda }} {{ $item->precio_venta }}"
                                                            data-detalle="{{ $item->descripcion_small }}">
                                                        @if(setting('admin.modo_sistema') != 'restaurante')
                                                            @if($item->codigo_interno)
                                                            #{{ $item->codigo_interno }}
                                                            @else
                                                            {{ $item->codigo }} - 
                                                            @endif 
                                                        @endif
                                                        {{ $item->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a class="tab-detalle" data-toggle="tab" data-name="descuento" data-value="1" href="#descuento">Descuentos</a></li>
                                                <li><a class="tab-detalle" data-toggle="tab" data-name="2_por_1" data-value="2" href="#2_por_1">2X1</a></li>
                                            </ul>    
                                            <div class="tab-content">
                                                <div id="descuento" class="tab-pane fade in active">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Producto</th>
                                                                    <th>Precio</th>
                                                                    <th width="200px">Monto</th>
                                                                    <th width="200px">Tipo de descuento</th>
                                                                    <th width="50px">Quitar</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-content" id="lista_descuento">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div id="2_por_1" class="tab-pane fade">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Producto</th>
                                                                    <th>Precio</th>
                                                                    <th width="50px">Quitar</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-content" id="lista_2_por_1">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
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
        <script src="{{url('js/image-preview/image-preview.js')}}"></script>
        <script src="{{url('js/loginweb.js')}}"></script>
        <script src="{{url('js/inventarios/ofertas.js')}}"></script>
        <script src="{{url('js/inventarios/productos.js')}}"></script>
        <script src="{{ asset('js/rich_select.js') }}"></script>
        <script>
            var tipo_oferta = 'descuento';
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover({ html : true });
                $('[data-toggle="tooltip"]').tooltip();
                rich_select('select-producto_id');

                @error('producto_id')
                toastr.error('Debe agregar al menos 1 producto a la lista.', 'Error');
                @enderror

                // Cuando se abre el acordeon se inizializan los select2 que tiene dentro
                $('#accordion').on('show.bs.collapse', function () {
                    setTimeout(function(){
                        $('#select-categoria_id').select2();
                        $('#select-subcategoria_id').select2();
                        $('#select-marca_id').select2();
                        $('#select-talla_id').select2();
                        $('#select-genero_id').select2();
                        $('#select-color_id').select2();
                    }, 100);
                });

                // realizar filtro
                $('.select-filtro').change(function(){
                    let tipo = $(this).data('tipo');
                    let destino = $(this).data('destino');

                    if(tipo){
                        obtener_lista(tipo, '{{url("admin/productos/list")}}', destino);
                    }
                    
                    filtro('{{url("admin/ofertas/filtros/filtro_simple/ofertas_detalles")}}', '{{ setting('admin.modo_sistema') }}');
                });

                // Cambiar duración de oferta
                $('.tab-duracion').click(function(){
                    let value = $(this).data('value');
                    switch (value) {
                        case 'rango':
                            $('#input-inicio').attr('required', true)
                            $('#select-dia').removeAttr('required')
                            $('#input-dia').removeAttr('required')
                            break;
                        case 'semanal':
                            $('#input-inicio').removeAttr('required')
                            $('#select-dia').attr('required', true)
                            $('#input-dia').removeAttr('required')
                            break;
                        case 'mensual':
                            $('#input-inicio').removeAttr('required')
                            $('#select-dia').removeAttr('required')
                            $('#input-dia').attr('required', true)
                            break;
                        default:
                            break;
                    }
                    $('#input-tipo_duracion').val(value)
                });

                // vaciar contenido de las tablas si se cambia de pestaña
                $('.tab-detalle').click(function(){
                    $('.table-content').html('');
                    tipo_oferta = $(this).data('name');
                    $('#input-tipo_oferta').val($(this).data('value'));
                });
            });

        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

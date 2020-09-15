@extends('voyager::master')
@section('page_title', 'Productos')

@if(auth()->user()->hasPermission('browse_productos'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-harddrive"></i> Productos
        </h1>
        @if(auth()->user()->hasPermission('add_productos'))
            <a href="{{ route('productos_create') }}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>Añadir nuevo</span>
            </a>
            <button class="btn btn-dark btn-add-new" title="Ver filtros" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <i class="voyager-params"></i> <span>Filtros</span>
            </button>
            <button class="btn btn-danger btn-add-new" onclick="imprimir_codigo()" title="Imprimir código de barras">
                <i class="voyager-polaroid"></i> <span>Imprimir código</span>
            </button>
            @php
                $limite_render = 500;
            @endphp
            @if ($count_productos<$limite_render)
            <a href="{{ route('generar_catalogo', ['inicio'=>0, 'cantidad'=>$limite_render]) }}" target="_blank" class="btn btn-warning btn-add-new" title="Generar catálogo">
                <i class="voyager-cloud-download"></i> <span>Generar catálogo</span>
            </a>
            @else
            <div class="dropdown" style="display:inline">
                <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown" style="margin-top:1px" title="Imprimir catalogo."><i class="voyager-cloud-download"></i> Generar catálogo
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    @for ($i = 0; $i < $count_productos; $i += $limite_render)
                    <li><a href="{{ route('generar_catalogo', ['inicio'=>$i, 'cantidad'=>$limite_render]) }}" target="_blank" >Del {{ $i }} al {{ $limite_render+$i }}</a></li>
                    @endfor
                </ul>
            </div>
            @endif
        @endif
    @stop
    @section('content')
        <div class="page-content">
            <div class="page-content browse container-fluid">
                @include('voyager::alerts')
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
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

                                                            {{-- Solo si el negocio es una boutique se muestran estos demas filtros --}}
                                                            <div style="@if(setting('admin.modo_sistema') != 'boutique') display:none @endif">
                                                                <div class="form-group col-md-4">
                                                                    <label class="text-primary" for=""><b>Talla</b></label><br>
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
                                    <div class="col-md-12">
                                        <div class="col-md-7">
                                            <div class="dataTables_length form-inline" id="contenedor">
                                                <label>
                                                Mostrar
                                                <select 
                                                name="selectcantidad" 
                                                class="form-control input-sm selectcantidad"
                                                >
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                </select>
                                                </label>
                                                <select class="form-control input-sm selectorder">
                                                    <option value="codigo">ID</option>
                                                    <option value="nombre">Nombre</option>
                                                </select>
                                                <div class="radio" style="margin-left:10px; margin-right:10px">
                                                    <label><input type="radio" name="typeorder" checked value="desc"> DESC</label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="typeorder" value="asc"> ASC</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <form id="form-search" class="form-search">
                                                <div class="input-group">
                                                    <input type="text" id="search_value" class="form-control" name="s" value="{{$value}}" placeholder="código o nombre">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" style="margin-top:0px;padding:8px" type="submit">
                                                            <i class="voyager-search"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                            <small class="text-muted">Para volver a ver todos los productos realizar busqueda vacía.</small>
                                        </div>                               
                                    </div>
                                </div>
                                </div>
                                <div style="min-height:200px">
                                    <div id="lista-productos"></div>
                                    <div id="load-modal" style="display: none;justify-content: center;align-items: center;height:100%">
                                        <img src="{{ url('storage').'/'.str_replace('\\', '/', setting('admin.img_loader')) }}" width="80px" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal delete --}}
        <form action="{{route('productos_delete')}}" method="POST">
            <div class="modal modal-danger fade" tabindex="-1" id="modal_delete" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">
                                <i class="voyager-trash"></i> Estás seguro que quieres borrar el siguiente registro?
                            </h4>
                        </div>

                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="">
                            <input type="submit" class="btn btn-danger pull-right delete-confirm"value="Sí, bórralo!">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @stop
    @section('css')
        <link href="{{url('ecommerce_public/plugins/fancybox/fancybox.min.css')}}" type="text/css" rel="stylesheet">
        <style>

        </style>
    @stop
    @section('javascript')
        <script src="{{url('ecommerce_public/plugins/fancybox/fancybox.min.js')}}" type="text/javascript"></script>
        <script src="{{url('js/loginweb.js')}}"></script>
        <script src="{{url('js/inventarios/productos.js')}}"></script>
        <script>
            var countPage = 10, order = 'id', typeOrder = 'desc';
            $(document).ready(function() {

                filtro_productos('{{url("admin/productos/lista")}}', 1);

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
                    
                    filtro_productos('{{url("admin/productos/lista")}}', 1);
                });

                $('#form-search').on('submit', function(e){
                    e.preventDefault();
                    filtro_productos('{{url("admin/productos/lista")}}', 1);
                });
            });

            function filtro_productos(url ,page ){
                $('#load-modal').css('display', 'flex');
                $('#lista-productos').html('');
                let categoria = $('#select-categoria_id').val() ? $('#select-categoria_id').val() : 'all';
                let subcategoria = $('#select-subcategoria_id').val() ? $('#select-subcategoria_id').val() : 'all';
                let marca = $('#select-marca_id').val() ? $('#select-marca_id').val() : 'all';
                let talla = $('#select-talla_id').val() ? $('#select-talla_id').val() : 'all';
                let genero = $('#select-genero_id').val() ? $('#select-genero_id').val() : 'all';
                let color = $('#select-color_id').val() ? $('#select-color_id').val() : 'all';
                let search = $('#search_value').val() ? $('#search_value').val() : 'all';

                $.ajax({
                    url: url+'/'+categoria+'/'+subcategoria+'/'+marca+'/'+talla+'/'+genero+'/'+color+'/'+search+'/'+order+'/'+typeOrder+'/'+countPage+'?page='+page,
                    type: 'get',
                    success: function(response){
                        $('#lista-productos').html(response);
                        $('#load-modal').css('display', 'none');
                    }
                });
            }
         
            $('.selectcantidad').change(function(){
                countPage = $(this).val();
                filtro_productos('{{url("admin/productos/lista")}}', 1);
            });
            $('.selectorder').change(function(){
                order = $(this).val();
                filtro_productos('{{url("admin/productos/lista")}}', 1);
            });
            $("input[name=typeorder]").click(function () {  
                  
                if (typeOrder != $(this).val()) {
                    typeOrder = $(this).val();
                    filtro_productos('{{url("admin/productos/lista")}}', 1);
                }
            });
        </script>
    @stop

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

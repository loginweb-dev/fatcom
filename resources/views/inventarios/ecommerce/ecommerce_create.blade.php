@extends('voyager::master')
@section('page_title', 'Añadir producto a E-Commerce')

@if(auth()->user()->hasPermission('add_ecommerce'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-basket"></i> Añadir producto
        </h1>
        {{-- <a href="{{route('sucursales_index')}}" class="btn btn-success btn-small">
            <i class="voyager-double-left"></i> <span>Atras</span>
        </a> --}}
    @stop

    @section('content')
        <div class="page-content">
            <form name="form" action="{{route('ecommerce_store')}}" method="post">
                @csrf
                <div class="page-content browse container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bordered">
                                <div class="panel-heading">
                                    <h4 class="panel-title" style="padding:0px 15px"> Lista de productos
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
                                            <label for="">Producto</label> @if(setting('admin.tips')) <span class="voyager-question text-info pull-right" data-toggle="tooltip" data-placement="left" title="Producto que se agregará al E-Commerce. Este campo es obligatorio."></span> @endif
                                            <div class="input-group">
                                                <select class="form-control" id="select-producto_id">
                                                    <option selected disabled value="">Seleccione una opción</option>
                                                    @foreach ($productos as $item)
                                                        @php
                                                            $imagen = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : 'productos/default.png';
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
                                                <span class="input-group-btn">
                                                    <button style="margin-top:0px;padding:8px" id="btn-agregar" type="button" class="btn btn-success">Añadir <span class="voyager-plus"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <input type="text" id="input-tags" data-role="tagsinput" class="form-control" name="tags" placeholder="Etiquetas">
                                                <span class="input-group-addon" style="margin-top:0px;padding:7px">
                                                    @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="left" title="Palabras claves que asociarán el producto con otros para hacer recomendaciones a la hora de buscar en el E-Commerce. Este campo no es obligatorio."></span> @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Producto</th>
                                                            <th width="100px">En escasez</th>
                                                            <th>Etiquetas</th>
                                                            <th width="50px">Quitar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="lista_productos"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" @if(setting('admin.modo_sistema') == 'restaurante') style="display:none" @endif>
                                        <div class="col-md-12">
                                            <hr>
                                            <h4>Costos de envío @if(setting('admin.tips')) <span style="font-size:15px" class="voyager-question text-default" data-toggle="tooltip" data-placement="right" title="Costos de envío del producto a las diferentes localidades, si el producto no se envía a esa localidad dejar el campo vacío y si el envío es gratis ingresar 0. Este campo no es obligatorio."></span> @endif</h4>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Departamento</th>
                                                            <th>Localidad</th>
                                                            <th style="width:200px">Precio</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($localidades as $item)
                                                        <tr>
                                                            <td>
                                                                {{$item->departamento}}
                                                                <input type="hidden" name="localidad_id[]" value="{{$item->id}}" class="form-control">
                                                            </td>
                                                            <td>{{$item->localidad}}</td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="number" name="precio[]" class="form-control" value="0">
                                                                    <span class="input-group-addon" style="margin-top:0px;padding:7px">Bs.</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <button type="button" id="btn-submit" class="btn btn-primary">Guardar</button>
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
        <link rel="stylesheet" href="{{url('js/input-multiple/bootstrap-tagsinput.css')}}">
        <link rel="stylesheet" href="{{url('js/input-multiple/app.css')}}">
        <style>
            .popover{
                width: 300px;
            }
        </style>
    @stop

    @section('javascript')
        <script src="{{url('js/image-preview/image-preview.js')}}"></script>
        <script src="{{url('js/input-multiple/bootstrap-tagsinput.js')}}"></script>
        <script src="{{url('js/input-multiple/app.js')}}"></script>
        <script src="{{url('js/loginweb.js')}}"></script>
        <script src="{{url('js/inventarios/productos.js')}}"></script>
        <script src="{{ asset('js/rich_select.js') }}"></script>
        <script>
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover({ html : true });
            $('[data-toggle="tooltip"]').tooltip();
            $('#input-tags').tagsinput({});
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
                
                filtro('{{url("admin/ofertas/filtros/filtro_simple/ecommerce_productos")}}', '{{ setting('admin.modo_sistema') }}');
            });

            // agregar productos
            let indice = 1;
            $('#btn-agregar').click(function(){
                let id = $('#select-producto_id').val();
                let nombre = $('#select-producto_id option:selected').text()+' - '+$('#select-producto_id option:selected').attr('data-categoria');
                let envio = $('#input-envio').val();
                let envio_rapido = $('#input-envio_rapido').val();
                let tags = $('#input-tags').val();

                if(id!=null){

                    // Verificar que el producto no se haya seleccionado antes
                    let existe = false
                    $(".input-producto_id").each(function(){
                        if($(this).val()==id){
                            existe = true;
                        }
                    });
                    if(existe){
                        toastr.warning('El producto seleccionado ya se encuentra en la lista.', 'Advertencia');
                        return false;
                    }

                    // Crear fila con datos del producto
                    $('#lista_productos').append(`<tr id="tr-${indice}">
                                                    <td><input type="hidden" class="input-producto_id" name="producto_id[]" value="${id}">${nombre}</td>
                                                    <td><select name="escasez[]" class="form-control" id="">
                                                            <option value="">No</option>
                                                            <option value="1">Si</option>
                                                        </select></td>
                                                    <td><input type="hidden" class="form-control" name="tags[]" value="${tags}">${tags}</td>
                                                    <td style="padding-top:15px"><span onclick="borrarTr(${indice})" class="voyager-x text-danger"></span></td>
                                                </tr>`);
                indice++;
                }else{
                    toastr.warning('Debe seleccionar un producto.', 'Advertencia');
                }
            });

            $('#btn-submit').click(function(){
                document.form.submit();
            });

            // ================
        });

        function borrarTr(id){
            $('#tr-'+id).remove();
        }
    </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

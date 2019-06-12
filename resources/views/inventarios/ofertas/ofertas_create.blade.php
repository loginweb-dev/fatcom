@extends('voyager::master')
@section('page_title', 'Nueva Oferta')

@if(auth()->user()->hasPermission('add_ofertas'))
    @section('page_header')
        <h1 class="page-title">
            <i class="voyager-harddrive"></i> Añadir oferta
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
                                                    <label for="">Nombre</label>  @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="right" title="Nombre o título de la campaña de ofertas. Este campo es obligatorio."></span> @endif
                                                    <input type="text" name="nombre" class="form-control" placeholder="Nombre de la campaña" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="" id="label-descripcion">Descripción (0/255)</label> @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="right" title="Descripción corta de la campaña, no debe exceder los 255 caracteres. Este campo es obligatorio."></span> @endif
                                                    <textarea name="descripcion" id="text-descripcion" class="form-control" maxlength="255" rows="5" placeholder="Descripción de la campaña de oferta" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="">Inicio</label>  @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="right" title="Fecha de inicio de la campaña. Este campo es obligatorio."></span> @endif
                                                    <input type="date" name="inicio" class="form-control" value="{{date('Y-m-d')}}" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="">Fin</label>  @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="right" title="Fecha de finalización de la campaña. Este campo no es obligatorio."></span> @endif
                                                    <input type="date" name="fin" class="form-control">
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
                                                    <tbody id="lista_productos">

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
                    if(id!=''){
                        $.ajax({
                            url: '{{url("admin/subcategorias/list/categoria")}}/'+id,
                            type: 'get',
                            success: function(response){
                                select2_reload_simple('subcategoria_id', response);

                                // agregar opcion por defecto
                                $('#select-subcategoria_id').prepend(`<option value="">Todas</option>`);
                                $('#select-subcategoria_id').select2('destroy');
                                $('#select-subcategoria_id').val('');
                                $('#select-subcategoria_id').select2();
                            }
                        });
                    }else{
                        select2_reload_simple('subcategoria_id', [{'id':'','nombre':'Todas'}]);
                    }
                });

                // realizar filtro
                $('.select-filtro').change(function(){
                    let categoria = $('#select-categoria_id').val() ? $('#select-categoria_id').val() : 'all';
                    let subcategoria = $('#select-subcategoria_id').val() ? $('#select-subcategoria_id').val() : 'all';
                    let marca = $('#select-marca_id').val() ? $('#select-marca_id').val() : 'all';

                    // evitar que se envie una sub categoria si no se esta enviando una categoria
                    if(categoria == 'all'){
                        subcategoria = 'all';
                    }

                    $.ajax({
                        url: '{{url("admin/ofertas/filtros/filtro_simple")}}/'+categoria+'/'+subcategoria+'/'+marca,
                        type: 'get',
                        success: function(response){
                            select2_reload_simple('producto_id', response);
                        }
                    });
                });

                // agregar productos
                let indice = 1;
                $('#btn-agregar').click(function(){
                    let id = $('#select-producto_id').val();
                    let nombre = $('#select-producto_id option:selected').text();
                    let monto = $('#input-monto').val();
                    let tipo = $('#select-tipo').val();
                    if(id!=null && monto != '' && tipo != ''){

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

                        // obtener precios de ventas del producto
                        let precios = '';
                        let aux = indice;
                        $.ajax({
                            url: '{{url("admin/productos/obtener/precios_venta")}}/'+id,
                            type: 'get',
                            success: function(response){
                                response.forEach(element => {
                                    precios = precios+element.precio+' '+element.moneda+' mínimo '+element.cantidad_minima+'<br>';
                                });
                                $('#precios-'+aux).html(precios);
                            }
                        });

                        // Crear fila con datos del producto
                        $('#lista_productos').append(`<tr id="tr-${indice}">
                                                        <td><input type="hidden" class="input-producto_id" name="producto_id[]" value="${id}">${nombre}</td>
                                                        <td><span id="precios-${indice}">Cargando...</span></td>
                                                        <td><input type="number" min="1" step="1" class="form-control" name="monto[]" value="${monto}" required></td>
                                                        <td>
                                                            <select name="tipo[]" class="form-control" id="select-tipo${indice}">
                                                                <option value="porcentaje">Porcentaje (%)</option>
                                                                <option value="monto">Monto fijo</option>
                                                            </select>
                                                        </td>
                                                        <td style="padding-top:15px"><span onclick="borrarTr(${indice})" class="voyager-x text-danger"></span></td>
                                                    </tr>`);
                        $('#select-tipo'+indice).val(tipo);
                    indice++;
                    }else{
                        if(id==null){
                            toastr.warning('Debe seleccionar un producto.', 'Advertencia');
                        }
                        if(monto==''){
                            toastr.warning('Debe ingresar un monto de descuento.', 'Advertencia');
                        }
                    }
                });

                // ================
            });

            function borrarTr(id){
                console.log(id)
                $('#tr-'+id).remove();
            }
        </script>
    @endsection

@else
    @section('content')
        @include('errors.sin_permiso')
    @stop
@endif

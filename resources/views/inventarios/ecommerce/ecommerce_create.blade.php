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
                                        <div class="col-md-5">
                                            <label for="">Producto</label> @if(setting('admin.tips')) <span class="voyager-question text-info" data-toggle="tooltip" data-placement="right" title="Producto que se agregará al E-Commerce. Este campo es obligatorio."></span> @endif
                                            <select class="form-control select2" id="select-producto_id">
                                                @foreach($productos as $item)
                                                <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Mostrar escasez</label> @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="bottom" title="Cuando el stock del producto sea menor o igual al número ingresado en este campo, se mostrará un mensaje en el E-Commerce haciendo notar que hay pocas unidades del producto. Este campo no es obligatorio."></span> @endif
                                            <input type="number" min="0" step="1" class="form-control" id="input-escasez">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Costo envío</label> @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="bottom" title="Costo de envío del producto en caso de que la compra sea en la ciudad actual. Este campo no es obligatorio."></span> @endif
                                            <input type="number" min="0" step="0.1" class="form-control" id="input-envio" >
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Costo envío rápido</label> @if(setting('admin.tips')) <span class="voyager-question text-default" data-toggle="tooltip" data-placement="bottom" title="Costo de envío rápido del producto en caso de que la compra sea en la ciudad actual. Este campo no es obligatorio."></span> @endif
                                            <div class="input-group">
                                                <input type="number" min="0" step="0.1" class="form-control" id="input-envio_rapido" >
                                                <span class="input-group-btn">
                                                    <button style="margin-top:0px" id="btn-agregar" type="button" class="btn btn-success">Añadir <span class="voyager-plus"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <input type="text" id="input-tags" data-role="tagsinput" class="form-control" name="tags" placeholder="Etiquetas">
                                                <span class="input-group-addon">
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
                                                            <th width="200px">Mostrar escasez</th>
                                                            <th width="200px">Costo de envío</th>
                                                            <th width="200px">Costo de envío rapido</th>
                                                            <th>Etiquetas</th>
                                                            <th width="50px">Quitar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="lista_productos">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
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
        <link rel="stylesheet" href="{{url('input-multiple/bootstrap-tagsinput.css')}}">
        <link rel="stylesheet" href="{{url('input-multiple/app.css')}}">
        <style>
            .popover{
                width: 300px;
            }
        </style>
    @stop

    @section('javascript')
        <script src="{{url('image-preview/image-preview.js')}}"></script>
        <script src="{{url('input-multiple/bootstrap-tagsinput.js')}}"></script>
        <script src="{{url('input-multiple/app.js')}}"></script>
        <script src="{{url('js/loginweb.js')}}"></script>
        <script>
            $(document).ready(function(){
                $('[data-toggle="popover"]').popover({ html : true });
                $('[data-toggle="tooltip"]').tooltip();
                $('#input-tags').tagsinput({});

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

                // Obtener marcas de una subcategoria
                $('#select-subcategoria_id').change(function(){
                    let id = $(this).val();
                    if(id!=''){
                        $.ajax({
                            url: '{{url("admin/marcas/list/subcategoria")}}/'+id,
                            type: 'get',
                            success: function(response){
                                select2_reload_simple('marca_id', response);

                                // agregar opcion por defecto
                                $('#select-marca_id').prepend(`<option value="">Todas</option>`);
                                $('#select-marca_id').select2('destroy');
                                $('#select-marca_id').val('');
                                $('#select-marca_id').select2();
                            }
                        });
                    }else{
                        select2_reload_simple('marca_id', [{'id':'','nombre':'Todas'}]);
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
                        url: '{{url("admin/ecommerce/filtros/filtro_simple")}}/'+categoria+'/'+subcategoria+'/'+marca,
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
                    let escasez = $('#input-escasez').val();
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
                                                        <td><input type="number" min="1" step="1" class="form-control" name="escasez[]" value="${escasez}"></td>
                                                        <td><input type="number" min="1" step="1" class="form-control" name="envio[]" value="${envio}"></td>
                                                        <td><input type="number" min="1" step="1" class="form-control" name="envio_rapido[]" value="${envio_rapido}"></td>
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

<div class="row" style="overflow-y: auto;@if(setting('delivery.activo')) height:370px @else height:300px @endif">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div id="div-select_producto">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="radio-inline"><input type="radio" class="input-radio" name="radio1" value="search" checked>Buscador</label>
                            <label class="radio-inline"><input type="radio" class="input-radio" name="radio1" value="bar_code">Código de barras</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="margin:0px">
                            <div id="accordion">
                                <div class="card">
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body" style="padding:0px">
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

                                                <div style="@if(setting('delivery.activo')) display:none @endif">
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
                        <div  class="col-md-12" style="margin:0px">
                            <div class="input-group" id="div-search">
                                <select name="select_producto" class="form-control" id="select-producto_id" onchange="seleccionar_producto()">
                                    <option selected disabled value="">Seleccione una opción</option>
                                    @foreach ($productos as $item)
                                        @php
                                            $imagen = ($item->imagen!='') ? str_replace('.', '_small.', $item->imagen) : '../img/default.png';
                                        @endphp
                                        <option value="{{ $item->id }}"
                                                data-imagen="{{ url('storage').'/'.$imagen }}"
                                                data-categoria="{{ $item->categoria }}"
                                                data-subcategoria="{{ $item->subcategoria }}"
                                                data-marca="{{ $item->marca }}"
                                                data-talla="{{ $item->talla }}"
                                                data-color="{{ $item->color }}"
                                                data-genero="{{ $item->genero }}"
                                                data-precio="{{ $item->moneda }} {{ $item->precio_venta }}"
                                                data-precio_minimo="{{ $item->moneda }} {{ $item->precio_minimo }}"
                                                data-detalle="{{ $item->descripcion_small }}">
                                            @if(setting('admin.modo_sistema') != 'restaurante')
                                                {{ $item->codigo }} - 
                                            @endif
                                            {{ $item->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" style="margin-top:0px;padding:8px" type="button" title="Ver filtros" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Filtros <span class="voyager-params" aria-hidden="true"></span></button>
                                </span>
                            </div>
                            <div class="row hidden" id="div-bar_code">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="text" id="input-bar_code" class="form-control" onkeypress="return getBarCode(event)" autocomplete="off" />
                                        <span class="input-group-addon">
                                            <span class="voyager-ticket"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin:0px">
                            <div id="div-carga"></div>
                        </div>
                    </div>
                </div>
                <div id="div-loader"></div>
            </div>
        </div>
    </div>
</div>
<style>
    #load-bar-venta{
        position:relative;
        top:10px;
        left:0px;
        width:100%;
        z-index: 10000;
    }
</style>
<script src="{{url('js/inventarios/productos.js')}}"></script>
<script src="{{ asset('js/rich_select.js') }}"></script>
<script>
    $(document).ready(function(){
        // $('#select-producto_id').select2();
        rich_select('select-producto_id');

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
            
            filtro('{{url("admin/ventas/productos")}}', '{{ setting('admin.modo_sistema') }}');
        });

    });

    // Cambiar opción de busqueda
    $('.input-radio').change(function(){
        let tipo = $('#div-select_producto input[name="radio1"]:checked').val();
        if(tipo==='search'){
            $('#div-bar_code').addClass('hidden');
            $('#div-search').removeClass('hidden');
        }else{
            $('#div-bar_code').removeClass('hidden');
            $('#div-search').addClass('hidden');
            setTimeout(() => {
                $('#input-bar_code').focus();
            }, 300);
        }
    });

    function getBarCode(e){
        tecla = (document.all) ? e.keyCode :e.which;
        let codigo = $('#input-bar_code').val();
        if(tecla==13){
            if(codigo){
                $.get("{{ url('admin/ventas/get_producto/bar_code') }}/"+codigo.slice(0, -1), function(data){
                    if(data.producto){
                        agregar_producto(data.producto.id);
                    }else{
                        toastr.error('Código de producto no encontrado', 'Error');
                    }
                });
            }
            $('#input-bar_code').val('');
            return false;
        }
    };

    function seleccionar_producto(){
        let id = $('#select-producto_id').val();
        
        $.get("{{ url('admin/productos/get_producto') }}/"+id, function(data){
            let stock = data.se_almacena ? data.stock : 1000;
            agregar_detalle_venta(data.id, data.nombre, data.precio, data.precio_minimo, stock, data.unidades, '', '');
            $('#select-producto_id').select2('destroy');
            $('#select-producto_id').val('');
            // $('#select-producto_id').select2();
            rich_select('select-producto_id');
        });
    }
</script>

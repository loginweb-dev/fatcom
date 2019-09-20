<div class="row" style="overflow-y: auto;@if(setting('delivery.activo')) height:370px @else height:300px @endif">
    <div class="col-md-12">
        {{-- <div class="panel">
            <div class="panel-body" style="padding-bottom:0px"> --}}
                {{-- <h4>Ingrese su busqueda</h4> --}}
                {{-- <form action="" id="form-buscar"> --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div id="div-select_producto"  >
                                <div class="row">
                                    <div class="col-md-12" style="margin:0px">
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
                                </div>
                                <div class="input-group">
                                    <select name="select_producto" class="form-control" id="select-producto_id" onchange="seleccionar_producto()">
                                        {{-- <option value="">Todos los productos</option>
                                        @foreach ($productos as $item)
                                            @if (!$item->se_almacena || ($item->se_almacena && $item->stock > 0))
                                                <option value="{{$item->id}}" > @if($item->codigo) {{$item->codigo}}.- @endif {{$item->nombre}} @if($item->codigo_interno) #{{$item->codigo_interno}}@endif</option>
                                            @endif
                                        @endforeach --}}
                                        <option selected disabled value="">Seleccione una opción</option>
                                        @foreach ($productos as $item)
                                        @php
                                            $imagen = $item->imagen ?? 'productos/default.png';
                                        @endphp
                                            <option value="{{ $item->id }}"
                                                    data-imagen="{{ url('storage').'/'.$imagen }}"
                                                    data-categoria="{{ $item->subcategoria }}"
                                                    {{-- data-marca="{{ $item->marca }}" --}}
                                                    data-detalle="{{ $item->descripcion_small }}"
                                            >{{$item->nombre}} @if($item->codigo_interno) #{{$item->codigo_interno}}@endif</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" style="margin-top:0px;padding:8px" type="button" title="Ver filtros" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Filtros <span class="voyager-params" aria-hidden="true"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div id="div-barras_producto" style="display:none">
                                <input type="text" class="form-control" autocomplete="off" id="input-barras_producto" name="barras_producto">
                            </div>
                            <div id="div-carga" class="text-center"></div>
                        </div>
                    </div>
                {{-- </form> --}}
            {{-- </div>
        </div> --}}
    </div>
</div>
<style>
    
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
            
            filtro('{{url("admin/ofertas/filtros/filtro_simple/all")}}');
        });

    });

    function seleccionar_producto(){
        let id = $('#select-producto_id').val();
        
        $.get("{{url('admin/productos/get_producto')}}/"+id, function(data){
            let stock = data.se_almacena ? data.stock : 1000;
            agregar_detalle_venta(data.id, data.nombre, data.precio, stock, '', '');
            $('#select-producto_id').select2('destroy');
            $('#select-producto_id').val('');
            // $('#select-producto_id').select2();
            rich_select('select-producto_id');
        });
    }

    // cambiar tipo de busqueda
    // $('#switch-buscar').change(function() {
    //     if($(this).prop('checked')){
    //         $('#div-select_producto').css('display', 'none');
    //         $('#div-barras_producto').css('display', 'block');
    //     }else{
    //         $('#div-select_producto').css('display', 'block');
    //         $('#div-barras_producto').css('display', 'none');
    //     }
    // });
</script>

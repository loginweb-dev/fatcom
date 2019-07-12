<div class="row" style="overflow-y: auto;height:370px">
    <div class="col-md-12">
        {{-- <div class="panel">
            <div class="panel-body" style="padding-bottom:0px"> --}}
                <h3>Ingrese su busqueda</h3><br>
                <form action="" id="form-buscar">
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
                                                            <div class="form-group col-md-6">
                                                                <label class="text-primary" for=""><b>Categoria</b></label><br>
                                                                <select id="select-categoria_id" class="form-control select-filtro">
                                                                    <option value="">Todas</option>
                                                                    @foreach($categorias as $item)
                                                                    <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="text-primary" for=""><b>Subcategoria</b></label><br>
                                                                <select id="select-subcategoria_id" class="form-control select-filtro">
                                                                    <option value="">Todas</option>
                                                                    <option value="">Debe seleccionar una categoría</option>
                                                                </select>
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
                                        <option value="">Todos los productos</option>
                                        @foreach ($productos as $item)
                                        <option value="{{$item->id}}">{{$item->nombre}} - {{$item->precio}} Bs.</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" style="margin-top:0px;padding:7px" type="button" title="Ver filtros" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Filtros <span class="voyager-params" aria-hidden="true"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div id="div-barras_producto" style="display:none">
                                <input type="text" class="form-control" autocomplete="off" id="input-barras_producto" name="barras_producto">
                            </div>
                            <div id="div-carga" class="text-center"></div>
                        </div>
                        {{-- <div class="col-md-2">
                            <input type="checkbox" id="switch-buscar" data-toggle="toggle" data-on="Código" data-off="Buscador" data-onstyle="success" data-offstyle="info">
                        </div> --}}
                    </div>
                </form>
            {{-- </div>
        </div> --}}
    </div>
</div>
<style>

</style>
<script src="{{url('js/inventarios/ofertas.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#select-producto_id').select2();

        // Cuando se abre el acordeon se inizializan los select2 que tiene dentro
        $('#accordion').on('show.bs.collapse', function () {
            setTimeout(function(){
                $('#select-categoria_id').select2();
                $('#select-subcategoria_id').select2();
            }, 100);
        })

       // Obtener subcategorias de una categoria
       $('#select-categoria_id').change(function(){
            let id = $(this).val();
            subcategorias(id, '{{url("admin/subcategorias/list/categoria")}}');
        });

        // realizar filtro
        $('.select-filtro').change(function(){
            filtro('{{url("admin/ofertas/filtros/filtro_simple")}}');
        });

    });

    function seleccionar_producto(){
        let id = $('#select-producto_id').val();
        $.get("{{url('admin/productos/get_producto')}}/"+id, function(data){
            agregar_detalle_restaurante(data.id, data.nombre, data.precio, 1000, '', '');
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

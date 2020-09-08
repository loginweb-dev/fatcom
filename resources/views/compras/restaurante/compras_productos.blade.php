
<div class="row">
    {{-- <div class="col-md-12" style="margin:0px"> --}}
        <div id="accordion">
            <div class="card">
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body" style="padding-bottom:0px">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Categoria</label>
                                <select id="select-categoria_id" class="form-control select2 select-filtro">
                                    <option value="">Todas</option>
                                    @foreach($categorias as $item)
                                    <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Subcategorias</label>
                                <select id="select-subcategoria_id" class="form-control select2 select-filtro">
                                    <option value="">Todas</option>
                                    @foreach($subcategorias as $item)
                                    <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}
</div>
<div class="input-group">
    <select name="select_producto" class="form-control select2" id="select-producto_id" onchange="agregarTr()">
        <option value="">--Seleccionar producto--</option>
        @foreach ($productos as $item)
        <option value="{{$item->id}}">{{$item->subcategoria}} - {{$item->nombre}}</option>
        @endforeach
    </select>
    <span class="input-group-btn">
        <button class="btn btn-primary" disabled style="margin-top:0px" type="button" title="Ver filtros" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Filtros <span class="voyager-params" aria-hidden="true"></span></button>
    </span>
</div>
<br>
<input type="hidden" name="compra_producto" value="1">
<table class="table table-bordered" >
    <thead style="background-color:#F8FAFC">
        <td class="">Cantidad</td>
        <td>Detalle</td>
        <td>Precio</td>
        <td>Subtotal</td>
        <td width="50px"></td>
    </thead>
    <tbody>
        <tr id="tr-total">
            <td  colspan="3" class="text-right"><b>TOTAL</b></td>
            <td colspan="2"><b id="label-total">0.00 Bs.</b></td>
        </tr>
    </tbody>
</table>
<script src="{{url('js/loginweb.js')}}"></script>
<script>
    $(document).ready(function(){

        // Usar filtro de productos
        $('.select-filtro').change(function(){
                let categoria = $('#select-categoria_id').val() ? escape($('#select-categoria_id').val()) : 'all';
                let marca = $('#select-marca_id').val() ? escape($('#select-marca_id').val()) : 'all';
                let talla = $('#select-talla_id').val() ? escape($('#select-talla_id').val()) : 'all';

                $.ajax({
                    url: '{{url("admin/productos/filtros/filtro_simple")}}/'+categoria+'/'+marca+'/'+talla,
                    type: 'get',
                    success: function(response){
                        select2_reload_simple('producto_id', response);
                    }
                });
            });
    });

    // agregar fila
    // variable de numero de filas
    var cont = 1;
    function agregarTr(){
        let id = $('#select-producto_id').val()
        if(id){
            let nombre = $('#select-producto_id option:selected').text()

            $('#tr-total').before(`<tr id="tr-${cont}" class="tr-detalle">
                                    <td class="@if(setting('empresa.tipo_actividad')=='servicios') hidden @endif"><input type="number" data-indice="${cont}" class="form-control" onchange="calcular_subtotal(${cont})" onkeyup="calcular_subtotal(${cont})" id="cantidad-${cont}" min="1" step="0.01" value="1" name="cantidad[]"></td>
                                    <td>
                                        <input type="hidden" class="input-producto_id" data-cont="${cont}" name="producto[]" value="${id}">
                                        <label>${nombre}</label>
                                    </td>

                                    <td><input style="width:90px" type="number" data-indice="${cont}" class="form-control" onchange="calcular_subtotal(${cont})" onkeyup="calcular_subtotal(${cont})" id="precio-${cont}" value="0" name="precio[]"></td>
                                    <td><b class="label-subtotal" id="label-subtotal-${cont}" style="font-weight:bold">0.00</b></td>
                                    <td>
                                        <button type="button" onclick="borrarTr(${cont})" class="btn btn-danger"><span class="voyager-trash"></span></button>
                                    </td>
                                </tr>`);
            calcular_subtotal(cont)
            cont++;
        }
    }

    // calcular precio de producto seleccionado
    function calcular_precio(indice){
        let id = $(`#select_producto_id${indice}`).val();
        let precio = $(`#select_producto_id${indice} option:selected`).data('precio');
        if(precio){

            // verificar si existe el producto en la lista
            let cont_productos = 0;
            $(".select_producto").each(function(){
                if($(this).val()==id){
                    cont_productos += 1;
                }
            });
            if(cont_productos>1){
                $(`#select_producto_id${indice}`).select2('destroy');
                $(`#select_producto_id${indice}`).val('');
                $('#precio-'+indice).val('0.00');
                calcular_subtotal(indice);
                toastr.warning('No puede elegir un producto más de una vez.', 'Información');
                setTimeout(function(){
                    $(`#select_producto_id${indice}`).select2();
                }, 500);
            }
            calcular_subtotal(indice);
        }else{
            $('#precio-'+indice).val('0.00');
            calcular_subtotal(indice);
        }
    }

</script>

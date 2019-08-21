
<div class="table-responsive">
    <div class="col-md-12" style="margin:0px">
        <div id="accordion">
            <div class="card">
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body" style="padding-bottom:0px">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="">Categoria</label>
                                <select id="select-categoria_id" class="form-control select-filtro">
                                    <option value="">Todas</option>
                                    @foreach($categorias as $item)
                                    <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Marca</label>
                                <select id="select-marca_id" class="form-control select-filtro">
                                    <option value="">Todas</option>
                                    @foreach($marcas as $item)
                                    <option value="{{$item->id}}" >{{$item->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Talla</label>
                                <select id="select-talla_id" class="form-control select-filtro">
                                    <option value="">Todas</option>
                                    @foreach($tallas as $item)
                                    <option value="{{$item->id}}" >{{$item->numero}}</option>
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
<div class="input-group">
    <select name="select_producto" class="form-control select2" id="select-producto_id" onchange="agregarTr()">
        <option value="">--Seleccionar producto--</option>
        @foreach ($productos as $item)
        <option value="{{$item->id}}" data-nombre="{{$item->nombre}}" data-subcategoria="{{$item->subcategoria}}" data-precio_venta="{{$item->precio_venta}}">{{$item->subcategoria}} - {{$item->nombre}}</option>
        @endforeach
    </select>
    <span class="input-group-btn">
        <button class="btn btn-primary" style="margin-top:0px" type="button" title="Ver filtros" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Filtros <span class="voyager-params" aria-hidden="true"></span></button>
    </span>
</div>
<br>
<input type="hidden" name="compra_productos" value="1">
<table class="table table-bordered" >
    <thead style="background-color:#F8FAFC">
        <td class="">Cantidad</td>
        <td>Detalle</td>
        <td>Precio de compra</td>
        <td>Precio de venta</td>
        <td>Ganancia</td>
        <td>Subtotal</td>
        <td width="50px"></td>
    </thead>
    <tbody>
        <tr id="tr-total">
            <td  colspan="6" class="text-right"><b>TOTAL</b></td>
            <td colspan="2"><b id="label-total">0.00 Bs.</b></td>
        </tr>
    </tbody>
</table>
<script src="{{url('js/loginweb.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#select-producto_id').select2();

        // Usar filtro de productos
        $('.select-filtro').change(function(){
                let categoria = $('#select-categoria_id').val() ? escape($('#select-categoria_id').val()) : 'all';
                let marca = $('#select-marca_id').val() ? escape($('#select-marca_id').val()) : 'all';
                let talla = $('#select-talla_id').val() ? escape($('#select-talla_id').val()) : 'all';

                $.ajax({
                    url: '{{url("admin/productos/filtros/filtro_simple")}}/'+categoria+'/'+marca+'/'+talla,
                    type: 'get',
                    success: function(response){
                        select2_reload_productos('producto_id', response);
                    }
                });
            });

        // calcular datos complementarios de impuestos
        $('.calculable').change(function(){
            calcular()
        });
        $('.calculable').keyup(function(){
            calcular()
        });

        // vaciar formularios
        $('#btn-reset').click(function(){
            $(".label-subtotal").text('0.00');
            $("#label-total").text('0.00 Bs.');
        });
    });

    // agregar fila
    // variable de numero de filas
    var cont = 1;
    function agregarTr(){
        let id = $('#select-producto_id').val()
        if(id){
            let subcategoria = $('#select-producto_id option:selected').data('subcategoria')
            let nombre = $('#select-producto_id option:selected').data('nombre')
            let precio_venta = $('#select-producto_id option:selected').data('precio_venta')


            $('#tr-total').before(`<tr id="tr-${cont}" class="tr-detalle">
                                    <td class="@if(setting('empresa.tipo_actividad')=='servicios') hidden @endif"><input style="width:80px" type="number" data-indice="${cont}" class="form-control" onchange="calcular_subtotal(${cont})" onkeyup="calcular_subtotal(${cont})" id="cantidad-${cont}" min="1" step="1" value="1" name="cantidad[]"></td>
                                    <td>
                                        <input type="hidden" class="input-producto_id" data-cont="${cont}" name="producto[]" value="${id}">
                                        <label>${subcategoria} - ${nombre} </label>
                                    </td>
                                    <td>
                                        <input style="width:100px" type="number" min="1" data-indice="${cont}" class="form-control" onchange="calcular_subtotal(${cont})" onkeyup="calcular_subtotal(${cont})" id="precio-${cont}" value="0" name="precio[]" required>
                                    </td>
                                    <td>
                                        <input style="width:100px" type="number" class="form-control" id="precio_venta-${cont}" onchange="calcular_ganancia(${cont})" onkeyup="calcular_ganancia(${cont})" name="precio_venta[]" value="${precio_venta}" required>
                                    </td>
                                    <td>
                                        <b id="label-ganancia-${cont}" style="font-weight:bold;font-size:18px">0.00</b>
                                    </td>
                                    <td><b class="label-subtotal" id="label-subtotal-${cont}" style="font-weight:bold;font-size:20px">0.00</b></td>
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
            // $('#precio-'+indice).val(precio);
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

    // Calcular porcentaje de precio de venta
    function calcular_ganancia(num){
        let precio = parseFloat($(`#precio-${num}`).val());
        let precio_venta = parseFloat($(`#precio_venta-${num}`).val());
        if(precio_venta>precio){
            let aumento = precio_venta - precio;
            let porcentaje = (precio > 0) ? parseInt((aumento*100)/precio)+' %' : '';
            $(`#label-ganancia-${num}`).html((precio_venta-precio).toFixed(2)+'<br><small class="text-primary">'+porcentaje+'</small>');
            toastr.remove();
        }else{
            toastr.remove();
            toastr.error('El precio de venta debe ser mayor al precio de compra.')
            $(`#label-ganancia-${num}`).text('0.00');
        }
    }
</script>

$(function(){
    // ===================Genérico====================
    // Calcular longitud de textarea "descripción"
    $('#text-descripcion').keyup(function(e){
        $('#label-descripcion').text(`Descripción (${$(this).val().length}/255)`)
    });
    // ===================/Genérico====================
});

function subcategorias(id, url){
    if(id!=''){
        $.ajax({
            url: url+'/'+id,
            type: 'get',
            success: function(response){
                select2_reload_simple('subcategoria_id', response, 'Todas');
            }
        });
    }else{
        select2_reload_simple('subcategoria_id', [], 'Todas');
    }
}

function filtro(url){
    let categoria = $('#select-categoria_id').val() ? $('#select-categoria_id').val() : 'all';
    let subcategoria = $('#select-subcategoria_id').val() ? $('#select-subcategoria_id').val() : 'all';
    let marca = $('#select-marca_id').val() ? $('#select-marca_id').val() : 'all';

    // evitar que se envie una sub categoria si no se esta enviando una categoria
    if(categoria == 'all'){
        subcategoria = 'all';
    }

    $.ajax({
        url: url+'/'+categoria+'/'+subcategoria+'/'+marca,
        type: 'get',
        success: function(response){
            select2_reload_simple('producto_id', response, 'Todos los productos');
        }
    });
}


function add_producto(indice, url){
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
        $.ajax({
            url: url+'/'+id,
            type: 'get',
            success: function(response){
                console.log(response)
                response.forEach(element => {
                    precios = precios+element.precio+' '+element.moneda+' mínimo '+element.cantidad_minima+'<br>';
                });
                $('#precios-'+aux).html(precios);
            }
        });
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
}

function borrarTr(id){
    console.log(id)
    $('#tr-'+id).remove();
}

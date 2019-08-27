$(function(){
    // ===============Genéricas===============

    // mostrar pantalla de carga al guardar un producto
    $('#form').on('submit', function(){
        $('#modal_load').modal('show');
    });


    // Editar==============================

    // Calcular longitud de textarea "descripción"
    $('#text-descripcion').keyup(function(e){
        $('#label-descripcion').text(`Descripción (${$(this).val().length}/255)`)
    });

    // set valor de delete imagen
    $('.btn-delete_img').click(function(){
        $('#modal_delete input[name="id"]').val($(this).data('id'));
    });

    // ===============/Genéricas===============


    // ===============Restaurantes===============
    // Agregar insumos para elaborar productos
    $('#btn-add').click(function(){
        let insumo_id = $('#select-insumo_id').val();
        let existe = false;
        $(".input-insumo").each(function(){
            if($(this).val()==insumo_id){
                existe = true;
            }
        });
        if(!existe){
            if(insumo_id!=''){
                let insumo = $('#select-insumo_id option:selected').text();
                let unidad_insumo = $('#select-insumo_id option:selected').data('unidad');
                $('#lista-insumos').append(`<tr id="tr-${insumo_indice}">
                                                <td>${insumo}</td>
                                                <td>
                                                    <input type="hidden" name="insumo_id[]" class="input-insumo" value="${insumo_id}">
                                                    <input type="number" class="form-control" name="cantidad_insumo[]" min="0.1" step="0.1" required>
                                                </td>
                                                <td>${unidad_insumo}</td>
                                                <td><span class="voyager-x text-danger" onclick="borrarTr(${insumo_indice})"></span></td>
                                            </tr>`);
                insumo_indice++;
                toastr.info('Insumo agregado correctamente', 'Bien hecho!');
            }
        }else{
            toastr.warning('El insumo ya se encuentra agregado', 'Advertencia');
        }
    });

    // ===============/Restaurantes===============
});


// Cambiar imagen principal
function change_background(img_medium, img, id, url){
    $('#modal_load').modal('show');
    $.ajax({
        url: url,
        type: 'get',
        success: function(response){
            if(response==1){
                $('#img-medium').attr('src', img_medium);
                $('#img-slider').attr('href', img);
                // Resaltar border de imagen seleccionada
                $('.item-gallery').css('border','none');
                $('#image-'+id).css('border','3px solid #2ECC71');

                // Quitar boton de eliminación de la imagen seleccionada
                $('.btn-delete_img').css('display','block');
                $(`#image-${id} .btn-delete_img`).css('display','none');
                toastr.info('Imagen princiapl actualizada correctamente', 'Información');
            }else{
                toastr.error('Ocurrió un error al eliminar la imagen', 'Error');
            }
            $('#modal_load').modal('hide');
        }
    });
}

// Eliminar imagen de producto
function delete_imagen(url, datos){
    let id = $('#modal_delete input[name="id"]').val();
    $('#modal_delete').modal('hide');
    $('#modal_load').modal('show');
    $.ajax({
        url: url,
        type: 'post',
        data: datos,
        success: function(response){
            if(response==1){
                $('#image-'+id).remove();
                $('#marco-'+id).remove();
                toastr.info('Imagen eliminada correctamente', 'Información');
            }else{
                toastr.error('Ocurrió un error al eliminar la imagen', 'Error');
            }
            $('#modal_load').modal('hide');
        }
    });
}


// Agregar precio de compra
function add_precio_compra(indice_compra){
    $('#tr-precioCompra').append(`<tr id="tr-precioCompra${indice_compra}">
                                    <td><input type="number" min="1" step="0.1" class="form-control" name="monto[]" required></td>
                                    <td><input type="number" min="1" step="1" class="form-control" name="cantidad_minima_compra[]" required></td>
                                    <td style="padding-top:15px"><span onclick="borrarTr(${indice_compra}, 'Compra')" class="voyager-x text-danger" title="Quitar"></span></td>
                                </tr>`);
}

// Agregar precio de venta
function add_precio_venta(indice_venta){
    $('#tr-precioVenta').append(`<tr id="tr-precioVenta${indice_venta}">
                                    <td>
                                        <input type="number" min="1" step="0.1" class="form-control" name="precio_venta[]" required>
                                        <input type="hidden" name="precio_minimo[]" value="0">
                                    </td>
                                    <td><input type="number" min="1" step="1" class="form-control" name="cantidad_minima_venta[]" required></td>
                                    <td style="padding-top:15px"><span onclick="borrarTr(${indice_venta}, 'Venta')" class="voyager-x text-danger" title="Quitar"></span></td>
                                </tr>`);
}
// Quitar fila de lista de precios
function borrarTr(id, tipo){
    $('#tr-precio'+tipo+id).remove();
}

// Filtro de productos y sus caracteristicas

async function obtener_lista(tipo, url, destino){
    let categoria = $('#select-categoria_id').val() ? $('#select-categoria_id').val() : 'all';
    let subcategoria = $('#select-subcategoria_id').val() ? $('#select-subcategoria_id').val() : 'all';
    let marca = $('#select-marca_id').val() ? $('#select-marca_id').val() : 'all';
    let talla = $('#select-talla_id').val() ? $('#select-talla_id').val() : 'all';
    let genero = $('#select-genero_id').val() ? $('#select-genero_id').val() : 'all';
    let color = $('#select-color_id').val() ? $('#select-color_id').val() : 'all';

    // Según el tipo de busqueda agregar parametros a la url
    switch (tipo) {
        // case 'categorias'    : url += '/'+tipo+'/'+categoria; break;
        case 'subcategorias':
            url += '/'+tipo+'/'+categoria;
            select2_reload_simple('marca_id', [], 'Todas(os)');
            select2_reload_simple('talla_id', [], 'Todas(os)');
            select2_reload_simple('genero_id', [], 'Todas(os)');
            select2_reload_simple('color_id', [], 'Todas(os)');
            break;
        case 'marcas':
            url += '/'+tipo+'/'+subcategoria;
            select2_reload_simple('talla_id', [], 'Todas(os)');
            select2_reload_simple('genero_id', [], 'Todas(os)');
            select2_reload_simple('color_id', [], 'Todas(os)');
            break;
        case 'tallas':
            url += '/'+tipo+'/'+subcategoria+'/'+marca;
            select2_reload_simple('genero_id', [], 'Todas(os)');
            select2_reload_simple('color_id', [], 'Todas(os)');
            break;
        case 'generos':
            url += '/'+tipo+'/'+subcategoria+'/'+marca+'/'+talla;
            select2_reload_simple('color_id', [], 'Todas(os)');
            break;
        case 'colores':
            url += '/'+tipo+'/'+subcategoria+'/'+marca+'/'+talla+'/'+genero;
            break;
        default: break;
    }
    
    $.get(url, function(response){
        select2_reload_simple(destino, response, 'Todas(os)');
    });
}

function filtro(url){
    let categoria = $('#select-categoria_id').val() ? $('#select-categoria_id').val() : 'all';
    let subcategoria = $('#select-subcategoria_id').val() ? $('#select-subcategoria_id').val() : 'all';
    let marca = $('#select-marca_id').val() ? $('#select-marca_id').val() : 'all';
    let talla = $('#select-talla_id').val() ? $('#select-talla_id').val() : 'all';
    let genero = $('#select-genero_id').val() ? $('#select-genero_id').val() : 'all';
    let color = $('#select-color_id').val() ? $('#select-color_id').val() : 'all';

    // evitar que se envie una sub categoria si no se esta enviando una categoria
    if(categoria == 'all'){
        subcategoria = 'all';
    }

    $.ajax({
        url: url+'/'+categoria+'/'+subcategoria+'/'+marca+'/'+talla+'/'+genero+'/'+color,
        type: 'get',
        success: function(response){
            // console.log(response)
            select2_reload_simple('producto_id', response, 'Todos los productos');
        }
    });
}
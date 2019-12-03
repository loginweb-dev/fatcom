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
        if(!existe && insumo_id){
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
            toastr.warning('Insumo no seleccionado o ya se encuentra agregado', 'Advertencia');
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
                                    <td><input type="number" min="0.01" step="0.01" class="form-control" name="monto[]" required></td>
                                    <td><input type="number" min="1" step="1" class="form-control" name="cantidad_minima_compra[]" required></td>
                                    <td style="padding-top:15px"><span onclick="borrarTr(${indice_compra}, 'Compra')" class="voyager-x text-danger" title="Quitar"></span></td>
                                </tr>`);
}

// Agregar precio de venta
function add_precio_venta(indice_venta){
    $('#tr-precioVenta').append(`<tr id="tr-precioVenta${indice_venta}">
                                    <td><input type="number" min="1" step="0.1" class="form-control" name="precio_venta[]" required></td>
                                    <td><input type="number" min="0" step="0.1" class="form-control" name="precio_minimo[]"></td>
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

function filtro(url, modo_sistema){
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

    $('#div-carga').html(` <div id="load-bar-venta">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" style="background-color:#096FA9" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>`);
    setTimeout(()=>{
        $('#load-bar-venta').css('display', 'block');
        $('#load-bar-venta .progress-bar').css('width', '99%');
    }, 50);

    $.ajax({
        url: url+'/'+categoria+'/'+subcategoria+'/'+marca+'/'+talla+'/'+genero+'/'+color,
        type: 'get',
        success: function(response){
            // console.log(response)
            $('#select-producto_id').select2('destroy');
            let datos = `<option selected disabled value="">Seleccione una opción</option>`;
            if(response.length>0){
                response.forEach(item => {
                    let imagen = item.imagen ? '../../storage/'+item.imagen : '../../storage/productos/default.png';
                    let nombre = '';
                    if(modo_sistema != 'restaurante'){
                        nombre = item.codigo_interno ? '#'+item.codigo_interno.toString().padStart(2, "0")+' - ' : item.codigo+' - ';
                    }
                    nombre += item.nombre

                    datos += `<option value="${item.id}"
                                    data-imagen="${imagen}"
                                    data-categoria="${item.categoria}"
                                    data-subcategoria="${item.subcategoria}"
                                    data-marca="${item.marca}"
                                    data-talla="${item.talla}"
                                    data-color="${item.color}"
                                    data-genero="${item.genero}"
                                    data-precio="${item.moneda} ${item.precio_venta}"
                                    data-precio_minimo="${item.moneda} ${item.precio_minimo}"
                                    data-detalle="${item.descripcion_small ? item.descripcion_small : ''}"
                                >
                                ${nombre}
                                </option>`;
                });
            }
            $('#div-carga').html(`<h5>${response.length} reultado(s)</h5>`)
            $('#select-producto_id').html(datos);
            rich_select('select-producto_id');
        }
    });
}
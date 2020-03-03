$(function(){
    // ===================Genérico====================
    // Calcular longitud de textarea "descripción"
    $('#text-descripcion').keyup(function(e){
        $('#label-descripcion').text(`Descripción (${$(this).val().length}/255)`)
    });
    // ===================/Genérico====================
});

function add_producto(){
    let id = $('#select-producto_id').val();
    let nombre = $('#select-producto_id option:selected').text();
    let precio = $('#select-producto_id option:selected').data('precio');

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
    switch (tipo_oferta) {
        case 'descuento':
            $('#lista_descuento').append(`
                <tr id="tr-${id}">
                    <td><input type="hidden" class="input-producto_id" name="producto_id[]" value="${id}">${nombre}</td>
                    <td><span id="precios-${id}">${precio}</span></td>
                    <td><input type="number" min="1" step="1" class="form-control" name="monto[]" value="" required></td>
                    <td>
                        <select name="tipo[]" class="form-control">
                            <option value="porcentaje">Porcentaje (%)</option>
                            <option value="monto">Monto fijo</option>
                        </select>
                    </td>
                    <td style="padding-top:15px"><span onclick="borrarTr(${id})" class="voyager-x text-danger"></span></td>
                </tr>`
            );
            break;
        case '2_por_1':
            $('#lista_2_por_1').append(`
                <tr id="tr-${id}">
                    <td><input type="hidden" class="input-producto_id" name="producto_id[]" value="${id}">${nombre}</td>
                    <td><span id="precios-${id}">${precio}</span></td>
                    <td style="padding-top:15px"><span onclick="borrarTr(${id})" class="voyager-x text-danger"></span></td>
                </tr>`
            );
            break;
        default:
            break;
    }
    
}

function borrarTr(id){
    console.log(id)
    $('#tr-'+id).remove();
}

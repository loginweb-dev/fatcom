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

        // Crear fila con datos del producto
        $('#lista_productos').append(`
            <tr id="tr-${id}">
                <td><input type="hidden" class="input-producto_id" name="producto_id[]" value="${id}">${nombre}</td>
                <td><span id="precios-${id}">${precio}</span></td>
                <td><input type="number" min="1" step="1" class="form-control" name="monto[]" value="${monto}" required></td>
                <td>
                    <select name="tipo[]" class="form-control" id="select-tipo${id}">
                        <option value="porcentaje">Porcentaje (%)</option>
                        <option value="monto">Monto fijo</option>
                    </select>
                </td>
                <td style="padding-top:15px"><span onclick="borrarTr(${id})" class="voyager-x text-danger"></span></td>
            </tr>`);
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

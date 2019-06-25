$(function(){
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

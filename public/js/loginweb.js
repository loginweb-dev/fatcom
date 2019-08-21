function inicializar_select2(id){
    $(`#select-${id}`).select2({
        tags: true,
        createTag: function (params) {
            return {
            id: params.term,
            text: params.term,
            newOption: true
            }
        },
        templateResult: function (data) {
            var $result = $("<span></span>");
            $result.text(data.text);
            if (data.newOption) {
                $result.append(" <em>(ENTER para agregar)</em>");
            }
            return $result;
        },
    });
}

function inicializar_select2_simple(id){
    $('#select-'+id).select2('destroy');
    $(`#select-${id}`).select2();
}

function select2_reload(id, data, head, option_default){
    $('#select-'+id).select2('destroy');
    let datos = head ? `<option value="">${head}</option>` : '';
    if(data.length>0){
        data.forEach(item => {
            datos += `<option value="${item.id}">${item.nombre}</option>`;
        });
    }
    $('#select-'+id).html(datos);
    $('#select-'+id).val(option_default);
    inicializar_select2(id);
}

function select2_reload_simple(id, data, head, option_default){
    $('#select-'+id).select2('destroy');
    let datos = head ? `<option value="">${head}</option>` : '';
    if(data.length>0){
        data.forEach(item => {
            datos += `<option value="${item.id}">${item.nombre}</option>`;
        });
    }
    $('#select-'+id).html(datos);
    $('#select-'+id).val(option_default);
    $(`#select-${id}`).select2();
}

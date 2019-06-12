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
                $result.append(" <em>(ENTER para crear Nueva)</em>");
            }
            return $result;
        },
    });
}

function select2_reload_simple(id, data){
    $('#select-'+id).select2('destroy');
    let datos = '';
    if(data.length>0){
        data.forEach(item => {
            datos += `<option value="${item.id}">${item.nombre}</option>`;
        });
    }
    $('#select-'+id).html(datos);
    $(`#select-${id}`).select2();
}

function select2_reload(id, data){
    $('#select-'+id).select2('destroy');
    let datos = '';
    if(data.length>0){
        data.forEach(item => {
            datos += `<option value="${item.id}">${item.nombre}</option>`;
        });
    }
    $('#select-'+id).html(datos);
    inicializar_select2(id);
}

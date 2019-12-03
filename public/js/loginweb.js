const URL_BASE = `${window.location.href.split('admin')[0]}/admin`;

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
    }).change(function(){
        if($(`#select-${id}`).val().trim() === $(`#select-${id} option:selected`).text().trim()){
            $.get(`${URL_BASE}/productos/parametros/store/${id}/${$(`#select-${id}`).val().trim()}`, function(data){
                if(!data.error){
                    var newOption = new Option(data.nombre, data.id, false, false);
                    $(`#select-${id}`).append(newOption);
                    $(`#select-${id}`).val(data.id);
                    toastr.info(`Se agregó el producto ${data.nombre}`, 'Información');
                }
            });
        }
    });;
}

// Cargar sub categorías de categoría
$('#select-categoria_id').change(function(){
    let id = $(this).val();
    if(!isNaN(id)){
        $.ajax({
            url: `${URL_BASE}/productos/list/subcategorias/categoria/${id}`,
            type: 'get',
            success: function(response){
                select2_reload('subcategoria_id', response, 'Seleccione una subcategría', '');
            }
        });
    }else{
        $('#select-subcategoria_id').html('');
        inicializar_select2('subcategoria_id');
    }
});

// Crear nueva sub categoría
$('#select-subcategoria_id').change(function(){
    if($(`#select-subcategoria_id`).val().trim() === $(`#select-subcategoria_id option:selected`).text().trim()){
        $.get(`${URL_BASE}/productos/subcategoria/store/${$('#select-categoria_id').val()}/${$(`#select-subcategoria_id`).val().trim()}`, function(data){
            var newOption = new Option(data.nombre, data.id, false, false);
            $(`#select-subcategoria_id`).append(newOption);
            $(`#select-subcategoria_id`).val(data.id);
            toastr.info(`Se agregó el producto ${data.nombre}`, 'Información');
        });
    }
});

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

function store_product(formData, url){
    $.ajax({
        url: url,
        type: 'post',
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response){
            let res = JSON.parse(response);
            if(res.success===1){
                toastr.success('Producto guardado exitosamente.', 'Bien hecho');
            }else{
                toastr.error('Ocurrio un error al guardar el producto', 'Error');
            }
            $('#modal_load').modal('hide');
            
            // Si se hace check en limpiar formulario
            if(res.reload){
                toastr.warning('El formulario se actualizara, espere...', 'Aviso');
                setTimeout(()=>{
                    location.reload();
                }, 2000);
            }
        }
    });
}

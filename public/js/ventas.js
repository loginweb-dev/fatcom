// Inicializar buscador de clientes
$('#select-cliente_id').select2({
    placeholder: '<i class="fa fa-search"></i> Buscar cliente...',
    escapeMarkup : function(markup) {
        return markup;
    },
    language: {
        inputTooShort: function (data) {
            return `Por favor ingrese ${data.minimum - data.input.length} o más caracteres`;
        },
        noResults: function () {
            return `<i class="far fa-frown"></i> No hay resultados encontrados`;
        }
    },
    quietMillis: 250,
    minimumInputLength: 4,
    ajax: {
        url: function (params) {
            return `../clientes/datos/search/${escape(params.term)}`;
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    },
    templateResult: formatResultCustomers,
    templateSelection: (opt) => opt.razon_social
}).change(function(){
    var id = $(this).val();
    $.get(`../clientes/datos/id/${id}`, function(data){
        $('#input-nit').val(data.nit)
        data.nit ? $('#check-factura').prop('checked', true).change() : $('#check-factura').prop('checked', false).change();
    });
});

$('#input-nit').keyup(function(){
    let nit = $(this).val();
    nit && nit != '0000' ? $('#check-factura').prop('checked', true).change() : $('#check-factura').prop('checked', false).change();
});

// eliminar fila
function borrarTr(num){
    $(`#tr-${num}`).remove();
    total();
}

// Calcular subtotal
function subtotal(index,id=null){

    // Si la cantidad ingresada supera el stock, se mostrará una alerta y se pondrá el monto del stock en la cantidad
    if(parseInt($('#input-cantidad_'+index).val()) > parseInt($('#input-cantidad_'+index).prop('max'))){
        $('#input-cantidad_'+index).val($('#input-cantidad_'+index).prop('max'));
        toastr.warning('La cantidad ingresada supera el stock existente del producto.', 'Atención');
    }

    let precio = ($(`#input-precio_${index}`).val()!='') ? parseFloat($(`#input-precio_${index}`).val()) : 0;
    let cantidad = ($(`#input-cantidad_${index}`).val()!='') ? parseFloat($(`#input-cantidad_${index}`).val()) : 0;
    let extras = ($(`#input-total_extras_${index}`).val()!='' && $(`#input-total_extras_${index}`).val()!=undefined) ? parseFloat($(`#input-total_extras_${index}`).val()) : 0;
    $(`#subtotal-${index}`).html(`<h4>${((precio+extras)*cantidad).toFixed(2)} Bs.</h4>`);
    if (id) {
        productoUnidades(id, index);
    }
    total();
}

// calcular total
function total(){
    let total = 0;
    let descuento = parseFloat($('#input-descuento').val());
    let costo_envio = parseFloat($('#input-costo_envio').val());
    $(".label-subtotal").each(function(){
        total += parseFloat($(this).text().replace(" Bs.", ""));
    });

    $('#label-total').html('<h4>'+(total+costo_envio-descuento).toFixed(2)+' Bs.</h4>');
    $('#input-total').val(total+costo_envio);

    if($('#check-domicilio').is(':checked') || $('#check-llevar').is(':checked') || $('#check-credito').is(':checked')){
        $('#input-entregado').prop('min', 0);
    }else{
        $('#input-entregado').prop('min', (total-descuento).toFixed(2))
    }

    calcular_cambio();
}

// calcular cambio devuelto
function calcular_cambio(){
    let total = parseFloat($('#input-total').val());
    let descuento = parseFloat($('#input-descuento').val());
    let entregado = parseFloat($('#input-entregado').val());
    let cambio = entregado-total+descuento;

    $('#input-cambio').val(parseFloat(cambio).toFixed(2));
    if(cambio<0){
        $('#input-cambio').css('color', 'red');
    }else{
        $('#input-cambio').css('color', 'green');
    }
}

// vaciar formularios
$('#btn-reset').click(function(){
    $(".tr-detalle").remove();
    $("#label-total").html('<h4>0.00 Bs.</h4>');
    $('#input-total').val('0');
    $('#check-domicilio').bootstrapToggle('off');
    $('#check-llevar').bootstrapToggle('off');
    $('#check-credito').bootstrapToggle('off');
});

// asignar 0 por defecto a los campos que no pueden estar vacios
$('.cero_default').keyup(function(){
    if($(this).val()==''){
        // $(this).val('0');
        // total();
        // calcular_cambio();
    }
});

// agregar lista de extras del producto
function verExtras(url, id, sucursal_id){
    let data = [];
    $('#table-extras').html(``);
    if(!sessionStorage.getItem(`extras${id}`)){
        $.get(`${url}/${id}/${sucursal_id}`, function(res){
            sessionStorage.setItem(`extras${id}`, JSON.stringify(res));
            data = JSON.parse(sessionStorage.getItem(`extras${id}`));
            if(data.extras.length==0){
                $('#table-extras').html(`<tr><td colspan="3" class="text-center">El producto no tiene extras asignados.</td></tr>`);
            }else{
                renderListaExtras(data.extras);
            }
        });
    }else{
        data = JSON.parse(sessionStorage.getItem(`extras${id}`));
        if(data.extras.length==0){
            $('#table-extras').html(`<tr><td colspan="3" class="text-center">El producto no tiene extras asignados.</td></tr>`);
        }else{
            renderListaExtras(data.extras);
        }
    }

    // Asignar el id del producto al que se le va a agregar los extras
    $('#modal-lista_extras input[name="id"]').val(id);
    listaExtrasProductosSeleccionados(id);
};

function renderListaExtras(extras){
    extras.map((extra)=>{
        return $('#table-extras').append(
                    `<tr>
                        <td width="90px"><img src="${extra.imagen ? '/storage/extras/'+extra.imagen : '/img/default.png'}" width="80px" /></td>
                        <td>${extra.nombre}</td>
                        <td>${extra.precio}</td>
                        <td width="150px">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" onclick="cambiarValorExtra(${extra.id}, 'less')" type="button" style="margin:0px;padding:9px">
                                        <span class="hidden-xs hidden-sm"></span> <b style="font-weinght:bold"> &nbsp;-&nbsp; </b>
                                    </button>
                                </span>
                                <input type="text" readonly name="cantidad_extra[]" class="form-control input-cantidad_extra" value="0" id="input-cantidad_extra${extra.id}" data-id="${extra.id}" data-nombre="${extra.nombre}" data-precio="${extra.precio}" data-stock="${extra.stock}" style="text-align:center" />
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" onclick="cambiarValorExtra(${extra.id}, 'plus')" type="button" style="margin:0px;padding:9px">
                                        <span class="hidden-xs hidden-sm"></span> <b style="font-weinght:bold"> &nbsp;+&nbsp; </b>
                                    </button>
                                </span>
                            </div>
                        </td>
                    </tr>`
                );
    });
}

function cambiarValorExtra(id, valor){
    let valor_actual = $(`#input-cantidad_extra${id}`).val();
    let stock = parseFloat($(`#input-cantidad_extra${id}`).data('stock'));
    if(valor=='plus'){
        if(valor_actual < stock){
            valor_actual++;
            $(`#input-cantidad_extra${id}`).val(valor_actual);
        }
    }else{
        if(valor_actual>0){
            valor_actual--;
            $(`#input-cantidad_extra${id}`).val(valor_actual);
        }
    }
    listaExtrasProducto()
}

function listaExtrasProducto(){
    let lista_extras = '';
    let input_extras = '';
    let input_catidad_extras = '';
    let input_precio_extras = '';
    let total_extras = 0;
    let producto_id = $('#modal-lista_extras input[name="id"]').val();
    $('.input-cantidad_extra').each(function(){
        let cantidad = $(this).val();
        let extra_id = $(this).data('id');
        let extra_nombre = $(this).data('nombre');
        let extra_precio = $(this).data('precio');
        if(cantidad>0){
            lista_extras += ' '+extra_nombre+',';
            input_extras += extra_id+',';
            input_catidad_extras += cantidad+',';
            input_precio_extras += extra_precio+',';

            total_extras += cantidad*extra_precio;
        }
    });
    $(`#extras_producto-${producto_id}`).html(`<div><small>${lista_extras.slice(0, -1)}</small></div>`);
    $(`#input-extras_id_${producto_id}`).val(input_extras.slice(0, -1));
    $(`#input-cantidad_extras_id_${producto_id}`).val(input_catidad_extras.slice(0, -1));
    $(`#input-precio_extras_id_${producto_id}`).val(input_precio_extras.slice(0, -1));

    $(`#input-total_extras_${producto_id}`).val(total_extras);
    $(`#label-extras_${producto_id}`).text(`+${total_extras}`);
    subtotal(producto_id);
}

function listaExtrasProductosSeleccionados(id){
    let extras_id = $(`#input-extras_id_${id}`).val();
    let extras_cantidades = $(`#input-cantidad_extras_id_${id}`).val();

    if(extras_id && extras_cantidades){
        extras_id = extras_id.split(',');
        extras_cantidades = extras_cantidades.split(',');

        for (let index = 0; index < extras_id.length; index++) {
            $(`#input-cantidad_extra${extras_id[index]}`).val(extras_cantidades[index]);
        }
    }
}

function cambio_precio(id, index){

    let unit = $(`#select-unidad_id-${index} option:selected`).val();
    let cant_llevar = $(`#input-cantidad_${index}`).val();

    $.get("/admin/productos/get_price_producto_units/"+id+"/"+unit, function(data){
        $(`#input-precio_${index}`).val(data.precio);
        $(`#input-units_products_id_${index}`).val(data.cantidad_unidad);
    });
    setTimeout(() => {
        subtotal(index);
    }, 200);

    productoUnidades(id, index);
}

function productoUnidades(id, index){
    let unit_aux = 0;
    let conversion = '';
    let id_unit = $(`#select-unidad_id-${index} option:selected`).val();
    let unit = $(`#select-unidad_id-${index} option:selected`).data('cantidad_unidad');
    let cant_llevar = $(`#input-cantidad_${index}`).val();
    unit = unit ? parseFloat(unit) : 0;
    cant_llevar = cant_llevar ? parseFloat(cant_llevar) : 0;
    $.get("/admin/productos/get_price_producto_units/"+id, function(res){
        res.map(unid => {
            if(unid.unidad.id != id_unit){
                unit_aux = unid.cantidad_unidad ? parseFloat(unid.cantidad_unidad) : 0;
                conversion += `${((unit*cant_llevar)/unit_aux).toFixed(2)} ${unid.unidad.abreviacion ? unid.unidad.abreviacion : unid.unidad.nombre}<br>`;
            }
        });
        $(`#conversiones_${index}`).html(conversion);
    });
}

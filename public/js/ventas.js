// Obtener nit de cliente
$('#select-cliente_id').change(function(){
    let razon_social = $(this).val();
    $.get(`../clientes/datos/id/${razon_social}`, function(data){
        $('#input-nit').val(data.nit);
    });

    // Si se elige un cliente se debe desbloquear el modal del mapa
    if (razon_social == 1) {
        // $('#check-domicilio').attr('disabled', true);
    }else{
        $('#check-domicilio').removeAttr('disabled');
    }
});

function getClienteNIT(e) {
    tecla = (document.all) ? e.keyCode :e.which;
    if(tecla==13){
        var nit = $('#input-nit').val();
        $.get(`../clientes/datos/nit/${nit}`, function(data){
            if(data){
                $('#select-cliente_id').select2('destroy')
                $('#select-cliente_id').val(data.id);
                inicializar_select2('cliente_id');
                toastr.info('Cliente encontrado', 'Información');
            }else{
                $('#input-modal_nit').val(nit);
                $('#input-modal_razon_social').val('');
                $('#modal-nuevo_cliente').modal('show');
                setTimeout(()=>$('#input-modal_razon_social').focus(), 700);
            }
        });
        return false;
    }
}

// eliminar fila
function borrarTr(num){
    $(`#tr-${num}`).remove();
    total();
}

// Calcular subtotal
function subtotal(id){
    // Si la cantidad ingresada supera el stock, se mostrará una alerta y se pondrá el monto del stock en la cantidad
    if(parseInt($('#input-cantidad_'+id).val()) > parseInt($('#input-cantidad_'+id).prop('max'))){
        $('#input-cantidad_'+id).val($('#input-cantidad_'+id).prop('max'))
            toastr.warning('La cantidad ingresada supera el stock existente del producto.', 'Atención');
    }

    let precio = ($(`#input-precio_${id}`).val()!='') ? parseFloat($(`#input-precio_${id}`).val()) : 0;
    let cantidad = ($(`#input-cantidad_${id}`).val()!='') ? parseFloat($(`#input-cantidad_${id}`).val()) : 0;
    $(`#subtotal-${id}`).html(`<h4>${(precio*cantidad).toFixed(2)} Bs.</h4>`);
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

    if($('#check-domicilio').is(':checked') || $('#check-llevar').is(':checked')){
        $('#input-entregado').prop('min', 0);
    }else{
        $('#input-entregado').prop('min', (total-descuento).toFixed(2))
    }
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
});

// asignar 0 por defecto a los campos que no pueden estar vacios
$('.cero_default').keyup(function(){
    if($(this).val()==''){
        // $(this).val('0');
        // total();
        // calcular_cambio();
    }
});

// Obtener nit de cliente
$('#select-cliente_id').change(function(){
    let razon_social = $(this).val();
    let nit = $('#select-cliente_id option:selected').data('nit');
    if(razon_social!=''){
        $('#input-nit').val(nit);
    }
});

// Obtener razón social de cliente
$('#input-nit').keyup(function(e){
    let nit = $(this).val();
    $("#select-cliente_id option").each(function(e){
        if($(this).data('nit') == nit){
            $('#select-cliente_id').select2('destroy')
            $('#select-cliente_id').val($(this).attr('value'));
            inicializar_select2('cliente_id');
            toastr.info('Cliente encontrado', 'Información');
        }
     });
});

// eliminar fila
function borrarTr(num){
    $(`#tr-${num}`).remove();
    total();
}

// calcular total
function total(){
    let total = 0;
    let costo_envio = parseFloat($('#input-costo_envio').val());
    $(".label-subtotal").each(function(){
        total += parseFloat($(this).text().replace(" Bs.", ""));
    });
    $('#label-total').html('<h4>'+(total+costo_envio).toFixed(2)+' Bs.</h4>');
    $('#input-total').val(total+costo_envio);
    // $('#input-entregado').prop('min', total)
}

// calcular cambio devuelto
function calcular_cambio(){
    let total = parseFloat($('#input-total').val());
    let entregado = parseFloat($('#input-entregado').val());
    let cambio = entregado-total;

    $('#input-cambio').val(parseFloat(cambio));
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
});

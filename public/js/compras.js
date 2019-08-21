// calcular datos complementarios de impuestos
$('.calculable').change(function(){
    calcular()
});
$('.calculable').keyup(function(){
    calcular()
});

// vaciar formularios
$('#btn-reset').click(function(){
    $(".label-subtotal").text('0.00');
    $("#label-total").text('0.00 Bs.');
});

// Calcular datos de impuestos
function calcular(){
    let importe = parseFloat($('#input-importe_compra').val());
    let exento = parseFloat($('#input-exento').val());
    let descuento = parseFloat($('#input-descuento').val());
    let subtotal = importe-exento;
    let credito_fiscal = (subtotal-descuento)*0.13
    $('#input-importe_compra').val(subtotal.toFixed(2));
    $('#input-importe_base').val((subtotal-descuento).toFixed(2));
    $('#input-credito_fiscal').val(credito_fiscal.toFixed(2));
}

// calcular subtotal
function calcular_subtotal(num){
    let precio = parseFloat($(`#precio-${num}`).val());
    let cantidad = parseFloat($(`#cantidad-${num}`).val());

    $(`#label-subtotal-${num}`).text((precio*cantidad).toFixed(2));
    total();
    calcular()
    calcular_ganancia(num)
}

// Calcular importe total de compra
function total(){
    let total = 0;
    $(".label-subtotal").each(function(){
        total += parseFloat($(this).text());
    });
    $('#label-total').text(total.toFixed(2)+' Bs.');
    $('#input-importe_compra').val(total)
}

// cargar vista de detalle de compra según tipo
function cargar_detalle(tipo, url){
    $('#input-importe_compra').val('');
    $('#input-importe_base').val('');
    $('#input-credito_fiscal').val('');

    $.ajax({
        url: `${url}/${tipo}`,
        type: 'get',
        success: function(data){
            $('#detalle_venta').html(data);
        },
        error: function(){
            console.log('error');
        }
    });
}

// eliminar fila
function borrarTr(num){
    $(`#tr-${num}`).remove();
    total();
    calcular()
}

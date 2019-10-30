$(document).ready(function () {
    
});

function rich_select(id){
    $(`#${id}`).select2({
        placeholder: "Buscar producto...",
        language: {
            inputTooShort: function (data) {
                return `Ingrese al menos ${data.minimum - data.input.length} caracteres`;
            }
        },
        minimumInputLength: 2,
        templateResult: formatResult,
        templateSelection: (opt) => opt.text
    });
}

function formatResult (option) {
    if (!option.id) {
        return option.text;
    }
    let imagen = $(option.element).attr('data-imagen');
    let categoria = $(option.element).attr('data-categoria') ? `<tr><td>Categoría : <i>${$(option.element).attr('data-categoria')}</i></td></tr>` : '';
    let marca = $(option.element).attr('data-marca') !== 'default' ? `<tr><td>Marca : <i>${$(option.element).attr('data-marca')}</i></td></tr>` : '';
    let color = $(option.element).attr('data-color') !== 'default' ? `<tr><td>Color : <i>${$(option.element).attr('data-color')}</i></td></tr>` : '';
    let talla = $(option.element).attr('data-talla') !== 'default' ? `<tr><td>Talla : <i>${$(option.element).attr('data-talla')}</i></td></tr>` : '';
    let precio = `<tr><td>Precio : <i>${$(option.element).attr('data-precio')}</i></td></tr>`;

    let detalle = $(option.element).attr('data-detalle') != '' ? `<tr><td><p>${$(option.element).attr('data-detalle')}</p></td></tr>` : '';

    if(!imagen){
        return option.text;
    } else {                    
        return $option = $(`<span>
                            <table>
                                <tr>
                                    <td rowspan="7" style="width:150px"><img src="${imagen}" width="140px" /></td>
                                    <td><b style="font-size:20px">${option.text}</b></td>
                                </tr>
                                ${categoria}${marca}${precio}${color}${talla}${detalle}
                            </table>
                        </span>`);
    }
}
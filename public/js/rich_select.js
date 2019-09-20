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
    let categoria = $(option.element).attr('data-categoria');
    // let marca = $(option.element).attr('data-marca');
    let detalle = $(option.element).attr('data-detalle');

    if(!imagen){
        return option.text;
    } else {                    
        return $option = $(`<span>
                            <table>
                                <tr>
                                    <td rowspan="5" style="width:120px"><img src="${imagen}" width="100px" /></td>
                                    <td><b style="font-size:20px">${option.text}</b></td>
                                </tr>
                                <tr><td>Categoría : <i>${categoria ? categoria : 'No definida'}</i></td></tr>
                                <tr><td><p>${detalle ? detalle : 'Ninguna descripción'}</p></td></tr>
                            </table>
                        </span>`);
    }
}
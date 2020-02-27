$(document).ready(function () {
    
});

function rich_select_simple(id){
    $(`#${id}`).select2({
        placeholder: "Buscar item...",
        language: {
            inputTooShort: function (data) {
                return `Ingrese al menos ${data.minimum - data.input.length} caracteres`;
            }
        },
        quietMillis: 250,
        minimumInputLength: 2,
        templateResult: formatResult_simple,
        templateSelection: (opt) => opt.text
    });
}

function formatResult_simple(option) {
    if (!option.id) {
        return option.text;
    }
    let subtitle = $(option.element).attr('data-subtitle');
    return $option = $(`<b style="font-size:20px">${option.text}</b><br><small>${subtitle}</small>`);
}
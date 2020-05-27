$(document).ready(function(){

    $('#select-main-search').select2({
        placeholder: '<i class="fa fa-search"></i> Buscar...',
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
                return `/search/${escape(params.term)}`;
            },        
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        templateResult: formatResultLandingPage,
        // templateSelection: (opt) => opt.slug
    });

    // Realizar busqueda mediante el panel lateral
    $('.btn-search').click(function(e){
        let tipo = $(this).data('tipo');
        let id = $(this).data('id');
        $(`#form-search input[name="${tipo}_id"]`).val(id);
        $(`#form-search input[name="tipo_busqueda"]`).val('click');
        // document.form.submit();
        search(1);
        // return false;
    });

    // actualizar input de precios
    $('.input-price').change(function(){
        $(`#form-search input[name="min"]`).val($('#input-min').val());
        $(`#form-search input[name="max"]`).val($('#input-max').val());
    });
    $('.input-price').keyup(function(){
        $(`#form-search input[name="min"]`).val($('#input-min').val());
        $(`#form-search input[name="max"]`).val($('#input-max').val());
    });

    // Obtener datos de busqueda del menu lateral
    $('.input-search_navbar').keyup(async function(e){
        let valor = $(this).val();
        let placement = $(this).data('placement');
        $(`#${placement}`).html('');
        
        if(valor.length > 2){
            var resutl = await nav_search(valor);
            $(`#${placement}`).html('');
            resutl.map((item) => {
                $(`#${placement}`).append(`<li class="list-group-item"><a href="/detalle/${item.slug}" class="sv-phr">${item.nombre+' '+item.subcategoria}</a></li>`);
            });
        }
    });
});

function list(page, scroll = false){
    if(scroll){
        $('.main-loader').css('display', 'block');
    }
    $.get(`list?page=${page}`, function(res){
        $('#list-products').html(res);
        
        if(scroll){
            $('.main-loader').css('display', 'none');
            $("html,body").animate({scrollTop: $('#list-products').offset().top - 50}, 500);
        }
    });
}

function search(page, viewType = 'normal'){
    $(`#form-search input[name="page"]`).val(page);
    $(`#form-search input[name="view_type"]`).val(viewType);
    $('.main-loader').css('display', 'block');
    let min = $(`#form-search input[name="min"]`).val();
    let max = $(`#form-search input[name="max"]`).val();
    if(min!='' && max!=''){
        if(min>max){
            toastr.error('El rango de precios está mal ingresado.', 'Error');
            return 0;
        }
    }
    
    let datos = $('#form-search').serialize();
    $("html,body").animate({scrollTop: $('#contenido').offset().top - 50}, 500);
    $.ajax({
        // Se utiliza la ruta absoluta ya que no se puede usar sintaxis blade en archivos .js
        url: "/search",
        type: 'post',
        data: datos,
        success: function(data){
            $('#contenido').html(data);
            $('.main-loader').css('display', 'none');
        }
    });
}

// Agregar a carrito
function addCart(id){
    $.ajax({
        url: `/carrito/agregar/${id}`,
        type: 'get',
        success: function(data){
            if(data==1){
                count_cart();
                Toast.fire({
                    icon: 'success',
                    title: 'Producto agregado'
                })
            }else{
                // toastr.error('Ocurrio un error al agregar el productos.', 'Error');
            }
        }
    });
}

// Quitar del carrito
function cartRemove(id){
    $('[data-toggle="tooltip"]').tooltip('dispose');
    $.get(`/carrito/borrar/${id}`, function(data){
        if(data==1){
            $(`#tr-${id}`).remove();
            totalVenta();
            count_cart();
        }
    })
}

// Contador de productos en carrito
function count_cart(){
    $.ajax({
        url: `/carrito/cantidad_carrito`,
        type: 'get',
        success: function(data){
            $('#label-count-cart').html(data)
        }
    });
}


async function nav_search(dato){
    if(dato != ''){
        const response = await fetch(`/search/${dato}`);
        const data = await response.json();
        return data;
    }else{
        return null;
    }
}



// Buscar mediante rango de precio
$('#btn-price').click(function(){
    let min = $(`#form-search input[name="min"]`).val();
    let max = $(`#form-search input[name="max"]`).val();
    if(min!='' || max!=''){
        $(`#form-search input[name="tipo_busqueda"]`).val('click');
        search(1);
    }else{
        toastr.error('Debe ingresar al menos un dato en el rango de precios.', 'Error');
    }
});

// Calcular total
function totalVenta(){
    let total = 0;
    $(".input-subtotal").each(function() {
        total += parseFloat($(this).val());
    });
    $('#label-total').text(`${moneda} ${total.toFixed(2)}`);
    $('#input-importe').val(total);
}

// Cambiar cantidad de producto
function cambiarCantidad(tipo, id){
    let cantidad = parseFloat($(`#input-cantidad-${id}`).val());
    let precio = parseFloat($(`#input-precio-${id}`).val());
    let precio_envio = parseFloat($(`#input-costo_envio${id}`).val());
    
    if(tipo == 'sumar'){
        cantidad++;
        $(`#input-cantidad-${id}`).val(cantidad);
    }else{
        if(cantidad > 1){
            cantidad--;
            $(`#input-cantidad-${id}`).val(cantidad);
        }
    }
    
    let total = cantidad*(precio+precio_envio);

    $(`#label-cantidad-${id}`).text(` ${cantidad} `);
    $(`#input-subtotal-${id}`).val(total);
    $(`#label-subtotal-${id}`).text(`${moneda} ${parseFloat(total).toFixed(2)}`);
    totalVenta();

    $.get(`carrito/editar/${id}/${cantidad}`, function(data){});
}

function set_rate(rate){
    $('#label-set-rate').css('width', rate+'%');
    $('#input-puntos').val(rate);
    $.post($('#form-rating').attr('action'), $('#form-rating').serialize(), (res)=>{
        if(res){
            console.log(res)
            $('[data-toggle="popover"]').popover('hide');
            $('#btn-rating').css('display', 'none');
            try {
                Toast.fire({
                    icon: 'success',
                    title: 'Gracias por su calificación'
                })
                $('#label-current-rate').css('width', rate+'%');
            } catch (error) {}
        }else{
            try {
                Toast.fire({
                    icon: 'error',
                    title: 'Ocurrió un error inesperado'
                })
            } catch (error) {}
        }
        
    })
}
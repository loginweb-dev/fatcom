$(document).ready(function(){
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

function search(page){
    $(`#form-search input[name="page"]`).val(page);
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

// Agregar producto al carrito
// se recibe el id del producto y el callback de la respuesta
function addCart(producto_id, callback){
    $.get(`/carrito/agregar/${producto_id}`, callback);
}

// Agregar a carrito
function cartAdd(id){
    $.ajax({
        url: `/carrito/agregar/${id}`,
        type: 'get',
        success: function(data){
            if(data==1){
                ohSnap('<span class="fa fa-check fa-2x"></span> Producto agregar al carrito.', {color: 'green'});
                count_cart();
                try {
                    toastr.info('Producto agregado al carrito.', 'Información');
                } catch (error) {}
            }else{
                ohSnap('<span class="fa fa-remove"></span> Ocurrio un error inesperado', {color: 'red'});
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
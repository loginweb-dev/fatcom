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
        quietMillis: 250,
        minimumInputLength: 2,
        templateResult: formatResultAdmin,
        templateSelection: (opt) => opt.text
    });
}

function formatResultAdmin (option) {
    if (!option.id) {
        return option.text;
    }
    let imagen = $(option.element).attr('data-imagen');
    let subcategoria = $(option.element).attr('data-subcategoria') ? `<tr><td>Subcategoría : <i>${$(option.element).attr('data-categoria')}</i></td></tr>` : '';
    let marca = $(option.element).attr('data-marca') !== 'default' ? `<tr><td>Marca : <i>${$(option.element).attr('data-marca')}</i></td></tr>` : '';
    let color = $(option.element).attr('data-color') !== 'default' ? `<tr><td>Color : <i>${$(option.element).attr('data-color')}</i></td></tr>` : '';
    let talla = $(option.element).attr('data-talla') !== 'default' ? `<tr><td>Talla : <i>${$(option.element).attr('data-talla')}</i></td></tr>` : '';
    let precio = `<tr><td>Precio : <i>${$(option.element).attr('data-precio')}</i></td></tr>`;

    let detalle = $(option.element).attr('data-detalle') != '' ? `<tr><td><p>${$(option.element).attr('data-detalle')}</p></td></tr>` : '';

    if(!imagen){
        return option.text;
    } else {                    
        return $option = $(`<span>
                            <table style="border-spacing: 5px;border-collapse: separate">
                                <tr>
                                    <td rowspan="7"><img src="${imagen}" height="120px" /></td>
                                    <td><b style="font-size:20px">${option.text}</b></td>
                                </tr>
                                ${subcategoria}${marca}${precio}${color}${talla}${detalle}
                            </table>
                        </span>`);
    }
}

function formatResultLandingPage(option){
    // Si está cargando mostrar texto de carga
    if (option.loading) {
        return '<span class="text-center"><i class="fas fa-spinner fa-spin"></i> Buscando...</span>';
    }
    
    // Mostrar las opciones encontradas
    return $(`<span>
                <a href="/detalle/${option.slug}">
                    <article class="card card-product-list mb-0 mt-0">
                        <div class="card-body">
                            <div class="row">
                                <aside class="col-sm-2 p-0">
                                    <img src="${option.imagen ? '/storage/'+option.imagen.replace('.', '_small.') : '/img/default.png'}" width="100%" />
                                </aside>
                                <div class="col-sm-10">
                                    <b class="text-dark">${option.nombre}</b>
                                    <div class="d-flex">
                                        <div class="price-wrap mr-4 text-dark">
                                            <b>Bs. ${option.precio_venta}</b>	
                                        </div>
                                        <div class="rating-wrap">
                                            <ul class="rating-stars">
                                                <li style="width:${option.puntos*20}%" class="stars-active"> 
                                                    <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                                    <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                                    <i class="fa fa-star"></i> 
                                                </li>
                                                <li>
                                                    <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                                    <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                                                    <i class="fa fa-star"></i> 
                                                </li>
                                            </ul>
                                            <small class="label-rating text-muted">${option.vistas} Vistas</small>
                                        </div>
                                    </div>
                                    <small class="text-dark">${option.descripcion_small.substr(0, 170)}...</small>
                                </div>
                            </div>
                        </div>
                    </article>
                </a>
            </span>`);
}

function formatResultCustomers(option){
    // Si está cargando mostrar texto de carga
    if (option.loading) {
        return '<span class="text-center"><i class="fas fa-spinner fa-spin"></i> Buscando...</span>';
    }
    
    // Mostrar las opciones encontradas
    return $(`<span>
                    <div class="row">
                        <div class="col-sm-10" style="margin:0px">
                            <b class="text-dark">${option.razon_social}</b><br>
                            ${option.nit ? option.nit : 'Sin NIT'}
                        </div>
                    </div>
            </span>`);
}
$(document).ready(function(){

    // Cambiar tipo de entrega (Recoger/A domicilio)
    $('.link-tab').click(function(){
        let tipo_entrega =$(this).data('value');
        $('#input-tipo_entrega').val(tipo_entrega);
        if(tipo_entrega=='tienda'){
            $('#form_carrito input[name=sucursal_id]').val($('input:radio[name=input-radio_sucursal]:checked').val());
            $('#form_carrito input[name=venta_tipo_id]').val(2);
        }else{
            $('#form_carrito input[name=sucursal_id]').val(0);
            $('#form_carrito input[name=venta_tipo_id]').val(3);
        }
    });
});

var map;
var marcador;

function inicializarMapa(map, marcador){
    map = L.map('map').fitWorld();
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 20,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox.streets'
    }).addTo(map);

    // Obtener coordenadas de ubicaciones antiguas
    $('.btn-coor').click(function(){
        map.removeLayer(marcador);
        let id = $(this).data('id');
        let lat = $(this).data('lat');
        let lon = $(this).data('lon');
        let descripcion = $(this).data('descripcion');

        $('#input-coordenada_id').val(id);
        $('#input-descripcion').val(descripcion)
        $('#latitud').val(lat);
        $('#longitud').val(lon);

        marcador = L.marker([lat, lon], {
                        draggable: true
                    }).addTo(map)
                    .bindPopup(descripcion).openPopup()
                    .on('drag', function(e) {
                        $('#latitud').val(e.latlng.lat);
                        $('#longitud').val(e.latlng.lng);
                        $('#input-coordenada_id').val('');
                        $('#input-descripcion').val('')
                    });;
        map.setView([lat, lon]);
    });

    // Obtener licalizacion actual del usuario y setear su latitud y longitud
    function onLocationFound(e) {
        $('#latitud').val(e.latlng.lat);
        $('#longitud').val(e.latlng.lng);
        marcador =  L.marker(e.latlng, {
                    draggable: true
                }).addTo(map)
                .bindPopup("Localización actual").openPopup()
                .on('drag', function(e) {
                    $('#latitud').val(e.latlng.lat);
                    $('#longitud').val(e.latlng.lng);
                    $('#input-coordenada_id').val('');
                    $('#input-descripcion').val('')
                });
        map.setView(e.latlng);
    }

    function onLocationError(e) {
        alert(e.message);
    }

    map.on('locationfound', onLocationFound);
    map.on('locationerror', onLocationError);

    map.locate();
    map.setZoom(13);
}


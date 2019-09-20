<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
# Socialite facebook
Route::get('/login/facebook', 'Auth\LoginController@redirectToFacebookProvider');
Route::get('/login/facebook/callback', 'Auth\LoginController@handleProviderFacebookCallback');
# End Socialite facebook

# Socialite google
Route::get('/login/google', 'Auth\LoginController@redirectToGoogleProvider');
Route::get('/login/google/callback', 'Auth\LoginController@handleProviderGoogleCallback');
# End Socialite google

Route::get('/policies', 'LandingPageController@ecommerce_policies');

// Perfil de ususario
Route::get('/profile', 'LandingPageController@profile')->name('profile');
Route::post('/profile/update', 'LandingPageController@profile_update')->name('profile_update');

// ================================Ecommerce===========================
Route::get('/', 'LandingPageController@index')->name('ecommerce_home');
Route::get('/detalle/{producto}', 'LandingPageController@detalle_producto')->name('detalle_producto_ecommerce');
Route::post('/search', 'LandingPageController@search')->name('busqueda_ecommerce');
Route::get('/ofertas', 'LandingPageController@ofertas')->name('ofertas_ecommerce');
Route::get('/subcategoria/{subcategoria}', 'LandingPageController@subcategorias')->name('subcategorias_ecommerce');
Route::get('/carrito', 'LandingPageController@carrito_index')->name('carrito_compra');
Route::get('/carrito/get_precio/{id}/{cantidad}', 'LandingPageController@get_precio');
Route::get('/carrito/cantidad_carrito', 'LandingPageController@cantidad_carrito')->name('cantidad_carrito');
Route::get('/carrito/agregar/comprar/{id}', 'LandingPageController@carrito_comprar');
Route::get('/carrito/agregar/{id}', 'LandingPageController@carrito_agregar');
Route::get('/carrito/borrar/{id}', 'LandingPageController@carrito_borrar');
Route::get('/carrito/cantidad_pedidos', 'LandingPageController@cantidad_pedidos')->name('cantidad_pedidos');
Route::get('/carrito/mis_pepdidos/{id}', 'LandingPageController@pedidos_index')->name('pedidos_index');
Route::get('/carrito/mis_pepdidos/get_estado_pedido/{id}', 'LandingPageController@get_estado_pedido');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// ================================Sucursales===========================
Route::get('admin/sucursales', 'SucursalesController@index')->name('sucursales_index');
Route::get('admin/sucursales/buscar/{value}', 'SucursalesController@search');
Route::get('admin/sucursales/ver/{id}', 'SucursalesController@view')->name('sucursales_view');
Route::get('admin/sucursales/crear', 'SucursalesController@create')->name('sucursales_create');
Route::post('admin/sucursales/guardar', 'SucursalesController@store')->name('sucursales_store');
Route::get('admin/sucursales/editar/{id}', 'SucursalesController@edit')->name('sucursales_edit');
Route::post('admin/sucursales/actualizar', 'SucursalesController@update')->name('sucursales_update');
Route::post('admin/sucursales/eliminar/', 'SucursalesController@delete')->name('sucursales_delete');

Route::get('admin/sucursales/cambiar/{id}', 'SucursalesController@sucursal_actual');

// ================================Depositos===========================
Route::get('admin/depositos', 'DepositosController@index')->name('depositos_index');
Route::get('admin/depositos/buscar/{value}', 'DepositosController@search');
Route::get('admin/depositos/ver/{id}', 'DepositosController@view')->name('depositos_view');
Route::get('admin/depositos/ver/{id}/buscar/{value}', 'DepositosController@view_search');
Route::get('admin/depositos/crear', 'DepositosController@create')->name('depositos_create');
Route::post('admin/depositos/guardar', 'DepositosController@store')->name('depositos_store');
Route::get('admin/depositos/editar/{id}', 'DepositosController@edit')->name('depositos_edit');
Route::post('admin/depositos/actualizar', 'DepositosController@update')->name('depositos_update');
Route::post('admin/depositos/eliminar/', 'DepositosController@delete')->name('depositos_delete');

Route::get('admin/depositos/producto/agregar/{id}', 'DepositosController@create_producto')->name('depositos_create_producto');
Route::post('admin/depositos/producto/store', 'DepositosController@store_producto')->name('depositos_store_producto');

// ================================Productos===========================
Route::get('admin/productos', 'ProductosController@index')->name('productos_index');
Route::get('admin/productos/lista/{categoria}/{subcategoria}/{marca}/{talla}/{genero}/{color}', 'ProductosController@productos_list');
Route::get('admin/productos/buscar/{value}', 'ProductosController@search');
Route::get('admin/productos/ver/{id}', 'ProductosController@view')->name('productos_view');
Route::get('admin/productos/ver/informacion/{id}', 'ProductosController@view_simple');
Route::get('admin/productos/crear', 'ProductosController@create')->name('productos_create');
Route::get('admin/productos/copiar/{id}', 'ProductosController@copy')->name('productos_copy');
Route::post('admin/productos/guardar', 'ProductosController@store')->name('productos_store');
Route::get('admin/productos/editar/{id}', 'ProductosController@edit')->name('productos_edit');
Route::post('admin/productos/actualizar', 'ProductosController@update')->name('productos_update');
Route::post('admin/productos/eliminar/', 'ProductosController@delete')->name('productos_delete');
Route::post('admin/productos/puntuar/', 'ProductosController@puntuar')->name('productos_puntuar');

Route::get('admin/productos/get_producto/{id}', 'ProductosController@get_producto');
Route::get('admin/productos/cambiar_imagen_principal/{producto_id}/{imagen_id}', 'ProductosController@cambiar_imagen');
Route::post('admin/productos/eliminar_imagen', 'ProductosController@delete_imagen')->name('delete_imagen');

// Obtener datos varios
Route::get('admin/productos/obtener/precios_venta/{id}', 'ProductosController@obtener_precios_venta');

// Filtros
Route::get('admin/productos/list/subcategorias/{categoria_id}', 'ProductosController@subcategorias_list');
Route::get('admin/productos/list/marcas/{subcategoria_id}', 'ProductosController@marcas_list');
Route::get('admin/productos/list/tallas/{subcategoria_id}/{marca_id}', 'ProductosController@tallas_list');
Route::get('admin/productos/list/generos/{subcategoria_id}/{marca_id}/{talla_id}', 'ProductosController@generos_list');
Route::get('admin/productos/list/colores/{subcategoria_id}/{marca_id}/{talla_id}/{genero_id}', 'ProductosController@colores_list');

Route::get('admin/ofertas/filtros/filtro_simple/{tipo}/{categoria}/{subcategoria}/{marca}/{talla}/{genero}/{color}', 'ProductosController@filtro_simple');


// Llamadas a vistas para cargar el modal de nuevo registro
Route::get('admin/productos/crear/agregar/{vista}', 'ProductosController@cargar_vista');


// ================================Subcategorias===========================
Route::get('admin/subcategorias/create_new/{value}', 'SubcategoriasController@create_new');

// ================================Marcas===========================
Route::get('admin/marcas/list/subcategoria/{id}', 'MarcasController@marcas_list');

// ================================Ofertas===========================
Route::get('admin/ofertas', 'OfertasController@index')->name('ofertas_index');
Route::get('admin/ofertas/buscar/{value}', 'OfertasController@search');
Route::get('admin/ofertas/ver/{id}', 'OfertasController@view')->name('ofertas_view');
Route::get('admin/ofertas/crear', 'OfertasController@create')->name('ofertas_create');
Route::post('admin/ofertas/guardar', 'OfertasController@store')->name('ofertas_store');
Route::get('admin/ofertas/editar/{id}', 'OfertasController@edit')->name('ofertas_edit');
Route::post('admin/ofertas/actualizar', 'OfertasController@update')->name('ofertas_update');
Route::post('admin/ofertas/eliminar/', 'OfertasController@delete')->name('ofertas_delete');

// ================================Ecommerce===========================
Route::get('admin/ecommerce', 'EcommerceController@index')->name('ecommerce_index');
Route::get('admin/ecommerce/buscar/{value}', 'EcommerceController@search');
Route::get('admin/ecommerce/ver/{id}', 'EcommerceController@view')->name('ecommerce_view');
Route::get('admin/ecommerce/crear', 'EcommerceController@create')->name('ecommerce_create');
Route::post('admin/ecommerce/guardar', 'EcommerceController@store')->name('ecommerce_store');
Route::get('admin/ecommerce/editar/{id}', 'EcommerceController@edit')->name('ecommerce_edit');
Route::post('admin/ecommerce/actualizar', 'EcommerceController@update')->name('ecommerce_update');
Route::post('admin/ecommerce/eliminar/', 'EcommerceController@delete')->name('ecommerce_delete');

// Filtros
Route::get('admin/ecommerce/filtros/filtro_simple/{categoria}/{subcategoria}/{marca}', 'EcommerceController@filtro_simple');

// =============================Cajas======================================
Route::get('/admin/cajas', 'CajasController@cajas_index')->name('cajas_index');
Route::get('/admin/cajas/buscar/{valor}', 'CajasController@cajas_buscar');
Route::get('admin/cajas/ver/{id}', 'CajasController@cajas_view')->name('cajas_view');
Route::get('/admin/cajas/crear', 'CajasController@cajas_create')->name('cajas_create');
Route::post('/admin/cajas/store', 'CajasController@cajas_store')->name('cajas_store');
Route::post('/admin/cajas/close', 'CajasController@cajas_close')->name('cajas_close');
Route::get('/admin/cajas/generar/pdf/{id}', 'CajasController@cajas_generarPDF')->name('cajas_generarPDF');

// Asientos
Route::get('/admin/asientos', 'CajasController@asientos_index')->name('asientos_index');
Route::get('/admin/asientos/buscar/{valor}', 'CajasController@asientos_buscar');
Route::get('/admin/asientos/crear', 'CajasController@asientos_create')->name('asientos_create');
Route::post('/admin/asientos/store', 'CajasController@asientos_store')->name('asientos_store');
Route::post('/admin/asientos/delete', 'CajasController@asientos_delete')->name('asientos_delete');


// ================================Compras===========================
Route::get('admin/compras', 'ComprasController@index')->name('compras_index');
Route::get('admin/compras/crear', 'ComprasController@create')->name('compras_create');
Route::post('admin/compras/store', 'ComprasController@store')->name('compras_store');

Route::get('admin/proveedores/get_proveedor/{nit}', 'ProveedoresController@get_proveedor');

// Cambiar tipo de compra
Route::get('admin/compras/crear/{tipo}', 'ComprasController@compras_cargar_tipo');

// ============================Ventas====================================
Route::get('admin/ventas', 'VentasController@index')->name('ventas_index');
Route::get('admin/ventas/buscar/{value}', 'VentasController@search')->name('ventas_search');
Route::get('admin/ventas/ver/{id}', 'VentasController@view')->name('ventas_view');
Route::get('admin/ventas/crear', 'VentasController@create')->name('ventas_create');
Route::post('admin/ventas/store', 'VentasController@store')->name('ventas_store');
Route::post('admin/ventas/delete', 'VentasController@delete')->name('venta_delete');
Route::get('admin/ventas/update/estado/{id}/{valor}', 'VentasController@estado_update')->name('estado_update');
Route::post('admin/ventas/asignar_repartidor', 'VentasController@asignar_repartidor')->name('asignar_repartidor');
Route::get('admin/ventas/get_ubicaciones_cliente/{id}', 'VentasController@get_ubicaciones_cliente');
Route::get('admin/ventas/detalles/{id}', 'VentasController@ventas_details');

// Ventas a crédito
Route::get('admin/ventas/credito', 'VentasController@ventas_credito_index')->name('ventas_credito_index');
Route::get('admin/ventas/credito/buscar/{value}', 'VentasController@ventas_credito_search');
Route::post('admin/ventas/credito/store', 'VentasController@ventas_credito_store')->name('ventas_credito_store');
Route::get('admin/ventas/credito/detalles/{id}', 'VentasController@ventas_credito_details');

// Proformas
Route::get('admin/proformas', 'VentasController@proformas_index')->name('proformas_index');
Route::get('admin/proformas/buscar/{value}', 'VentasController@proformas_search');
Route::get('admin/proformas/crear', 'VentasController@proformas_create')->name('proformas_create');
Route::post('admin/proformas/store', 'VentasController@proformas_store')->name('proformas_store');
Route::get('admin/proformas/impresion/{tipo}/{id}', 'VentasController@proformas_print');
Route::get('admin/proformas/detalle/{id}', 'VentasController@proformas_detalle');

Route::get('admin/ventas/lista_nuevos_pedidos/{last}', 'VentasController@get_nuevos_pedidos');
Route::get('admin/ventas/crear/productos_search', 'VentasController@productos_search');
Route::get('admin/ventas/crear/ventas_categorias/{id}', 'VentasController@ventas_categorias');
Route::get('admin/ventas/crear/ventas_productos_categorias/{id}', 'VentasController@ventas_productos_categorias');

// ============================Dosificacion====================================
Route::get('admin/dosificaciones', 'DosificacionesController@index')->name('dosificaciones_index');
Route::get('admin/dosificaciones/view/{id}', 'DosificacionesController@view')->name('dosificaciones_view');
Route::get('admin/dosificaciones/crear', 'DosificacionesController@create')->name('dosificaciones_create');
Route::post('admin/dosificaciones/store', 'DosificacionesController@store')->name('dosificaciones_store');
Route::get('admin/dosificaciones/editar/{id}', 'DosificacionesController@edit')->name('dosificaciones_edit');
Route::post('admin/dosificaciones/update', 'DosificacionesController@update')->name('dosificaciones_update');
Route::post('admin/dosificaciones/delete', 'DosificacionesController@delete')->name('dosificaciones_delete');

// =========================Código de control===========================
Route::get('admin/codigo_control', 'FacturasController@codigo_control_index')->name('codigo_control_index');
Route::post('admin/generar_codigo_control', 'FacturasController@codigo_control')->name('generar_codigo_control');
Route::get('admin/venta/impresion/{tipo}/{id}', 'VentasController@ventas_print');
// Route::get('admin/factura/cambiar_tipo/{tipo}/{id}', 'VentasController@cambiar_tipo_factura');

// Pedidos
Route::post('admin/ventas/pedidos/store', 'VentasController@pedidos_store')->name('pedidos_store');
Route::get('pedidos/success', 'VentasController@pedidos_success')->name('pedidos_success');

// ============================Delivery====================================
Route::get('admin/administracion/delivery', 'VentasController@delivery_admin_index')->name('delivery_admin_index');
Route::get('admin/administracion/delivery/detalle/{id}', 'VentasController@delivery_admin_view')->name('delivery_admin_view');
Route::get('admin/administracion/delivery/close/{id}', 'VentasController@delivery_admin_close')->name('delivery_admin_close');

// Opciones del repartidor
Route::get('admin/repartidor/delivery', 'VentasController@delivery_index')->name('delivery_index');
Route::get('admin/repartidor/delivery/buscar/{value}', 'VentasController@delivery_search');
Route::get('admin/repartidor/delivery/view/{id}', 'VentasController@delivery_view')->name('delivery_view');
Route::get('admin/repartidor/delivery/close/{id}', 'VentasController@delivery_close')->name('delivery_close');
Route::get('admin/repartidor/delivery/set_ubicacion/{id}/{lat}/{lon}', 'VentasController@set_ubicacion');
Route::get('admin/repartidor/delivery/get_ubicacion/{id}', 'VentasController@get_ubicacion');


// ============================Clientes====================================
Route::get('admin/clientes', 'ClientesController@index')->name('clientes_index');
Route::get('admin/clientes/buscar/{value}', 'ClientesController@search')->name('clientes_search');
Route::get('admin/clientes/crear', 'ClientesController@create')->name('clientes_create');
Route::post('admin/clientes/store', 'ClientesController@store')->name('clientes_store');
Route::get('admin/clientes/editar/{id}', 'ClientesController@edit')->name('clientes_edit');
Route::post('admin/clientes/update', 'ClientesController@update')->name('clientes_update');

Route::get('admin/clientes/lista', 'ClientesController@clientes_list')->name('clientes_list');
Route::get('admin/clientes/datos/{id}', 'ClientesController@get_cliente')->name('get_cliente');
Route::post('admin/clientes/ventas/create', 'ClientesController@createUserFromVentas');

// ============================Empleados====================================
Route::get('admin/empleados', 'EmpleadosController@index')->name('empleados_index');
Route::get('admin/empleados/buscar/{value}', 'EmpleadosController@search')->name('empleados_search');
Route::get('admin/empleados/crear', 'EmpleadosController@create')->name('empleados_create');
Route::post('admin/empleados/store', 'EmpleadosController@store')->name('empleados_store');
Route::get('admin/empleados/editar/{id}', 'EmpleadosController@edit')->name('empleados_edit');
Route::post('admin/empleados/update', 'EmpleadosController@update')->name('empleados_update');
Route::post('admin/empleados/delete', 'EmpleadosController@delete')->name('empleados_delete');

// ============================Reportes============================
// Graficos
Route::get('admin/reportes/graficos', 'ReportesController@graficos_index')->name('graficos_index');
Route::post('admin/reportes/graficos/generar', 'ReportesController@graficos_generar')->name('graficos_generar');


// Clear cache
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "La cache del sistema está limpia";
});

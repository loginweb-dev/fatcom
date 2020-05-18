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
Route::get('/detalle/producto/get_producto/{id}', 'LandingPageController@get_producto');
Route::post('/search', 'LandingPageController@search')->name('busqueda_ecommerce');
Route::get('/search/{value}', 'LandingPageController@search_product');
Route::get('/ofertas', 'LandingPageController@ofertas')->name('ofertas_ecommerce');
Route::get('/subcategoria/{subcategoria}', 'LandingPageController@subcategorias')->name('subcategorias_ecommerce');
Route::get('/carrito', 'LandingPageController@carrito_index')->name('carrito_compra');
Route::get('/carrito/get_precio/{id}/{cantidad}', 'LandingPageController@get_precio');
Route::get('/carrito/cantidad_carrito', 'LandingPageController@cantidad_carrito')->name('cantidad_carrito');
Route::get('/carrito/agregar/comprar/{id}', 'LandingPageController@carrito_comprar');
Route::get('/carrito/agregar/{id}', 'LandingPageController@carrito_agregar');
Route::get('/carrito/editar/{id}/{cantidad}', 'LandingPageController@carrito_editar');
Route::get('/carrito/borrar/{id}', 'LandingPageController@carrito_borrar');
Route::get('/carrito/cantidad_pedidos', 'LandingPageController@cantidad_pedidos')->name('cantidad_pedidos');
Route::get('/carrito/pedidos/{id}', 'LandingPageController@pedidos_index')->name('pedidos_index');

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

Route::get('admin/sucursales/cambiar/{route}/{id}', 'SucursalesController@sucursal_actual');

// ================================Depositos===========================
Route::get('admin/depositos', 'DepositosController@index')->name('depositos_index');
Route::get('admin/depositos/buscar/{value}', 'DepositosController@search');
Route::get('admin/depositos/ver/{id}', 'DepositosController@view')->name('depositos_view');
Route::get('admin/depositos/ver/list/{type}/{id}/{search?}', 'DepositosController@view_list');
Route::get('admin/depositos/crear', 'DepositosController@create')->name('depositos_create');
Route::post('admin/depositos/guardar', 'DepositosController@store')->name('depositos_store');
Route::get('admin/depositos/editar/{id}', 'DepositosController@edit')->name('depositos_edit');
Route::post('admin/depositos/actualizar', 'DepositosController@update')->name('depositos_update');
Route::post('admin/depositos/eliminar/', 'DepositosController@delete')->name('depositos_delete');

Route::post('admin/depositos/extras/registro', 'DepositosController@registro_extra')->name('deposito_registro_extra');
Route::post('admin/depositos/insumos/registro', 'DepositosController@registro_insumo')->name('deposito_registro_insumo');
Route::post('admin/depositos/items/traspasar', 'DepositosController@traspaso_items')->name('deposito_traspaso_items');
Route::get('admin/depositos/producto/agregar/{id}', 'DepositosController@create_producto')->name('depositos_create_producto');
Route::post('admin/depositos/producto/store', 'DepositosController@store_producto')->name('depositos_store_producto');
Route::post('admin/depositos/producto/update', 'DepositosController@update_producto')->name('depositos_update_producto');
Route::post('admin/depositos/producto/delete', 'DepositosController@delete_producto')->name('depositos_delete_producto');

// ================================Productos===========================
Route::get('admin/productos', 'ProductosController@index')->name('productos_index');
Route::get('admin/productos/lista/{categoria}/{subcategoria}/{marca}/{talla}/{genero}/{color}/{search}', 'ProductosController@productos_list');
Route::get('admin/productos/buscar/{value}', 'ProductosController@search');
Route::get('admin/productos/ver/{id}', 'ProductosController@view')->name('productos_view');
Route::get('admin/productos/ver/informacion/{id}', 'ProductosController@view_simple');
Route::get('admin/productos/crear', 'ProductosController@create')->name('productos_create');
Route::post('admin/productos/copiar', 'ProductosController@copy')->name('productos_copy');
Route::post('admin/productos/guardar', 'ProductosController@store')->name('productos_store');
Route::get('admin/productos/editar/{id}', 'ProductosController@edit')->name('productos_edit');
Route::post('admin/productos/actualizar', 'ProductosController@update')->name('productos_update');
Route::post('admin/productos/actualizar/stock', 'ProductosController@update_stock')->name('productos_update_stock');
Route::post('admin/productos/eliminar/', 'ProductosController@delete')->name('productos_delete');
Route::post('admin/productos/puntuar/', 'ProductosController@puntuar')->name('productos_puntuar');
Route::post('admin/productos/imprimir/codigo_barras', 'ProductosController@imprimir_codigo_barras')->name('imprimir_codigo_barras');
Route::get('admin/productos/catalogo/generar/{inicio}/{cantidad}', 'ProductosController@generar_catalogo')->name('generar_catalogo');

Route::get('admin/productos/get_producto/{id}', 'ProductosController@get_producto');
Route::get('admin/productos/lista_imagenes/{id}', 'ProductosController@lista_imagenes');
Route::post('admin/productos/add_imagen/{id}', 'ProductosController@add_imagen')->name('add_images_product');
Route::get('admin/productos/cambiar_imagen_principal/{producto_id}/{imagen_id}', 'ProductosController@cambiar_imagen');
Route::post('admin/productos/eliminar_imagen', 'ProductosController@delete_imagen')->name('delete_imagen');

// Obtener datos varios
Route::get('admin/productos/obtener/precios_venta/{id}', 'ProductosController@obtener_precios_venta');
Route::get('admin/productos/obtener/codigo_interno/{id}', 'ProductosController@ultimo_codigo_interno');

// Lista de sub categorías de una categoría
Route::get('admin/productos/list/subcategorias/categoria/{categoria_id}', 'ProductosController@subcategorias_categoria');

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
Route::get('admin/compras/{id}/ver', 'ComprasController@read')->name('compras_read');

Route::get('admin/proveedores/get_proveedor/{nit}', 'ProveedoresController@get_proveedor');

// Cambiar tipo de compra
Route::get('admin/compras/crear/{tipo}', 'ComprasController@compras_cargar_tipo');

// ============================Ventas====================================
Route::get('admin/ventas', 'VentasController@index')->name('ventas_index');
Route::get('admin/ventas/lista/{sucursal_id}/{search}', 'VentasController@ventas_list');
Route::get('admin/ventas/ver/{id}', 'VentasController@view')->name('ventas_view');
Route::get('admin/ventas/crear', 'VentasController@create')->name('ventas_create');
Route::post('admin/ventas/store', 'VentasController@store')->name('ventas_store');
Route::post('admin/ventas/change/type', 'VentasController@convertir_factura')->name('convertir_factura');
Route::post('admin/ventas/delete', 'VentasController@delete')->name('venta_delete');
Route::get('admin/ventas/update/estado/{id}/{valor}', 'VentasController@estado_update')->name('estado_update');
Route::post('admin/ventas/asignar_repartidor', 'VentasController@asignar_repartidor')->name('asignar_repartidor');
Route::get('admin/ventas/get_ubicaciones_cliente/{id}', 'VentasController@get_ubicaciones_cliente');
Route::get('admin/ventas/detalles/{id}', 'VentasController@ventas_details');
Route::get('admin/ventas/get_producto/bar_code/{code}', 'VentasController@productos_search_barcode');

Route::get('admin/ventas/tickets','VentasController@tickets_index')->name('tickets_index');
Route::get('admin/ventas/tickets/list','VentasController@tickets_list');
Route::get('admin/ventas/cocina','VentasController@cocina_index')->name('cocina.index');
Route::get('admin/ventas/cocina/list','VentasController@cocina_list')->name('cocina.list');
Route::get('admin/ventas/lista/{id}','VentasController@pedido_listo');

// Obtener publicaciones
Route::get('admin/ventas/tickets/posts','VentasController@get_posts');

// Obtener productos disponibles en la sucursal
Route::get('admin/ventas/productos/{categoria}/{subcategoria}/{marca}/{talla}/{genero}/{color}', 'VentasController@filtro_productos_disponibles');

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
Route::get('admin/proformas/impresion/{tipo}/{id}/{pdf?}', 'VentasController@proformas_print');
Route::get('admin/proformas/detalle/{id}', 'VentasController@proformas_detalle');

// Hojas de trabajo
Route::get('admin/hojastrabajo', 'VentasController@hojas_trabajos_index')->name('hojas_trabajos_index');
Route::get('admin/hojastrabajo/buscar/{value}', 'VentasController@hojas_trabajos_search');
Route::get('admin/hojastrabajo/crear', 'VentasController@hojas_trabajos_create')->name('hojas_trabajos_create');
Route::post('admin/hojastrabajo/store', 'VentasController@hojas_trabajos_store')->name('hojas_trabajos_store');
Route::get('admin/hojastrabajo/impresion/{id}', 'VentasController@hojas_trabajos_print');
Route::get('admin/hojastrabajo/detalle/{id}', 'VentasController@hojas_trabajos_details')->name('hojas_trabajos_details');
Route::post('admin/hojastrabajo/cerrar', 'VentasController@hojas_trabajos_close')->name('hojas_trabajos_close');

Route::get('admin/ventas/crear/productos_search', 'VentasController@productos_search');
Route::get('admin/ventas/crear/ventas_categorias/{id}', 'VentasController@ventas_categorias');
Route::get('admin/ventas/crear/ventas_productos_categorias/{id}', 'VentasController@ventas_productos_categorias');
Route::get('admin/ventas/crear/extras_producto/{id}/{sucursal_id}', 'VentasController@extras_producto');

// libros
Route::get('admin/reporte/ventas/libro', 'VentasController@ventas_libro')->name('ventas_libro');
Route::post('admin/reporte/ventas/libro/generar', 'VentasController@ventas_libro_generar')->name('ventas_libro_generar');
Route::get('admin/reporte/ventas/libro/generar/excel/{mes}/{anio}', 'VentasController@ventas_libro_generar_excel');
Route::get('admin/reporte/ventas/libro/generar/pdf/{mes}/{anio}', 'VentasController@ventas_libro_generar_pdf');
// formularios
Route::get('admin/reporte/ventas/formulario/200/pdf/{mes}/{anio}', 'VentasController@ventas_formulario_200_pdf');
Route::get('admin/reporte/ventas/formulario/400/pdf/{mes}/{anio}', 'VentasController@ventas_formulario_400_pdf');

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
Route::post('admin/administracion/delivery/close', 'VentasController@delivery_admin_close')->name('delivery_admin_close');

// Opciones del repartidor
Route::get('admin/repartidor/delivery', 'VentasController@delivery_index')->name('delivery_index');
Route::get('admin/repartidor/delivery/buscar/{value}', 'VentasController@delivery_search');
Route::get('admin/repartidor/delivery/view/{id}', 'VentasController@delivery_view')->name('delivery_view');
Route::get('admin/repartidor/delivery/close/{id}', 'VentasController@delivery_close')->name('delivery_close');
Route::get('admin/repartidor/delivery/set_ubicacion/{id}/{lat}/{lon}', 'VentasController@set_ubicacion');
// Route::get('admin/repartidor/delivery/get_ubicacion/{id}', 'VentasController@get_ubicacion');

// ============================Clientes====================================
Route::get('admin/clientes', 'ClientesController@index')->name('clientes_index');
Route::get('admin/clientes/buscar/{value}', 'ClientesController@search')->name('clientes_search');
Route::get('admin/clientes/crear', 'ClientesController@create')->name('clientes_create');
Route::post('admin/clientes/store', 'ClientesController@store')->name('clientes_store');
Route::get('admin/clientes/editar/{id}', 'ClientesController@edit')->name('clientes_edit');
Route::post('admin/clientes/update', 'ClientesController@update')->name('clientes_update');

Route::get('admin/clientes/lista', 'ClientesController@clientes_list')->name('clientes_list');
Route::get('admin/clientes/datos/{type}/{id}', 'ClientesController@get_cliente')->name('get_cliente');
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

Route::get('admin/reportes/ventas', 'ReportesController@ventas_reporte')->name('ventas_reporte');
Route::post('admin/reportes/ventas/generar', 'ReportesController@ventas_reporte_generar')->name('ventas_reporte_generar');

Route::get('admin/reportes/ganancia_producto', 'ReportesController@ganancia_producto_reporte')->name('ganancia_producto_reporte');
Route::post('admin/reportes/ganancia_producto/generar', 'ReportesController@ganancia_producto_reporte_generar')->name('ganancia_producto_reporte_generar');
Route::get('admin/reportes/productos/escasez', 'ReportesController@productos_escasez')->name('productos_escasez');

// Creación de parametros
Route::get('admin/productos/parametros/store/{type}/{value}', 'ProductosController@crear_parametros');
// Se debe crear una ruta exclusiva para crear sub categoría debido a que necesita la llave foranea de categoría
Route::get('admin/productos/subcategoria/store/{categoria_id}/{value}', 'ProductosController@crear_subcategoria');

// Clear cache
Route::get('/admin/clear-cache', function() {
    Artisan::call('optimize:clear');
    return redirect('/admin')->with(['message' => 'Cache eliminada.', 'alert-type' => 'success']);
});

// Administrador de plantillas
Route::get('/admin/templates', 'TemplatesController@index');
Route::post('/admin/templates/create', 'TemplatesController@template_create')->name('templates.create');
Route::post('/admin/templates/pages/create', 'TemplatesController@page_create')->name('templates.pages.create');
Route::post('/admin/templates/pages/sections/create', 'TemplatesController@section_create')->name('templates.pages.sections.create');
Route::post('/admin/templates/pages/sections/update', 'TemplatesController@section_update')->name('templates.pages.sections.update');
Route::get('/admin/templates/pages/sections/delete/{id}/{template_id}/{page_id}', 'TemplatesController@section_delete');
Route::post('/admin/templates/pages/sections/blocks/create', 'TemplatesController@create_block')->name('templates.pages.sections.blocks.create');
Route::get('/admin/templates/pages/sections/blocks/{type}/{id}/{template_id}/{page_id}', 'TemplatesController@options_block');
Route::post('/admin/templates/pages/sections/blocks/inputs/update', 'TemplatesController@update_block_input')->name('templates.pages.sections.blocks.inputs.update');
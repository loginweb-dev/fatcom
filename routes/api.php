<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Autenticación
Route::post('/login','ApiController@login');
Route::post('/registro','ApiController@register');
Route::post('/update/profile','ApiController@update_profile');
Route::post('/confirm/profile','ApiController@confirm_profile');
Route::post('/update/profile/delivery','ApiController@update_profile_delivery');
Route::post('/update/profile/delivery/avatar/{id}','ApiController@update_profile_delivery_avatar');
Route::post('/login/social','ApiController@login_social');
Route::post('/login/delivery','ApiController@login_delivery');

// Categorías diponibles
Route::get('/categories','ApiController@categories_list');

// Oferta actual diponibles
Route::get('/oferta_actual','ApiController@get_oferta_actual');

// Productos de una categoría
Route::get('/products/list/{type}/{id}/{user_id}','ApiController@products_list_filter');

// Detalle de un producto
Route::get('/product/{id}','ApiController@product_details');

// Like a producto
Route::get('/products/like/{product_id}/{state}/{user_id}','ApiController@product_like');

// Lista de pedidos
Route::get('/pedidos/list/{user_id}','ApiController@pedidos_list');

// Lista de pedidos
Route::get('/pedidos/state/costumer/{user_id}','ApiController@pedidos_state_costumer');

// Obtener ultimas ubicaciones del cliente
Route::get('/pedidos/location/costumer/{id}','ApiController@get_locations');

// Registrar pedido
Route::post('/pedidos/store','ApiController@pedidos_store');

// Detalle de pedido
Route::get('/pedidos/details/{id}','ApiController@pedidos_detalles');

// Seguimiento de pedido
Route::get('/pedidos/tracking/{id}','ApiController@pedidos_seguimiento');




// ================================== Version 2 ==================================
Route::group(['prefix' => 'v2'], function () {
    Route::post('/login', 'ApiController@login_v2');
    Route::post('/update_user_profile', 'ApiController@update_user_profile_v2');
    Route::post('/update_user_avatar/{user_id}', 'ApiController@update_user_avatar_v2');
    Route::get('/index', 'ApiController@index_v2');
    Route::get('/index_alt', 'ApiController@index_alt_v2');
    Route::post('/filter/products', 'ApiController@filter_products_v2');
    Route::get('/category_products/{category_id}', 'ApiController@category_products_v2');
    Route::get('/offer_products/{offer_id}', 'ApiController@offer_products_v2');
    Route::post('/order_register', 'ApiController@order_register_v2');
    Route::get('/orders_list/{user_id}', 'ApiController@orders_list_v2');
    Route::get('/order_details/{order_id}', 'ApiController@order_details_v2');
});
// ===============================================================================


// ================================== Delivery ==================================
// Lista de pedidos asignados a un repartidor
Route::get('/delivery/pedidos/lista/{user_id}','ApiController@pedidos_pendientes');
// Lista de pedidos asignados a un repartidor
Route::get('/delivery/pedidos/close/{id}','ApiController@delivery_close');
// ===============================================================================
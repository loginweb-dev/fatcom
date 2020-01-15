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
Route::post('/login/social','ApiController@login_social');

// Categorías diponibles
Route::get('/categories','ApiController@categories_list');

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
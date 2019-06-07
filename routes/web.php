<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('accounts/register'                           , 'AccountController@register');
$router->post('accounts/login'                              , 'AccountController@login');
$router->post('accounts/logout'                             , 'AccountController@logout');
$router->get('users/{user_id}'                              , 'UserController@show');
$router->get('stores'                                       , 'StoreController@index');
$router->get('stores/{store_id}'                            , 'StoreController@show');
$router->get('stores/{store_id}/brands'                     , 'BrandController@index');
$router->get('stores/{store_id}/brands/{brand_id}'          , 'BrandController@show');
$router->get('stores/{store_id}/categories'                 , 'CategoryController@index');
$router->get('stores/{store_id}/categories/{category_id}'   , 'CategoryController@show');
$router->get('stores/{store_id}/collections'                , 'CollectionController@index');
$router->get('stores/{store_id}/collections/{collection_id}', 'CollectionController@show');
$router->get('stores/{store_id}/products'                   , 'ProductController@index');
$router->get('stores/{store_id}/products/{product_id}'      , 'ProductController@show');
$router->get('stores/{user_id}/addresses'                   , 'AddressController@index');
$router->post('stores/{user_id}/addresses'                  , 'AddressController@store');
$router->get('stores/{store_id}/addresses/{address_id}'     , 'AddressController@show');
$router->patch('stores/{store_id}/addresses/{address_id}'   , 'AddressController@update');
$router->delete('stores/{store_id}/addresses/{address_id}'  , 'AddressController@destroy');
$router->get('stores/{store_id}/orders'                     , 'OrderController@index');
$router->post('stores/{store_id}/orders'                    , 'OrderController@store');
$router->get('stores/{store_id}/orders/{number}'            , 'OrderController@show');
$router->patch('stores/{store_id}/orders/{number}'          , 'OrderController@update');
$router->get('stores/{store_id}/orders/{number}/items'      , 'OrderLineItemController@index');

$router->group([
    'namespace'  => 'Admin',
    'prefix'     => 'admin',
    'middleware' => [
        'jwt.auth',
        'role.admin',
    ],
], function() use ($router)
{
});

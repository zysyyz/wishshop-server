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

$router->post('account/register'                            , 'AccountController@register');
$router->post('account/login'                               , 'AccountController@login');
$router->post('account/logout'                              , 'AccountController@logout');
$router->get('users/{user_id}'                              , 'UserController@show');
$router->get('users/{user_id}/settings'                     , 'UserSettingController@index');
$router->post('users/{user_id}/settings'                    , 'UserSettingController@store');
$router->get('stores'                                       , 'StoreController@index');
$router->get('stores/{store_id}'                            , 'StoreController@show');
$router->get('stores/{store_id}/brands'                     , 'BrandController@index');
$router->get('stores/{store_id}/brands/{brand_id}'          , 'BrandController@show');
$router->get('stores/{store_id}/categories'                 , 'CategoryController@index');
$router->get('stores/{store_id}/categories/{category_id}'   , 'CategoryController@show');
$router->get('stores/{store_id}/products'                   , 'ProductController@index');
$router->get('stores/{store_id}/products/{product_id}'      , 'ProductController@show');
$router->get('stores/{store_id}/orders'                     , 'OrderController@index');
$router->post('stores/{store_id}/orders'                    , 'OrderController@store');
$router->get('stores/{store_id}/orders/{order_number}'      , 'OrderController@show');
$router->patch('stores/{store_id}/orders/{order_number}'    , 'OrderController@update');

$router->group([
    'namespace'  => 'Admin',
    'prefix'     => 'admin',
    'middleware' => [
        'jwt.auth',
        'role.admin',
    ],
], function() use ($router)
{
    $router->get('/users'                   , 'UserController@index');
    $router->get('/users/{user_id}'         , 'UserController@show');
    $router->patch('/users/{user_id}'       , 'UserController@update');
    $router->get('brands'                   , 'BrandController@index');
    $router->get('brands/{brand_id}'        , 'BrandController@show');
    $router->get('categories'               , 'CategoryController@index');
    $router->get('categories/{category_id}' , 'CategoryController@show');

});

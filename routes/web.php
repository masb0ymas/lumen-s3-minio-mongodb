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
    return response()->json(['Hello' => 'world']);
});

$router->group(['prefix' => '/storage'], function () use ($router) {
    $router->get('/', 'UploadController@get_all');
    $router->get('/direct/{id}', 'UploadController@redirect_url');
    $router->get('/{id}', 'UploadController@get_one');
    $router->post('/', 'UploadController@store');
    $router->put('/{id}', 'UploadController@update');
    $router->delete('/{id}', 'UploadController@destroy');
});
<?php

/** @var $router \Laravel\Lumen\Routing\Router */

$router->get('/', function () {
    return response()->json(['Hello' => 'world']);
});

$router->group(['prefix' => '/faq'], function () use ($router) {
    $router->get('/', 'FaqController@index');
    $router->post('/', 'FaqController@store');
});

$router->group(['prefix' => '/action'], function () use ($router) {
    $router->get('/', 'ActionController@index');
    $router->post('/', 'ActionController@store');
    $router->put('/{id}', 'ActionController@update');
    $router->delete('/{id}', 'ActionController@destroy');
});

$router->group(['prefix' => '/storage'], function () use ($router) {
    $router->get('/', 'MinIOController@index');
    $router->get('/files', 'MinIOController@list_files');
    $router->get('/{id}', 'MinIOController@get_one');
    $router->post('/', 'MinIOController@store');
    $router->put('/{id}', 'MinIOController@update');
    $router->delete('/{id}', 'MinIOController@destroy');
});

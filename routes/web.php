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
$router->get('/parser', 'ExampleController@parse');
$router->get('/send', 'ExampleController@botsend');
$router->get('/all', 'ExampleController@all');
$router->get('/add', 'ExampleController@add');
$router->get('/get', 'ExampleController@getImagesJSON');
$router->get('/set', 'ExampleController@setJSONImages');

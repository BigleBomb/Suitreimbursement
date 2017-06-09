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

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->post('/login', 'LoginController@index');
$app->post('/register', 'UserController@register');
$app->get('/user/{id}', ['middleware' => 'auth', 'uses' =>  'UserController@get_user']);
$app->post('/changepass/{id}', 'UserController@changepass');
$app->post('/set/{menu}/{id}', 'UserController@set');

$app->get('/reimburse', 'ReimburseController@index');
$app->get('/reimburse/{id}', 'ReimburseController@get_reimburse');
$app->get('/reimburse/delete/{id}', 'ReimburseController@delete');
$app->post('/reimburse/new', 'ReimburseController@create');
$app->post('/reimburse/update/{id}', 'ReimburseController@update');


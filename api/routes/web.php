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

// USER ROUTES
$app->post('/user/login', 'LoginController@index');
$app->post('/user/register', 'UserController@register');
$app->get('/user/get/{id}', ['middleware' => 'auth', 'uses' =>  'UserController@get_user']);
$app->post('/user/changepass/{id}', 'UserController@changepass');
$app->post('/user/set/{menu}/{id}', 'UserController@set');
$app->get('/user/all', ['middleware' => 'auth', 'uses' => 'UserController@index']);
$app->get('/user/delete/{id}', ['middleware' => 'auth', 'uses' => 'UserController@delete']);
$app->get('/user/count', ['middleware' => 'auth', 'uses' => 'UserController@get_user_count']);


// REIMBURSE ROUTES
$app->get('/reimburse/all', 'ReimburseController@index');
$app->get('/reimburse/get/{id}', 'ReimburseController@get_reimburse');
$app->get('/reimburse/delete/{id}', 'ReimburseController@delete');
$app->post('/reimburse/new', 'ReimburseController@create');
$app->post('/reimburse/update/{menu}', 'ReimburseController@update');
$app->get('/reimburse/pending/{menu}','ReimburseController@get_pending');
$app->get('/reimburse/list/{menu}', 'ReimburseController@get_list');
$app->get('/reimburse/accept/{id}', 'ReimburseController@accept');
$app->get('/reimburse/reject/{id}', 'ReimburseController@reject');
$app->get('/reimburse/last/{amount}', 'ReimburseController@get_last');

$app->get('sendbasicemail','MailController@basic_email');
$app->get('sendhtmlemail','MailController@html_email');
$app->get('sendattachmentemail','MailController@attachment_email');

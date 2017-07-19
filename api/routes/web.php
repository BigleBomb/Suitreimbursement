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
$app->post('/user/update/{id}', 'UserController@update');

// ITEM ROUTES
$app->get('/reimburse/getbyproject/{id}', 'ReimburseController@get');
$app->post('/reimburse/new', 'ReimburseController@create');
$app->get('/reimburse/last/{count}', 'ReimburseController@get_last');
$app->get('/reimburse/pending/{menu}','ReimburseController@get_pending');
$app->get('/reimburse/pending/{menu}','ReimburseController@get_pending');
$app->get('/reimburse/get/{id}', 'ReimburseController@get_reimburse');

// REIMBURSE ROUTES
$app->get('/project/all', 'ProjectController@index');
$app->get('/project/getuserlist/{id}', 'ProjectController@get_user_list');
$app->get('/project/getusercount/{id}', 'ProjectController@get_user_count');
$app->get('/project/get/{id}', 'ProjectController@get_project');
$app->get('/project/delete/{id}', 'ProjectController@delete');
$app->post('/project/new', 'ProjectController@create');
$app->post('/project/update/{menu}', 'ProjectController@update');
$app->get('/project/list/{menu}', 'ProjectController@get_list');
$app->post('/project/accept/{id}', 'ProjectController@accept');
$app->post('/project/reject/{id}', 'ProjectController@reject');
$app->get('/project/last/{count}', 'ProjectController@get_last');

$app->get('sendbasicemail','MailController@basic_email');
$app->get('sendhtmlemail','MailController@html_email');
$app->get('sendattachmentemail','MailController@attachment_email');
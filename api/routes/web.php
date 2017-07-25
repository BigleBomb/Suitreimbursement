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
$app->post('/user/set/{menu}/{id}', 'UserController@set');
$app->get('/user/all', ['middleware' => 'auth', 'uses' => 'UserController@index']);
$app->get('/user/delete/{id}', ['middleware' => 'auth', 'uses' => 'UserController@delete']);
$app->get('/user/count', ['middleware' => 'auth', 'uses' => 'UserController@get_user_count']);
$app->post('/user/update/{id}', 'UserController@update');

// REIMBURSE ROUTES
$app->get('/reimburse/getbyproject/{id}', 'ReimburseController@get');
$app->post('/reimburse/new', 'ReimburseController@create');
$app->get('/reimburse/last/{count}', 'ReimburseController@get_last');
$app->get('/reimburse/pending/{menu}','ReimburseController@get_pending');
$app->get('/reimburse/list/{menu}', 'ReimburseController@get_list');
$app->get('/reimburse/get/{id}', 'ReimburseController@get_reimburse');
$app->post('/reimburse/accept/{id}', 'ReimburseController@accept');
$app->post('/reimburse/reject/{id}', 'ReimburseController@reject');
$app->get('/reimburse/getfromprojectbyuserid/{pid}/{id}', 'ReimburseController@get_reimburse_from_project_by_user_id');
$app->get('/reimburse/getimagepath/{pid}/{rid}', 'ReimburseController@getImagePath');
$app->get('/reimburse/gettotal/{menu}', 'ReimburseController@get_total');
$app->get('/reimburse/delete/{id}', 'ReimburseController@delete');

// PROJECT ROUTES
$app->get('/project/all', 'ProjectController@index');
$app->get('/project/getuserlist/{id}', 'ProjectController@get_user_list');
$app->get('/project/getusercount/{id}', 'ProjectController@get_user_count');
$app->get('/project/getreimburselist/{id}/{menu}', 'ProjectController@get_reimburse_list');
$app->get('/project/getbyuserid/{id}', 'ProjectController@get_project_by_userid');
$app->get('/project/get/{id}', 'ProjectController@get_project');
$app->get('/project/delete/{id}', 'ProjectController@delete');
$app->post('/project/new', 'ProjectController@create');
$app->get('/project/updatecost/{pid}', 'ProjectController@update_cost');
$app->get('/project/last/{count}', 'ProjectController@get_last');
$app->post('/project/adduser', 'ProjectController@add_user');
$app->post('/project/deleteuser', 'ProjectController@delete_user');
$app->get('/project/getavailableuser/{pid}', 'ProjectController@get_available_user');
$app->post('/project/update/{pid}', 'ProjectController@update');
$app->get('/project/getunchecked/{pid}', 'ProjectController@get_unchecked');
$app->get('/project/gettotal', 'ProjectController@get_total');

$app->get('sendbasicemail','MailController@basic_email');
$app->get('sendhtmlemail','MailController@html_email');
$app->get('sendattachmentemail','MailController@attachment_email');
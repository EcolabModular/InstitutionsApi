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

$router->get('/institutions','InstitutionController@index');
$router->post('/institutions','InstitutionController@store');
$router->get('/institutions/{institution}','InstitutionController@show');
$router->put('/institutions/{institution}','InstitutionController@update');
$router->patch('/institutions/{institution}','InstitutionController@update');
$router->delete('/institutions/{institution}','InstitutionController@destroy');

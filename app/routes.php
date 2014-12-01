<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/readings', array(
	'as' => 'home'
));
Route::get('/readings/threshold', array(
    'as' => 'range',
    'uses' => 'ReadingsController@postRange'
));
Route::get('/readings/{room}', array(
	'as' => 'graph',
	'uses' => 'ReadingsController@getGraph'
));

Route::Controller('readings', 'ReadingsController');
Route::Controller('variable', 'VariableController');

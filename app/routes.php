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

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('imu', function()
{
	$im = App::make('IMu');
	#return $im::VERSION;
	$imSession = App::make('IMuSession');
	$imSession->host='server.com';
	$imSession->port = 12345; 
	try
	{
		return $imSession->connect();	
	}catch (Exception $e)
	{
		var_dump((string)$e);
	}
});
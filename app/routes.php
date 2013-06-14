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

Route::get ( '/', function ()
{
	return View::make ( 'hello' );
} );

Route::get ( 'imu', function ()
{
	try
	{
		$mySession = App::make ( 'IMuSession' );
		$mySession->host = '203.22.224.29';
		$mySession->port = 40000;
		$mySession->connect ();
		
		Config::set ( 'imu.module_table', 'eparties' );
		$parties = App::make ( 'IMuModule' );
		$search = array('NamLast','Smith');
		$hits = $parties->findTerms($search);
		$columns = array(
			'irn',
			'NamFirst',
			'NamLast'
		);
		$result = $parties->fetch('start',0,3,$columns);
		var_dump($result);
	} catch ( Exception $e )
	{
		var_dump($e);
	}

} );
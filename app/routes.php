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

// Our intial routes.
Route::get('/', 'HomeController@index');
Route::get('search/results', 'SearchController@results');
Route::get('info', 'InformationController@index');
Route::get('object', 'ObjectController@index');

// IMu test.
Route::get ('imu-test', function ()
{
	try
	{
		$mySession = App::make ( 'ImuSession' );
		$mySession->host = '203.22.224.29';
		$mySession->port = 40000;
		$mySession->connect ();
		Config::set ( 'imu.module_table', 'eparties' );
		$parties = App::make ( 'ImuModule' );
		$search = array ('NamLast', 'Smith' );
		$hits = $parties->findTerms ( $search );
		$columns = array ('irn', 'NamFirst', 'NamLast' );
		$result = $parties->fetch ( 'start', 0, 3, $columns );
		print_r( $result );
	}
	catch ( Exception $e )
	{
		print ( $e->getMessage() );
	}
});

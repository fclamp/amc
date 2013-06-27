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
Route::get('info/{id}', 'InformationController@index');
Route::get('object/{id}', 'ObjectController@index');

//Show Image
Route::get('show-img/{irn}',function($irn){

	$search = new Search();
	$search->getImage($irn);
	
});

// IMu test.
Route::get ('imu-test', function ()
{
	try
	{
		$mySession = App::make ( 'ImuSession' );
		$mySession->host = '203.22.224.29';
		$mySession->port = 40000;
		$mySession->connect ();
		Config::set ( 'imu.module_table', 'ecatalogue' );
		$parties = App::make ( 'ImuModule' );
		
		$hits = $parties->findKey(18409);
		$columns = array ('irn', 
			'SummaryData', 
			'MulMultiMediaRef_tab',
			'image.resource'
		);
		$result = $parties->fetch ( 'start', 0, 3, $columns );
		echo '<pre>';
		print_r( $result );
		
		
		Config::set ( 'imu.module_table', 'emultimedia' );
		$parties = App::make ( 'ImuModule' );
		
		$hits = $parties->findKey(8171);
		$columns = array ('irn', 
			'resource',
		);
		$result = $parties->fetch ( 'start', 0, 3, $columns );		
		print_r( $result );
		
		
		
	}
	catch ( Exception $e )
	{
		print ( $e->getMessage() );
	}
});

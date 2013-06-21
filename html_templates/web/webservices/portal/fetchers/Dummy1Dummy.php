<?php

/**
*
* A Dummy Fetcher
*
* used to assist testing portals and mappers etc
* Provides a fetcher service to an 'always'
* available dummy data source.
* No actual data source is used - the fetcher
* simulates one
*
* Copyright (c) 2005 - KE Software Pty Ltd
*
* @package EMuWebServices
*
*/



if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));


require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/portal/DummyFetcher.php');


class Dummy1DummyFetcher extends DummyFetcher
{

	var 	$enabled = false;
	
	var 	$serviceName = "Dummy1DigirFetcher";

	/*  Describe Digir configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "Test Data (EMu-DiGIR.02)";
	var	$resource = "Dummy1_EMu";
	var 	$preferredRGB = '#eeffaa';
	var 	$preferredIcon = '';
	var 	$caheIsOn = false;

	function describe()
	{
		return	
			"A Dummy 1 Fetcher is a\n".
			"Dummy implementation of a\n".
			"Digir Fetcher\n\n".
			Parent::describe();  
	}

	function testQueryTerms()
	{
		return	"darwin:Genus = <input type='text' name='qry_darwin:Genus' value='Aedes' />\n";
	}

}


if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'Dummy1Dummy.php')
	{
		$source = new Dummy1DummyFetcher();
		$source->test(true);
	}
}


?>

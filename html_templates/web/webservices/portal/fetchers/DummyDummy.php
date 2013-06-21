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
* Copyright (c) 1998-2012 KE Software Pty Ltd
*
* @package EMuWebServices
*
*/


if (!isset($WEB_ROOT))
{
	// Fetchers may live in 2 places - the default or the client localised
	// path.
	if (preg_match("/portal.fetchers/",realpath(__FILE__)))
		$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
	else	
		$WEB_ROOT = dirname(dirname(dirname(dirname(dirname(realpath(__FILE__))))));
}


require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/portal/DummyFetcher.php');


class DummyDummyFetcher extends DummyFetcher
{

	var 	$enabled = false;
	
	var 	$serviceName = "DummyDigirFetcher";

	/*  Describe Digir configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "Test Data (EMu-DiGIR.02)";
	var	$resource = "Dummy_EMu";
	var 	$preferredRGB = '#eeffaa';
	var 	$preferredIcon = '';
	var 	$caheIsOn = false;

	function describe()
	{
		return	
			"A Dummy Fetcher is a\n".
			"Dummy implementation of a\n".
			"Digir Fetcher\n\n".
			parent::describe();  
	}

	function testQueryTerms()
	{
		return	"darwin:Genus = <input type='text' name='qry_darwin:Genus' value='Aedes' />\n";
	}

}


if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'DummyDummy.php')
	{
		$source = new DummyDummyFetcher();
		$source->test(true);
	}
}


?>

<?php

/*
 *  Copyright (c) 2005 - KE Software Pty Ltd
 */


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/portal/DigirFetcher.php');


/**
*
* A localised Fetcher 
*
* Copyright (c) 2005 - KE Software Pty Ltd
*
* @package EMuWebServices
*
*/


class AnicDigirFetcher extends DigirFetcher
{
	var	$enabled = false;
	var 	$serviceName = "AnicDigirFetcher";

	/*  Describe Digir configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "ANIC (GBIF/DiGIR)";
	var	$hostname = "digir.ento.csiro.au";
	var	$port = 3128;
	var	$provider = "digir/DiGIR.php";
	var	$resource = "ANIC";
	var 	$exampleQueryTerms = Array(
			"Genus" => "Heliothis",
	);
	var 	$preferredRGB = '#00ffee';
	var 	$preferredIcon = '';

	function describe()
	{
		return	
			"An ANIC Digir Fetcher is a\n".
			"ANIC specific implementation of a\n".
			"Digir Fetcher\n\n".
			Parent::describe();  
	}

	function testQueryTerms()
	{
		return  "darwin:Genus = <input type='text' name='qry_darwin:Genus' value='Heliothis' />";
	}

}


if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'Fetcher.php')
	{
		$source = new AnicDigirFetcher();
		$source->test(true);
	}
}


?>

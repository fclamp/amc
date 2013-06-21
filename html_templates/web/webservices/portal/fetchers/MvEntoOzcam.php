<?php

/*
 *  Copyright (c) 2005 - KE Software Pty Ltd
 */



if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));


require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/portal/OzcamFetcher.php');


/**
*
* A localised Fetcher 
*
* Copyright (c) 2005 - KE Software Pty Ltd
*
* @package EMuWebServices
*
*/

class MvEntoOzcamFetcher extends OzcamFetcher
{

	var 	$enabled = false;

	var 	$serviceName = "MvEntoOzcamFetcher";

	/*  Describe Digir configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "MV Ento (OZCAM2)";
	var	$hostname = "ozcamtest.museum.vic.gov.au";
	var	$port = 80;
	var	$provider = "wrapper.aspx";
	var	$resource = "anwc_herpetology2";
	var 	$exampleQueryTerms = Array(
	);
	var 	$preferredRGB = '#aaaaff';
	var 	$preferredIcon = '';
	var 	$timeout = 20;

	function describe()
	{
		return	
			"A MV Entomology OZCAM Fetcher is a\n".
			"implementation of a OZCAM Fetcher\n".
			"that talks to the MV entomology\n".
			"OZCAM 2 wrapper\n\n".
			Parent::describe();  
	}

	function testQueryTerms()
	{
		return  "Genus = <input type='text' name='qry_ge1' value='Culex' /><br/>\nOR<br/>\n".
			"Genus = <input type='text' name='qry_ge2' value='Aedes' />";
	}

}


if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'Fetcher.php')
	{
		$source = new MvEntoOzcamFetcher();
		$source->test(true);
	}
}


?>

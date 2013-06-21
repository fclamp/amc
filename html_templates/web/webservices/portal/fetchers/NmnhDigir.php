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

class NmnhDigirFetcher extends DigirFetcher
{

	var 	$enabled = false;
	
	var 	$serviceName = "NmnhDigirFetcher";

	/*  Describe Digir configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "NMNH Mosquito (EMu-DiGIR.02)";
	var	$hostname = "syd.kesoftware.com";
	var	$port = 80;
	var	$provider = "emuwebnmnhdigir/webservices/digir.php";
	var	$resource = "NMNH_EMu";
	var 	$exampleQueryTerms = Array(
			"darwin:Genus = Culex",
	);
	var 	$preferredRGB = '#eeffaa';
	var 	$preferredIcon = '';

	function describe()
	{
		return	
			"A Nmnh Digir Fetcher is a\n".
			"NMNH specific implementation of a\n".
			"Digir Fetcher\n\n".
			Parent::describe();  
	}

}


if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'Fetcher.php')
	{
		$source = new NmnhDigirFetcher();
		$source->test(true);
	}
}


?>

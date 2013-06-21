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


class AmDigirFetcher extends DigirFetcher
{
	var	$enabled = false;

	var	$serviceName = "AmDigirFetcher";

	/*  Describe Digir configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "AM Malacology (EMu-DiGIR.02)";
	var	$hostname = "cronulla";
	var	$port = 80;
	var	$provider = "emuwebamdigir/webservices/digir.php";
	var	$resource = "AM_EMu";

	var 	$exampleQueryTerms = Array(
			"darwin:Genus = Chromodoris",
			"darwin:Genus = Helix",
	);

	var 	$preferredRGB = '#aaffaa';
	var 	$preferredIcon = '';

	function describe()
	{
		return	
			"An AM Digir Fetcher is an Australian Museum\n".
			"specific implementation of a Digir Fetcher\n\n".
			Parent::describe();  
	}

}


if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'AmDigir.php')
	{
		$source = new AmDigirFetcher();
		$source->test(true);
	}
}


?>

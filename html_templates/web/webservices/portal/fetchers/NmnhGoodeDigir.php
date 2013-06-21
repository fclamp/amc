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

class NmnhGoodeDigirFetcher extends DigirFetcher
{

	var 	$enabled = false;

	var 	$serviceName = "NmnhGoodeDigirFetcher";

	/*  Describe Digir configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "NMNH Live (EMu-DiGIR.0a)";
	var	$hostname = "goode.si.edu";
	var	$port = 80;
	var	$provider = "webnew/digir/emudigir.php";
	var	$resource = "NmnhEMu";
	var 	$exampleQueryTerms = Array(
	);

	var 	$preferredRGB = '#eeffff';
	var 	$preferredIcon = '';

	function describe()
	{
		return	
			"A Nmnh Goode Digir Fetcher is a\n".
			"NMNH specific implementation of a\n".
			"Digir Fetcher running on goode\n\n".
			Parent::describe();  
	}

	function testQueryTerms()
	{
		return  "darwin:Genus = <input type='text' name='qry_darwin:Genus' value='Helix' /><br/>\nOR<br/>\n".
			"darwin:Genus = <input type='text' name='qry_darwin:Genus' value='Aedes' />";
	}

}


if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'Fetcher.php')
	{
		$source = new NmnhGoodeDigirFetcher();
		$source->test(true);
	}
}


?>

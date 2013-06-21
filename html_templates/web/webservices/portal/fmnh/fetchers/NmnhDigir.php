<?php

/*
 *  Copyright (c) 1998-2009 KE Software Pty Ltd
 */



if (!isset($WEB_ROOT))
{
	// Fetchers may live in 2 places - the default or the client
	// localised path.
	if (preg_match("/portal.fetchers/",realpath(__FILE__)))
		$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
	else	
		$WEB_ROOT = dirname(dirname(dirname(dirname(dirname(realpath(__FILE__))))));
}


require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/portal/DigirFetcher.php');


/**
*
* A localised Fetcher 
*
* Copyright (c) 1998-2009 KE Software Pty Ltd
*
* @package EMuWebServices
*
*/

class NmnhDigirFetcher extends DigirFetcher
{

	var 	$enabled = true;
	
	var 	$serviceName = "NmnhDigirFetcher";

	/*  Describe Digir configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "NMNH (EMu-DiGIR.02)";
	var	$hostname = "acsmith.si.edu";
	var	$port = 80;
	var	$provider = "emuwebvzfishesweb/webservices/digir.php";
	var	$resource = "NMNH-VZBirds";
	var 	$queryableFields = Array(
			'darwin:Genus' => Array(2,"Lampsilis"),
			'darwin:Species' => Array(3,""),
		);
	var 	$preferredRGB = '#ffaaaa';
	var 	$preferredIcon = '';

	function NmnhDigirFetcher($instanceDir='',$backendType='',$webRoot='',$webDirName='',$debugOn=true)
	{
		$this->{get_parent_class(__CLASS__)}($instanceDir,$backendType,$webRoot,$webDirName,$debugOn);

		// used to set queryable fields.  May also participate in
		// "SELECT" type statement when querying data source.
		// Returned fields will be translated from source field to
		// concept if possible.
		//   syntax:
		// setKnownConcept(Concept,DataSourceField,[ExampleValue])

		$this->setKnownConcept("IRN","CatalogNumberNumeric","","integer");
		$this->setKnownConcept("Family","Family","Unionidae");
		$this->setKnownConcept("Genus","Genus");
		$this->setKnownConcept("Species","Species");
		$this->setKnownConcept("Latitude","DecimalLatitude","","float");
		$this->setKnownConcept("Longitude","DecimalLongitude","","float");
	}

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

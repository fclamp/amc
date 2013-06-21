<?php

/**
*
* The Local Default Fetcher
*
* This fetcher should connect to a standard EMu DiGIR Provider set up on this
* host
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
require_once ($WEB_ROOT . '/webservices/portal/DigirFetcher.php');

class DefaultDigirFetcher extends DigirFetcher
{

	var 	$enabled = false;
	
	var 	$serviceName = "LocalDigirFetcher";

	/*  Describe Digir configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "EMu (EMu-DiGIR.02)";
	var	$hostname = "localhost";
	var	$port = 80;
	var	$resource = "EMu";
	var 	$preferredRGB = '#eeffaa';
	var 	$preferredIcon = '';
	var 	$caheIsOn = false;

	function DefaultDigirFetcher($instanceDir='',$backendType='',$webRoot='',$webDirName='',$debugOn='')
	{
		$this->{get_parent_class(__CLASS__)}($instanceDir,$backendType,$webRoot,$webDirName,$debugOn);

		// data source is local EMu-DiGIR service
		$this->provider = $this->webDirName . "/webservices/digir.php";

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
			"A Local Default Fetcher is a\n".
			"Fetcher that should connect to the local DiGIR service\n".
			"of the EMuWeb system the fetcher is configured on\n\n".
			parent::describe();  
	}

}


if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'DefaultDigir.php')
	{
		$source = new DefaultDigirFetcher();
		$source->test(true);
	}
}


?>

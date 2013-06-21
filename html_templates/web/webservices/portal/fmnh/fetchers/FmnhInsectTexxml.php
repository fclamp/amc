<?php

/**
*
* The Local Default Texxml Fetcher
*
* Copyright (c) 1998-2009 KE Software Pty Ltd
*
* @package EMuWebServices
*
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
require_once ($WEB_ROOT . '/webservices/portal/TexxmlFetcher.php');

class FmnhInsectTexxmlFetcher extends TexxmlFetcher
{

	var 	$enabled = true;
	
	var 	$serviceName = "FMNH Insect TexxmlFetcher";

	/*  Describe Texxml configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "FMNH Insects EMu";
	var	$hostname = "remus.yvr.kesoftware.com";
	var 	$queryableFields = Array(
			'DarGenus' => Array(1,""),
			'DarScientificName' => Array(1,""),
			'SummaryData' => Array(1,"fasciatus"),
		);

	var	$resource = "EMu";
	var 	$preferredRGB = '#e1e1e5';
	var 	$preferredIcon = '';
	var 	$caheIsOn = false;

	function FmnhInsectTexxmlFetcher($instanceDir='',$backendType='',$webRoot='',$webDirName='',$debugOn=true)
	{
		$this->{get_parent_class(__CLASS__)}($instanceDir,$backendType,$webRoot,$webDirName,$debugOn);
		$this->port = 9138;

		// used to set queryable fields.  May also participate in
		// "SELECT" type statement when querying data source.
		// Returned fields will be translated from source field to
		// concept if possible.
		//   syntax:
		// setKnownConcept(Concept,DataSourceField,[ExampleValue])

		#$this->setKnownConcept("IRN","irn","","integer");
		$this->setKnownConcept("Family","DarFamily");
		$this->setKnownConcept("Genus","DarGenus");
		$this->setKnownConcept("Species","DarSpecies","cariosa");
		$this->setKnownConcept("Latitude","DarDecimalLatitude","","float");
		$this->setKnownConcept("Longitude","DarDecimalLongitude","","float");

		$this->addAHardWiredRestriction("CatCatalog = 'Insects'");
	}

	function describe()
	{
		return	
			"A FMNH Texxml Fetcher is a\n".
			"Fetcher that can connect to the local FMNH Texxml service\n\n".
			parent::describe();  
	}

}


if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'FmnhInsectTexxml.php')
	{
		$source = new FmnhInsectTexxmlFetcher();
		$source->test(true);
	}
}


?>

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

class FmnhFishesTexxmlFetcher extends TexxmlFetcher
{

	var 	$enabled = true;
	
	var 	$serviceName = "FMNH Fish TexxmlFetcher";

	/*  Describe Texxml configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "FMNH Fish EMu";
	var	$hostname = "remus.yvr.kesoftware.com";
	var 	$queryableFields = Array(
			'DarGenus' => Array(1,""),
			'DarScientificName' => Array(1,""),
			'SummaryData' => Array(1,"cariosa"),
		);

	var	$resource = "EMu";
	var 	$preferredRGB = '#E7F5F6';
	var 	$preferredIcon = '';
	var 	$caheIsOn = false;

	function FmnhFishesTexxmlFetcher($instanceDir='',$backendType='',$webRoot='',$webDirName='',$debugOn=true)
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
		$this->setKnownConcept("Species","DarSpecies","gracilis");
		$this->setKnownConcept("Latitude","DarDecimalLatitude","","float");
		$this->setKnownConcept("Longitude","DarDecimalLongitude","","float");
		$this->setKnownConcept("Summary","SummaryData");

		$this->addAHardWiredRestriction("CatCatalog = 'Fishes'");
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
	if (basename($_SERVER['PHP_SELF']) == 'FmnhFishesTexxml.php')
	{
		$source = new FmnhFishesTexxmlFetcher();
		$source->test(true);
	}
}


?>

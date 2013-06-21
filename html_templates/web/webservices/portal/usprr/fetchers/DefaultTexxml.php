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

class DefaultTexxmlFetcher extends TexxmlFetcher
{

	var 	$enabled = true;
	
	var 	$serviceName = "DefaultTexxmlFetcher";

	/*  Describe Texxml configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "EMu (EMu-Texxml)";
	var	$hostname = "localhost";
	var 	$queryableFields = Array(
			'SummaryData' => Array(1,""),
			'ObjRockType' => Array(1,""),
			'ObjRockName' => Array(1,"dacite"),
		);

	var	$resource = "EMu";
	var 	$preferredRGB = '#eeffaa';
	var 	$preferredIcon = '';
	var 	$caheIsOn = false;

	function DefaultTexxmlFetcher($instanceDir='',$backendType='',$webRoot='',$webDirName='',$debugOn=true)
	{
		$this->{get_parent_class(__CLASS__)}($instanceDir,$backendType,$webRoot,$webDirName,$debugOn);

		// used to set queryable fields.  May also participate in
		// "SELECT" type statement when querying data source.
		// Returned fields will be translated from source field to
		// concept if possible.
		//   syntax:
		// setKnownConcept(Concept,DataSourceField,[ExampleValue,[type]])

		$this->setKnownConcept("IRN","irn","","integer");
		$this->setKnownConcept("RockType","ObjRockType");
		$this->setKnownConcept("RockName","ObjRockName","dacite");
		$this->setKnownConcept("Era","AgeEra_tab","");
		$this->setKnownConcept("Period","AgePeriod_tab","");
		$this->setKnownConcept("Latitude","LtyLatitudeDms","","float");
		$this->setKnownConcept("Longitude","LtyLongitudeDms","","float");
		$this->setKnownConcept("Summary","SummaryData");
	}

	function describe()
	{
		return	
			"A Default Texxml Fetcher is a\n".
			"Fetcher that can connect to the local Texxml service\n".
			"of the EMuWeb system the fetcher is configured on\n\n".
			parent::describe();  
	}

}


if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'DefaultTexxml.php')
	{
		$source = new DefaultTexxmlFetcher();
		$source->test(true);
	}
}


?>

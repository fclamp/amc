<?php

/**
*
* The Local Garden Texxml Fetcher
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

class GardenTexxmlFetcher extends TexxmlFetcher
{

	var 	$enabled = true;
	
	var 	$serviceName = "GardenTexxmlFetcher";

	/*  Describe Texxml configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "RBGNSW Garden EMu";
	var	$hostname = "localhost";
	var	$resource = "EMu";
	var 	$preferredRGB = '#aaffaa';
	var 	$preferredIcon = '';
	var 	$caheIsOn = false;
	var	$translatorType = "Garden";

	function GardenTexxmlFetcher($instanceDir='',$backendType='',$webRoot='',$webDirName='',$debugOn=true)
	{
		$this->{get_parent_class(__CLASS__)}($instanceDir,$backendType,$webRoot,$webDirName,$debugOn);

		// used to set queryable fields.  May also participate in
		// "SELECT" type statement when querying data source.
		// Returned fields will be translated from source field to
		// concept if possible.
		//   syntax:
		// setKnownConcept(Concept,DataSourceField,[ExampleValue,[type]])

		$this->setKnownConcept("irn","irn_1","","integer");
		$this->setKnownConcept("CommonName","QuiTaxonomyCommonName_tab[QuiTaxonomyCommonName]","Brazilian Araucaria");
		$this->setKnownConcept("Location","LocCurrentLocationLocal");
		$this->setKnownConcept("Family","QuiTaxonomyFamily");
		$this->setKnownConcept("ScientificName","QuiTaxonomyScientificName");
		$this->setKnownConcept("Genus","QuiTaxonomyGenus");
		$this->setKnownConcept("Species","QuiTaxonomySpecies");
		$this->setKnownConcept("FlowerColour","HorFlowerColour_tab[HorFlowerColour]");
		$this->setKnownConcept("NativeExotic","CorNative");
		$this->setKnownConcept("ConservationStatus","QuiTaxonomyStatus_tab[QuiTaxonomyStatus]");
		$this->setKnownConcept("JanuaryFlower","FloFloweringJan");
		$this->setKnownConcept("FebruaryFlower","FloFloweringFeb");
		$this->setKnownConcept("MarchFlower","FloFloweringMar");
		$this->setKnownConcept("AprilFlower","FloFloweringApr");
		$this->setKnownConcept("MayFlower","FloFloweringMay");
		$this->setKnownConcept("JuneFlower","FloFloweringJun");
		$this->setKnownConcept("JulyFlower","FloFloweringJul");
		$this->setKnownConcept("AugustFlower","FloFloweringAug");
		$this->setKnownConcept("SeptemberFlower","FloFloweringSep");
		$this->setKnownConcept("OctoberFlower","FloFloweringOct");
		$this->setKnownConcept("NovemberFlower","FloFloweringNov");
		$this->setKnownConcept("DecemberFlower","FloFloweringDec");

		$this->setDirectTranslation("FlowerMonth = 'January'","FloFloweringJan = 'Yes'");
		$this->setDirectTranslation("FlowerMonth = 'February'","FloFloweringFeb = 'Yes'");
		$this->setDirectTranslation("FlowerMonth = 'March'","FloFloweringMar = 'Yes'");
		$this->setDirectTranslation("FlowerMonth = 'April'","FloFloweringApr = 'Yes'");
		$this->setDirectTranslation("FlowerMonth = 'May'","FloFloweringMay 'Yes'");
		$this->setDirectTranslation("FlowerMonth = 'June'","FloFloweringJun = 'Yes'");
		$this->setDirectTranslation("FlowerMonth = 'July'","FloFloweringJul = 'Yes'");
		$this->setDirectTranslation("FlowerMonth = 'August'","FloFloweringAug = 'Yes'");
		$this->setDirectTranslation("FlowerMonth = 'September'","FloFloweringSep = 'Yes'");
		$this->setDirectTranslation("FlowerMonth = 'October'","FloFloweringOct = 'Yes'");
		$this->setDirectTranslation("FlowerMonth = 'November'","FloFloweringNov = 'Yes'");
		$this->setDirectTranslation("FlowerMonth = 'December'","FloFloweringDec = 'Yes'");

		$this->setDirectTranslation("NativeOrExotic = 'Exotic'","CorNative = 'E'");
		$this->setDirectTranslation("NativeOrExotic = 'Native'","CorNative = 'N'");
		$this->setDirectTranslation("NativeOrExotic = 'Unknown'","CorNative = '\"?\"'");

		$this->addAHardWiredRestriction("SummaryData CONTAINS 'Garden'");
		$this->addAHardWiredRestriction("AdmPublishWebNoPassword = 'Yes'");
		$this->addAHardWiredRestriction("ArbSiteRef IS NOT NULL");


	}

	function describe()
	{
		return	
			"A Garden Texxml Fetcher is a\n".
			"Fetcher that can connect to the local Texxml service\n".
			"of the EMuWeb system the fetcher is configured on\n\n".
			parent::describe();  
	}

}


if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'GardenTexxml.php')
	{
		$source = new GardenTexxmlFetcher();
		$source->test(true);
	}
}


?>

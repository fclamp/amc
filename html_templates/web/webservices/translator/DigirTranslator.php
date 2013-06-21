<?php

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */


if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/translator/Translator.php');

/**
 *
 * DigirTranslator is Class for translating DiGIR XML
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class DigirTranslator extends Translator 
{
	var $serviceName = "DigirTranslator";
	var $recordElement = 'record';
	var $latitudeElement = 'Latitude';
	var $longitudeElement = 'Longitude';
	var $potentialGroups = array (
			'ScientificName' => '0',
			'Family' => '1', 
			'Genus' => '2', 
			'CollectionCode' => '3', 
		);	

	function describe()
	{
		return	
			"A DigirTranslator is a Translator that can read\n".
			"DiGIR Web Service Records\n\n".
			parent::describe();
	}


	function hasRecord()
	{
		return false;
	}

	function getDescription()
	{
		if ($this->recordPointer >= 0 && $this->recordPointer < count($this->records))
		{
			$record = $this->records[$this->recordPointer];
			return $record['Genus'] . ' ' . $record['Species'];
		}
		return '';
	}


	function makeTestPage()
	{
		$args = array();
		$args['DiGIR Record (enter 1 or more DiGIR xml records)'] = "<textarea cols='120' rows='15' name='data'>".<<<XML
<?xml version="1.0" encoding="ISO-8859-1"?>
<?xml-stylesheet  type="text/xsl" href="digir/style/digir.xsl" ?>
<?suggestedQuery Species=minullus?>
<?suggestedResource NMNH-VZBirds?>
<response xmlns='http://digir.net/schema/protocol/2003/1.0'>
  <header>
    <version>2</version>
    <sendTime>2007-11-09 10:19:13.00Z</sendTime>
    <source resource=''>
    http://kenya.mel.kesoftware.com//emuwebnmnh-izdigir/webservices/digir.php</source>
    <destination>kenya.mel.kesoftware.com</destination>
    <type>search</type>
  </header>
  <content
  xmlns:darwin='http://digir.net/schema/conceptual/darwin/2003/1.0'
  xmlns:xsd='http://www.w3.org/2001/XMLSchema'
  xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'>
    <record>
      <darwin:DateLastModified>2005-7-20T9:56:33.000Z</darwin:DateLastModified>
      <darwin:InstitutionCode>USNM</darwin:InstitutionCode>
      <darwin:CollectionCode>Invertebrate Zoology:Crustacea</darwin:CollectionCode>
      <darwin:CatalogNumber>126240.90457</darwin:CatalogNumber>
      <darwin:ScientificName>Taeniastrotoscaliforniensis</darwin:ScientificName>
      <darwin:BasisOfRecord>S</darwin:BasisOfRecord>
      <darwin:Kingdom>Animalia</darwin:Kingdom>
      <darwin:Phylum>Arthropoda</darwin:Phylum>
      <darwin:Class>Maxillopoda</darwin:Class>
      <darwin:Order>Poecilostomatoida</darwin:Order>
      <darwin:Family>Taeniacanthidae</darwin:Family>
      <darwin:Genus>Taeniastrotos</darwin:Genus>
      <darwin:Species>californiensis</darwin:Species>
      <darwin:ScientificNameAuthor>Cressey</darwin:ScientificNameAuthor>
      <darwin:IdentifiedBy>Cressey, Roger F.</darwin:IdentifiedBy>
      <darwin:YearIdentified>1968</darwin:YearIdentified>
      <darwin:MonthIdentified>10</darwin:MonthIdentified>
      <darwin:DayIdentified>2</darwin:DayIdentified>
      <darwin:TypeStatus>Holotype</darwin:TypeStatus>
      <darwin:Collector>E. Hobson</darwin:Collector>
      <darwin:YearCollected>1968</darwin:YearCollected>
      <darwin:MonthCollected>10</darwin:MonthCollected>
      <darwin:DayCollected>2</darwin:DayCollected>
      <darwin:JulianDay>276</darwin:JulianDay>
      <darwin:ContinentOcean>North Pacific Ocean</darwin:ContinentOcean>
      <darwin:Country>United States</darwin:Country>
      <darwin:StateProvince>California</darwin:StateProvince>
      <darwin:Locality>La Jolla</darwin:Locality>
      <darwin:Sex>female</darwin:Sex>
      <darwin:PreparationType>Alcohol (Ethanol)</darwin:PreparationType>
      <darwin:IndividualCount>1</darwin:IndividualCount>
    </record>
  </content>
  </diagnostics>
</response>
XML
.

			"</textarea>";
		$vars = array();
		$submission = "<input type='submit' name='action' value='translate' />";
		return $this->makeDiagnosticPage(
					'Test Digir Translator',
					'simple test',
					'',
					'./DigirTranslator.php',
					$args,
					$submission,
					$vars,
					$this->describe()
				);
	}

}

if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'DigirTranslator.php')
	{
		$translator = new DigirTranslator();
		print $translator->test(true);
	}
}


?>

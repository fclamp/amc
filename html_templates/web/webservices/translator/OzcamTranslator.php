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
 * OzcamTranslator is a class for translating OZCAN XML
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class OzcamTranslator extends Translator 
{
	var $serviceName = "OzcamTranslator";
	var $recordElement = 'speciesRecord';
	var $latitudeElement = 'Latitude';
	var $longitudeElement = 'Longitude';
	var $potentialGroups = array (
			'ScientificName' => '0',
			'Family' => '1', 
			'Genus' => '2', 
			'Species' => '3', 
			'CatalogNumber' => '4',
			'StateProvince' => '5',
		);	

	var $translations = array ( "StateTerritory" => "StateProvince");


	function describe()
	{
		return	
			"An OzcamTranslator is a Translator that can read\n".
			"OZCAM2 Web Service Records\n\n".
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
		$args['OZCAM2 Record (enter 1 or more OZCAM2 xml records)'] = "<textarea cols='120' rows='15' name='record'>".
			"<records>\n".
			"<speciesRecord fuzz='yes' portSurvey='no'>\n".
			"	<DateLastModified>2005-05-06 17:15:00.00Z</DateLastModified>\n".
			"	<InstitutionCode>KE</InstitutionCode>\n".
			"	<CollectionCode>Triantiwontigongolops</CollectionCode>\n".
			"	<CatalogNumber>123456:117</CatalogNumber>\n".
			"	<ScientificName>Culumbodina occidentalis</ScientificName>\n".
			"	<Kingdom>Animalia</Kingdom>\n".
			"	<Phylum>Conodonta</Phylum>\n".
			"	<Family>Culumbodinadae</Family>\n".
			"	<Genus>Culumbodina</Genus>\n".
			"	<Species>occidentalis</Species>\n".
			"	<Longitude>79.41639</Longitude>\n".
			"	<Latitude> 9.16139</Latitude>\n".
			"	<StateTerritory>WA</StateTerritory>\n".
			"</speciesRecord>".
			"<speciesRecord>\n".
			"	<DateLastModified>2005-05-06 17:15:00.00Z</DateLastModified>\n".
			"	<InstitutionCode>KE</InstitutionCode>\n".
			"	<CollectionCode>Triantiwontigongolops</CollectionCode>\n".
			"	<CatalogNumber>123456:118</CatalogNumber>\n".
			"	<ScientificName>Pseudobelodina kirki</ScientificName>\n".
			"	<Kingdom>Animalia</Kingdom>\n".
			"	<Phylum>Conodonta</Phylum>\n".
			"	<Family>Pseudobelodindae</Family>\n".
			"	<Genus>Pseudobelodina</Genus>\n".
			"	<Species>kirki</Species>\n".
			"	<Longitude>79.41639</Longitude>\n".
			"	<Latitude> 9.16139</Latitude>\n".
			"	<StateTerritory>NSW</StateTerritory>\n".
			"</speciesRecord>".
			"<speciesRecord>\n".
			"	<DateLastModified>2005-05-06 17:15:00.00Z</DateLastModified>\n".
			"	<InstitutionCode>KE</InstitutionCode>\n".
			"	<CollectionCode>Triantiwontigongolops</CollectionCode>\n".
			"	<CatalogNumber>123456:119</CatalogNumber>\n".
			"	<ScientificName>Pseudobelodina vulgaris</ScientificName>\n".
			"	<Kingdom>Animalia</Kingdom>\n".
			"	<Phylum>Conodonta</Phylum>\n".
			"	<Family>Pseudobelodindae</Family>\n".
			"	<Genus>Pseudobelodina</Genus>\n".
			"	<Species>vulgaris</Species>\n".
			"	<Longitude>79.41639</Longitude>\n".
			"	<Latitude> 9.16139</Latitude>\n".
			"	<StateTerritory>VIC</StateTerritory>\n".
			"</speciesRecord>".
			"</records>".
			"</textarea>";
		$vars = array();
		$submission = "<input type='submit' name='action' value='translate' />";
		return $this->makeDiagnosticPage(
					'Test Ozcam Translator',
					'simple test',
					'',
					'./OzcamTranslator.php',
					$args,
					$submission,
					$vars,
					$this->describe()
				);
	}

}

if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'OzcamTranslator.php')
	{
		$translator = new OzcamTranslator();
		print $translator->test(true);
	}
}


?>

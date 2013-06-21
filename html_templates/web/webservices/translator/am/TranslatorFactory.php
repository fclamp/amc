<?php

/*
 *  Copyright (c) 1998-2009 KE Software Pty Ltd
 */

// NB this file probably best viewed with tabspace=3 if using 80
// character line terminal

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/translator/DigirTranslator.php');
require_once ($WEB_ROOT . '/webservices/translator/EMuTranslator.php');
require_once ($WEB_ROOT . '/webservices/translator/TexxmlTranslator.php');
require_once ($WEB_ROOT . '/webservices/translator/OzcamTranslator.php');



/**
*
* Translation Factory class
*
* used to create right instance of client
* specific Translator from common program
* interface
*
* to add new translator:
* 1. add require_once (translator-source.php)
* 2. add case matching it in switch statement
*
*
* Copyright (c) 1998-2009 KE Software Pty Ltd
*
* @package EMuWebServices
*
*/


class TranslatorFactory
{
	function TranslatorFactory($backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		$this->backendType = $backendType;
		$this->webRoot = $webRoot;
		$this->webDirName = $webDirName;
		$this->debugOn = $debugOn;
	}

	function getInstance($type='Generic')
	{
		switch (strtoupper($type))
		{
			case 'EMU'  :
				$translator = new AmEMuTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'TEXXML'  :
				$translator = new AmTexxmlTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'DIGIR':
				$translator = new DigirTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'OZCAM':
				$translator = new OzcamTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'GENERIC':
				$translator = new GenericTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			default:
				WebServiceObject::errorResponse("Error: creation of type: '$type' not implemented in TranslatorFactory.php");
				break;
		}
		return $translator;
	}
}

class AmEMuTranslator extends EMuTranslator 
{
	var $serviceName = "AmEMuTranslator";
	var $recordElement = 'tuple';
	var $potentialGroups = array (
			'ScientificName' => '0',
			'Class' => '1', 
			'Family' => '2', 
			'Genus' => '3', 
			'Species' => '4', 
			'irn'	=> '5',
			'Latitude'	=> '6',
		);	

	var $latitudeElement = 'Latitude';
	var $longitudeElement = 'Longitude';

	function configure()
        {
                $this->setTranslation('ecatalogue.atom[name=irn]','irn','integer');
                $this->setTranslation('ecatalogue.atom[name=QuiLatitude]','Latitude','float');
                $this->setTranslation('ecatalogue.atom[name=QuiLongitude]','Longitude','float');

		$this->setTranslation('ecatalogue.atom[name=QuiTaxonScientificName]','ScientificName','string');
                $this->setTranslation('ecatalogue.atom[name=QuiTaxonomyClass]','Class','string');
                $this->setTranslation('ecatalogue.atom[name=QuiTaxonomyFamily]','Family','string');
                $this->setTranslation('ecatalogue.atom[name=QuiTaxonomyGenus]','Genus','string');
                $this->setTranslation('ecatalogue.atom[name=QuiTaxonomySpecies]','Species','string');
                $this->setTranslation('ecatalogue.atom[name=SummaryData]','description','string');
	}

	function describe()
	{
		return	
			"An AmEMuTranslator is a AM specific EMuTranslator\n\n".
			parent::describe();
	}

	function makeTestPage()
	{
		$args = array();
		$args['EMu XML Record (enter 1 or more EMu xml records)'] = "<textarea cols='120' rows='15' name='data'>". <<<XML
<?xml version='1.0' encoding='ISO-8859-1' ?>
<table name='ecatalogue'>
	<!-- Row 1 -->
	<tuple>
		<atom name='irn'>1111891</atom>
		<atom name='QuiTaxonomyFamily'>Balanidae</atom>
		<atom name='QuiTaxonomyGenus'>Balanus</atom>
		<atom name='QuiTaxonomySpecies'>amphitrite</atom>
		<atom name='SummaryData'>P.17635 - Balanus amphitrite Darwin,
		1854 - WA, North Mole, Perth, Western Australia, Australia , 24 May 1969</atom>
		</tuple>
	<!-- Row 2 -->
	<tuple>
		<atom name='irn'>1174360</atom>
		<atom name='QuiTaxonomyFamily'>Balanidae</atom>
		<atom name='QuiTaxonomyGenus'>Balanus</atom>
		<atom name='QuiTaxonomySpecies'>variegatus</atom>
		<table name='QuiLatitude0'>
			<tuple>
				<atom name='QuiLatitude'>32 53 S</atom>
			</tuple>
		</table>
		<table name='QuiLongitude0'>
			<tuple>
				<atom name='QuiLongitude'>151 46 12 E</atom>
			</tuple>
		</table>
		<atom name='SummaryData'>P.70040 - Balanus variegatus Darwin,
		1854 - New South Wales, Newcastle , (32° 53' S , 151° 46' 12' E), 26 Aug 1997</atom>
	</tuple>
</table>

XML
			. "</textarea>";
		$vars = array("type" => "EMu");
		$submission = "<input type='submit' name='action' value='translate' />";

		return $this->makeDiagnosticPage(
					'Test EMu Translator',
					'simple test',
					'',
					'./TranslatorFactory.php',
					$args,
					$submission,
					$vars,
					$this->describe()
				);
	}

}

class AmTexxmlTranslator extends TexxmlTranslator 
{
	var $serviceName = "AmTexxmlTranslator";
	var $potentialGroups = array (
			'ScientificName' => '0',
			'Class' => '1', 
			'Family' => '2', 
			'Genus' => '3', 
			'Species' => '4', 
			'TypeStatus' => '5',
			'Latitude' => '6',
			'Longitude' => '7',
			'irn' => '8',
			'SummaryData' => '9',
		);	

	var $latitudeElement = 'Latitude';
	var $longitudeElement = 'Longitude';

	function configure()
	{
		$this->setTranslation('ecatalogue.irn_1','irn','integer');
		$this->setTranslation('ecatalogue.QuiTaxonScientificName','ScientificName','string');
		$this->setTranslation('ecatalogue.QuiLatitude0[QuiLatitude]','Latitude','float');
		$this->setTranslation('ecatalogue.QuiLongitude0[QuiLongitude]','Longitude','float');
		$this->setTranslation('ecatalogue.QuiTaxonomyFamily','Family','string');
		$this->setTranslation('ecatalogue.QuiTaxonomyGenus','Genus','string');
		$this->setTranslation('ecatalogue.QuiTaxonomySpecies','Species','string');
		$this->setTranslation('ecatalogue.SummaryData','SummaryData','string');
	}

	function makeTestPage()
	{
		$args = array();
		$args['Texxml XML Record (enter 1 or more Texxml XML records)'] = "<textarea cols='120' rows='15' name='data'>". <<<XML

<?xml version="1.0" encoding="ISO-8859-1"?>
<results status="success" matches="1">
  <record>
    <irn_1>10253302</irn_1>
    <QuiTaxonScientificName>Helix cincta Mueller, 1774</QuiTaxonScientificName>
    <QuiLatitude0>
      <QuiLatitude>35 00 00 N</QuiLatitude>
    </QuiLatitude0>
    <QuiLongitude0>
      <QuiLongitude>033 30 00 E</QuiLongitude>
    </QuiLongitude0>
    <QuiTaxonomyFamily>Helicidae</QuiTaxonomyFamily>
    <QuiTaxonomyGenus>Helix</QuiTaxonomyGenus>
    <QuiTaxonomySpecies>cincta</QuiTaxonomySpecies>
    <SummaryData>C.339052 - Helicidae: Helix cincta ,  (35° N , 033° 30&amp; apos; E),  1998</SummaryData>
  </record>
</results>


XML
		."</textarea>";
		$vars = array();
		$submission = "<input type='submit' name='action' value='translate' />";

		return $this->makeDiagnosticPage(
					'Test EMu Translator',
					'simple test',
					'',
					'./TranslatorFactory.php',
					$args,
					$submission,
					$vars,
					$this->describe()
				);
	}
}


if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'TranslatorFactory.php')
	{
		if (isset($_REQUEST['type']))
			$type = strtoupper($_REQUEST['type']);
		else
			$type = "TEXXML";

		$factory = new TranslatorFactory();
		$translator = $factory->getInstance($type);
		$translator->test(true);
	}
}


?>

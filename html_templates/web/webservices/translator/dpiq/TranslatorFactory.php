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
		switch ($type)
		{
			case 'emu'  :
			case 'Emu'  :
			case 'EMu'  :
				$translator = new DpiqEMuTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'texxml'  :
			case 'Texxml'  :
			case 'TexXml'  :
			case 'TexXML'  :
				$translator = new DpiqTexxmlTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'Digir':
				$translator = new DigirTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'Ozcam':
				$translator = new OzcamTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'Generic':
				$translator = new GenericTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			default:
				WebServiceObject::errorResponse("Error: creation of type: '$type' not implemented in TranslatorFactory.php");
				break;
		}
		return $translator;
	}
}

class DpiqEMuTranslator extends EMuTranslator 
{
	var $serviceName = "DpiqEMuTranslator";
	var $recordElement = 'tuple';
	var $potentialGroups = array (
			'ScientificName' => '0',
			'Class' => '1', 
			'Family' => '2', 
			'Genus' => '3', 
			'Species' => '4', 
			'TypeStatus' => '5',
		);	

	var $translations = array (
		'atom[name=DarScientificName]' => 'ScientificName',
		'atom[name=DarLatitude]' => 'latitude',
		'atom[name=DarLongitude]' => 'longitude',
		'atom[name=DarClass]' => 'Class',
		'atom[name=DarFamily]' => 'Family',
		'atom[name=DarGenus]' => 'Genus',
		'atom[name=DarSpecies]' => 'Species',
		'atom[name=DarSubSpecies]' => 'SubSpecies',
		'atom[name=DarTypeStatus]' => 'TypeStatus',
	);

	function describe()
	{
		return	
			"A DpiqEMuTranslator is a DPIQ specific EMuTranslator\n\n".
			Parent::describe();
	}

	function makeTestPage()
	{
		$args = array();
		$args['EMu XML Record (enter 1 or more EMu xml records)'] = "<textarea cols='120' rows='15' name='data'>". <<<XML
		 <!-- Data --> 
		 <table name='ecatalogue'> 
		  <!-- Row 1 --> 
		  <tuple>
		   <atom name='DarScientificName'>Mysella ovata (Jeffreys, 1881)</atom> 
		   <atom name='DarLatitude'> 38.076667</atom> 
		   <atom name='DarLongitude'>-74.028333</atom> 
		   <atom name='DarLocality'></atom>
		  </tuple>
		 </table>
XML
			. "</textarea>";
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

class DpiqTexxmlTranslator extends TexxmlTranslator 
{
	var $serviceName = "DpiqTexxmlTranslator";
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
		);	

	var $translations = array (
		'irn_1' => 'irn',
		'WebName' => 'ScientificName',
		'LocLatitude' => 'Latitude',
		'LocLongitude' => 'Longitude',
		'TaxFamily' => 'Family',
		'TaxGenus' => 'Genus',
		'TaxSpecies' => 'Species',
	);
	var $latitudeElement = 'Latitude';
	var $longitudeElement = 'Longitude';

	function makeTestPage()
	{
		$args = array();
		$args['EMu XML Record (enter 1 or more EMu xml records)'] = "<textarea cols='120' rows='15' name='data'>". <<<XML
<results status="success" matches="32">
  <record>
    <irn>
      <irn_1>586856</irn_1>
    </irn>
    <SummaryData>32714 [POR] Merriamium tortugasensis de
    Laubenfels, 1936 : Anchinoidae : Poecilosclerida : Demospongiae
    : Porifera; ; North Atlantic Ocean : : United States : : : : :
    Off North Carolina : 33 30 42 N : 77 23 42 W : Sta. MS04; 12
    Aug 1981; Duke Univers</SummaryData>
    <BioPreferredCentroidLatitude>33 30 42
    N</BioPreferredCentroidLatitude>
    <BioPreferredCentroidLongitude>077 23 42
    W</BioPreferredCentroidLongitude>
    <CatDepartment>Systematic Biology</CatDepartment>
    <CatCatalog>Porifera</CatCatalog>
    <CatCollectionName_tab>
      <CatCollectionName>MMS Collections</CatCollectionName>
      <CatCollectionName>South Atlantic Outer Continental Shelf
      Living Mari</CatCollectionName>
      <CatCollectionName>LMRS</CatCollectionName>
    </CatCollectionName_tab>
    <CatSection>Invertebrate Zoology</CatSection>
    <BioEventLocal>North Atlantic Ocean : : United States : : : : :
    Off North Carolina : 33 30 42 N : 77 23 42 W : Sta. MS04; 12
    Aug 1981; Duke University For Minerals Management
    Service/Bureau of Land Management BLM/ MMS; LMRS; 28; Sample
    No. 818209</BioEventLocal>
  </record>

  <record>
    <irn>
      <irn_1>587703</irn_1>
    </irn>
    <SummaryData>33561 [POR] Merriamium tortugasensis de
    Laubenfels, 1936 : Anchinoidae : Poecilosclerida : Demospongiae
    : Porifera; ; North Atlantic Ocean : : United States : : : : :
    Off North Carolina : 33 32 36 N : 77 25 24 W : Sta. MS04; 04
    Sep 1980; Duke Univers</SummaryData>
    <BioPreferredCentroidLatitude>33 32 36
    N</BioPreferredCentroidLatitude>
    <BioPreferredCentroidLongitude>077 25 24
    W</BioPreferredCentroidLongitude>
    <CatDepartment>Systematic Biology</CatDepartment>
    <CatCatalog>Porifera</CatCatalog>
    <CatCollectionName_tab>
      <CatCollectionName>MMS Collections</CatCollectionName>
      <CatCollectionName>South Atlantic Outer Continental Shelf
      Living Mari</CatCollectionName>
      <CatCollectionName>LMRS</CatCollectionName>
    </CatCollectionName_tab>
    <CatSection>Invertebrate Zoology</CatSection>
    <BioEventLocal>North Atlantic Ocean : : United States : : : : :
    Off North Carolina : 33 32 36 N : 77 25 24 W : Sta. MS04; 04
    Sep 1980; Duke University For Minerals Management
    Service/Bureau of Land Management BLM/ MMS; LMRS; 33; Sample
    No. 809040</BioEventLocal>
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
		$factory = new TranslatorFactory();
		$translator = $factory->getInstance('EMu');
		#$translator = $factory->getInstance('Texxml');
		$translator->test(true);
	}
}


?>

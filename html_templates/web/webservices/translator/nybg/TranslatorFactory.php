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
			case 'EMu'  :
				$translator = new NybgEMuTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'texxml'  :
			case 'Texxml'  :
			case 'TexXml'  :
			case 'TexXML'  :
				$translator = new NybgTexxmlTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
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

class NybgEMuTranslator extends EMuTranslator 
{
	var $serviceName = "NybgEMuTranslator";
	var $recordElement = 'tuple';
	var $potentialGroups = array (
			'ScientificName' => '0',
			'Class' => '1', 
			'Family' => '2', 
			'Genus' => '3', 
			'TypeStatus' => '4',
		);	

	var $translations = array (
		'atom[name=IdeQualifiedName]' => 'ScientificName',
		'atom[name=LatCentroidLatitude]' => 'latitude',
		'atom[name=LatCentroidLongitude]' => 'longitude',
		'atom[name=IdeFiledAsClassLocal]' => 'Class',
		'atom[name=IdeFiledAsFamilyLocal]' => 'Family',
		'atom[name=IdeFiledAsGenusLocal]' => 'Genus',
		'atom[name=IdeFiledAsSpeciesLocal]' => 'Species',
		'atom[name=IdeFiledAsSubSpecies]' => 'SubSpecies',
		'atom[name=IdeFiledAsTypeStatus]' => 'TypeStatus',
	);

	function describe()
	{
		return	
			"An NybgEMuTranslator is a NYBG specific EMuTranslator\n\n".
			Parent::describe();
	}

	function makeTestPage()
	{
		$args = array();
		$args['EMu XML Record (enter 1 or more EMu xml records)'] = "<textarea cols='120' rows='15' name='data'>".
			'<table name="ecatalogue">' ."\n".
			'  <tuple>' ."\n".
			'    <atom name="irn">9007717</atom>' ."\n".
			'    <tuple name="BioSiteRef">' ."\n".
			'      <table name="LatCentroidLatitude0">' ."\n".
			'        <tuple>' ."\n".
			'          <atom name="LatCentroidLatitude">17 09 04 N</atom>' ."\n".
			'        </tuple>' ."\n".
			'      </table>' ."\n".
			'      <table name="LatCentroidLongitude0">' ."\n".
			'        <tuple>' ."\n".
			'          <atom name="LatCentroidLongitude">088 44 21 E</atom>' ."\n".
			'        </tuple>' ."\n".
			'      </table>' ."\n".
			'    </tuple>' ."\n".
			'    <table name="IdeQualifiedName_tab">' ."\n".
			'      <tuple>' ."\n".
			'        <atom name="IdeQualifiedName">Chagasia bathana</atom>' ."\n".
			'      </tuple>' ."\n".
			'    </table>' ."\n".
			'    <atom name="SummaryData"> [MOSQUITO] Chagasia bathana : Culicidae : Diptera : :; ; [irn: 9008935]</atom>' ."\n".
			'    <atom name="CatNumber"/>' ."\n".
			'    <atom name="CatCatalog">Mosquito</atom>' ."\n".
			'    <atom name="IdeFiledAsClass">4B</atom>' ."\n".
			'    <atom name="IdeFiledAsFamily">Culicidae</atom>' ."\n".
			'    <atom name="IdeFiledAsGenus">Chagasia</atom>' ."\n".
			'    <atom name="IdeFiledAsSpecies">bathana</atom>' ."\n".
			'    <atom name="IdeFiledAsSubSpecies"/>' ."\n".
			'    <atom name="IdeFiledAsTypeStatus">Kellyotype</atom>' ."\n".
			'  </tuple>' ."\n".
			'<!-- Row 5 -->' ."\n".
			'  <tuple>' ."\n".
			'    <atom name="irn">9008655</atom>' ."\n".
			'    <tuple name="BioSiteRef">' ."\n".
			'      <table name="LatCentroidLatitude0">' ."\n".
			'        <tuple>' ."\n".
			'          <atom name="LatCentroidLatitude">09 17 19 N</atom>' ."\n".
			'        </tuple>' ."\n".
			'      </table>' ."\n".
			'      <table name="LatCentroidLongitude0">' ."\n".
			'        <tuple>' ."\n".
			'          <atom name="LatCentroidLongitude">082 24 08 E</atom>' ."\n".
			'        </tuple>' ."\n".
			'      </table>' ."\n".
			'    </tuple>' ."\n".
			'    <table name="IdeQualifiedName_tab">' ."\n".
			'      <tuple>' ."\n".
			'        <atom name="IdeQualifiedName">Chagasia bathana</atom>' ."\n".
			'      </tuple>' ."\n".
			'    </table>' ."\n".
			'    <atom name="SummaryData"> [MOSQUITO] Chagasia bathana : Culicidae : Diptera : :; ; [irn: 9005750]</atom>' ."\n".
			'    <atom name="CatNumber"/>' ."\n".
			'    <atom name="CatCatalog">Mosquito</atom>' ."\n".
			'    <atom name="IdeFiledAsClass"/>' ."\n".
			'    <atom name="IdeFiledAsFamily">Culicidae</atom>' ."\n".
			'    <atom name="IdeFiledAsGenus">Chagasia</atom>' ."\n".
			'    <atom name="IdeFiledAsSpecies">bathana</atom>' ."\n".
			'    <atom name="IdeFiledAsSubSpecies"/>' ."\n".
			'    <atom name="IdeFiledAsTypeStatus"/>' ."\n".
			'  </tuple>' ."\n".
			'<!-- Row 6 -->' ."\n".
			'  <tuple>' ."\n".
			'    <atom name="irn">9009315</atom>' ."\n".
			'    <tuple name="BioSiteRef">' ."\n".
			'																																											        </tuple>' ."\n".
			'    <table name="IdeQualifiedName_tab">' ."\n".
			'      <tuple>' ."\n".
			'        <atom name="IdeQualifiedName">Chagasia bathana</atom>' ."\n".
			'      </tuple>' ."\n".
			'    </table>' ."\n".
			'    <atom name="SummaryData"> [MOSQUITO] Chagasia bathana : Culicidae : Diptera : :; ; [irn: 9004308]</atom>' ."\n".
			'    <atom name="CatNumber"/>' ."\n".
			'    <atom name="CatCatalog">Mosquito</atom>' ."\n".
			'    <atom name="IdeFiledAsClass"/>' ."\n".
			'    <atom name="IdeFiledAsFamily">Culicidae</atom>' ."\n".
			'    <atom name="IdeFiledAsGenus">Chagasia</atom>' ."\n".
			'    <atom name="IdeFiledAsSpecies">bathana</atom>' ."\n".
			'    <atom name="IdeFiledAsSubSpecies"/>' ."\n".
			'    <atom name="IdeFiledAsTypeStatus"/>' ."\n".
			'  </tuple>' ."\n".
			'</table>' ."\n".
			"</textarea>";
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

class NybgTexxmlTranslator extends TexxmlTranslator 
{
	var $serviceName = "NybgTexxmlTranslator";
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
		'DetFiledAsQualifiedName' => 'ScientificName',
		'DetCentroidLatitude' => 'Latitude',
		'DetCentroidLongitude' => 'Longitude',
		'DetFiledAsClassLocal' => 'Class',
		'DetFiledAsFamilyLocal' => 'Family',
		'DetFiledAsGenusLocal' => 'Genus',
		'DetFiledAsSpeciesLocal' => 'Species',
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
		$translator = $factory->getInstance('Texxml');
		$translator->test(true);
	}
}


?>

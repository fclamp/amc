<?php

/*
 *  Copyright (c) 1998-2009 KE Software Pty Ltd
 */

// NB this file probably best viewed with tabspace=3 if using 80
// character line terminal



/*  Factory class used to create right instance of 
 *  translator objects.
 */

/* to add new translator:
 * 1. add require_once (translator-source.php)
 * 2. add case matching it in switch statement
 */




if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/translator/DigirTranslator.php');
require_once ($WEB_ROOT . '/webservices/translator/EMuTranslator.php');
require_once ($WEB_ROOT . '/webservices/translator/TexxmlTranslator.php');
require_once ($WEB_ROOT . '/webservices/translator/OzcamTranslator.php');


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
				$translator = new MvEMuTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'TEXXML'  :
				$translator = new MvTexxmlTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
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

class MvEMuTranslator extends EMuTranslator 
{
	var $serviceName = "MvEMuTranslator";
	var $recordElement = 'tuple';
	var $potentialGroups = array (
			'ScientificName' => '0',
			'Class' => '1', 
			'Family' => '2', 
			'Genus' => '3', 
			'TypeStatus' => '4',
		);	

	var $latitudeElement = 'Latitude';
	var $longitudeElement = 'Longitude';

	function configure()
        {
		$this->setTranslation('ecatalogue.atom[name=irn]','irn','integer');
		$this->setTranslation('ecatalogue.atom[name=DarScientificName]','ScientificName','string');
		$this->setTranslation('ecatalogue.atom[name=DarDecimalLatitude]','Latitude','float');
		$this->setTranslation('ecatalogue.atom[name=DarDecimalLongitude]','Longitude','float');
		$this->setTranslation('ecatalogue.atom[name=DarClass]','Class','string');
		$this->setTranslation('ecatalogue.atom[name=DarFamily]','Family','string');
		$this->setTranslation('ecatalogue.atom[name=DarGenus]','Genus','string');
		$this->setTranslation('ecatalogue.atom[name=DarSpecies]','Species','string');
		$this->setTranslation('ecatalogue.atom[name=DarSubspecies]','SubSpecies','string');
		$this->setTranslation('ecatalogue.atom[name=DarTypeStatus]','TypeStatus','string');
	}

	function describe()
	{
		return	
			"An MvEMuTranslator is a MV specific EMuTranslator\n\n".
			parent::describe();
	}

	function makeTestPage()
	{
		$args = array();
		$args['EMu XML Record (enter 1 or more EMu xml records)'] = "<textarea cols='120' rows='15' name='data'>".<<<XML
<!-- Data -->
<table name="ecatalogue">
  <!-- Row 1 -->
  <tuple>
    <atom name="DarScientificName">Anopheles Anopheles vestitipennis</atom>
    <atom name="DarDecimalLatitude">10.345</atom>
    <atom name="DarDecimalLongitude">85.347</atom>
    <atom name="DarFamily">Culicidae</atom>
    <atom name="DarGenus">Anopheles</atom>
    <atom name="DarSpecies">vestitipennis</atom>
    <atom name="SummaryData">[irn: 224]</atom>
  </tuple>
  <!-- Row 2 -->
  <tuple>
    <atom name="DarScientificName">Anopheles Anopheles vestitipennis</atom>
    <atom name="DarDecimalLatitude">30.692</atom>
    <atom name="DarDecimalLongitude">32.270</atom>
    <atom name="DarFamily">Culicidae</atom>
    <atom name="DarGenus">Anopheles</atom>
    <atom name="DarSpecies">vestitipennis</atom>
    <atom name="SummaryData">[irn: 233]</atom>
  </tuple>
  <!-- Row 6 -->
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

class MvTexxmlTranslator extends TexxmlTranslator 
{
	var $serviceName = "MvTexxmlTranslator";
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

	var $latitudeElement = 'Latitude';
	var $longitudeElement = 'Longitude';

	function configure()
	{
		$this->setTranslation('ecatalogue.irn_1','irn','integer');
		$this->setTranslation('ecatalogue.DarScientificName','ScientificName','string');
		$this->setTranslation('ecatalogue.DarDecimalLatitude','Latitude','float');
		$this->setTranslation('ecatalogue.DarDecimalLongitude','Longitude','float');
		$this->setTranslation('ecatalogue.DarClass','Class','string');
		$this->setTranslation('ecatalogue.DarFamily','Family','string');
		$this->setTranslation('ecatalogue.DarGenus','Genus','string');
		$this->setTranslation('ecatalogue.DarSpecies','Species','string');
		$this->setTranslation('ecatalogue.DarSubspecies','SubSpecies','string');
		$this->setTranslation('ecatalogue.DarTypeStatus','TypeStatus','string');
	}

	function makeTestPage()
	{
		$args = array();
		$args['EMu XML Record (enter 1 or more EMu xml records)'] = "<textarea cols='120' rows='15' name='data'>".  <<<XML
<results status="success" matches="2">
  <record>
    <irn_1>224</irn_1>
    <DarScientificName>Anopheles Anopheles  vestitipennis</DarScientificName>
    <DarDecimalLatitude>10.345</DarDecimalLatitude>
    <DarDecimalLongitude>85.347</DarDecimalLongitude>
    <DarClass />
    <DarFamily>Culicidae</DarFamily>
    <DarGenus>Anopheles</DarGenus>
    <DarSpecies>vestitipennis</DarSpecies>
    <DarSubspecies />
    <DarTypeStatus />
    <SummaryData>[irn: 224]</SummaryData>
  </record>
  <record>
    <irn_1>233</irn_1>
    <DarScientificName>Anopheles Anopheles  vestitipennis</DarScientificName>
    <DarDecimalLatitude>30.692</DarDecimalLatitude>
    <DarDecimalLongitude>32.270</DarDecimalLongitude>
    <DarClass />
    <DarFamily>Culicidae</DarFamily>
    <DarGenus>Anopheles</DarGenus>
    <DarSpecies>vestitipennis</DarSpecies>
    <DarSubspecies />
    <DarTypeStatus />
    <SummaryData>[irn: 233]</SummaryData>
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

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
				$translator = new NhdemoEMuTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'TEXXML'  :
				$translator = new NhdemoTexxmlTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
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

class NhdemoEMuTranslator extends EMuTranslator 
{
	var $serviceName = "NhdemoEMuTranslator";
	var $recordElement = 'tuple';
	var $potentialGroups = array (
			'ScientificName' => '0',
			'Class' => '1', 
			'Family' => '2', 
			'Genus' => '3', 
			'Species' => '4', 
			'TypeStatus' => '5',
			'irn' => '6',
		);	

	var $latitudeElement = 'Latitude';
        var $longitudeElement = 'Longitude';

	function configure()
	{
		$this->setTranslation('ecatalogue.atom[name=irn]','irn','integer');
		$this->setTranslation('ecatalogue.atom[name=DarLatitude]','Latitude','float');
		$this->setTranslation('ecatalogue.atom[name=DarLongitude]','Longitude','float');
		$this->setTranslation('ecatalogue.atom[name=DarScientificName]','ScientificName','string');
		$this->setTranslation('ecatalogue.atom[name=DarClass]','Class','string');
		$this->setTranslation('ecatalogue.atom[name=DarFamily]','Family','string');
		$this->setTranslation('ecatalogue.atom[name=DarGenus]','Genus','string');
		$this->setTranslation('ecatalogue.atom[name=DarSpecies]','Species','string');
		$this->setTranslation('ecatalogue.atom[name=DarSubSpecies]','SubSpecies','string');
		$this->setTranslation('ecatalogue.atom[name=DarTypeStatus]','TypeStatus','string');
	}

	function describe()
	{
		return	
			"A NhdemoEMuTranslator is a NHDEMO specific EMuTranslator\n\n".
			parent::describe();
	}

	function makeTestPage()
	{
		$args = array();
		$args['EMu XML Record (enter 1 or more EMu xml records)'] = "<textarea cols='120' rows='15' name='data'>". <<<XML
		<results>
		 <table name='ecatalogue'> 
		  <tuple>
    		   <atom name="irn">634317</atom>
		   <atom name='DarScientificName'>Mysella ovata (Jeffreys, 1881)</atom> 
		   <atom name='DarLatitude'> 38.076667</atom> 
		   <atom name='DarLongitude'>-74.028333</atom> 
		   <atom name='DarLocality'></atom>
		  </tuple>
		  <tuple>
    		   <atom name="irn">634316</atom>
		   <atom name='DarScientificName'>Mysella ovata (Jeffreys, 1881)</atom> 
		   <atom name='DarLatitude'>38.076667</atom> 
		   <atom name='DarLongitude'>-74.028333</atom> 
		  </tuple>
		 </table>
		</results>
XML
			. "</textarea>";
		$vars = array('EMu' => '1');
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

class NhdemoTexxmlTranslator extends TexxmlTranslator 
{
	var $serviceName = "NhdemoTexxmlTranslator";
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
		$this->setTranslation('ecatalogue.DarLatitude','Latitude','float');
		$this->setTranslation('ecatalogue.DarLongitude','Longitude','float');
		$this->setTranslation('ecatalogue.DarGenus','Genus','string');
		$this->setTranslation('ecatalogue.DarFamily','Family','string');
		$this->setTranslation('ecatalogue.DarCatalogNumberNumeric','CatalogNumberNumeric','integer');
		$this->setTranslation('ecatalogue.SummaryData','Summary','string');
	}

	function makeTestPage()
	{
		$args = array();
		$args['EMu XML Record (enter 1 or more EMu xml records)'] = "<textarea cols='120' rows='15' name='data'>". <<<XML
<results status="success" matches="2">
  <record>
    <irn>
      <irn_1>1</irn_1>
    </irn>
    <SummaryData>Echo Beach, Far Away In Time</SummaryData> 
    <LatCentroidLatitudeDec_tab>
       <LatCentroidLatitudeDec>38.076667</LatCentroidLatitudeDec> 
    </LatCentroidLatitudeDec_tab>
    <LatCentroidLongitudeDec_tab>
       <LatCentroidLongitudeDec>-74.028333</LatCentroidLongitudeDec> 
    </LatCentroidLongitudeDec_tab>
  </record>
  <record>
    <irn>
      <irn_1>586856</irn_1>
    </irn>
    <SummaryData>Blah Blah</SummaryData>
    <BioPreferredCentroidLatitude>33 30 42 N</BioPreferredCentroidLatitude>
    <BioPreferredCentroidLongitude>077 23 42 W</BioPreferredCentroidLongitude>
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
		if (isset($_REQUEST['EMu']))
			$translator = $factory->getInstance('EMu');
		else	
			$translator = $factory->getInstance('Texxml');
		$translator->test(true);
	}
}


?>

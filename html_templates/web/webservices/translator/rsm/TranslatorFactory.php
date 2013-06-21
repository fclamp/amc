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
				$translator = new RsmEMuTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'texxml'  :
			case 'Texxml'  :
			case 'TexXml'  :
			case 'TexXML'  :
				$translator = new RsmTexxmlTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
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

class RsmEMuTranslator extends EMuTranslator 
{
	var $serviceName = "RsmEMuTranslator";
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

	/*var $translations = array (
		# catalogue translations
		'ecatalogue.atom[name=ClaScientificName]' => 'ScientificName',
		'ecatalogue.atom[name=LatCentroidLatitude]' => 'latitude',
		'ecatalogue.atom[name=LatCentroidLongitude]' => 'longitude',
		'ecatalogue.atom[name=DarClass]' => 'Class',
		'ecatalogue.atom[name=ClaFamily]' => 'Family',
		'ecatalogue.atom[name=ClaGenus]' => 'Genus',
		'ecatalogue.atom[name=ClaSpecies]' => 'Species',
		'ecatalogue.atom[name=DarSubSpecies]' => 'SubSpecies',
		'ecatalogue.atom[name=DarTypeStatus]' => 'TypeStatus',

		# esites translations
		'esites.atom[name=LatCentroidLatitudeDec]' => 'latitude',
		'esites.atom[name=LatCentroidLongitudeDec]' => 'longitude',
	);*/

	function configure()
        {
                $this->setTranslation('ecatalogue.atom[name=irn]','irn','integer');
                $this->setTranslation('ecatalogue.atom[name=LatCentroidLatitudeDecLocal]','latitude','float');
                $this->setTranslation('ecatalogue.atom[name=LatCentroidLongitudeDecLocal]','longitude','float');

                $this->setTranslation('ecatalogue.atom[name=ClaScientificName]','ScientificName','string');

                $this->setTranslation('ecatalogue.atom[name=ClaClass]','Class','string');
                $this->setTranslation('ecatalogue.atom[name=ClaFamily]','Family','string');
                $this->setTranslation('ecatalogue.atom[name=ClaGenus]','Genus','string');
                $this->setTranslation('ecatalogue.atom[name=ClaSpecies]','Species','string');
                $this->setTranslation('ecatalogue.atom[name=ClaSubspecies]','Subspecies','string');
                $this->setTranslation('ecatalogue.atom[name=SecDepartment]','Department','string');
                $this->setTranslation('ecatalogue.atom[name=TaxTaxonomy_tab]','Taxonomy','string');

                $this->setTranslation('ecatalogue.atom[name=SummaryData]','description','string');

                $this->setTupleNumber("ScientificName",1);
                $this->setTupleNumber("Family",1);
                $this->setTupleNumber("Genus",1);
	}


	function describe()
	{
		return	
			"A RsmEMuTranslator is a RSM specific EMuTranslator\n\n".
			Parent::describe();
	}

	function makeTestPage()
	{
		$args = array();
		$args['EMu XML Record (enter 1 or more EMu xml records)'] = "<textarea cols='120' rows='15' name='data'>". <<<XML
		<results>
		 <!-- Data --> 
		 <table name='esites'> 
		  <!-- Row 1 --> 
		  <tuple>
		   <atom name='SummaryData'>Echo Beach, Far Away In Time</atom> 
		   <atom name='LatCentroidLatitudeDec'>38.076667</atom> 
		   <atom name='LatCentroidLongitudeDec'>-74.028333</atom> 
		  </tuple>
		 </table>
		 <table name='ecatalogue'> 
		  <!-- Row 1 --> 
		  <tuple>
		   <atom name='DarScientificName'>Mysella ovata (Jeffreys, 1881)</atom> 
		   <atom name='DarLatitude'> 38.076667</atom> 
		   <atom name='DarLongitude'>-74.028333</atom> 
		   <atom name='DarLocality'></atom>
		  </tuple>
		 </table>
		</results>
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

class RsmTexxmlTranslator extends TexxmlTranslator 
{
	var $serviceName = "RsmTexxmlTranslator";
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

/*	var $translations = array (
		# catalogue translations
		'ecatalogue.irn_1' => 'irn',
		'ecatalogue.IdeFiledAsQualifiedName' => 'ScientificName',
		'ecatalogue.BioPreferredCentroidLatitude' => 'Latitude',
		'ecatalogue.BioPreferredCentroidLongitude' => 'Longitude',
		'ecatalogue.IdeFiledAsClass' => 'Class',
		'ecatalogue.IdeFiledAsFamily' => 'Family',
		'ecatalogue.IdeFiledAsGenus' => 'Genus',
		'ecatalogue.IdeFiledAsSpecies' => 'Species',
		'ecatalogue.IdeFiledAsSubSpecies' => 'SubSpecies',
		'ecatalogue.IdeFiledAsTypeStatus' => 'TypeStatus',

		# esites translations
		'esites.LatCentroidLatitudeDec' => 'Latitude',
		'esites.LatCentroidLongitudeDec' => 'Longitude',
	);*/

	var $latitudeElement = 'Latitude';
	var $longitudeElement = 'Longitude';

	function configure()
	{
		$this->setTranslation('ecatalogue.irn_1','irn','integer');
		$this->setTranslation('ecatalogue.IdeScientificNameLocal_tab','ScientificName','string');
		$this->setTranslation('ecatalogue.LatCentroidLatitude0','Latitude','float');
		$this->setTranslation('ecatalogue.LatCentroidLongitude0','Longitude','float');
		$this->setTranslation('ecatalogue.ClaGenus','Genus','string');
		$this->setTranslation('ecatalogue.ClaFamily','Family','string');
		$this->setTranslation('ecatalogue.ClaSpecies','Species','string');
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
		$translator = $factory->getInstance('EMu');
		#$translator = $factory->getInstance('Texxml');
		$translator->test(true);
	}
}


?>

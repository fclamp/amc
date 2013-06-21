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
				$translator = new RbgnswEMuTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'TEXXML'  :
				$translator = new RbgnswTexxmlTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'GARDEN' :
				$translator = new RbgnswGardenTexxmlTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
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

class RbgnswEMuTranslator extends EMuTranslator 
{
	var $serviceName = "RbgnswEMuTranslator";
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
		# catalogue translations
		'ecatalogue.atom[name=QuiTaxonomyScientificName]' => 'ScientificName',
		'ecatalogue.atom[name=QuiLatitude]' => 'latitude',
		'ecatalogue.atom[name=QuiLongitude]' => 'longitude',
		'ecatalogue.atom[name=QuiTaxonomyFamily]' => 'Family',
		'ecatalogue.atom[name=QuiTaxonomyGenus]' => 'Genus',
		'ecatalogue.atom[name=QuiTaxonomySpecies]' => 'Species',
	);

	function describe()
	{
		return	
			"A RbgnswEMuTranslator is a RBGNSW specific EMuTranslator\n\n".
			parent::describe();
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
		$vars["type"] = "EMu";
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

class RbgnswTexxmlTranslator extends TexxmlTranslator 
{
	var $serviceName = "RbgnswTexxmlTranslator";
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
			'Summary' => '9',
		);	

	var $latitudeElement = 'Latitude';
	var $longitudeElement = 'Longitude';

	function configure()
	{
		$this->setTranslation('ecatalogue.irn_1','irn','integer');
		$this->setTranslation('ecatalogue.LatDec','Latitude','float');
		$this->setTranslation('ecatalogue.LongDec','Longitude','float');
		$this->setTranslation('ecatalogue.QuiTaxonomyScientificName','ScientificName','string');
		$this->setTranslation('ecatalogue.QuiTaxonomyFamily','Family','string');
		$this->setTranslation('ecatalogue.QuiTaxonomyGenus','Genus','string');
		$this->setTranslation('ecatalogue.QuiTaxonomySpecies','Species','string');
		$this->setTranslation('ecatalogue.SummaryData','Summary','string');
	}

	function makeTestPage()
	{
		$args = array();
		$args['EMu Texxml Record (enter 1 or more EMu Texxml records)'] = "<textarea cols='120' rows='15' name='data'>". <<<XML
<results status="success" matches="147">
  <record>
    <irn_1>707207</irn_1>
    <LatDec>33 33 33 S</LatDec>
    <LongDec>151 33 33 E</LongDec>
    <QuiTaxonomyScientificName>Agathis microstachya Bailey &amp; amp; C.T.White</QuiTaxonomyScientificName>
    <QuiTaxonomyFamily>Araucariaceae</QuiTaxonomyFamily>
    <QuiTaxonomyGenus>Agathis</QuiTaxonomyGenus>
    <QuiTaxonomySpecies>microstachya</QuiTaxonomySpecies>
    <SummaryData>NSW707207 Garden Agathis microstachya Bailey &amp; amp; C.T.White [Acc.No./Old No.20010050]</SummaryData>
  </record>
  <record>
    <irn_1>4059334</irn_1>
    <LatDec>34 34 34 S</LatDec>
    <LongDec>152 34 34 E</LongDec>
    <QuiTaxonomyScientificName>Agathis atropurpurea B.Hyland</QuiTaxonomyScientificName>
    <QuiTaxonomyFamily>Araucariaceae</QuiTaxonomyFamily>
    <QuiTaxonomyGenus>Agathis</QuiTaxonomyGenus>
    <QuiTaxonomySpecies>atropurpurea</QuiTaxonomySpecies>
    <SummaryData>NSW4059334 Garden Agathis atropurpurea B.Hyland [Acc.No./Old No.13914]</SummaryData>
  </record>

XML
		."</textarea>";
		$vars = array();
		$vars["type"] = "texxml";
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

class RbgnswGardenTexxmlTranslator extends TexxmlTranslator 
{
	var $serviceName = "RbgnswTexxmlTranslator";
	var $potentialGroups = array (
			'irn' => '0',
			'CommonName' => '1',
			'ScientificName' => '2',
			'Location' => '3',
			'Family' => '4', 
			'Genus' => '5', 
			'MultimediaIrn' => '6',
			'NativeExotic' => '8',
		);	

	var $latitudeElement = 'Latitude';
	var $longitudeElement = 'Longitude';

	function configure()
	{
		$this->setTranslation('ecatalogue.irn_1','irn','integer');
		$this->setTranslation('ecatalogue.LatDec','Latitude','float');
		$this->setTranslation('ecatalogue.LongDec','Longitude','float');
		$this->setTranslation('ecatalogue.QuiTaxonomyScientificName','ScientificName','string');
		$this->setTranslation('ecatalogue.QuiTaxonomyFamily','Family','string');
		$this->setTranslation('ecatalogue.QuiTaxonomyGenus','Genus','string');
		$this->setTranslation('ecatalogue.QuiTaxonomySpecies','Species','string');
		$this->setTranslation('ecatalogue.QuiTaxonomyCommonName_tab[QuiTaxonomyCommonName]','CommonName','string');
		$this->setTranslation('ecatalogue.SummaryData','Summary','string');
		$this->setTranslation('ecatalogue.MulMultiMediaRef_tab[MulMultiMediaRef]','MultimediaIrn','integer');
		$this->setTranslation('ecatalogue.LocCurrentLocationLocal','Location','string');
		$this->setTranslation('ecatalogue.CorNative','NativeExotic','string');
	}

	function makeTestPage()
	{
		$args = array();
		$args['Garden XML Record (enter 1 or more Garden xml records)'] = "<textarea cols='120' rows='15' name='data'>". <<<XML
<results status="success" matches="2">
  <record>
    <irn_1>4114530</irn_1>
    <LatDec>33 51 54 S</LatDec>
    <LongDec>151 13 07 E</LongDec>
    <QuiTaxonomyScientificName>Agathis robusta (F.Muell.) Bailey</QuiTaxonomyScientificName>
    <QuiTaxonomyFamily>Araucariaceae</QuiTaxonomyFamily>
    <QuiTaxonomyGenus>Agathis</QuiTaxonomyGenus>
    <QuiTaxonomySpecies>robusta</QuiTaxonomySpecies>
    <QuiTaxonomyCommonName_tab>
      <QuiTaxonomyCommonName>Queensland Kauri Pine</QuiTaxonomyCommonName>
    </QuiTaxonomyCommonName_tab>
    <SummaryData>NSW4114530 Garden Agathis robusta (F.Muell.) Bailey [Acc.No./Old No.863429]</SummaryData>
    <MulMultiMediaRef_tab>
      <MulMultiMediaRef>9539</MulMultiMediaRef>
      <MulMultiMediaRef>9349</MulMultiMediaRef>
      <MulMultiMediaRef>35984</MulMultiMediaRef>
    </MulMultiMediaRef_tab>
    <LocCurrentLocationLocal>ANNAN GARDENS - bed gap - grid M8</LocCurrentLocationLocal>
    <CorNative>N</CorNative>
  </record>
  <record>
    <irn_1>4114531</irn_1>
    <LatDec>33 51 33 S</LatDec>
    <LongDec>151 12 57 E</LongDec>
    <QuiTaxonomyScientificName>Agathis robusta (F.Muell.) Bailey</QuiTaxonomyScientificName>
    <QuiTaxonomyFamily>Araucariaceae</QuiTaxonomyFamily>
    <QuiTaxonomyGenus>Agathis</QuiTaxonomyGenus>
    <QuiTaxonomySpecies>robusta</QuiTaxonomySpecies>
    <QuiTaxonomyCommonName_tab>
      <QuiTaxonomyCommonName>Queensland Kauri Pine</QuiTaxonomyCommonName>
    </QuiTaxonomyCommonName_tab>
    <SummaryData>NSW4114531 Garden Agathis robusta (F.Muell.) Bailey [Acc.No./Old No.863429]</SummaryData>
    <MulMultiMediaRef_tab>
      <MulMultiMediaRef>9807</MulMultiMediaRef>
    </MulMultiMediaRef_tab>
    <LocCurrentLocationLocal>ANNAN GARDENS - bed gap - grid M8</LocCurrentLocationLocal>
    <CorNative>N</CorNative>
  </record>
</results>


XML
		."</textarea>";
		$vars = array();
		$vars["type"] = "garden";
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
	$type = "EMu";
	if (isset($_REQUEST['type']))
	{
		$type = $_REQUEST['type'];
	}

	if (basename($_SERVER['PHP_SELF']) == 'TranslatorFactory.php')
	{
		$factory = new TranslatorFactory();
		$translator = $factory->getInstance($type);
		$translator->test(true);
	}
}


?>

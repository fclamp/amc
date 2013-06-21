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
				$translator = new TePapaEMuTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'TEXXML'  :
				$translator = new TePapaTexxmlTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
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

class TePapaEMuTranslator extends EMuTranslator 
{
	var $serviceName = "TePapaEMuTranslator";
	var $recordElement = 'tuple';
	var $potentialGroups = array (
			'ScientificName' => '0',
			'Family' => '2', 
			'Genus' => '3', 
			'Species' => '4', 
			'irn' => '6',
			'Collector' => '7',
			'CollectionMethod' => '8',

		);	
	var $latitudeElement = 'Latitude';
	var $longitudeElement = 'Longitude';



	function configure()
        {
                $this->setTranslation('ecatalogue.atom[name=irn]','irn','integer');
                $this->setTranslation('ecatalogue.atom[name=LatCentroidLatitudeDec]','Latitude','float');
                $this->setTranslation('ecatalogue.atom[name=LatCentroidLongitudeDec]','Longitude','float');

                $this->setTranslation('ecatalogue.atom[name=ClaScientificName]','ScientificName','string');
                $this->setTranslation('ecatalogue.atom[name=ClaFamily]','Family','string');
                $this->setTranslation('ecatalogue.atom[name=ClaGenus]','Genus','string');
                $this->setTranslation('ecatalogue.atom[name=ClaSpecies]','Species','string');
                $this->setTranslation('ecatalogue.atom[name=SecDepartment]','Department','string');

                $this->setTranslation('ecatalogue.atom[name=SummaryData]','description','string');
                $this->setTranslation('ecatalogue.atom[name=ColCollectionMethod]','CollectionMethod','string');
                $this->setTranslation('ecatalogue.atom[name=ColParticipantString]','Collector','string');
		

                $this->setTupleNumber("ScientificName",1);
                $this->setTupleNumber("Family",1);
                $this->setTupleNumber("Genus",1);
                $this->setTupleNumber("Species",1);

	}


	function describe()
	{
		return	
			"A TePapaEMuTranslator is a TEPAPA specific EMuTranslator\n\n".
			parent::describe();
	}

	function makeTestPage()
	{
		$args = array();
		$args['EMu XML Record (enter 1 or more EMu xml records)'] = "<textarea cols='120' rows='15' name='data'>". <<<XML
<?xml version='1.0' encoding='ISO-8859-1' ?>
<!DOCTYPE table [ <!ELEMENT table (tuple)*> <!ATTLIST table name CDATA #REQUIRED > <!ELEMENT tuple (table|tuple|atom)*> <!ATTLIST tuple name CDATA #IMPLIED >
<!ELEMENT atom (#PCDATA)*>
<!ATTLIST atom name CDATA #REQUIRED type CDATA 'text' size CDATA 'short' > ] > 
<?schema table ecatalogue integer irn table TaxTaxonomyRef_tab text short ClaFamily text short ClaGenus text short ClaSpecies text short ClaScientificName end text short SummaryData text short ColCollectionMethod table ColCollectionName_tab text short ColCollectionName end end ?>
<!-- Data --> 
<table name="ecatalogue">
<!-- Row 1 -->
  <tuple>
    <atom name="irn">705314</atom>
    <table name="TaxTaxonomyRef_tab">
      <tuple>
        <atom name="ClaFamily">Diretmidae</atom>
        <atom name="ClaGenus">Diretmus</atom>
        <atom name="ClaSpecies">argenteus Johnson, 1863</atom>
        <atom name="ClaScientificName">Diretmus argenteus Johnson, 1863</atom>
      </tuple>
    </table>
    <atom name="SummaryData">P.041207; Diretmus argenteus Johnson, 1863; ethanol 70%</atom>
    <atom name="ColCollectionMethod">Midwater trawl</atom>
  </tuple>
<!-- Row 2 -->
  <tuple>
    <atom name="irn">705335</atom>
    <table name="TaxTaxonomyRef_tab">
      <tuple>
        <atom name="ClaFamily">Ceratiidae</atom>
        <atom name="ClaGenus">Ceratias</atom>
        <atom name="ClaSpecies">tentaculatus (Norman, 1930)</atom>
        <atom name="ClaScientificName">Ceratias tentaculatus (Norman, 1930)</atom>
      </tuple>
    </table>
    <atom name="SummaryData">P.041990; Ceratias tentaculatus (Norman, 1930); ethanol 70%</atom>
    <atom name="ColCollectionMethod">Trawl</atom>
  </tuple>
<!-- Row 3 -->
  <tuple>
    <atom name="irn">705336</atom>
    <table name="TaxTaxonomyRef_tab">
      <tuple>
        <atom name="ClaFamily">Ceratiidae</atom>
        <atom name="ClaGenus">Ceratias</atom>
        <atom name="ClaSpecies">tentaculatus (Norman, 1930)</atom>
        <atom name="ClaScientificName">Ceratias tentaculatus (Norman, 1930)</atom>
      </tuple>
    </table>
    <atom name="SummaryData">P.041991; Ceratias tentaculatus (Norman, 1930); ethanol 70%</atom>
    <atom name="ColCollectionMethod">Trawl</atom>
  </tuple>
<!-- Row 4 -->
  <tuple>
    <atom name="irn">705338</atom>
    <table name="TaxTaxonomyRef_tab">
      <tuple>
        <atom name="ClaFamily">Ceratiidae</atom>
        <atom name="ClaGenus">Ceratias</atom>
        <atom name="ClaSpecies">tentaculatus (Norman, 1930)</atom>
        <atom name="ClaScientificName">Ceratias tentaculatus (Norman, 1930)</atom>
      </tuple>
    </table>
    <atom name="SummaryData">P.041992; Ceratias tentaculatus (Norman, 1930); ethanol 70%</atom>
    <atom name="ColCollectionMethod">Trawl</atom>
  </tuple>
<!-- Row 5 -->
  <tuple>
    <atom name="irn">705334</atom>
    <table name="TaxTaxonomyRef_tab">
      <tuple>
        <atom name="ClaFamily">Ceratiidae</atom>
        <atom name="ClaGenus">Cryptopsaras</atom>
        <atom name="ClaSpecies">couesi Gill, 1883</atom>
        <atom name="ClaScientificName">Cryptopsaras couesi Gill, 1883</atom>
      </tuple>
    </table>
    <atom name="SummaryData">P.041989; Cryptopsaras couesi Gill, 1883; ethanol 70%</atom>
    <atom name="ColCollectionMethod">Trawl</atom>
  </tuple>
<!-- Row 6 -->
  <tuple>
    <atom name="irn">703380</atom>
    <table name="TaxTaxonomyRef_tab">
      <tuple>
        <atom name="ClaFamily">Chaunacidae</atom>
        <atom name="ClaGenus">Chaunax</atom>
        <atom name="ClaSpecies">sp.</atom>
        <atom name="ClaScientificName">Chaunax sp.</atom>
      </tuple>
    </table>
    <atom name="SummaryData">P.040706; Chaunax sp.; ethanol 70%</atom>
    <atom name="ColCollectionMethod">Bottom trawl</atom>
  </tuple>
<!-- Row 7 -->
  <tuple>
    <atom name="irn">705674</atom>
    <table name="TaxTaxonomyRef_tab">
      <tuple>
        <atom name="ClaFamily">Macroramphosidae</atom>
        <atom name="ClaGenus">Centriscops</atom>
        <atom name="ClaSpecies">humerosus (Richardson, 1846)</atom>
        <atom name="ClaScientificName">Centriscops humerosus (Richardson, 1846)</atom>
      </tuple>
    </table>
    <atom name="SummaryData">P.041998; Centriscops humerosus (Richardson, 1846); ethanol 70%</atom>
    <atom name="ColCollectionMethod">Trawl</atom>
  </tuple>
<!-- Row 8 -->
  <tuple>
    <atom name="irn">705829</atom>
    <table name="TaxTaxonomyRef_tab">
      <tuple>
        <atom name="ClaFamily">Gigantactinidae</atom>
        <atom name="ClaGenus">Gigantactis</atom>
        <atom name="ClaSpecies">paxtoni Bertelsen, Pietsch &amp; Lavenberg, 1981</atom>
        <atom name="ClaScientificName">Gigantactis paxtoni Bertelsen, Pietsch &amp; Lavenberg, 1981</atom>
      </tuple>
    </table>
    <atom name="SummaryData">P.42005; Gigantactis paxtoni Bertelsen, Pietsch &amp; Lavenberg, 1981; ethanol 70%</atom>
    <atom name="ColCollectionMethod">Trawl</atom>
  </tuple>
<!-- Row 9 -->
  <tuple>
    <atom name="irn">705830</atom>
    <table name="TaxTaxonomyRef_tab">
      <tuple>
        <atom name="ClaFamily">Macrouridae</atom>
        <atom name="ClaGenus">Cetonurus</atom>
        <atom name="ClaSpecies">crassiceps (Gunther, 1878)</atom>
        <atom name="ClaScientificName">Cetonurus crassiceps (Gunther, 1878)</atom>
      </tuple>
    </table>
    <atom name="SummaryData">P.42006; Cetonurus crassiceps (Gunther, 1878); ethanol 70%</atom>
    <atom name="ColCollectionMethod">Trawl</atom>
  </tuple>
</table>
XML
			. "</textarea>";
		$vars = array( "EMu" => "true" );
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

class TePapaTexxmlTranslator extends TexxmlTranslator 
{
	var $serviceName = "TePapaTexxmlTranslator";
	var $potentialGroups = array (
			'ScientificName' => '0',
			'Family' => '2', 
			'Genus' => '3', 
			'Species' => '4', 
			'Latitude' => '6',
			'Longitude' => '7',
			'irn' => '8',
			'Collector' => '9',
			'CollectionMethod' => '10',
		);	

	var $latitudeElement = 'Latitude';
	var $longitudeElement = 'Longitude';

	function configure()
	{
		$this->setTranslation('ecatalogue.irn_1','irn','integer');
		$this->setTranslation('ecatalogue.IdeScientificNameLocal_tab[IdeScientificNameLocal]','ScientificName','string');
		$this->setTranslation('ecatalogue.LatCentroidLatitude0[LatCentroidLatitude]','Latitude','float');
		$this->setTranslation('ecatalogue.LatCentroidLongitude0[LatCentroidLongitude]','Longitude','float');
		$this->setTranslation('ecatalogue.ClaFamily','Family','string');
		$this->setTranslation('ecatalogue.ClaGenus','Genus','string');
		$this->setTranslation('ecatalogue.ClaSpecies','Species','string');
                $this->setTranslation('ecatalogue.SummaryData','SummaryData','string');
                $this->setTranslation('ecatalogue.ColCollectionMethod','CollectionMethod','string');
                $this->setTranslation('ecatalogue.ColParticipantString','Collector','string');

	}

	function makeTestPage()
	{
		$args = array();
		$args['EMu XML Record (enter 1 or more EMu xml records)'] = "<textarea cols='120' rows='15' name='data'>". <<<XML
<results status="success" matches="3">
  <record>
    <irn_1>703767</irn_1>
    <IdeScientificNameLocal_tab>
      <IdeScientificNameLocal>Paradiplospinus gracilis (Brauer, 1906)</IdeScientificNameLocal>
    </IdeScientificNameLocal_tab>
    <LatCentroidLatitude0>
      <LatCentroidLatitude>44 31  S</LatCentroidLatitude>
    </LatCentroidLatitude0>
    <LatCentroidLongitude0>
      <LatCentroidLongitude>165 23  E</LatCentroidLongitude>
    </LatCentroidLongitude0>
    <ClaFamily>Gempylidae</ClaFamily>
    <ClaGenus>Paradiplospinus</ClaGenus>
    <ClaSpecies>gracilis (Brauer, 1906)</ClaSpecies>
    <SummaryData>P.040738; Paradiplospinus gracilis (Brauer, 1906); ethanol 70%</SummaryData>
    <ColCollectionMethod>stolen</ColCollectionMethod>
    <ColParticipantString>Person or Persons Unknown</ColParticipantString>

  </record>
  <record>
    <irn_1>634316</irn_1>
    <IdeScientificNameLocal_tab>
      <IdeScientificNameLocal>Ophiopeza gracilis (Mortensen)</IdeScientificNameLocal>
    </IdeScientificNameLocal_tab>
    <LatCentroidLatitude0>
      <LatCentroidLatitude>37 23 30 S</LatCentroidLatitude>
    </LatCentroidLatitude0>
    <LatCentroidLongitude0>
      <LatCentroidLongitude>176 45 00 E</LatCentroidLongitude>
    </LatCentroidLongitude0>
    <ClaFamily>Ophiodermatidae</ClaFamily>
    <ClaGenus>Ophiopeza</ClaGenus>
    <ClaSpecies>gracilis (Mortensen)</ClaSpecies>
    <SummaryData>EC.008132; Ophiopeza gracilis (Mortensen); dry</SummaryData>
    <ColCollectionMethod>obtained</ColCollectionMethod>
    <ColParticipantString>A Colourful Racing Identity</ColParticipantString>
  </record>
  <record>
    <irn_1>634314</irn_1>
    <IdeScientificNameLocal_tab>
      <IdeScientificNameLocal>Ophiopeza gracilis (Mortensen)</IdeScientificNameLocal>
    </IdeScientificNameLocal_tab>
    <LatCentroidLatitude0>
      <LatCentroidLatitude>37 33 12 S</LatCentroidLatitude>
    </LatCentroidLatitude0>
    <LatCentroidLongitude0>
      <LatCentroidLongitude>178 50 18 E</LatCentroidLongitude>
    </LatCentroidLongitude0>
    <ClaFamily>Ophiodermatidae</ClaFamily>
    <ClaGenus>Ophiopeza</ClaGenus>
    <ClaSpecies>gracilis (Mortensen)</ClaSpecies>
    <SummaryData>EC.008131; Ophiopeza gracilis (Mortensen); dry</SummaryData>
    <ColCollectionMethod>Extortion</ColCollectionMethod>
    <ColParticipantString>Doug Dinsdale</ColParticipantString>
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

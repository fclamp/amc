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
				$translator = new UsprrEMuTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'TEXXML'  :
				$translator = new UsprrTexxmlTranslator($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
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

class UsprrEMuTranslator extends EMuTranslator 
{
	var $serviceName = "UsprrEMuTranslator";
	var $recordElement = 'tuple';
	var $potentialGroups = array (
		);	

	var $translations = array (
		'atom[name=LtyLatitudeDms]' => 'latitude',
		'atom[name=LtyLongitudeDms]' => 'longitude',
		'atom[name=ObjRockType]'	=> 'RockType',
		'atom[name=ObjRockName]'	=> 'RockName',
		'atom[name=SummaryData]'	=> 'SummaryData',
	);

	function describe()
	{
		return	
			"A UsprrEMuTranslator is a USPRR specific EMuTranslator\n\n".
			parent::describe();
	}

	function makeTestPage()
	{
		$args = array();
		$args['EMu XML Record (enter 1 or more EMu xml records)'] = "<textarea cols='120' rows='15' name='data'>". <<<XML
<!-- Data --> 
<table name='ecatalogue'> 
	<!-- Row 1 --> 
	<tuple>
		<atom name="irn">9007717</atom>
		<atom name="SummaryData">Stuff goes Here</atom>
		<atom name='ObjRockType'>More Stuff</atom> 
		<atom name='ObjRockName'>More Stuff</atom> 
		<atom name='LtyLatitudeDms'>35 0 0 S</atom> 
		<atom name='LtyLatitudeDms'>151 0 0 E</atom> 
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

class UsprrTexxmlTranslator extends TexxmlTranslator 
{
	var $serviceName = "UsprrTexxmlTranslator";
	var $potentialGroups = array (
			'Latitude' => '1',
			'Longitude' => '2',
			'RockType' => '3',
			'RockName' => '4',
			'Era'		=> '5',
			'Period'	=> '6',
			'AccessionNumber'	=>'7',
			'SummaryData'	=> '8',
			'irn' => '9',
		);	

	/*var $translations = array (
		'irn_1' => 'irn',
		'LtyLatitudeDms' => 'Latitude',
		'LtyLongitudeDms' => 'Longitude',
		'ObjRockType'	=> 'RockType',
		'ObjRockName'	=> 'RockName',
		'AgeEra_tab'	=> 'Era',
		'AgePeriod_tab'	=> 'Period',
		'SummaryData'	=> 'SummaryData',
		'ColAccessionNo'	=> 'AccessionNumber',
	);*/

	function configure()
	{
		$this->setTranslation('ecatalogue.irn_1','irn','integer');
		$this->setTranslation('ecatalogue.LtyLatitudeDms','Latitude','float');
		$this->setTranslation('ecatalogue.LtyLongitudeDms','Longitude','float');
		$this->setTranslation('ecatalogue.ObjRockType','RockType','string');
		$this->setTranslation('ecatalogue.ObjRockName','RockName','string');
		$this->setTranslation('ecatalogue.AgeEra_tab','Era','string');
		$this->setTranslation('ecatalogue.AgePeriod_tab','Period','string');
		$this->setTranslation('ecatalogue.SummaryData','Summary','string');
	}

	function makeTestPage()
	{
		$args = array();
		$args['EMu XML Record (enter 1 or more EMu xml records)'] = "<textarea cols='120' rows='15' name='data'>". <<<XML
<results status="success" matches="32">
  <record>
    <irn>
      <irn_1>1</irn_1>
    </irn>
	<SummaryData>PRR-2 : sandstone : Founders Peaks : Heritage Range 
		: Ellsworth Mountains : Craddock, Dr. Campbell - 
		University of Wisconsin at Madison : Rock Sample
	</SummaryData>
	<LtyLatitudeDms>79 10  S</LtyLatitudeDms>
	<LtyLongitudeDms>086 15  W</LtyLongitudeDms>
	<ObjRockType>Sedimentary</ObjRockType>
	<ObjRockName>sandstone</ObjRockName>
	<AgeEra_tab>
		<AgeEra>Paleozoic</AgeEra>
	</AgeEra_tab>
	<AgePeriod_tab>
		<AgePeriod>Cambrian</AgePeriod>
	</AgePeriod_tab>
	<ColDateCollected>26/12/1959;</ColDateCollected>
	<ColFieldYearCollected>1959</ColFieldYearCollected>
	<ColAccessionNo>2003.00002</ColAccessionNo>
	<ColIsgnNo>IGSN.PRR000002</ColIsgnNo>
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
        	$type = "TEXXML";
        	if (isset($_REQUEST['type']))
        	{
                	$type = strtoupper($_REQUEST['type']);
        	}
		$factory = new TranslatorFactory();
		$translator = $factory->getInstance($type);
		$translator->test(true);
	}
}

?>

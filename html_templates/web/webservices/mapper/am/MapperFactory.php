<?php

/*
 *  Copyright (c) 1998-2009 KE Software Pty Ltd
 */

// NB this file probably best viewed with tabspace=3 if using 80
// character line terminal


/**
*
* Mapper Factory class
*
* used to create right instance of client
* specific Mapper from common program
* interface
*
* Copyright (c) 1998-2009 KE Software Pty Ltd
*
* @package EMuWebServices
*
*/

if (!isset($WEB_ROOT))
{
	if (basename($_SERVER['PHP_SELF']) == 'MapperFactory.php')
        	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
	else	
        	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
}		
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/mapper/Mapper.php');
require_once ($WEB_ROOT . '/webservices/translator/'. $BACKEND_TYPE .'/TranslatorFactory.php');


class MapperFactory
{

	function MapperFactory($backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		$this->backendType = $backendType;
		$this->webRoot = $webRoot;
		$this->webDirName = $webDirName;
		$this->debugOn = $debugOn;
	}

	function getInstance($mapFile,$type='')
	{
		switch (strtoupper($type))
		{
			case 'EMU' :
				return new AmEMuMapper($mapFile,$this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'STANDALONE' :
			default:
				return new AmStandardMapper($mapFile,$this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
		}
	}
}

class AmEMuMapper extends Mapper
{
	var $systemName = "EMu AM Mapper v2";

	function AmEMuMapper($mapFile,$backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{

		$this->Mapper($mapFile,$backendType,$webRoot,$webDirName,$debugOn);

		$this->addProjection("Latitude/Longitude",
					"latlong.map",
					"-180 -90 180 90");

		$this->addProjection("Mercator",
					"mercator.map",
					"-5000000  -10000000 5000000 10000000"); 

	}

	function describe()
	{
		return	
			"An EMu AM Mapper is an AM specific Mapper\n".
			"typically for use with the standard EMu client\n\n".
			parent::describe();
	}

	function makeTestPage()
	{
		$title = "Quick Test for KE Client Driven Map Object: ". $this->serviceName;
		$args = array();

		$args['Image Size'] = 
			"width : <input type='text' name='width' value='500' size='4'/> px<br/>".
			"height: <input type='text' name='height' value='250' size='4' /> px";

		$args['Map Extent'] = 
			"Min Lat: <input type='text' name='minlat' value='-90' size='4'/><br/>".
			"Min Long: <input type='text' name='minlong' value='-180' size='4' /><br/>".
			"Max Lat: <input type='text' name='maxlat' value='90' size='4'/><br/>".
			"Max Long: <input type='text' name='maxlong' value='180' size='4' />";


		$args['EMu XML Record (enter 1 or more EMu xml records)'] = "<textarea cols='40' rows='15' name='data'>".
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
		$vars["class"] = "Mapper";
		$vars["testCall"] = "true";

		$args['stylesheet'] = "<input type='text' name='stylesheet' value='/". 
				$this->webDirName .
				"/webservices/mapper/style/". 
				"/simplemap.xss' />";

		$submission = "<input type='submit' name='action' value='Map' />";
		return $this->makeDiagnosticPage(
				$title,
				'',
				'',
				'./MapperFactory.php',
				$args,
				$submission,
				$vars,
				$this->describe()
				);
	}

	function makeTestResponse($set)
	{

		
		$colour = 0xff0000;
		$i = 0;

		foreach ($set as $recordSet)
		{
			$hexSt = '#' . dechex($colour);
			$this->addPoints("Set $i",$recordSet,$hexSt,$this->getSymbol($i++));
			$colour += 0x00ff00;
		}


		$width = 500;
		$height = 250;

		if ($_REQUEST['width'])
			$width = $_REQUEST['width'];
		if ($_REQUEST['height'])
			$height = $_REQUEST['height'];

		$this->setSize($width,$height);

		$minlat = -90;
		$minlong = -180;
		$maxlat = 90;
		$maxlong = 180;

		if ($_REQUEST['minlat'])
			$minlat = $_REQUEST['minlat'];
		if ($_REQUEST['minlong'])
			$minlong = $_REQUEST['minlong'];
		if ($_REQUEST['maxlat'])
			$maxlat = $_REQUEST['maxlat'];
		if ($_REQUEST['maxlong'])
			$maxlong = $_REQUEST['maxlong'];

		$this->setExtent($minlong,$minlat,$maxlong,$maxlat);
		return $this->request();
	}

}

class AmStandardMapper extends StandardMapper
{
	var $systemName = "AM Mapper v2";
	var $defaultStylesheet = "mapper/style/mapdisplay.xsl";
	var $defaultQueryDataStylesheet = "mapquery.xsl";

	var $queryTerms = Array(
			'darwin:Family',
			'darwin:Genus',
			'darwin:Species',
			'darwin:TypeStatus',
			'darwin:Locality',
	);

	var $queryScreen = Array(
		'standardTimeout' => 25,
		'orRows' => 5,
		'maxPerSource' => 50,
		'showTransformOption' => false,
		'diagnostics' => false,
	);

	var $suggestedQueryScreenParameters = Array(
		"maxPerSource" => 50,
		"timeoutSeconds" => 25,
	);


	function AmStandardMapper($mapFile,$backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{

		$this->Mapper($mapFile,$backendType,$webRoot,$webDirName,$debugOn);

		$this->addProjection("World Latitude/Longitude",
					"world.map",
					"-179 -89 179 89"); 
		$this->addProjection("Tasman Centred Latitude/Longitude",
					"tasman.map",
					"160 -60 210 10");
		$this->addProjection("Pacific Centred Latitude/Longitude",
					"pacific.map",
					"160 -60 210 10");
		$this->addProjection("Stereographic South Pole",
					"stereosouth.map",
					"-2877974.62258588 -2535021.30046716 2919369.49967643 2413783.16981739");
	}

	function describe()
	{
		return	
			"An AM Mapper is a AM client specific mapper\n\n".
			parent::describe();
	}


}

/* test calls typically of form:
 * http://HOST/emuweb/objects/CLIENT/Mapper.php?test=true&type=EMu
 * http://HOST/emuweb/objects/CLIENT/Mapper.php?test=true&type=Standalone
 * http://HOST/emuweb/objects/CLIENT/Mapper.php?test=true&type=EMu&mapfile=standard.map
 * etc
 */

if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'MapperFactory.php')
	{
		$type = 'EMu';
		$mapfile = 'standard.map';

		if (isset($_REQUEST['type']))
			$type = $_REQUEST['type'];
		
		if (isset($_REQUEST['mapfile']))
			$mapfile = $_REQUEST['mapfile'];
		
		$factory = new MapperFactory();
		$mapper = $factory->getInstance($mapfile,$type);

		if (isset($_REQUEST['testCall']))
		{
			$mapper->addDataAndType($_REQUEST['data'],$type);

			print $mapper->request();
		}
		else
			$mapper->test(true);
	}
}


?>

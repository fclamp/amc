<?php

/*
 *  Copyright (c) 2005 - KE Software Pty Ltd
 */

// NB this file probably best viewed with tabspace=3 if using 80
// character line terminal



/*  Factory class used to create right instance of client
**  specific objects.
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
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
		switch ($type)
		{
			case 'EMu' :
				return new NmnhEMuMapper($mapFile,$this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'Standalone' :
			default:
				return new NmnhStandardMapper($mapFile,$this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
		}
	}
}

class NmnhEMuMapper extends Mapper
{
	var $systemName = "EMu NMNH Mapper v2";

	function NmnhEMuMapper($mapFile,$backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		$this->Mapper($mapFile,$backendType,$webRoot,$webDirName,$debugOn);
	}

	function describe()
	{
		return	
			"An EMu NMNH Mapper is an NMNH specific Mapper\n".
			"typically for use with the standard EMu client\n\n".
			Parent::describe();
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
				"/objects/". 
				$this->backendType .
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

class NmnhStandardMapper extends StandardMapper
{
	var $systemName = "NMNH Mapper v2";
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

	var $standardSchema = 'http://digir.sourceforge.net/schema/conceptual/darwin/full/2003/1.0/darwin2full.xsd';
	var $standardStylesheet = "/pages/common/standardmap.html";
	var $standardTransform = 'SimpleTransformation';

	function describe()
	{
		return	
			"A NMNH Mapper is a NMNH client specific mapper\n\n".
			Parent::describe();
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

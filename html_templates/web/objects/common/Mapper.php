<?php

/* CURRENTLY THIS STUFF IS UNDER CONSTRUCTION */

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */


// NB this file probably best viewed with tabspace=3 if using 80
// character line terminal

/* Implements a Generic Mapper service */



if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once($LIB_DIR . 'common.php');
require_once ($WEB_ROOT . '/objects/common/SourceFactory.php');
require_once ($WEB_ROOT . '/objects/'.$BACKEND_TYPE.'/TranslatorFactory.php');
require_once ($WEB_ROOT . "/objects/common/WebServiceObject.php");
require_once ($WEB_ROOT . "/objects/common/DigirTranslator.php");
require_once ($WEB_ROOT . "/objects/common/DataCacher.php");

/**
 * SimpleMapper provides basic map drawing functionality.
 *
 * Simplemapper can be used when all that is required is a single map image
 * (without any scalebars, zooming, layer control, querying etc)
 *
 * a typical use is for drawing the status map in the Portal - the Portal can
 * show a map of records on the current page. This map is generated via
 * SimpleMap.  There is no need to change layers, zoom etc
 *
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 * @tutorial EMuWebServices/Mapper.cls
 *
 */
class SimpleMapper extends WebServiceObject
{

	var $systemName = "KE Software EMu Mapper Version 4";
	/**
	 * @var object[] MapScript::MapObject object
	 */
	var $mapObject = null;
	/**
	 * @var string URL of generated map
	 */
	var $mapUrl = '';
	/**
	 * holds generated response to map query
	 * @var string
	 */
	var $response = '';
	/**
	 * @var object internal caching object
	 */
	var $_cacher   = null;
	/**
	 * @var float[] lat/long coords of the map boundary
	 */
	var $_maxCoords   = array(0,0,0,0);

	/**
	 * @var object[]
	 * Array of translators, one for each XML record set that needs to be
	 * mapped. 
	 */
	var $translators = Array();

	/**
	 * @param string $mapfile path to standard mapserver map file
	 */
	function SimpleMapper($mapFile,$backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		// php doesn't call parent constructors... do it manually
		$this->{get_parent_class(__CLASS__)}($backendType,$webRoot,$webDirName,$debugOn);
		$this->serviceName = 'SimpleMapper';


		$mapFile = $this->webRoot ."/../maps/config/$mapFile";

		if ( ! is_file($mapFile))
			$this->errorResponse("Error in map component: mapfile: '$mapFile' not a file");

		if (! ($this->mapObject =  ms_newMapObj($mapFile)))
			$this->errorResponse("Error in map component: cannot create map object");

		$this->_cacher = new DataCacher($this->backendType,$this->webRoot,$this->webDirName);
	}

	function describe()
	{
		return	
			"A Simple Mapper is a basic map generation Web Service Object\n\n".
			Parent::describe();
	}

	/**
	 * 
	 * Send the generated results back to the client.(will be XML)
	 * @return string
	 *
	 */
	function sendResults()
	{

		$this->_log("<action>sendResults</action>");
		return $this->response;
	}

	/**
	 * 
	 * Set the pixel size of the wanted map
	 *
	 * @param int $width
	 * @param int $height
	 * @return void
	 */
	function setSize($width,$height)
	{
		$this->mapObject->setSize($width,$height);
	}

	/**
	 * Set the Lat/Long boundary of the wanted map
	 *
	 * @param float $minLong
	 * @param float $minLat
	 * @param float $maxLong
	 * @param float $maxLat
	 *
	 * @return void
	 */
	function setExtent($minLong,$minLat,$maxLong,$maxLat)
	{
		$this->mapObject->setExtent($minLong,$minLat,$maxLong,$maxLat);
		$this->maxCoords[0] = $minLong;
		$this->maxCoords[1] = $minLat;
		$this->maxCoords[2] = $maxLong;
		$this->maxCoords[3] = $maxLat;
	}

	/**
	 *
	 * Convert an integer index to a symbol name
	 *
	 * @param int $index
	 *
	 * @return string
	 *
	 */
	function getSymbol($index)
	{
		$maxSymbols = 5;
		return sprintf("symbol%d",$index % $maxSymbols);
	}

	/**
	 *
	 * Convert an integer index to a RGB colour specifier
	 *
	 * @param int $index
	 *
	 * @return string
	 *
	 */
	function getColour($index)
	{
		$colours = Array(
			'#ff0000','#0000ff','#ff00ff','#66ff33','#000000','#999999','#336699',
		);
		return $colours[$index % count($colours)];
	}


	/**
	 * Creates a layer for drawing points on
	 *
	 * @param string $symbol
	 * @param int $size
	 * @param string $colour
	 * @param string $name
	 *
	 * @return object
	 */
	function _makePointLayer($symbol,$size,$colour,$name)
	{
		// creates a layer that can be drawn on

		$symbolIdx = $this->mapObject->getsymbolbyname($symbol);

		if ( ! $layer = ms_newLayerObj($this->mapObject))
			$this->errorResponse("Error Creating new layer obj");
		$layer->set("name","dynamic_layer_$name");
		$layer->set("type",MS_LAYER_POINT);
		$layer->set("status",MS_ON);
		$layer->set("template","bogus.html");

		// save a name for this layer - useful for sharing icons
		// between sessions as they are common images
		$this->_layerIconName["dynamic_layer_$name"] = "$symbol-$size-$colour";
		$this->_layerIconName = preg_replace("/#/",'',$this->_layerIconName);

		$class = ms_newClassObj($layer);
		$class->set('name',$name);
		$class->label->set('size',MS_MEDIUM);
		$class->label->set('force',MS_TRUE);
		$class->label->color->setRGB(127,127,127);
		//$class->label->outlinecolor->setRGB(255,255,255);
		//$class->label->backgroundcolor->setRGB(127,127,127);

		$style = ms_newStyleObj($class);
		$style->set("size",15);
		$style->set("symbol",$symbolIdx);
		$style->set("symbolname",$symbol);

		if (! preg_match('/#([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})/i',$colour,$rgb))
			$rgb = array(0,0,0,0);

		$style->color->setRGB(hexdec($rgb[1]),hexdec($rgb[2]),hexdec($rgb[3]));
		$style->outlinecolor->setRGB(255,255,255);
		$style->backgroundcolor->setRGB(127,127,127);

		return $layer;
	}

	/**
	 * Add single point to shapefile and  return the shapefile
	 *
	 * @param float $lat
	 * @param float $long
	 * @param string $description
	 * @param boolean $labelOn
	 *
	 * @return object
	 */
	function _drawPoint($lat,$long,$description,$labelOn=false)
	{


		if (! $point = ms_newPointObj())
			$this->errorResponse("Error Creating new point obj");
		$point->setXY($long,$lat);


		$line = ms_newLineObj();
		$line->add($point);
		$shpObj = ms_newShapeObj(MS_SHAPE_POINT);
		$shpObj->add($line);
		if ($labelOn)
			$shpObj->set('text',$description);
		else
			$shpObj->set('text',null);

		return $shpObj;
	}


	/**
	 * Draw records on layer
	 *
	 * given an array of records (each being a hash of data keyed by
	 * field), add each as a point to a layer
	 * The record array is normally generated internally from a translator.
	 * This method should be considered private.
	 *
	 * 
	 * @param string $name
	 * @param array $records
	 * @param string $colour
	 * @param string $symbol
	 * @param bool $expandExtent
	 * @param bool $ignoreZeroLatLongs
	 * @param bool $labelOn
	 *
	 * @return void
	 *
	 */
	function addPoints($name,$records,$colour,$symbol,$expandExtent=false,$ignoreZeroLatLongs=true,$labelOn=false)
	{

		$img = $this->mapObject->prepareImage();
		$layer = $this->_makePointLayer($symbol,$size,$colour,$name);

		foreach ($records as $record)
		{
			$lat = $record['lat'];
			$long = $record['long'];
			$description = $record['description'];
		
			if ($lat != NULL && $long != NULL)
			{

				if (($lat && $long) || ! $ignoreZeroLatLongs)
				{
					if ($expandExtent)
					{
						if ($lat < $this->maxCoords[1])
							$this->maxCoords[1] = $lat;
						if ($lat > $this->maxCoords[3])
							$this->maxCoords[3] = $lat;
						if ($long < $this->maxCoords[0])
							$this->maxCoords[0] = $long;
						if ($long > $this->maxCoords[2])
							$this->maxCoords[2] = $long;
					}		
	
					$shpObj = $this->_drawPoint($lat,$long,$description,$labelOn);
					if ($layer->addFeature($shpObj) != MS_SUCCESS)
						$this->errorResponse("Error Adding shape object to layer");
				}
			}	
		}

	}

	/**
	 *
	 * add data from a translator to map
	 *
	 * pass a array of 'primed' translators, the system will group all
	 * records by the passed 'groupBy' param and do an 'addPoints' for each
	 * grouping
	 *
	 * @param object[] $translators
	 * @param string $groupBy
	 *
	 * @return void
	 *
	 */
	function addTranslatorData($translators,$groupBy = 'source')
	{

		$records = Array();
		foreach ($translators as $src => $translator)
		{
			$groups =  $translator->getGroups();
			foreach ($groups as $group)
				$this->_knownFields[$group]++;

			$groupVal = $src;
			while ($translator->nextRecord())
			{
				$lat = $translator->getLatitude();
				$long = $translator->getLongitude();
				$description = $translator->getDescription();

				if ($lat && $long)
				{
					$translated = Array();
					$translated['index'] = $current;
					$translated['source'] = $src;
					$translated['description'] = $description;
					$translated['lat'] = $lat;
					$translated['long'] = $long;
					foreach ($groups as $group)
					{
						if ($value =  $translator->getGroup($group))
							$translated[$group] = $value;

						if ($group == $groupBy)	
							$groupVal = $value;
						
						$uniques[$group][$value]++;	
					}

					if (! $records[$groupVal])
						$records[$groupVal] = '';
					

					$records[$groupVal][] = $translated;

					$current++;
				}
			}

		}

		$i = 0;
		foreach ($records as $group => $pointData)
		{
			$this->addPoints($group,$pointData,$this->getColour($i),$this->getSymbol($i++),true,false,($_REQUEST['labels'] == 'on'));
		}
	}

	/**
	 * set up mapper to map some passed XML (rather than querying for data)
	 *
	 * pass XML record data string (or URL) and a translator type
	 * string (eg 'Emu' or 'Digir') that understands this XML.
	 * Creates a Translator object, primes it with data and adds to
	 * Mapper's internal list of translators.
	 *
	 * @param string $data
	 * @param string $type
	 *
	 * @return void
	 *
	 */
	function addDataAndType($data,$type)
	{

		$factory = new translatorFactory($backendType,$webRoot,$webDirName,$mapFile);
		if (! is_object($translator = $factory->getInstance($type)))
			$this->errorResponse('Failure to get translator instance in mapper.php');

		if (get_magic_quotes_gpc())
			$data = stripslashes($data);

		// if $data is a url, get data otherwise assume it is XML string
		if (! preg_match('/<.+>/',$data))
		{
			$data = file_get_contents('http://bondi'.$data);
		}

		// remove XML headers
		$data = preg_replace('/^.+\?>/s','',$data);

		// save data in cache
		$this->_cacher->save($this->_currentInstance,$data);
		$this->dataUrl = $this->_cacher->getUrlOfIndex($this->_currentInstance);
		$this->dataType = $type;

		// add 'primed' translator to mapper
		$translator->translate($data);	
		$this->translators[] = $translator;
	}



	/**
	 *
	 * Act on map request
	 * returns XML describing generated map.  For this class it is just XML
	 * wrapped around a URL of an image
	 *
	 * behaviour depends on $_REQUEST values
	 *
	 * @return string
	 *
	 */
	function request()
	{
		if (isset($_REQUEST['sortby']))
			$showby = $_REQUEST['sortby'];
		else
			$showby = 'ScientificName';
			
		// get each translator to add it's points
		$this->addTranslatorData($this->translators,$showby);

		$this->mapObject->setExtent(
			$this->maxCoords[0],
			$this->maxCoords[1],
			$this->maxCoords[2],
			$this->maxCoords[3]
			);

		if ($imgObject = $this->mapObject->draw())
		{
			$index = $this->_currentInstance;
			$fileName = $this->_cacher->makeFileName($index);
			$fileName = $fileName . ".gif";
			$url = $this->_cacher->getUrlOfFile($fileName);
			if ($imgObject->saveImage($fileName,$this->mapObject) == MS_SUCCESS)
				$this->mapUrl = $url;
			else	
				$this->errorResponse("Error Saving map image");
		}
		else
			$this->errorResponse("Error Drawing map");

		$this->response = "<mapper><map>". $this->mapUrl ."</map></mapper>";

		return $this->mapUrl;
	}


	function test()
	{
		if (isset($_REQUEST['testCall']))
		{
			print $this->makeTestResponse($_REQUEST['recordSet']);
		}
		else	
		{
			header("Content-type: text/html",1);
			print $this->makeTestPage();
		}
	}

	/**
	 * respond to test page submission
	 *
	 * Take parameters passed from test page and call request method to generate a
	 * map
	 * @return string
	 */
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


		$mapFile = 'simple.map';
		if ($_REQUEST['mapfile'])
			$mapFile = $_REQUEST['mapfile'];
		$mapFile = $this->webRoot ."/../maps/config/$mapFile";

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
		$imageRef = $this->request();

		$vars = array();
		$vars["class"] = "SimpleMapper";
		$args["Map"] = "<img src='$imageRef' alt='generatedImage' />";
		return $this->makeDiagnosticPage(
			"Test Map Response",
			'',
			'',
			'',
			$args,
			'',
			$vars,
			$this->describe()
			);
	}

	function makeTestPage()
	{
		$title = "Quick Test for KE Simple Map Object: ". $this->serviceName;
		$args = array();

		$args['Image Size'] = 
			"width : <input type='text' name='width' value='500' size='4'/> px<br/>".
			"height: <input type='text' name='height' value='250' size='4' /> px";

		$args['Map Extent'] = 
			"Min Lat: <input type='text' name='minlat' value='-90' size='4'/><br/>".
			"Min Long: <input type='text' name='minlong' value='-180' size='4' /><br/>".
			"Max Lat: <input type='text' name='maxlat' value='90' size='4'/><br/>".
			"Max Long: <input type='text' name='maxlong' value='180' size='4' />";

		$args['Mapfile'] =
			"<input type='text' name='mapfile' value='simple.map' size='25'/>";

		$args['Data Set 1'] = "<textarea cols='40' rows='15' name='recordSet[]'>".
			"<records>\n".
			"<record>\n".
			"	<DateLastModified>2005-05-06 17:15:00.00Z</DateLastModified>\n".
			"	<InstitutionCode>KE</InstitutionCode>\n".
			"	<CollectionCode>Triantiwontigongolops</CollectionCode>\n".
			"	<CatalogNumber>123456:117</CatalogNumber>\n".
			"	<ScientificName>Culumbodina occidentalis</ScientificName>\n".
			"	<Kingdom>Animalia</Kingdom>\n".
			"	<Phylum>Conodonta</Phylum>\n".
			"	<Family>Culumbodinadae</Family>\n".
			"	<Genus>Culumbodina</Genus>\n".
			"	<Species>occidentalis</Species>\n".
			"	<longitude>115.41639</longitude>\n".
			"	<latitude>-9.16139</latitude>\n".
			"</record>".
			"<record>\n".
			"	<DateLastModified>2005-05-06 17:15:00.00Z</DateLastModified>\n".
			"	<InstitutionCode>KE</InstitutionCode>\n".
			"	<CollectionCode>Triantiwontigongolops</CollectionCode>\n".
			"	<CatalogNumber>123456:118</CatalogNumber>\n".
			"	<ScientificName>Pseudobelodina kirki</ScientificName>\n".
			"	<Kingdom>Animalia</Kingdom>\n".
			"	<Phylum>Conodonta</Phylum>\n".
			"	<Family>Pseudobelodindae</Family>\n".
			"	<Genus>Pseudobelodina</Genus>\n".
			"	<Species>kirki</Species>\n".
			"	<longitude>152.91639</longitude>\n".
			"	<latitude>-34.26339</latitude>\n".
			"</record>".
			"<record>\n".
			"	<DateLastModified>2005-05-06 17:15:00.00Z</DateLastModified>\n".
			"	<InstitutionCode>KE</InstitutionCode>\n".
			"	<CollectionCode>Triantiwontigongolops</CollectionCode>\n".
			"	<CatalogNumber>123456:119</CatalogNumber>\n".
			"	<ScientificName>Pseudobelodina vulgaris</ScientificName>\n".
			"	<Kingdom>Animalia</Kingdom>\n".
			"	<Phylum>Conodonta</Phylum>\n".
			"	<Family>Pseudobelodindae</Family>\n".
			"	<Genus>Pseudobelodina</Genus>\n".
			"	<Species>vulgaris</Species>\n".
			"	<longitude>150.51640</longitude>\n".
			"	<latitude>-42.17139</latitude>\n".
			"</record>".
			"</records>".
			"</textarea>";

		$args['Data Set 2'] = "<textarea cols='40' rows='15' name='recordSet[]'>".
			"<records>\n".
			"<record>\n".
			"	<DateLastModified>2005-05-06 17:15:00.00Z</DateLastModified>\n".
			"	<InstitutionCode>KE</InstitutionCode>\n".
			"	<CollectionCode>Triantiwontigongolops</CollectionCode>\n".
			"	<CatalogNumber>523456:117</CatalogNumber>\n".
			"	<ScientificName>Xidazoon stephanus</ScientificName>\n".
			"	<Kingdom>Animalia</Kingdom>\n".
			"	<Phylum>Vetulicolia</Phylum>\n".
			"	<Genus>Xidazoon</Genus>\n".
			"	<Species>stephanus</Species>\n".
			"	<longitude>130.41639</longitude>\n".
			"	<latitude>-31.16139</latitude>\n".
			"</record>".
			"<record>\n".
			"	<DateLastModified>2005-05-06 17:15:00.00Z</DateLastModified>\n".
			"	<InstitutionCode>KE</InstitutionCode>\n".
			"	<CollectionCode>Triantiwontigongolops</CollectionCode>\n".
			"	<CatalogNumber>223456:118</CatalogNumber>\n".
			"	<ScientificName>Didazoon haoae</ScientificName>\n".
			"	<Kingdom>Animalia</Kingdom>\n".
			"	<Phylum>Vetulicolia</Phylum>\n".
			"	<Genus>Didazoon</Genus>\n".
			"	<Species>haoae</Species>\n".
			"	<longitude>149.91639</longitude>\n".
			"	<latitude>-30.26339</latitude>\n".
			"</record>".
			"<record>\n".
			"	<DateLastModified>2005-05-06 17:15:00.00Z</DateLastModified>\n".
			"	<InstitutionCode>KE</InstitutionCode>\n".
			"	<CollectionCode>Triantiwontigongolops</CollectionCode>\n".
			"	<CatalogNumber>323456:119</CatalogNumber>\n".
			"	<ScientificName>Vetulicola cuneata</ScientificName>\n".
			"	<Kingdom>Animalia</Kingdom>\n".
			"	<Phylum>Vetulicolia</Phylum>\n".
			"	<Genus>Vetulicola</Genus>\n".
			"	<Species>cuneata</Species>\n".
			"	<longitude>110.4351</longitude>\n".
			"	<latitude>-32.18139</latitude>\n".
			"</record>".
			"</records>".
			"</textarea>";

		$vars = array();
		$vars["class"] = "SimpleMapper";
		$vars["testCall"] = "true";

		$submission = "<input type='submit' name='action' value='Map' />";
		return $this->makeDiagnosticPage(
				$title,
				'',
				'',
				'./Mapper.php',
				$args,
				$submission,
				$vars,
				$this->describe()
				);
	}

}

/**
 * Class Mapper
 *
 * At some point Mapper and StandardMapper should be merged into a single
 * object
 *
 * @package EMuWebServices
 */
class Mapper extends SimpleMapper
{
	var $scaleUrl = '';
	var $refMapUrl = '';
	var $dataUrl = '';
	var $standardStylesheet = '/pages/common/standardmap.xsl';
	var $standardTransform = '';
	var $passive = false;
	var $dataType = 'digir';


	function Mapper($mapFile,$backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		WebServiceObject::WebServiceObject($backendType,$webRoot,$webDirName,$debugOn);
		$this->serviceName = 'Mapper';
		if (isset($_REQUEST['instance']))
			$this->_currentInstance = $_REQUEST['instance'];

		$mapFile = $this->webRoot ."/../maps/config/$mapFile";

		if ( ! is_file($mapFile))
			$this->errorResponse("Error in map component: mapfile: '$mapFile' not a file");

		if (! ($this->mapObject =  ms_newMapObj($mapFile)))
			$this->errorResponse("Error in map component: cannot create map object");

		$this->_cacher = new DataCacher($this->backendType,$this->webRoot,$this->webDirName);
	}

	function describe()
	{
		return	
			"A Mapper is a general map generation object\n".
			"that extends a SimpleMapper\n\n".  Parent::describe();
	}


	function addPoints($name,$records,$colour,$symbol,$expandExtent=false,$ignoreZeroLatLongs=true,$labelOn=false)
	{

		$img = $this->mapObject->prepareImage();
		$layer = $this->_makePointLayer($symbol,$size,$colour,$name);

		foreach ($records as $record)
		{
			$lat = $record['lat'];
			$long = $record['long'];
			if ($_REQUEST['action'] == 'Query')
			{
				$description = '<data>';
				foreach ($record as $field => $value)
					$description .= "\t<$field>$value</$field>\n";
				$description .= '</data>';
				$labelOn = true;
			}
			else
			{
				$description = $record['ScientificName'];
			}
		
			if ($lat != NULL && $long != NULL)
			{
				if (($lat && $long) || ! $ignoreZeroLatLongs)
				{
					if ($expandExtent)
					{
						if ($lat < $this->maxCoords[1])
							$this->maxCoords[1] = $lat;
						if ($lat > $this->maxCoords[3])
							$this->maxCoords[3] = $lat;
						if ($long < $this->maxCoords[0])
							$this->maxCoords[0] = $long;
						if ($long > $this->maxCoords[2])
							$this->maxCoords[2] = $long;
					}		
	
					$shpObj = $this->_drawPoint($lat,$long,$description,$labelOn);
					if ($layer->addFeature($shpObj) != MS_SUCCESS)
						$this->errorResponse("Error Adding shape object to layer");
				}
			}	
		}

	}

	function mapXml($xml,$sortBy)
	{
		// given xml use this to make map
		//
		// well - where is the code !?
	}

	function setLayerStatusAsRequested()
	{
		for ($layerIndex = 0; $layerIndex < $this->mapObject->numlayers; $layerIndex++)
		{
			$layer = $this->mapObject->getLayer($layerIndex);
			$name = $layer->name;
			$stName = preg_replace('/\s/','_',$name);
			$stName = preg_replace('/\./','_',$stName);
				
			if ($_REQUEST[$stName] == 'off')
				$layer->set("status",MS_OFF);
			// if called with an action, layers are expected to be
			// explicitly turned off if not wanted.  If no action
			// use whatever the default status is (typically as per
			// mapfile
			else if (isset($_REQUEST['action']))
				$layer->set("status",MS_ON);
		}
	}

	function querySpatial($minlong,$minlat,$maxlong,$maxlat)
	{
		$this->errorResponse("spatial query function not yet implemented");
	}

	function queryRegion($minlong,$minlat,$maxlong,$maxlat)
	{

		$rect = ms_newRectObj();
		$rect->setExtent($minlong,$minlat,$maxlong,$maxlat);

		$xml = "";

		// query layers turned on by user (otherwise it would query
		// layers with status=on in the mapfile entry)
		$this->setLayerStatusAsRequested();
		$layersUsed = Array();

		if ($this->mapObject->queryByRect($rect) == MS_SUCCESS)
		{
			for ($layerIndex = 0; $layerIndex < $this->mapObject->numlayers; $layerIndex++)
			{
				$layer = $this->mapObject->getLayer($layerIndex);
				if (($matchCount = $layer->getNumResults()) != 0)
				{
					if ($layer->open() == MS_SUCCESS)
					{
						for ($i=0; $i <  $matchCount; $i++)
						{
							$result = $layer->getResult($i);
							
							$queryGroup = $layer->name;

							if ($result->shapeindex >= 0)
							{
								$shp = $layer->getShape($result->tileindex,$result->shapeindex);
								$data = "\t<record>\n";
								foreach ($shp->values as $field => $value)
									$data .= "\t\t<$field>$value</$field>\n";
								$data .= "\t</record>\n";
								$layersUsed[$queryGroup][] = $data;
							}
							else
							{
								$shp = $layer->getShape($result->tileindex,0);
								$data = "\t<record>\n";
								$data .= $shp->text;
								$data .= "\t</record>\n";
								$layersUsed[$queryGroup][] = $data;
							}
						}
						$layer->close();	
					}
					$this->mapObject->freequery($layerIndex);
				}
				else
				{
				}
			}
		}
		$layers = '';
		krsort($layersUsed);
		foreach ($layersUsed as $layer => $data)
		{
			$layers .=  "<layer name='$layer'>\n".  implode ("\n",$data) ."</layer>\n";
		}
		$this->response = "<mapper><layers>\n$layers</layers>\n</mapper>";
		
		// for queries we don't want to taint normal transform and
		// stylesheet when cached - set them here (after any parameter
		// caching done)
		if (isset($_REQUEST['qtransform']))
			$_REQUEST['transform'] = $_REQUEST['qtransform'];
		if (isset($_REQUEST['qstylesheet']))
			$_REQUEST['stylesheet'] = $_REQUEST['qstylesheet'];

		$response = $this->formatOutput($_REQUEST);
		foreach ($this->_headers as $header)
			header($header,1);

		return $response;
	}




	function portalQuery($portal)
	{
		// standalone maps require a system to query datasources rather
		// than be passed data passively.  This system uses a EMu data
		// portal to get the data


		// need to think better what to treat as insufficient call parameters
		// - this for time being
		if (! ($_REQUEST['search'] || $_REQUEST['instance']))
			$this->errorResponse("system incorrectly called - no search parameter");
		
		// read cached parameters (typically most important is the query)
		// point portal to appropriate cached search params
		$instance = preg_replace('/^[a-zA-Z]+/','Portal',$this->_currentInstance);
		if ($request = $portal->readState($instance,$_REQUEST))			
			$_REQUEST = $request;

		$data = $portal->request(true,$instance);			

		$data = preg_replace('/^.+\?>/s','',$data);
		$this->_cacher->save($this->_currentInstance,$data);
		$this->dataUrl = $this->_cacher->getUrlOfIndex($this->_currentInstance);

		$this->translators = $portal->_translators;
	}


	function request($portal = null,$setHeaders=true)
	{
		if (! isset($_REQUEST['identifier']))
			$_REQUEST['identifier'] = 'cgi.'. $this->_currentInstance;

		if ($mergedParams = $this->retrieveCallingParameters($_REQUEST['identifier'],$_REQUEST))
			$_REQUEST = $mergedParams;
		
		$paramCache = $this->saveCallingParameters($_REQUEST['identifier'],$_REQUEST);


		if ($portal)
		{
			// if given a portal the mapper is responsible for
			// finding data

			if ($_REQUEST['queryScreen'] and $portal)
			{
				$sources = $portal->getSources();
				return $this->queryScreen($sources);
			}
			else
			{
				$this->portalQuery($portal);
			}
		}
		else
		{
			if (isset($_REQUEST['data']) && isset($_REQUEST['translator']))
				$this->addDataAndType($_REQUEST['data'],$_REQUEST['translator']);
		}

		// plot data points and make map
		if (isset($_REQUEST['action']) && $_REQUEST['action'] != 'Spatial')
		{

			if (isset($_REQUEST['sortby']))
				$showby = $_REQUEST['sortby'];
			else
				$showby = 'ScientificName';
			

			// get each translator to add it's points
			$this->addTranslatorData($this->translators,$showby);
		}

		// adjust context/display etc based on passed requests
		list($minlong,$minlat,$maxlong,$maxlat)	 = Array(-179,-89,179,90);
		if (isset($_REQUEST['minlat']))
			$minlat = $_REQUEST['minlat'];
		if (isset($_REQUEST['minlong']))
			$minlong = $_REQUEST['minlong'];
		if (isset($_REQUEST['maxlat']))
			$maxlat = $_REQUEST['maxlat'];
		if (isset($_REQUEST['maxlong']))
			$maxlong = $_REQUEST['maxlong'];

		if ($minlong || $minlat || $maxlong || $maxlat)	
			$this->setExtent($minlong,$minlat,$maxlong,$maxlat);

		if (isset ($_REQUEST['action']))
			$action = $_REQUEST['action'];
		else
			$action = 'none';

		// make map components

		if ($action == 'Query')
			return $this->queryRegion($minlong,$minlat,$maxlong,$maxlat);
		if ($action == 'Spatial')
			return $this->querySpatial($minlong,$minlat,$maxlong,$maxlat);

		$dynamicLayers = Array();
		$staticLayers = Array();
		$noteReferences = Array();
		$noteReferenceCount = 1;

		for ($layerIndex = 0; $layerIndex < $this->mapObject->numlayers; $layerIndex++)
		{
			$layer = $this->mapObject->getLayer($layerIndex);
			$name = $layer->name;
			$stName = preg_replace('/\s/','_',$name);
			$stName = preg_replace('/\./','_',$stName);
				
			$checked = "checked='true'";
			if (isset($_REQUEST[$stName]) && $_REQUEST[$stName] == 'off')
			{
				$checked = "";
				$layer->set("status",MS_OFF);
			}	

			// if called with an action, layers are expected to be
			// explicitly turned off if not wanted.  If no action
			// use whatever the default status is (typically as per
			// mapfile
			else if (isset($_REQUEST['action']))
				$layer->set("status",MS_ON);

			if ($layer->status == MS_OFF)
				$checked = "";

			if (preg_match('/dynamic_layer_(.+)/',$name,$match))
			{
				$class = $layer->getClass(0);

				if ($icon = $class->createLegendIcon(20,20,$imageObject,0,0))
				{
					$index = $this->_layerIconName[$name];
					$fileName = $this->_cacher->makeFileName($index);
					$fileName = $fileName . ".gif";
					$url = $this->_cacher->getUrlOfFile($fileName);
					if ($icon->saveImage($fileName,$this->mapObject) == MS_SUCCESS)
						$dynamicLayers[] = "<dynamicLayer>\n".
							"<layerName>$name</layerName>\n".
							"<icon>$url</icon>\n".
							"<name>". $class->name ."</name>\n".
							"<status>$checked</status>\n".
							"</dynamicLayer>";
					else	
						$this->_setError("Error Saving icon image");
				}
				else
					$this->_setError("Error Drawing Icon Image");
			}
			else
			{
				$notes = $layer->getMetaData('Notes');
				if (! $notes)
					$noteReferences[$notes] = '';
				else if (! isset ($noteReferences[$notes]))
					$noteReferences[$notes] = $noteReferenceCount++;
					
				$displayName = preg_replace('/_/',' ',$name);
				$staticLayers[] = "<staticLayer>\n".
					"<layerName>$name</layerName>\n".
					"<icon/>\n".
					"<name>$displayName</name>\n".
					"<notes>". $notes ."</notes>\n".
					"<noteId>". $noteReferences[$notes] ."</noteId>\n".
					"<status>$checked</status>\n".
					"</staticLayer>";
			}
		}
		$layerNotes = Array();
		foreach ($noteReferences as $note => $id)
		{
			if ($id)
				$layerNotes[] = "<layerNotes>\n".
					"\t<id>$id</id>\n".
					"\t<notes>$note</notes>\n".
					"</layerNotes>";
		}

		if ($imgObject = $this->mapObject->draw())
		{
			$index = 'map-'. $this->_currentInstance;
			$fileName = $this->_cacher->makeFileName($index);
			$fileName = $fileName . ".gif";
			$url = $this->_cacher->getUrlOfFile($fileName);
			if ($imgObject->saveImage($fileName,$this->mapObject) == MS_SUCCESS)
				$this->mapUrl = $url;
			else	
				$this->_setError("Error Saving map image");
		}
		else
			$this->_setError("Error Drawing map");
		
		if ($imgObject = $this->mapObject->drawReferenceMap())
		{
			$index = 'refmap-'. $this->_currentInstance;
			$fileName = $this->_cacher->makeFileName($index);
			$fileName = $fileName . ".gif";
			$url = $this->_cacher->getUrlOfFile($fileName);
			if ($imgObject->saveImage($fileName,$this->mapObject) == MS_SUCCESS)
				$this->refMapUrl = $url;
			else	
				$this->_setError("Error Saving map image");
		}
		else
			$this->_setError("Error Drawing Reference Map");

		if ($imgObject = $this->mapObject->drawScaleBar())
		{
			$index = 'scalebar-'. $this->_currentInstance;
			$fileName = $this->_cacher->makeFileName($index);
			$fileName = $fileName . ".gif";
			$url = $this->_cacher->getUrlOfFile($fileName);
			if ($imgObject->saveImage($fileName,$this->mapObject) == MS_SUCCESS)
				$this->scaleUrl = $url;
			else	
				$this->_setError("Error Saving scalebar image");
		}
		else
			$this->_setError("Error Drawing Reference Map");

		
		// make xml response

		if (isset ($_REQUEST['sessionCount']))
			$sessionCount = $_REQUEST['sessionCount'];
		else
			$sessionCount = 1;

		$referredArguments = Array();
		foreach ($_REQUEST as $param => $val)	
		{
			if (get_magic_quotes_gpc())
				$val = stripslashes($val);
			$val = preg_replace('/"/',"'",$val);	
			$val = preg_replace('/^\s+|\s+$/','',$val);	
			$val = preg_replace('/&/','&amp;',$val);	
			$referredArguments[] = "$param=$val";
		}


		// trick browser image caches by added random parameter to
		// image urls
		$rnd = rand(0,9000);	

		if (($errors = $this->getError()))
			$status = 'fail';
		else
			$status = 'success';

		if ($this->passive)
			$passiveFlag = 'true';
		else	
			$passiveFlag = 'false';

		$this->response .= "<mapper status='$status'>\n";
		$this->response .= "<diagnostics>$errors</diagnostics>\n";
		$this->response .= "<map>". $this->mapUrl ."?random=$rnd</map>\n";
		$this->response .= "<scale>". $this->mapObject->scale ."</scale>\n";
		$this->response .= "<scalebar>". $this->scaleUrl ."?random=$rnd</scalebar>\n";
		$this->response .= "<referenceMap>". $this->refMapUrl ."?random=$rnd</referenceMap>\n";
		$this->response .= "<data>". $this->dataUrl ."?random=$rnd</data>\n";
		$this->response .= "<dataType>". $this->dataType ."</dataType>\n";
		$this->response .= "<cgiCache>". $paramCache ."</cgiCache>\n";
		$this->response .= "<passive>". $passiveFlag ."</passive>\n";

		$this->response .= "<extent>". 
				$this->mapObject->extent->minx . ' ' .
				$this->mapObject->extent->miny . ' ' .
				$this->mapObject->extent->maxx . ' ' .
				$this->mapObject->extent->maxy .
			"</extent>\n";


		$this->response .= 	"<layers>\n". 
					implode($staticLayers,"\n").
					implode($dynamicLayers,"\n").
					implode($layerNotes,"\n").
					"\n</layers>";

		// the echo mechanism allows passing of state/context back and
		// forth between client and web service - anything sent in an
		// echo parameter will be returned as echo xml
		$echo = '';
		if (isset($_REQUEST['echo']))
			foreach ($_REQUEST['echo'] as $echoArg)
			{
				list ($param,$val) = preg_split('/=/',$echoArg,2);
				$echo .= "<$param>$val</$param>\n";
			}


		
		$this->response .= "<displayParameters>\n".
					"<referredArguments>". implode('&amp;',$referredArguments) ."</referredArguments>\n".
					"<imgWidth>". $this->mapObject->width ."</imgWidth>\n".
					"<imgHeight>". $this->mapObject->height ."</imgHeight>\n".
					"<scalebarWidth>". $this->mapObject->scalebar->width ."</scalebarWidth>\n".
					"<scalebarHeight>". $this->mapObject->scalebar->height ."</scalebarHeight>\n".
					"<referenceMapWidth>". $this->mapObject->reference->width ."</referenceMapWidth>\n".
					"<referenceMapHeight>". $this->mapObject->reference->height ."</referenceMapHeight>\n".
					"<instance>". $this->_currentInstance ."</instance>\n".
					"<actionRequested>$action</actionRequested>\n".
					"<mapperUrl>/". $this->webDirName ."/webservices/mapper.xml</mapperUrl>\n".
					"<sessionCount>". $sessionCount ."</sessionCount>\n".
					"<echo>\n$echo\n</echo>\n".
					"</displayParameters>\n";

		$this->response .= "</mapper>\n";

		// transform response as requested

		$response = $this->formatOutput($_REQUEST);
		if ($setHeaders)
			foreach ($this->_headers as $header)
				header($header,1);

		return $response;
	}

}

/**
 * Class StandardMapper
 *
 * At some point Mapper and StandardMapper should be merged into a single
 * object
 *
 * @package EMuWebServices
 */
class StandardMapper extends Mapper
{

	var $queryTerms = Array(
			'Genus',
			'Species',
	);

	var $queryScreenParams = Array(
		'standardTimeout' => 25,
		'orRows' => 5,
		'maxPerSource' => 50,
		'showTransformOption' => true,
		'diagnostics' => true,
		'defaultMinLat' => -90,
		'defaultMinLong' => -180,
		'defaultMaxLat' => 90,
		'defaultMaxLong' => 180,
	);

	var $standardSchema = '';

	//var $_portal = null;

	var $_layerIconName   = array();

	function StandardMapper($mapFile,$backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		$this->Mapper($mapFile,$backendType,$webRoot,$webDirName,$debugOn);
		$this->serviceName = 'StandardMapper';

	}

	function describe()
	{
		return	
			"A Standard Mapper is a map generation object\n".
			"that extends a Mapper allowing it to get data\n".
			"from multiple sources\n\n".  Parent::describe();
	}


	function querySpatial($minlong,$minlat,$maxlong,$maxlat)
	{
		$inputs = "Lat:<input type='text name='latfrom' value='$minlat' size='3'/>";
		$inputs .= "Long:<input type='text name='longfrom' value='$minlong' size='3'/>";
		$inputs .= " - Lat:<input type='text name='latto' value='$maxlat' size='3'/>";
		$inputs .= "Long:<input type='text name='longto' value='$maxlong' size='3 '/>
			<span style='color:red'> NB SPATIAL SEARCH NOT CURRENTLY AVAILABLE</span>";
		return $this->queryScreen('x',Array("Spatial Region" => $inputs));
	}




	function queryScreen($sources,$extras=Array())
	{
		// display a query screen to drive mapper
		// 

		$sourceBoxes = array();
		$sourceQuery = array();
		$exampleQueries = array();


		sort($sources);

		foreach ($sources as $source)
		{
			$factory = new SourceFactory();
			if ($factory != null)
			{
				$instance =  $factory->getInstance($source);
				if ($instance != null)
				{
					$sourceQuery[] = $instance->testQueryTerms();
					$sourceBoxes[] = "<input type='checkbox' name='source[]' value='$source' checked='1' />$source";
					$exampleQueries[] = $instance->exampleQueryTerms();
				}	
			}
		}	
		
		
		$sources = implode(" &nbsp; ",$sourceBoxes);
		$schema = $this->standardSchema;
		$transform = $this->standardTransform;
		if (preg_match('/Simple/',$transform))
			$stylesheet = $this->webRoot . $this->standardStylesheet;
		else
			$stylesheet = $this->webDirName . $this->standardStylesheet;


		$termCount = count($this->queryTerms);
		for ($row=0; $row < $this->queryScreenParams['orRows']; $row++)
			foreach ($this->queryTerms as $term)
				$qryRows[$term][] = "<input type='text' id='qry_${term}_$row' name='qry_${term}[]' value='' />";
		
		$extraQueryTerms = '';
		foreach ($extras as $heading => $value)
			$extraQueryTerms .= "<tr style='text-align: center'><td>$heading</td><td colspan='$termCount'>$value</td></tr>";

		foreach ($qryRows as $term => $options)
		{
			$term = preg_replace('/.+?:/','',$term);
			$rows[] = "<td>$term<br/>\n\t" . implode("<br/>\n\t",$options) . "</td>";
		}
		$qryBlock = implode("\n",$rows);

		$jsSnippet = "/* dynamically generated js */\n";
		$jsSnippet .= "\t\t\t\tvar orTerms = '';\n";
		$jsSnippet .= "\t\t\t\tvar andTerms = '';\n\n";
		for ($row=0; $row < $this->queryScreenParams['orRows']; $row++)
		{
			$jsSnippet .= "\t\t\t\tandTerms = '';\n";
			foreach ($this->queryTerms as $term)
			{
// ---------------- INLINE BLOCK --------------------		
				$jsSnippet .= <<<JAVASCRIPT
				input = document.getElementById('qry_${term}_$row');
				value = input.value;
				if (value.length > 0)
				{
					if (andTerms == '')
						andTerms = "<equals><$term>"+ value +"</$term></equals>";
					else
						andTerms = "<and><equals><$term>"+ value +"</$term></equals>"+ andTerms +"</and>";
				}
JAVASCRIPT;
// --------------------------------------------------		
			}	

// ---------------- INLINE BLOCK --------------------		
			$jsSnippet .= <<<JAVASCRIPT
				if (orTerms == '')
					orTerms = andTerms;
				else
				{
					if (andTerms != '')
						orTerms = "<or>"+ andTerms + orTerms +"</or>";
				}
JAVASCRIPT;
// --------------------------------------------------		
		}

		$jsSnippet .= "\t\t\t\t<!-- end dynamically generated js -->\n";

		$i = 0;
		$exampleJs = "/* examples from specific portal sources */\n";
		$exampleUsed = Array();
		foreach ($exampleQueries as $examples)
		{
			$used = false;
			if ($i < $this->queryScreenParams['orRows'])
			{
				foreach ($examples as $field => $value)
				{
					if (! isset($exampleUsed["$field:$value"]))
					{
						$exampleJs .= "\t\t\t\tdocument.getElementById('qry_${field}_$i').value = '$value'\n";
						$used = true;
						$exampleUsed["$field:$value"] = 1;
					}
					else
						$exampleUsed["$field:$value"]++;
				}
				if ($used)
					$i++;
			}
			
		}
		$specifiedTimeout = $this->queryScreenParams['standardTimeout'];
		$maxPerSource = $this->queryScreenParams['maxPerSource'];	
		$allLimitDefault = $termCount * $maxPerSource;	
		$minlat = $this->queryScreenParams['defaultMinLat'];
		$minlong = $this->queryScreenParams['defaultMinLong'];
		$maxlat = $this->queryScreenParams['defaultMaxLat'];
		$maxlong = $this->queryScreenParams['defaultMaxLong'];
		if ($this->queryScreenParams['showTransformOption'])
		{
// ---------------- INLINE BLOCK --------------------		
			$transformOption = <<<HTML
						<tr>
							<td>Transform</td>
							<td colspan='$termCount'>
								<input type='radio' name='transform' value='' checked='true' />Browser Side<br/>
								<input type='radio' name='transform' value='XsltTransformation' />Server Side
							</td>
						</tr>
HTML;
// --------------------------------------------------		
		}
		else
			$transformOption = '';

		if ($this->queryScreenParams['diagnostics'])
		{
			$showQuery = "<input type='button' name='action' value='Show Query' onClick='showRequest();' />";
			$messageStyle = 'style="visibility: visible;"';
		}	
		else
		{
			$showQuery = '';
			$messageStyle = 'style="visibility: hidden;"';
		}


// ---------------- INLINE BLOCK --------------------		
		return <<<HTML
		<html>
			<head>
				<!-- (C)2000-2005 KE Software -->
				<title>$this->systemName</title>
				<style>
					body {
					}
					div {
						margin-left: auto; 
						margin-right: auto; 
					}
					table { 
						margin-left: auto; 
						margin-right: auto; 
						white-space: nowrap; 
						border: 1px solid blue;
						background-color: #aaaaff;
					}
					td, th { 
						white-space: nowrap; 
						background-color: #eeffff;
						border: 0px solid black;
						font-weight: bold;
					}
					.fancyLink {
						border:1px solid red;
						width=15em;
						vertical-align: top;
						text-align: center;
						background-color: #dddddd;
					}
				</style>
				<script>
				<!--
			<!-- (C)2000-2005 KE Software -->
			var StartTime = null;
			var SpecifiedTimeout = $specifiedTimeout;
		
			function makeRequest()
			{

				showRequest();	
				if (document.getElementById('search').value.length > 0)
				{
					startCountdown();
					document.forms[0].submit();
				}
				else
					alert("You must enter query Terms !");
			}

			function showRequest()
			{
				var search = '';
				var records = '';
				var start = '';
				var limit = '';
				var input = '';
				var value = '';
				var termCount = 0;
		
				start = document.getElementById('start').value;
				limit = document.getElementById('limit').value;
				schema = document.getElementById('schema').value;
				
				$jsSnippet

				if (orTerms != '')
				{
					search = "<filter>\\n"+ orTerms +"\\n</filter>\\n";
		
					records = "<records limit='"+ limit +"' start='"+ start +"'>\\n";
					records += "<structure schemaLocation='" + schema +"'/>\\n</records>";
					search += records;
		
					document.getElementById('message').innerHTML = "<pre>"+ search.replace(/</g,'&lt;') +"</pre>";
					document.getElementById('search').value = search.replace(/\\n|\\t/g,'');
				}	
				else
					document.getElementById('message').innerHTML = "<pre>No Query Terms !</pre>";
			}

			function sampleValues()
			{
				$exampleJs;
			}

			function setMaxTotal(input)
			{
				document.getElementById('allLimit').value = input.value * $termCount;
			}

			function updateTimer()
			{
				var timeNow = new Date();
				var diff = timeNow.getTime() - StartTime.getTime();
				var diffTime = new Date();
				diffTime.setTime(diff);
				var t = SpecifiedTimeout - diffTime.getSeconds();
				if (t <= 5)
					document.getElementById('timer').style.backgroundColor = '#ADFF2F';
				if (t <= 0)
					document.getElementById('timer').style.backgroundColor = '#ff0000';
				document.getElementById('timer').value = t ;
			   	setTimeout("updateTimer()", 1000);
			}


			function startCountdown()
			{
				StartTime = new Date();
				document.getElementById('timer').value = SpecifiedTimeout;
				document.getElementById('remaining').style.visibility = "visible";
			   	setTimeout("updateTimer()", 1000);
			}

			function changeTimeout(control)
			{
				SpecifiedTimeout = control.value;
			}
				-->
				</script>
			</head>
			<body>
			<center>
				<h2 align='center'>$this->systemName</h2>
		
				<!-- NB for configuration.  IE currently gives url file
					extension higher priority than HTTP Content-type
					headers.  for this reason if IE browser looks up a php
					resource that delivers XML it will not run an included
					XSL stylsheet on the result (because of php suffix).
					For this reason give the URL an xml suffix and let
					apache do content negotion to actually use
					portal.xml.php.
				-->	
				<form method='POST' action='/$this->webDirName/webservices/mapper.xml'>
					<table border='1'>
						<tr>
							<td>Data Sources</td>
							<td colspan='$termCount' align='center'>$sources</td>
							<td rowspan=10' align='center'>
 								<img border="0" alt='discover' src='../objects/images/earth.jpg'/>
							</td>
						</tr>
						<tr>
							<td>Query Terms<br/><i>blank terms ignored</i></td>
							$qryBlock
						</tr>
						$extraQueryTerms
						<tr>
							<td>Records</td>
							<td colspan='$termCount'>
								Max Per Source<input type='input' name='limit' id='limit' value='$maxPerSource' size='2' 
									onChange='setMaxTotal(this)'/>
								Max Total <input type='input' id='allLimit' name='allLimit' 
									style='background-color: #e0e0e0;'
									value='$allLimitDefault' size='2' readonly='true'/>

								Sample across sources 
						        	<input type='radio' name='scatter' value='true' checked='true'  />YES
								<input type='radio' name='scatter' value='false' />NO 
							</td>
						</tr>
						<tr><td>Sort</td><td colspan='$termCount'>By <input type='input' name='sortby' value='ScientificName' size='20' />
						     Order <input type='input' name='order' value='ascending' size='10' /></td></tr>
						<tr><td>Timeout per Source</td><td colspan='$termCount'>
							<input type='input' name='timeout' value='28' size='2'
								OnChange='changeTimeout(this);'	 
							/> seconds
							&nbsp; <span id='remaining' style='visibility: hidden;'>(<input type='text' name='timer'
							style='background-color: #eeffff; border: 0px none;'
 							id='timer' value='-' size='2' readonly='true' /> remaining)</span></td>
						</tr>
						$transformOption
						<tr>
							<td>Action</td>
							<td colspan='$termCount' align='center'>
								<input type='button' name='action' value='Query' onClick='makeRequest();' />
								$showQuery
								<input type='button' name='action' value='Fill With Example Values' onClick='sampleValues();' />
								<input type='reset' value='Clear'/>
							</td>
						</tr>
					</table>
					<!--Each Source Start--><input type='hidden' name='start' id='start' value='0' />
					<!--Display Start    --><input type='hidden' name='allStart' id='allStart' value='0' />
					<!--Schema           --><input type='hidden' name='schema' id='schema' value='$schema' />
					<!--Stylesheet       --><input type='hidden' name='stylesheet' id='stylesheet' value='$stylesheet' />
					<!--Transform        --><input type='hidden' name='transform' id='stylesheet' value='$transform' />
					<!--initial extent   --><input type='hidden' name='minlat' id='minlat' value='$minlat' />
					<!--initial extent   --><input type='hidden' name='minlong' id='minlong' value='$minlong' />
					<!--initial extent   --><input type='hidden' name='maxlat' id='maxlat' value='$maxlat' />
					<!--initial extent   --><input type='hidden' name='maxlong' id='maxlong' value='$maxlong' />




					<input type='hidden' name='search' id='search'/>
				</form>
				<img border="0" alt="KE EMu" src="/images/productlogo.gif" width="134" height="48"/>
				<img border="0" alt="KE Software" src="/images/companylogo.gif" width="60" height="50"/>
				<br/>
				(C) 2000-2005 KE Software
				<div id='message' name='message' $messageStyle><div/>
			</center>
			</body>
		</html>
HTML;
// --------------------------------------------------		
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


		if ($_REQUEST['mapfile'])
			$mapFile = $_REQUEST['mapfile'];
		$mapFile = $this->webRoot ."/../maps/config/$mapFile";

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
		return $this->request(null);
	}

	function makeTestPage()
	{
		$title = "Quick Test for KE Standard Map Object: ". $this->serviceName;
		$args = array();

		$args['Image Size'] = 
			"width : <input type='text' name='width' value='500' size='4'/> px<br/>".
			"height: <input type='text' name='height' value='250' size='4' /> px";

		$args['Map Extent'] = 
			"Min Lat: <input type='text' name='minlat' value='-90' size='4'/><br/>".
			"Min Long: <input type='text' name='minlong' value='-180' size='4' /><br/>".
			"Max Lat: <input type='text' name='maxlat' value='90' size='4'/><br/>".
			"Max Long: <input type='text' name='maxlong' value='180' size='4' />";

		$args['Mapserver Mapfile'] =
			"<input type='text' name='mapfile' value='standard.map' size='15'/>";

		$args['XML Record Data'] = "<textarea cols='60' rows='15' name='data'>".
			"<records>\n".
			"<record>\n".
			"	<DateLastModified>2005-05-06 17:15:00.00Z</DateLastModified>\n".
			"	<InstitutionCode>KE</InstitutionCode>\n".
			"	<CollectionCode>Triantiwontigongolops</CollectionCode>\n".
			"	<CatalogNumber>123456:117</CatalogNumber>\n".
			"	<ScientificName>Culumbodina occidentalis</ScientificName>\n".
			"	<Kingdom>Animalia</Kingdom>\n".
			"	<Phylum>Conodonta</Phylum>\n".
			"	<Family>Culumbodinadae</Family>\n".
			"	<Genus>Culumbodina</Genus>\n".
			"	<Species>occidentalis</Species>\n".
			"	<Longitude>115.41639</Longitude>\n".
			"	<Latitude>-9.16139</Latitude>\n".
			"</record>".
			"<record>\n".
			"	<DateLastModified>2005-05-06 17:15:00.00Z</DateLastModified>\n".
			"	<InstitutionCode>KE</InstitutionCode>\n".
			"	<CollectionCode>Triantiwontigongolops</CollectionCode>\n".
			"	<CatalogNumber>123456:118</CatalogNumber>\n".
			"	<ScientificName>Pseudobelodina kirki</ScientificName>\n".
			"	<Kingdom>Animalia</Kingdom>\n".
			"	<Phylum>Conodonta</Phylum>\n".
			"	<Family>Pseudobelodindae</Family>\n".
			"	<Genus>Pseudobelodina</Genus>\n".
			"	<Species>kirki</Species>\n".
			"	<Longitude>152.91639</Longitude>\n".
			"	<Latitude>-34.26339</Latitude>\n".
			"</record>".
			"<record>\n".
			"	<DateLastModified>2005-05-06 17:15:00.00Z</DateLastModified>\n".
			"	<InstitutionCode>KE</InstitutionCode>\n".
			"	<CollectionCode>Triantiwontigongolops</CollectionCode>\n".
			"	<CatalogNumber>123456:119</CatalogNumber>\n".
			"	<ScientificName>Pseudobelodina vulgaris</ScientificName>\n".
			"	<Kingdom>Animalia</Kingdom>\n".
			"	<Phylum>Conodonta</Phylum>\n".
			"	<Family>Pseudobelodindae</Family>\n".
			"	<Genus>Pseudobelodina</Genus>\n".
			"	<Species>vulgaris</Species>\n".
			"	<Longitude>150.51640</Longitude>\n".
			"	<Latitude>-42.17139</Latitude>\n".
			"</record>".
			"</records>".
			"</textarea>";
		$args["XML Type"] = "<input type='text' name='translator' value='Digir' size='5'/>";
		$args['stylesheet'] = "<input type='text' name='stylesheet' value='/". 
				$this->webDirName .
				"/objects/". 
				$this->backendType .
				"/simplemap.xss' />";

		$vars = array();
		$vars["class"] = "StandardMapper";
		$vars["testCall"] = "true";

		$submission = "<input type='submit' name='action' value='Map' />";
		return $this->makeDiagnosticPage(
				$title,
				'',
				'',
				'./Mapper.php',
				$args,
				$submission,
				$vars,
				$this->describe()
				);
	}

}

if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'Mapper.php')
	{
		$webObject = null;

		$mapFile = 'simple.map';
		$standardMapFile = 'standard.map';

		if ($_REQUEST['mapfile'])
			$mapFile = $_REQUEST['mapfile'];

		if ($_REQUEST["class"] == "SimpleMapper")
			$webObject = new SimpleMapper($mapFile);

		if ($_REQUEST["class"] == "Mapper")
			$webObject = new Mapper($mapFile);

		if ($_REQUEST["class"] == "StandardMapper")
			$webObject = new StandardMapper($standardMapFile);


		if ($webObject)
			print $webObject->test();
	}	
}


?>

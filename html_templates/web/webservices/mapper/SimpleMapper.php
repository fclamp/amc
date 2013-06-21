<?php

/*
 *  Copyright (c) 1998-2010 KE Software Pty Ltd
 */


// NB this file probably best viewed with tabspace=3 if using 80
// character line terminal

/* Implements a Generic Mapper service */



if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once($LIB_DIR . 'common.php');
require_once ($WEB_ROOT . '/webservices/portal/FetcherFactory.php');
require_once ($WEB_ROOT . '/webservices/translator/'.$BACKEND_TYPE.'/TranslatorFactory.php');
require_once ($WEB_ROOT . "/webservices/lib/WebServiceObject.php");
require_once ($WEB_ROOT . "/webservices/lib/DataCacher.php");


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
 *  Copyright (c) 1998-2010 KE Software Pty Ltd
 *
 * @package EMuWebServices
 * @tutorial EMuWebServices/Mapper.cls
 *
 * @TODO move request params from _REQUEST to internal structure
 *
 * @TODO fix query where click on single point rather than box (currently
 * breaks)
 *
 */
class SimpleMapper extends WebServiceObject
{

	var $serviceName = 'SimpleMapper';
	var $serviceDirectory = "webservices/mapper";

	var $systemName = "KE Software EMu Mapper Version 4";
	var $defaultQueryScreen = "mapper_queryscreen.xsl";

	var $maxXmlSize = 7200000;	# size in bytes of the maximum
					# XML data string that the system
					# can handle (to avoid browsers
					# crashing when styling it)

	/**
	 * @var object[] MapScript::MapObject object
	 */
	var $mapObject = null;
	/**
	 * @var string URL of generated map
	 */
	var $mapUrl = '';
	var $imageFileRaw = '';
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

	var $_projectionList = Array();
	var $_units = "DEGREES";

	var $_minResolution = 0.5; // min lat resolution in nautical miles
			         // 1nm = 1/60 degree of latitude = 1.853 km

	var $_labelPoints = false;
	var $_pointLabelSize = MS_LARGE;			 
	var $_pointLabelColour = array(127,127,127);
	var $_pointLabelOutlineColour = array(0,0,0);			 
	var $_symbolSize = 15;			 
	var $_pointProjection = "proj=latlong,ellps=WGS84";

	// if point outside extent should extent be expanded?
	var $_allowExtentExpansion = true;

	/**
	 * @var object[]
	 * Array of translators, one for each XML record set that needs to be
	 * mapped. 
	 */
	var $translators = Array();

	var $noLatLong = 0;
	var $recordsPassed = 0;
	var $warnings = Array();

	/**
	 * @param string $mapfile path to standard mapserver map file
	 */
	function SimpleMapper($mapFile,$backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		// php doesn't call parent constructors... do it manually
		$this->{get_parent_class(__CLASS__)}($backendType,$webRoot,$webDirName,$debugOn);

		$mapFile = $this->findMapFile($mapFile);

		if ( ! is_file($mapFile))
			$this->errorResponse("Error in map component: map file: ".
				"'$mapFile' not found (NB permission problems may cause this)");

		if (! ($this->mapObject =  ms_newMapObj($mapFile)))
			$this->errorResponse("Error in map component: cannot create map object ".
				"from mapfile:$mapFile (syntax error in map file?)");

		$this->extractMapFileData($mapFile);	

		$this->_cacher = new DataCacher($this->backendType,$this->webRoot,$this->webDirName);

		$this->_labelPoints = ($_REQUEST['labels'] == 'on');

		if ($error = $this->systemFaults())
			$this->errorResponse($error);
	}

	function extractMapFileData($mapFile)
	{
		// set shapepath - will differ from default if a localised mapfile
		$mapperPath = $this->webRoot . '/'. $this->serviceDirectory;
		$defaultShapePath = $mapperPath . '/maps/layers';
		$localShapePath = $mapperPath .'/'.  $this->backendType .'/maps/layers/';
		$this->mapObject->set("shapepath",$localShapePath);

		// we test for shapefile existence manually in local or default
		// location.  Need also to to set path for reference map (local
		// ref map has precedence over default)

		$refMapImage = $this->mapObject->reference->image;
		$defaultRefMap =  $mapperPath . '/maps/layers/'. $refMapImage;
		$localRefMap =  $mapperPath .'/'. $this->backendType . '/maps/layers/'. $refMapImage;

		if (file_exists($localRefMap))
			$this->mapObject->reference->set( 'image',$localRefMap);
		else if (file_exists($defaultRefMap))
			$this->mapObject->reference->set( 'image',$defaultRefMap);
		else
			$this->errorResponse(
				"Error cannot determine path to reference map: $refMapImage\n".
					"Check MapFile or EMu Web Webservices environment\n".
					"MapFile: $mapFile\n".
					"ShapePath: ".$this->mapObject->shapepath ."\n".
					"MapPath: ".$this->mapObject->mappath ."\n".
					"Paths tried are:\n".
					"\tdefault:$defaultRefMap\n".
					"\tlocalised:$localRefMap\n"
				);

		$this->setShapeFileDataPath($mapFile);
		
		$extent = $this->mapObject->extent;
		$this->startExtent = Array($extent->minx,$extent->miny,$extent->maxx,$extent->maxy);

		if ($_REQUEST && ! isset($_REQUEST['ForceExtent']))
		{
			# if we only have a cookie specifying default mapfile assume being called as
			# a map query screen - don't add other request data or
			# mapper.php will think we are wanting a map
			if ($_REQUEST && (sizeof($_REQUEST) > 1 || ! isset($_REQUEST["KE_cookie_mapfile_"])))
				$this->adjustRequestCoords($_REQUEST[projection],$this->mapObject->getProjection());
		}
	
	}

	function setPointProjection($proj4String)
	{
		// sets the proj4 projection parameters for point data created
		// dynamically (eg EMu data)
		$this->_pointProjection = $proj4String; 
	}

	function setMinResolution($nm)
	{
		// min lat resolution in nautical miles
	   	// 1nm = 1/60 degree of latitude = 1.853 km
		$this->_minResolution = $nm; 
	}

	function allowExtentExpansion($allow)
	{
		$this->_allowExtentExpansion = $allow;
	}

	function setShapeFileDataPath($mapFile)
	{
		// layers can be found in default location
		// web/webservices/mapper/maps/layers 
		//  or localised path
		// web/webservices/mapper/CLIENT/maps/layers
		// localised path has higher priority...
		//
		// NB for localised files you will need actual filenmae to look
		// at in the map file for this to work in case of shapefiles
		// (ie in mapfile say
		// "world/boundaries/country.dbf" *NOT* just
		// "world/boundaries/country"
		// otherwise the default file will be used)

		$mapperPath = $this->webRoot . '/'. $this->serviceDirectory;
		$defaultShapePath = $mapperPath . '/maps/layers';
		$localShapePath = $mapperPath .'/'.  $this->backendType .'/maps/layers/';

		$layerNames = $this->mapObject->getAllLayerNames();
		foreach ($layerNames as $name)
		{
			if ($layer = $this->mapObject->getLayerByName($name))
			{
				$file = $layer->data;
				if (file_exists("$localShapePath/$file"))
					$layer->set('data',"$localShapePath/$file");
				else if (file_exists("$defaultShapePath/$file"))
					$layer->set('data',"$defaultShapePath/$file");
				else
				{
					$this->errorResponse(
						"Error cannot determine path to layer: $file\n".
						"Check MapFile or EMu Web Webservices environment\n".
						"MapFile: $mapFile\n".
						"ShapePath: ".$this->mapObject->shapepath ."\n".
						"MapPath: ".$this->mapObject->mappath ."\n".
						"Paths tried are:\n".
						"\tdefault:$defaultShapePath/$file\n".
						"\tlocalised:$localShapePath/$file\n"
					);
				}
			}
		}
	}	

	function adjustRequestCoords($referenceProjection,$displayProjection)
	{
		$displayProjection = preg_replace("/\+|^\s*|\s*$/","",$displayProjection);
		$referenceProjection = preg_replace("/\+|^\s*|\s*$/","",$referenceProjection);
		$displayProjection = preg_replace("/\s+/"," ",$displayProjection);
		$referenceProjection = preg_replace("/\s+/"," ",$referenceProjection);

		if (preg_match("/units=m/i",$displayProjection))
			$this->_units = 'METERS';
		else	
			$this->_units = 'DEGREES';

		if ($_REQUEST && ((! $referenceProjection) || ($referenceProjection != $displayProjection)))
		{
			$extent = $this->mapObject->extent;
			$_REQUEST[minlong] = $extent->minx;
			$_REQUEST[minlat] =  $extent->miny;
			$_REQUEST[maxlong] =  $extent->maxx;
			$_REQUEST[maxlat] =  $extent->maxy;
		}
	}

	function systemFaults()
	{
		if ($error = $this->_cacher->systemFaults())
			return $error;
		else	
			return parent::systemFaults();
	}

	/**
	 * returns mapfile
	 *
	 * returns the client specific mapfile if found or if not returns
	 * default mapfile
	 *
	 * @return string
	 */
	function findMapFile($mapFile)
	{
 		$filePath = $this->webRoot . '/webservices/mapper/'. $this->backendType .'/maps/config/'.$mapFile;
		if (file_exists($filePath))
			return  $filePath;

 		$filePath = $this->webRoot . '/webservices/mapper/maps/config/'. $mapFile;
		if (file_exists($filePath))
			return  $filePath;

		return $mapFile;
	}

	function describe()
	{
		return	
			"A Simple Mapper is a basic map generation Web Service Object\n\n".
			parent::describe();
	}
	
	/**
	 * add an available projection option, using human readable name and
	 * the proj4 specification of the projection.
	 *
	 */
	function addProjection($name,$mapFile,$defaultStartExtent)
	{
		$this->_projectionList[$name] = Array($mapFile,$defaultStartExtent);
	}

	/**
	 * 
	 * Send the generated results back to the client.(will be XML)
	 * @return string
	 *
	 */
	function sendResults()
	{

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
		$minDegrees = $this->_minResolution / 60;		    
		$minArea = ($minDegrees * $minDegrees);

		$area = ($maxLat - $minLat) * ($maxLong - $minLong);
		if ($area < $minArea)
		{
			$maxLat = $minLat + $minDegrees;
			$maxLong = $minLong + $minDegrees;
		}
		$this->mapObject->setExtent($minLong,$minLat,$maxLong,$maxLat);
		$this->maxCoords[0] = $minLong;
		$this->maxCoords[1] = $minLat;
		$this->maxCoords[2] = $maxLong;
		$this->maxCoords[3] = $maxLat;
	}

	function setPointLabelProperties($symSize,$labSize,$aLabelColour,$aOutlineColour)
	{
		$this->_symbolSize = $symSize;			 
		$this->_pointLabelSize = $labSize;			 
		$this->_pointLabelColour = $aLabelColour;
		$this->_pointLabelOutlineColour = $aOutlineColour;			 
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

		if ($this->mapObject->numlayers > 198)
		{
			$this->errorResponse(
				"You have attempted to map too many distinct layers! " .
				"Please try again with fewer distinct categories"
				);
		}

		if ( ! $layer = ms_newLayerObj($this->mapObject))
			$this->errorResponse("Error Creating new layer obj");

		$layer->set("name","dynamic_layer_$name");
		$layer->set("type",MS_LAYER_POINT);
		$layer->set("status",MS_ON);
		$layer->set("classitem","name");
		$layer->set("template","bogus.html");
		$proj = $this->mapObject->getProjection();
		if (! preg_match("/latlong/",$proj))
			$layer->setProjection($this->_pointProjection);

		// save a name for this layer - useful for sharing icons
		// between sessions as they are common images
		$this->_layerIconName["dynamic_layer_$name"] = "$symbol-$size-$colour";
		$this->_layerIconName = preg_replace("/#/",'',$this->_layerIconName);

		$class = ms_newClassObj($layer);
		$class->set('name',$name);
		$class->set('title',$name);
		$class->set("template","bogus.html");
		$class->label->set('size',$this->_pointLabelSize);
		$class->label->set('force',MS_TRUE);
		$class->label->color->setRGB(
					$this->_pointLabelColour[0],
					$this->_pointLabelColour[1],
					$this->_pointLabelColour[2]
				);
		$class->label->outlinecolor->setRGB(
					$this->_pointLabelOutlineColour[0],
					$this->_pointLabelOutlineColour[1],
					$this->_pointLabelOutlineColour[2]
				);
		$class->label->mindistance = 120;
		$class->label->position = MS_LL;

		$style = ms_newStyleObj($class);
		$style->set("size",$this->_symbolSize);
		$style->set("symbol",$symbolIdx);
		$style->set("symbolname",$symbol);

		if (! preg_match('/#([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})/i',$colour,$rgb))
			$rgb = array(0,0,0,0);

		$style->color->setRGB(hexdec($rgb[1]),hexdec($rgb[2]),hexdec($rgb[3]));
		$style->outlinecolor->setRGB(127,255,255);
		$style->backgroundcolor->setRGB(255,127,127);

		return $layer;
	}


	function showLabels($show)
	{

		for ($layerIndex = 0; $layerIndex < $this->mapObject->numlayers; $layerIndex++)
		{
			$layer = $this->mapObject->getLayer($layerIndex);
			if ($on)
				$layer->set('labelrequires','');
			else	
				$layer->set('labelrequires','false');
		}			
	}

	function splitLatLongs($st)
	{
		if (! preg_match("/\s+/",$st))
			return $st;
		$st = preg_replace("/^\s+|\s$/","",$st);
		$lParts = preg_split("/\s+/",$st);
		$deg = 0;
		for ($i = 0; $i < count($lParts)-1; $i++)
		{
			$deg += $lParts[$i]/pow(60,($i));
		}
		if (preg_match("/S|W/",$lParts[$i]))
			$deg = - $deg;
		return $deg;
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
		if (preg_match("/(S|N)$/",$lat,$match))
		{
			$lat = $this->splitLatLongs($lat);
		}
		if (preg_match("/(E|W)$/",$long,$match))
		{
			$long = $this->splitLatLongs($long);
		}

		/*if (! $point = ms_newPointObj())
			$this->errorResponse("Error Creating new point obj");
		$point->setXY($long,$lat);*/
		

		$line = ms_newLineObj();
		$line->addXY($long,$lat);
		/*$line->add($point);*/

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
	function addPoints($name,
				$records,
				$colour,
				$symbol,
				$expandExtent=false,
				$ignoreZeroLatLongs=true,
				$labelOn=false)
	{

		$img = $this->mapObject->prepareImage();
		$layer = $this->_makePointLayer($symbol,$size,$colour,$name);

		$index = 0;
		foreach ($records as $record)
		{
			$lat = $record['latitude'];
			$long = $record['longitude'];
			$description = $record['description'];
		
			if ($lat != NULL && $long != NULL)
			{
				$lat = $this->splitLatLongs($lat);
				$long = $this->splitLatLongs($long);

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
					$shpObj->set('index',$index++);
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
		$this->noLatLong = 0;
		$this->recordsPassed = 0;

		// kludge - avoids breaking legacy systems that use term
		// source...
		if ($groupBy == 'source')
			$groupBy = 'recordSource';		

		foreach ($translators as $src => $translator)
		{
			$translator->decodeUtf8();
			// portal may have been using translator prior to this
			// point so reset it
			$translator->reset();

			$groups =  $translator->getGroups();

			foreach ($groups as $group)
				$this->_knownFields[$group]++;

			$groupVal = $src;
			$current = 0;
			while ($translator->nextRecord())
			{
				$this->recordsPassed++;
				$lat = $translator->getLatitude();
				$long = $translator->getLongitude();
				$description = $translator->getDescription();

				if ($lat && $long)
				{
					$translated = Array();
					$translated['index'] = $current;
					$translated['recordSource'] = $src;
					$translated['description'] = $description;
					$translated['latitude'] = $lat;
					$translated['longitude'] = $long;

					foreach ($groups as $group)
					{
						if ($value =  $translator->getGroup($group))
							$translated[$group] = $value;

						if ($group == $groupBy)	
						{
							if (! $value)
								$groupVal = 'blank';
							else	
								$groupVal = $value;
						}
						
						$uniques[$group][$value]++;	
					}

					if (! isset($records[$groupVal]))
						$records[$groupVal] = Array();
					
					$records[$groupVal][] = $translated;

					$current++;
				}
				else
				{
					$this->noLatLong++;
				}
			}

		}
		$i = 0;
		foreach ($records as $group => $pointData)
		{
			$this->addPoints($group,
					$pointData,
					$this->getColour($i),
					$this->getSymbol($i++),
					$this->_allowExtentExpansion,
					false,
					$this->_labelPoints);
		}
	}

	/**
	 * set up mapper to map some passed XML (rather than querying for data)
	 *
	 * pass XML record data string (or URL) and a translator type
	 * string (eg 'EMu' or 'Digir') that understands this XML.
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
		$data = preg_replace('/^.*?\?>/s', '', $data);

		if (strlen($data) > $this->maxXmlSize)
		{
			$this->errorResponse('Too much data.  Sorry but most
			current web browsers will not be able to handle the
			size of the map response for this many specimens. KE is
			working on changing the way the map is generated to get
			around this limitation in future Mapper releases.
			Until then, try reducing the specimen count in your
			report.');
		}

		// save data in cache
		$this->_cacher->save('data.'.$this->_currentInstance,$data);
		$this->dataUrl = $this->_cacher->getUrlOfIndex('data.'.$this->_currentInstance);
		$this->dataType = $type;

		// add 'primed' translator to mapper
		$translator->translate($data);	
		$this->translators[$type] = $translator;
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
			{
				$this->mapUrl = $url;
				$this->imageFileRaw = $fileName;
			}
			else	
				$this->errorResponse("Error Saving map image");
		}
		else
			$this->errorResponse("Error Drawing map");

		$this->response = "<mapper><map>". $this->mapUrl ."</map></mapper>";

		return $this->mapUrl;
	}

	function dumpRawImage()
	{
		if (file_exists($this->imageFileRaw))
		{
			$fsize = filesize($this->imageFileRaw);
			if ($fsize)
			{
				header("Content-Type: image/gif");
				$fh = fopen($this->imageFileRaw, "r");
				$data = fread($fh, $fsize);
				fclose($fh);
				print $data;
			}
			else
			{
				$this->errorResponse("Cannot dump Image '$this->imageFileRaw'");
			}
		}
		else
		{
			$this->errorResponse("Image File not set");
		}
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
		$mapFile = $this->findMapFile($mapFile);

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

		$submission = "<input type='submit' name='call' value='Map' />";
		return $this->makeDiagnosticPage(
				$title,
				'',
				'',
				'./SimpleMapper.php',
				$args,
				$submission,
				$vars,
				$this->describe()
				);
	}

}

if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'SimpleMapper.php')
	{
		$webObject = null;

		$mapFile = 'simple.map';
		if ($_REQUEST["class"] == "SimpleMapper")
			$webObject = new SimpleMapper($mapFile);

		if ($webObject)
			print $webObject->test();
		else
			print "Couldn't make map object!?\n";
	}	
}


?>

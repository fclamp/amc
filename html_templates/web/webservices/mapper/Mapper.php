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
require_once ($WEB_ROOT . "/webservices/mapper/SimpleMapper.php");
require_once ($WEB_ROOT . "/webservices/portal/$BACKEND_TYPE/FetcherDriverFactory.php");
require_once ($WEB_ROOT . "/webservices/portal/$BACKEND_TYPE/PortalFactory.php");


/**
 * Class Mapper
 *
 * At some point Mapper and StandardMapper should be merged into a single
 * object
 *
 * @package EMuWebServices
 * @tutorial EMuWebServices/Mapper.cls
 *
 * @todo clean up Mapper classes.  Probably merge Mapper and StandardMapper
 *       classes (structure hangover from conversion from old perl mapper)
 *
 * @todo change queryScreen method to return XML rather than HTML
 *       (can then be styled using xsl)
 *
 * @todo remove the $_REQUEST dependence.  It should be
 * 	independent of $_REQUEST
 *
 * @todo complete mapper tutorial
 * 
 *
 */
class Mapper extends SimpleMapper
{
	var $serviceName = "Mapper";
	var $scaleUrl = '';
	var $refMapUrl = '';
	var $dataUrl = '';
	var $defaultStylesheet = 'mapdisplay.xsl';
	var $defaultQueryDataStylesheet = 'mapquery.xsl';
	var $standardTransform = '';
	var $passive = false;
	var $dataType = 'digir';
	var $_referer = '';

	var $startExtent = Array(-180,-90,180,90);

	var $suggestedQueryScreenParameters = Array(
		"maxPerSource" => 50,
		"timeoutSeconds" => 25,
		"image" => "./mapper/images/earth.jpg",
		"transform" => "SimpleTransformation"
	);

	var $_generateImageMap = true;
	var $_imageMapItems = array();
	var $_imageMapKeys = array();
	var $_imageMapXYUsed = array();

	var $_hotSpotSizePx = 20;

	function Mapper($mapFile,$backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		$this->{get_parent_class(__CLASS__)}($mapFile,$backendType,$webRoot,$webDirName,$debugOn);
		if (isset($_REQUEST['instance']))
			$this->_currentInstance = $_REQUEST['instance'];
		if (! isset($_REQUEST['referer']))
			$this->_referer = $_SERVER['HTTP_REFERER'];
		else
			$this->_referer = $_REQUEST['referer'];
	}

	function configureInterfaces()
	{
		parent::configureInterfaces();
		$this->setStandardArgument("source","can be used multiple times - list of data sources");
		$this->setStandardArgument("limit");
		$this->setStandardArgument("allLimit");
		$this->setStandardArgument("scatter");
		$this->setStandardArgument("sortby");
		$this->setStandardArgument("order");
		$this->setStandardArgument("timeout");
		$this->setStandardArgument("search");
		$this->setStandardArgument("action");
		$this->setStandardArgument("start");
		$this->setStandardArgument("allStart");
		$this->setStandardArgument("structuredQuery");

		$this->setStandardArgument("instance");
		$this->setStandardArgument("labels");
		$this->setStandardArgument("projection");
		$this->setStandardArgument("minlat");
		$this->setStandardArgument("minlong");
		$this->setStandardArgument("maxlat");
		$this->setStandardArgument("maxlong");
		$this->setStandardArgument("oldminlat");
		$this->setStandardArgument("oldminlong");
		$this->setStandardArgument("oldmaxlat");
		$this->setStandardArgument("oldmaxlong");

		$this->setStandardArgument("ForceExtent","make extent exactly equal to passed rectangle");
	}


	function describe()
	{
		return	
			"A Mapper is a general map generation object\n".
			"that extends a SimpleMapper\n\n".  parent::describe();
	}


	function addPoints($name,$records,$colour,$symbol,$expandExtent=false,$ignoreZeroLatLongs=true,$labelOn=false)
	{

		$name = html_entity_decode($name,ENT_QUOTES,'ISO-8859-1');
		// I must be thick - I did the decode, but &apos; still
		// appearing...  next line is a hack to get around my ignorance
		$name = preg_replace("/&apos;/","'",$name);

		if ($this->maxPointCoords == null)
		{
			$this->maxPointCoords = array(10000,10000,-10000,-10000);
		}

		$img = $this->mapObject->prepareImage();
		$layer = $this->_makePointLayer($symbol,$size,$colour,$name);

		$index = 0;
		foreach ($records as $record)
		{

			$lat = $record['latitude'];
			$long = $record['longitude'];
			if (preg_match("/E|W/",$long))
				$long = $this->splitLatLongs($long);
			if (preg_match("/N|S/",$lat))
				$lat = $this->splitLatLongs($lat);

			if ($_REQUEST['action'] == 'Query')
			{
				if (isset($record['description']))
					$desc = $record['description'];
				else
					$desc = $name;

				$description = "<record marked='false' index='".$record['index']."'>\n";
				$description .= "\t<recordSource>".$record['source']."</recordSource>\n";
				$description .= "\t<description>$desc</description>\n";
				$description .= "\t<latitude>".$record['latitude']."</latitude>\n";
				$description .= "\t<longitude>".$record['longitude']."</longitude>\n";
				foreach ($record as $field => $value)
				{
					if (! preg_match("/description|latitude|longitude/",$field))
						$description .= "\t<group name='$field'>$value</group>\n";
				}
				$description .= '</record>';
				$labelOn = true;
			}
			else
			{
				$description = $name;
			}
		
			if ($lat != NULL && $long != NULL)
			{
				if (($lat && $long) || ! $ignoreZeroLatLongs)
				{
					// record max spatial extent of points
					if ($lat < $this->maxPointCoords[1])
					{
						$this->maxPointCoords[1] = $lat;
					}
					if ($lat > $this->maxPointCoords[3])
					{
						$this->maxPointCoords[3] = $lat;
					}
					if ($long < $this->maxPointCoords[0])
					{
						$this->maxPointCoords[0] = $long;
					}
					if ($long > $this->maxPointCoords[2])
					{
						$this->maxPointCoords[2] = $long;
					}
					
					$shpObj = $this->_drawPoint($lat,$long,$description,$labelOn);
					$shpObj->set('index',$index++);
					if ($layer->addFeature($shpObj) != MS_SUCCESS)
						$this->errorResponse("Error Adding shape object to layer");

					if ($this->_generateImageMap)
					{
						if (! $record["description"])
							$record["description"] = "no summary data for irn:" . $record["irn"];

						$this->makeImageMapKey($lat,$long,$record,$record['irn']);
					}

					// add point beyond dateline if map has scrolled past dateline
					if ($this->_units == 'DEGREES' && (($this->startExtent[2] > 180) && (preg_match("/W/",$long) || $long < 0)))
					{
						$long = $this->splitLatLongs($long);
						$shpObj = $this->_drawPoint($lat,$long+360,$description,$labelOn);
						$shpObj->set('index',$index++);
						if ($layer->addFeature($shpObj) != MS_SUCCESS)
							$this->errorResponse("Error Adding shape object to layer");
					}
				}
			}	
		}

	}

	function addCopyright($cString,$textColour=array(255,255,255),$bgColour=array(127,127,127),$size=MS_SMALL)
	{
		$this->copyright = array($cString,$textColour,$bgColour,$size);

	}

	function drawCopyrightLayer()
	{
		if ($this->copyright != null)
		{
			list($cString,$textColour,$bgColour,$size) = $this->copyright;

			if ( ! $layer = ms_newLayerObj($this->mapObject))
				$this->errorResponse("Error Creating new layer obj");

			$layer->set("name","copyright");
			$layer->set("type",MS_LAYER_ANNOTATION);
			$layer->set("status",MS_ON);
			$layer->set("transform",MS_FALSE);

			if ( ! $class = ms_newClassObj($layer))
				$this->errorResponse("Error Creating new class obj:");
			$class->label->set('size',$size);
			$class->label->set('force',MS_TRUE);
			$class->label->set('partials',MS_FALSE);
			$class->label->set('offsetx',10);
			$class->label->backgroundcolor->setRGB($bgColour[0],$bgColour[1],$bgColour[2]);
			$class->label->color->setRGB($textColour[0],$textColour[1],$textColour[2]);
			$class->label->position = MS_CR;
	
			if ( ! $feature = ms_newShapeObj(MS_SHAPE_POINT))
				$this->errorResponse("Error Creating new shape obj");
			$feature->set("text",$cString);
	
			if ( ! $point = ms_newPointObj())
				$this->errorResponse("Error Creating new point obj");
			$point->setXY(80,$this->mapObject->height - 10);
	
			if ( ! $line = ms_newLineObj())
				$this->errorResponse("Error Creating new line obj");
			$line->add($point);

			$feature->add($line);

			if ($layer->addFeature($feature) != 0)
				$this->errorResponse("Error Adding copyright object to layer " + $i);
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

	function setHotSpotSize($size)
	{
		$this->_hotSpotSizePx = $size;
	}

	function getHotSpotSize()
	{
		return $this->_hotSpotSizePx;
	}

	function querySpatial($minlong,$minlat,$maxlong,$maxlat)
	{
		$this->errorResponse("SPATIAL SEARCH NOT CURRENTLY AVAILABLE\n$minlat,$minlong,$maxlat,$maxlong");
	}

	function getLayerDataFromRegion($minlong,$minlat,$maxlong,$maxlat)
	{
		$rect = ms_newRectObj();
		$rect->setExtent($minlong,$minlat,$maxlong,$maxlat);

		$xml = "";

		// query layers turned on by user (otherwise it would query
		// layers with status=on in the mapfile entry)
		$this->setLayerStatusAsRequested();
		$dynamicLayers = Array();
		$staticLayers = Array();
		$staticFields = Array();

		$dynamicShapes = Array();
		$staticShapes = Array();

		
		for ($layerIndex = 0; $layerIndex < $this->mapObject->numlayers; $layerIndex++)
		{
			$layer = $this->mapObject->getLayer($layerIndex);
			$layer->sizeunits = MS_METERS;
			$layer->toleranceunits = MS_METERS;
			$layer->tolerance = 100;
			$descriptionField = $layer->getMetaData('DescriptionField');
			if ($layer->status == MS_ON)
			{
				$queryGroup = $layer->name;
				# MapScript documentation
				# http://mapserver.org/mapscript/php/index.html#layerobj-class
				# says to query first then open the layer.
				# This works with MapServer 5.2 and 5.6 but
				# with MapsServer version 5.4.2 this causes
				# problems.  Seems to work in reverse though
				# for all versions 5.2+
				#
				# In future MapServer releases it be
				# best to move querying to whichShapes() and
				# nextShape() methods.

				if ($layer->open() == MS_SUCCESS)
				{
					if (@$layer->queryByRect($rect) == MS_SUCCESS)
					{
						$matchCount = $layer->getNumResults();

						for ($i=0; $i <  $matchCount; $i++)
						{
							$result = $layer->getResult($i);
							$layer->open();
							$shp = $layer->getShape($result->tileindex,$result->shapeindex);
							if ($descriptionField)
								$description = $shp->values[$descriptionField];
							else	
							{
								$descriptions = Array();
								foreach ($shp->values as $field => $value)
									$descriptions[] = "$field:$value";
								$description = implode(",",$descriptions);	
							}

							if (preg_match("/dynamic_/",$queryGroup))
							{
								$dynamicShapes[] = $shp;
								$dName = preg_replace("/dynamic_layer_/","",$queryGroup);
								$dynamicLayers[$dName][] = $shp->text;
							}
							else
							{
								$staticShapes[] = Array($queryGroup,$shp,$description);
								foreach ($shp->values as $field => $value)
								{
									$staticFields[$queryGroup][$field]++;
								}
							}
						}
					}
					$layer->close();	
				}
			}
		}

		List($dShapes,$sShapes) = $this->pointQueryStaticShapes($dynamicShapes,$staticShapes);
		
		return Array($dShapes,$sShapes,$staticFields);
	}

	function sendResults()
	{
		//  Send the generated results back to the client.
		if (is_array($this->response))
			return "<xml>\n". implode($this->response,"\n"). "</xml>";
		else
			return parent::sendResults();
	}

	function passToDataDisplay($translators,$rawData)
	{
		/* we want to produce xml result that can be suitably styled
		 * like fetcherDriver results 
		 */

		// for queries we don't want to taint normal transform and
		// stylesheet when cached - set them here (after any parameter
		// caching done)
		$request = $_REQUEST;

		if (isset ($_REQUEST['qtransform']))
			$request['transform'] = $_REQUEST['qtransform'];
		else
			unset($request['transform']);

		$request['stylesheet'] = $_REQUEST['qstylesheet'];

		// this bit a hack... we are making a fetcherdriver just to use
		// some of its presentation skills
		$fetcherDriver = null;
		
		$factory = new FetcherDriverFactory();
		if (! $fetcherDriver = $factory->getInstance())
			WebServiceObject::errorResponse('Failure to get fetcherDriver instance in mapper.php');

		foreach ($translators as $name => $translator)
		{
			$fetcherDriver->sourceList[$name]->sourceName = $name;
			$fetcherDriver->_sourceStatus[$name][] = 'extracted from map';
		}	

		// lat longs may now correspond to query box - see if the map
		// extent was saved and if so use that

		if (isset($_REQUEST['oldminlat']))
			$oldminlat = $_REQUEST['oldminlat'];
		else
			$oldminlat = $_REQUEST['minlat'];

		if (isset($_REQUEST['oldminlong']))
			$oldminlong = $_REQUEST['oldminlong'];
		else
			$oldminlong = $_REQUEST['minlong'];

		if (isset($_REQUEST['oldminlat']))
			$oldmaxlat = $_REQUEST['oldmaxlat'];
		else
			$oldmaxlat = $_REQUEST['maxlat'];

		if (isset($_REQUEST['oldminlong']))
			$oldmaxlong = $_REQUEST['oldmaxlong'];
		else
			$oldmaxlong = $_REQUEST['maxlong'];
	

		$returnUrl = $_SERVER['HTTP_REFERER'].
			"?instance=". $_REQUEST['instance'] .
			"&action=ZoomIn" .
			"&passive=true" .
			"&projection=" . $_REQUEST['projection'] .
			"&mapfile=" . $_REQUEST['mapfile'] .
			"&minlat=" .  $oldminlat .
			"&minlong=" .  $oldminlong .
			"&maxlat=" .  $oldmaxlat .
			"&maxlong=" .  $oldmaxlong;

		$fetcherDriver->assembleTranslatedData($translators,$request,'',$returnUrl,"spatiallyQueriedData");
		$this->response = $fetcherDriver->response;
		$response = $this->formatOutput($request, $rawData,0);

		// IE MSXML parser will complain if finds character data
		// outside 0x00-0x7f range.  Fix this by specifying encoding
		// scheme
		if (! preg_match("/<\?xml/",$response)) 
			$response = "<?xml version='1.0' encoding='iso-8859-1' ?>\n<!-- region only -->\n$response";

		header("Content-type: text/xml");
		foreach ($this->_headers as $header)
			header($header,1);
			
		return $response;
	}


	function getPointOfDynamicShape($shp)
	{
		// get xy coords of point shapefile
		$line = $shp->line(0);
		return $line->point(0);
	}

	function pointQueryStaticShapes($dynamicShapes,$staticShapes)
	{
		$matches = Array();
		$shapeMatches = Array();
		$pointToLayer = Array();

		$sShapes = Array();
		// create structure of shapes by category
		foreach ($staticShapes as $group)
		{
			$category = $group[0];
			$sShp     = $group[1];
			$description = $group[2];
			$sShapes[$category][] = Array($description,$sShp);
		}

		// create structure indexed by point with set of categories
		// each containing an index of shapes associated with that
		// point in that category
		foreach ($dynamicShapes as $dShp)
		{
			$dKey = $dShp->text;
			$dynamicPoint = $this->getPointOfDynamicShape($dShp);
			$dynamicPoint->z = 0;

			foreach ($sShapes as $category => $shapes)
			{
				$staticIndex = 0;	
				foreach ($shapes as $shape)
				{
					$description = $shape[0];
					$sShp        = $shape[1];
					if ($sShp->contains($dynamicPoint))
						$shapeMatches[$dKey][$category][] = Array($staticIndex,$description,$sShp);
					$staticIndex++;	
				}
			}	
		}

		$dShapes = Array();
		foreach ($dynamicShapes as $dShp)
		{
			$dKey = $dShp->text;
			$layers = "";

			if (array_key_exists($dKey,$shapeMatches))
			{
				$layerXml = Array();
				foreach ($shapeMatches[$dKey] as $category => $matches)
				{
					$index = Array();
					$descriptions = Array();
					$extraXml = Array();
					foreach ($matches as $match)
					{
						$index[] = $match[0];
						$descriptions[] = $match[1];
						$shp = $match[2];
						foreach ($shp->values as $field => $value)
						{
							$extraXml[$match[1]][] = "<$field>$value</$field>";
						}
					}
					$indices = implode(",",$index);
					$d = implode(",",$descriptions);
					$layers .= "\t\t<group name='$category'>$d</group>";
					$layerXml[] = "\t\t<keLayer name='$category'>";
					$layerXml[] = "\t\t\t<keDescription>$d</keDescription>";
					foreach ($extraXml as $description => $values)
					{
						foreach ($values as $value)
							$layerXml[] = "\t\t\t$value";
					}
					$layerXml[] = "\t\t</keLayer>";
				}
				$layers .= "\t<keLayers>\n" .  implode("\n",$layerXml) . "\t</keLayers>";
				
				$dKey = preg_replace("/(<\/record>)/","$layers\n$1",$dKey);
				$dKey = preg_replace("/<record [^>]+>/","<record>",$dKey);
				$dShapes[] = $dKey;
			}
			else
			{
				$dShapes[] = $dKey;
			}
		}

		$staticData = Array();
		foreach ($sShapes as $category => $shapes)
		{
			$index = 0;
			$data = "";
			foreach ($shapes as $shape)
			{
				$description = $shape[0];
				$sShp        = $shape[1];
				$data .= "<record>\n\t<keShapeIndex>$index</keShapeIndex>\n";
				$data .= "\t<keDescription>$description</keDescription>\n";
				$index++;
				foreach ($sShp->values as $field => $value)
				{
					$data .= "\t<$field>$value</$field>\n";
				}
				$data .= "</record>";
			}
			$staticData[$category] = $data;
		}

		return Array($dShapes,$staticData);
	}

	function queryRegion($minlong,$minlat,$maxlong,$maxlat,$rawData)
	{

		List($dynamicLayers,$staticLayers,$staticFields) = 
			$this->getLayerDataFromRegion($minlong,$minlat,$maxlong,$maxlat);


		$translators = Array();
		// process queried data using translator

		krsort($dynamicLayers);
		foreach ($dynamicLayers as $layer => $data)
		{
			$data = preg_replace("/<group name=.index.>.*/",'',$data);
			$dlayers .= $data;
		}	
		
		$dynamicDataTranslator = new GenericTranslator();
		$dynamicDataTranslator->passThrough("keLayers");
		$dynamicDataTranslator->translate("<records>$dlayers</records>");
		$dynamicDataTranslator->decodeUtf8();
		$dynamicDataTranslator->setGroupsUsingPattern("/^.*/");
		$dynamicDataTranslator->tagAllRecords("typeOfData","Mapped Records");
		$translators['point data'] =  $dynamicDataTranslator;

		krsort($staticLayers);

		// this code will return all static layers in a region query
		// currently disabled to make XML less complicated
		if (0)
		{
			foreach ($staticLayers as $category => $data)
			{
				$staticDataTranslator = new GenericTranslator();
				$staticDataTranslator->translate("<records>$data</records>");
				$staticDataTranslator->setGroupsUsingPattern("/^.*/");
				$staticDataTranslator->tagAllRecords("typeOfData","Geographic Data: $category");
				$translators[$category] =  $staticDataTranslator;
			}
		}
		return $this->passToDataDisplay($translators,$rawData);
	}

	function mapErrorHandler($errno, $errstr, $errfile, $errline)
	{
		switch($errno)
		{
			case 2:
				if (preg_match("/Failed to draw layer named(.*)/",$errstr,$match))
				{
					$this->errorResponse("requested layer ". $match[1] .
						" not found - please fix mapper configuration. ".
						" see $errfile line:$errline (actual error: $errstr)" );
				}
				break;
		}
		$this->errorResponse("mapper configuration error detected: $errno, $errstr, $errfile, $errline\n");
		exit(1);
	}

	function fetcherDriverQuery($fetcherDriver)
	{
		// standalone maps require a system to query datasources rather
		// than be passed data passively.  This system uses a EMu data
		// fetcherDriver to get the data


		// kludge - fetcherDriver may effect $_REQUEST - save it for later
		// reinstatement (need to stop this from happening)
		$oldRequest = $_REQUEST;

		$data = $fetcherDriver->request(true);			
		$data = preg_replace('/^.+\?>/s','',$data);

		if (preg_match("/<status\s+source=.(.+).\s+code=.[^03].>(.+)<\/status>/",$data,$matches))
		{
			$this->warnings[] = "<warning>WARNING: $matches[1] $matches[2]</warning>";
		}
		else if (preg_match("/<status\s+source=.(.+).\s+code=.8.>(.+)<\/status>/",$data,$matches))
		{
			$this->warnings[] = "<warning>$matches[1] $matches[2]</warning>";
		}

		$this->dataUrl = $this->_cacher->getUrlOfIndex('data.'. $this->_currentInstance);
		$this->translators = $fetcherDriver->_translators;

		$_REQUEST = $oldRequest;
	}

	function describeProjections()
	{
		$projs = "";
		foreach ($this->_projectionList as $name => $params)
		{
			$projs .= 
				"\t<availableProjection>\n".
				"\t\t<name>$name</name>\n".
				"\t\t<mapfile>$params[0]</mapfile>\n".
				"\t\t<defaultExtent>$params[1]</defaultExtent>\n".
				"\t</availableProjection>\n";
		}
		return $projs;
	}

	function request($fetcherDriver=null, $rawData=false, $setHeaders=true)
	{
		// hack to get around IE that will use name as well as id 
		// in getElementById DOM method in supporting javascript.  
		// See kemapdisplay.js
		if (isset($_REQUEST['showby']))
			$_REQUEST['sortby'] = $_REQUEST['showby'];

		// this method way to complicated... needs to be re written
		if (! isset($_REQUEST['instance']))
			$_REQUEST['instance'] = $this->_currentInstance;

		if ($mergedParams = $this->retrieveCallingParameters($_REQUEST['instance'],$_REQUEST))
		{
			if (isset($mergedParams['queryScreen']))
			{
				unset($mergedParams['queryScreen']);
			}
			$_REQUEST = $mergedParams;

		}
		else if ($mergedParams == NULL && ! $this->cacheExists($_REQUEST['instance']))
		{
			# if a returning call and no cache - data has expired...
			if (isset($_REQUEST['action']))
			{
				if (file_exists($this->webRoot . "/webservices/mapper/" . $this->backendType . "/style/expired.xsl"))
					$_REQUEST['stylesheet'] = "mapper/" . $this->backendType . "/style/expired.xsl";
				else	
					$_REQUEST['stylesheet'] = "mapper/style/expired.xsl";
			}
		}

		if (isset($_REQUEST['getPrevious']))
			$_REQUEST = $this->getMapFromHistory($_REQUEST['getPrevious']);
		else
			$paramCache = $this->saveCallingParameters($_REQUEST['instance'],$_REQUEST);

		if ($mergedParams[transform] == 'raw')
			$rawData = true;

		# if getting parameters from cache then some things relying on
		# $_REQUEST prior to getting cached values not set yet.  Set
		# them now
		if (isset($_REQUEST['passive']))
		{
			$this->passive = true;
			$fetcherDriver = null;

			// the mapper is now responsible for cleaning the
			// cache (if active this would be done by
			// FetcherDriver)
			$this->_cacher->cacheStats(900,true);
			$_REQUEST['queryScreen'] = null;
		}

		$this->_fetcherDriver = $fetcherDriver;

		if ($_REQUEST['queryScreen'])
		{
			$this->suggestedQueryScreenParameters["dataSchema"] = $this->standardSchema;
			$this->suggestedQueryScreenParameters["displayStylesheet"] = $this->findStylesheet();
			$this->suggestedQueryScreenParameters["queryStylesheet"] = $this->findStylesheet($_REQUEST['queryScreen']);
			$this->suggestedQueryScreenParameters["projections"] = "\n" . $this->describeProjections();

			$sources = $this->_fetcherDriver->getFetchers();
			$this->response = $this->_fetcherDriver->queryScreen($this->systemName,
						$this->suggestedQueryScreenParameters,
						$sources);
			
			$response = $this->formatOutput($this->_fetcherDriver->_request,$rawData);
			if ($setHeaders)
				foreach ($this->_headers as $header)
					header($header,1);
			return $response;
		}
		else
		{

			if ($this->_fetcherDriver)
			{
				// if given a fetcherDriver the mapper is responsible for
				// finding data (using the fetcherDriver)

				$this->fetcherDriverQuery($fetcherDriver);
			}
			else
			{

				if (isset($_REQUEST['data']) && isset($_REQUEST['translator']))
					$this->addDataAndType($_REQUEST['data'],$_REQUEST['translator']);
			}
			// plot data points and make map (unless a spatial query)
			if (! (isset($_REQUEST['action']) && $_REQUEST['action'] == 'Spatial'))
			{
	
				if (isset($_REQUEST['sortby']) && $_REQUEST['sortby'] != 'off')
					$showby = $_REQUEST['sortby'];
				else
					$showby = 'ScientificName';
				
	
				// get each translator to add it's points
				$this->addTranslatorData($this->translators,$showby);
			}	

			// adjust context/display etc based on passed requests
			// default extent is the extent in mapfile set in constructor

			if (isset($_REQUEST['minlat']))
				$minlat = $_REQUEST['minlat'];
			if (isset($_REQUEST['minlong']))
				$minlong = $_REQUEST['minlong'];
			if (isset($_REQUEST['maxlat']))
				$maxlat = $_REQUEST['maxlat'];
			if (isset($_REQUEST['maxlong']))
				$maxlong = $_REQUEST['maxlong'];

			if (($minlong || $minlat || $maxlong || $maxlat))	
			{
				$this->setExtent($minlong,$minlat,$maxlong,$maxlat);
			}
			else if ($this->maxCoords)
			{
				$this->mapObject->setExtent(
					$this->maxCoords[0],
					$this->maxCoords[1],
					$this->maxCoords[2],
					$this->maxCoords[3]);
			}
			else
			{
				List($minlong,$minlat,$maxlong,$maxlat) = $this->startExtent;
			}
			if (isset ($_REQUEST['action']))
				$action = $_REQUEST['action'];
			else
				$action = 'none';
	
			// make map components
	
			if ($action == 'Query')
				return $this->queryRegion($minlong,$minlat,$maxlong,$maxlat,$rawData);
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

				if (isset($_REQUEST['layerSetting']) && $_REQUEST['layerSetting'] == 'default')
				{
					// user has asked for just default layers
				}
				if (isset($_REQUEST['layerSetting']) && $_REQUEST['layerSetting'] == 'on')
				{
					$checked = "";
					$layer->set("status",MS_ON);
				}
				if (isset($_REQUEST['layerSetting']) && $_REQUEST['layerSetting'] == 'manual')
				{
					if (isset($_REQUEST[$stName]) && $_REQUEST[$stName] == 'on')
					{
						$layer->set("status",MS_ON);
					}	
					else if (isset($_REQUEST[$stName]) && $_REQUEST[$stName] == 'off')
					{
						$checked = "";
						$layer->set("status",MS_OFF);
					}
				}
				elseif (isset($_REQUEST[$stName]) && $_REQUEST[$stName] == 'off')
				{
					$checked = "";
					$layer->set("status",MS_OFF);
				}	
				// if called with an action, layers are expected to be
				// explicitly turned off if not wanted.  If no action,
				// use whatever the default status is (typically as per
				// mapfile).  This is a simple way to detect if the
				// mapper is being called a subsequent time - action in
				// this case should always have a value
				else if (isset($_REQUEST['action']) && $_REQUEST['action'])
					$layer->set("status",MS_ON);

				if ($layer->status == MS_OFF)
				{
					$checked = "";
					$_REQUEST[$stName] = 'off'; 
				}
				else
				{
					$_REQUEST[$stName] = 'on'; 
				}
	
				if (preg_match('/dynamic_layer_(.+)/',$name,$match))
				{
					$class = $layer->getClass(0);
					if ($icon = $class->createLegendIcon(20,20,$imageObject,0,0))
					{
						$index = $this->_layerIconName[$name];
						$fileName = $this->_cacher->makeFileName($index);
						$fileName = $fileName . ".gif";
						$url = $this->_cacher->getUrlOfFile($fileName);
						$encodeName = htmlspecialchars($name);
						if ($icon->saveImage($fileName,$this->mapObject) == MS_SUCCESS)
							$dynamicLayers[] = "<dynamicLayer>\n".
								"<layerName>$encodeName</layerName>\n".
								"<icon>$url</icon>\n".
								"<name>". htmlspecialchars($class->name) ."</name>\n".
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
					if ($layer->labelitem != '')
					{
						if ($_REQUEST['labelall'] != 'true')
						{
							$layer->set('labelitem','XXX');
							$layer->set('labelrequires','false');
						}
					}

					$notes = $layer->getMetaData('Notes');
					if (! $notes)
						$noteReferences[$notes] = '';
					else if (! isset ($noteReferences[$notes]))
						$noteReferences[$notes] = $noteReferenceCount++;
						
					$displayName = htmlspecialchars(preg_replace('/_/',' ',$name));
					$encodeName = htmlspecialchars($name);
					$staticLayers[] = "<staticLayer>\n".
						"<layerName>$encodeName</layerName>\n".
						"<icon/>\n".
						"<name>$displayName</name>\n".
						"<notes>". $notes ."</notes>\n".
						"<noteId>". $noteReferences[$notes] ."</noteId>\n".
						"<status>$checked</status>\n".
						"</staticLayer>";
				}
			}



			// _REQUEST  may have changed (notably layer settings) - so save them
			$paramCache = $this->saveCallingParameters($_REQUEST['instance'],$_REQUEST);
 
			$layerNotes = Array();
			foreach ($noteReferences as $note => $id)
			{
				if ($id)
					$layerNotes[] = "<layerNotes>\n".
						"\t<id>$id</id>\n".
						"\t<notes>$note</notes>\n".
						"</layerNotes>";
			}
			$this->drawCopyrightLayer();
			$oldHandler = set_error_handler(Array($this,"mapErrorHandler"));
			if ($imgObject = $this->mapObject->draw())
			{
				$index = 'map-'. $this->_currentInstance;
				$fileName = $this->_cacher->makeFileName($index);
				$fileName = $fileName . ".gif";
				$url = $this->_cacher->getUrlOfFile($fileName);
				if ($imgObject->saveImage($fileName,$this->mapObject) == MS_SUCCESS)
				{
					$this->mapUrl = $url;
					$this->imageFileRaw = $fileName;
				}
				else	
				{
					$this->_setError("Error Saving map image - mapserver returned error");
				}
				if (filesize($fileName) == 0)
				{
					$this->_setError("Error Saving map image - empty image! (disk full?)");
				}

			}
			else
			{
				$this->_setError("Error Drawing map");
			}
			restore_error_handler();
			
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
			{
				$this->_setError("Error Drawing Reference Map");
			}
	
			if (@$imgObject = $this->mapObject->drawScaleBar())
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
			{
				$this->_setError("Error Drawing Reference Map");
			}

			if ($this->_generateImageMap)
			{
				$this->makeImageMap();
			}
	
			// make xml response
	
			// save passed arguments in an XML element
			$referredArguments = Array();
			foreach ($_REQUEST as $param => $val)	
			{
				if (get_magic_quotes_gpc())
				{
					$param = stripslashes($param);
				}
				if (is_array($val))
				{
					$param .= '[]';
					if (count($val) > 0)
					{
						foreach ($val as $subValue)
						{
							if (get_magic_quotes_gpc())
							{
								$subValue = stripslashes($subValue);
							}
							$referredArguments[] = "$param=$subValue";
						}
					}
					else
					{
							$referredArguments[] = "";
					}

				}
				else
				{
					if (get_magic_quotes_gpc())
					{
						$val = stripslashes($val);
					}

					$val = preg_replace('/"/',"'",$val);	
					$val = preg_replace('/^\s+|\s+$/','',$val);	
					if (isset($val))
						$val = urlencode($val);

					$param = urlencode($param);	
					$referredArguments[] = "$param=$val";
				}	
			}
		
		
			// trick browser image caches by added random parameter to
			// image urls
			$rnd = rand(0,90000);	
	
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
			$this->response .= "<mapProjection>". $this->mapObject->getProjection() ."</mapProjection>\n";
			$this->response .= "<projectionUnits>". $this->_units ."</projectionUnits>\n";
			$this->response .= "<imageMap>". $this->_imageMap ."</imageMap>\n";
			$this->response .= "<showby>$showby</showby>\n";
			if (isset($_REQUEST['source']))
			{
				foreach  ($_REQUEST['source'] as $source)
				{
					$this->response .= "<dataSource>$source</dataSource>\n";
				}
			}
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
			// UPDATE
			// This appears to not be currently used (and role
			// has been duplicated by "additionalRequestArguments"
			// mechanism so suggest removal of echo)
			$echo = '';
			if (isset($_REQUEST['echo']))
			{
				foreach ($_REQUEST['echo'] as $echoArg)
				{
					list ($param,$val) = preg_split('/=/',$echoArg,2);
					$echo .= "<$param>$val</$param>\n";
				}
			}

			// mechanism to use instead of echo
			$additionalRequestArgumentsXml = $this->argumentsAsXml($this->additionalRequestArguments);
	
			$warnings = implode("\n",$this->warnings);
	
			$queryDataStylesheet = $this->findStylesheet($this->defaultQueryDataStylesheet);

			$projs = $this->describeProjections();

			# if user wants to zoom to show just the points set
			# this so - if no points zoom to start extent, if 1
			# point zoom in a bit from start extent centred on dot.

			if ($this->maxPointCoords == NULL)
				$this->maxPointCoords = $this->startExtent;

			if ($this->recordsPassed < 1)
			{
				$this->maxPointCoords = $this->startExtent;
			}
			else if ($this->recordsPassed < 2)
			{
				$invZoomFactor = 20;
				$xAdjust = 10;
				$yAdjust =10; 
				$xAdjust = ($this->startExtent[2] - $this->startExtent[0])/$invZoomFactor;
				$yAdjust = ($this->startExtent[3] - $this->startExtent[1])/$invZoomFactor;
				$this->maxPointCoords[0] -= $xAdjust;
				$this->maxPointCoords[1] -= $yAdjust;
				$this->maxPointCoords[2] += $xAdjust;
				$this->maxPointCoords[3] += $yAdjust;
			}

			# in some extreme cases this argument may be too long a 
			# string and so may have to be edited somehow to avoid
			# causing webserver/browser hangs - but leave that
			# coding for future bug fix
			$passedArgs = implode('&amp;',$referredArguments);			
			
			$this->response .= "<displayParameters>\n".
						"<!-- MAP AND COMPONENT SIZES -->\n" .
						"<imgWidth>". $this->mapObject->width ."</imgWidth>\n".
						"<imgHeight>". $this->mapObject->height ."</imgHeight>\n".
						"<scalebarWidth>". $this->mapObject->scalebar->width ."</scalebarWidth>\n".
						"<scalebarHeight>". $this->mapObject->scalebar->height ."</scalebarHeight>\n".
						"<referenceMapWidth>". $this->mapObject->reference->width ."</referenceMapWidth>\n".
						"<referenceMapHeight>". $this->mapObject->reference->height ."</referenceMapHeight>\n".

						"<!-- STATUS/DISPLAY OR ADDITIONAL COMPONENT INFORMATION-->\n" .
						"<missingLatLongs>$this->noLatLong</missingLatLongs>\n".
						"<recordsPassed>$this->recordsPassed</recordsPassed>\n".

						"<pointExtents>" . implode(" ",$this->maxPointCoords) . "</pointExtents>\n".
						"<mapfileExtents>" . implode(" ",$this->startExtent) . "</mapfileExtents>\n".

						"<warnings>". $warnings ."</warnings>\n".
						"<availableProjections>\n" . $this->describeProjections() . "\n</availableProjections>\n".
						"<queryDataStylesheet>".  $queryDataStylesheet ."</queryDataStylesheet>\n".
						"<!-- ENVIRONMENT/CALLING PARAMETERS ETC -->\n" .
						"<systemName>$this->systemName</systemName>\n".
						"<instance>". $this->_currentInstance ."</instance>\n".
						"<emuBackendType>". $this->backendType ."</emuBackendType>\n".
						"<emuWebBase>". $this->webDirName ."</emuWebBase>\n".
						"<referredArguments>$passedArgs</referredArguments>\n".
						"<referer>". urlencode($this->_referer) ."</referer>\n".
						"<mapperUrl>/". $this->webDirName ."/webservices/mapper.php</mapperUrl>\n".
						"<actionRequested>$action</actionRequested>\n".
						"<randomStamp>$rnd</randomStamp>\n".

						"<!-- NON STANDARD ARGUMENTS -->\n".
						$additionalRequestArgumentsXml . "\n".
						"</displayParameters>\n";
	
			$this->response .= "</mapper>\n";
		}

		// transform response as requested

		$response = $this->formatOutput($_REQUEST,$rawData);
		if ($setHeaders)
			foreach ($this->_headers as $header)
				header($header,1);

		$this->saveHistory($_REQUEST);
		return $response;
	}

	function latLongToPixels($lat,$long)
	{
		// convert lat/long to image coords (eg for making imagemap coords)
		// NB called as lat,long but returns x,y

		// map units may not be degrees - if not change lat/longs to degrees
		if ($this->mapObject->units != MS_DD)
		{
			if (! $point = ms_newPointObj())
				$this->errorResponse("Error Creating new point obj");
			$point->setXY($long,$lat);	
			$projectionFrom = ms_newprojectionobj("proj=latlong");
			$projectionTo = ms_newprojectionobj($this->mapObject->getProjection());
			$point->project($projectionFrom,$projectionTo);	
			$lat = $point->y;
			$long = $point->x;
		}
		
		while ($long < $this->mapObject->extent->minx)
		{
			$long += 360;
		}


		$ratioX =  (($long - $this->mapObject->extent->minx) / ($this->mapObject->extent->maxx - $this->mapObject->extent->minx)) ;
		$ratioY =  (($lat - $this->mapObject->extent->miny) / ($this->mapObject->extent->maxy - $this->mapObject->extent->miny)) ;

	        $x = round($this->mapObject->width * $ratioX);
	        $y = round($this->mapObject->height - ($this->mapObject->height * $ratioY));
		return array($x,$y);
	}				

	function makeImageMapDescription($record)
	{
		return $record['description'];
	}

	function makeImageMapKey($lat,$long,$record,$itemKey)
	{
		if (preg_match("/(S|N)$/",$lat,$match))
		{
			$lat = $this->splitLatLongs($lat);
		}
		if (preg_match("/(E|W)$/",$long,$match))
		{
			$long = $this->splitLatLongs($long);
		}
		$description = $this->makeImageMapDescription($record);

		$this->_imageMapItems["$lat,$long"][] = array($itemKey,$description);

	}

	function makeHtmlImageMap($name, $width, $height, $size)
	{
		$divs = array();
		$areas = array();
		foreach ($this->_imageMapItems as $latlong => $items)
		{
			$descriptions = array();
			$keys = array();
			foreach ($items as $item)
			{
				$descriptions[] = $item[1];
				$keys[] = $item[0];
			}

			list($lat,$long) = preg_split("/,/",$latlong,2);
			list($x,$y) = $this->latLongToPixels($lat,$long);
			$key = implode(",",$keys);
			$description = implode(" | ",$descriptions);
			$description = preg_replace("/'/","&apos;",$description);
			$areas[] = "<area nohref='#' title='$description' 
					name='$key' 
					id='$key' 
					shape='circle' 
					coords='$x,$y,$size' />";

			$hsSize = $this->_hotSpotSizePx;
			$hsWidth = $hsSize / 2;
			$top = $y - $hsWidth;
			$left = $x - $hsWidth;
			$divs[] = "<div id='k-" . $key . "' 
					alt='$description'
					title='$description'
					style='position: absolute;
					z-index:2;
					width:${hsSize}px;
					height:${hsSize}px;
					top:${top}px;
					left:${left}px;'>&nbsp;</div>";
				
		}

		$map = "<map id='$name' name='$name' width='$width' height='$height'>\n";
		$map .= implode("\n",$areas);
		$map .= "</map>\n";
		$map .= implode("\n",$divs);

		return $map;
	}

	function makeImageMap()
	{
		$map = "";
		foreach ($this->_imageMapItems as $latlong => $items)
		{
			$descriptions = array();
			$keys = array();
			foreach ($items as $item)
			{
				$descriptions[] = $item[1];
				$keys[] = $item[0];
			}

			list($lat,$long) = preg_split("/,/",$latlong,2);
			list($x,$y) = $this->latLongToPixels($lat,$long);
			$key = implode(",",$keys);
			$description = implode(" | ",$descriptions);
			$description = htmlspecialchars($description,ENT_QUOTES);
			$map .= "<area key='$key' data='$description' coords='$x,$y' />";
				
		}
		$this->_imageMap = $map;
	}


	function saveHistory($request)
	{
		$historyFileName = 'history.'.$this->_currentInstance;


		if ($this->_cacher->exists($historyFileName))
			$history = $this->_cacher->retrieve($historyFileName);

		$history .= "<hist>";
		$args = Array();
		foreach ($request as $arg => $value)
		{
			$arg = urlencode($arg);
			if (is_array($value))
			{
				foreach ($value as $subvalue)
				{
					$args[] = $arg ."[]=". urlencode($subvalue);
				}
			}
			else
				$args[] = "$arg=". urlencode($value);
		}
		$history .= implode("&",$args) . "</hist>";

		$this->_cacher->save($historyFileName,$history);
	}

	function getMapFromHistory($offset)
	{
		$request = Array();

		$historyFileName = 'history.'.$this->_currentInstance;
		if ($this->_cacher->exists($historyFileName))
		{
			$history = preg_split("/<\/hist><hist>/",$this->_cacher->retrieve($historyFileName));
			$historyEntries = count($history);

			if ($offset < 0)
				$offset = 0;
			else if ($offset >= $historyEntries)
				$offset = $historyEntries - 1;

			$response = preg_replace("/^<hist>|<\/hist>$/","",$history[$offset]);
			foreach (preg_split("/&/",$response) as $argument)
			{
				list($arg,$value) = preg_split("/=/",$argument,2);
				$arg = urldecode($arg);
				$value = urldecode($value);
				if (preg_match("/^(.+)\[\]$/",$arg,$match))
					$request[$match[1]][] = $value;
				else
					$request[$arg] = $value;
			}
			return $request;
	 	}
		return $_REQUEST;
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
	var $serviceName = "StandardMapper";

	var $queryTerms = Array(
			'Genus',
			'Species',
	);

	var $queryScreenParams = Array(
		'standardTimeout' => 25,
		'orRows' => 5,
		'maxPerFetcher' => 50,
		'showTransformOption' => true,
		'diagnostics' => true,
		'defaultMinLat' => -90,
		'defaultMinLong' => -180,
		'defaultMaxLat' => 90,
		'defaultMaxLong' => 180,
	);

	var $standardSchema = '';

	var $_fetcherDriver = null;

	var $_layerIconName   = array();

	function StandardMapper($mapFile,$backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		$this->{get_parent_class(__CLASS__)}($mapFile,$backendType,$webRoot,$webDirName,$debugOn);
	}

	function describe()
	{
		return	
			"A Standard Mapper is a map generation object\n".
			"that extends a Mapper allowing it to get data\n".
			"from multiple sources\n\n".  parent::describe();
	}


//-------------------------------------------------------------------------
	/***************************************/
	/*  BELOW HERE ARE TESTING COMPONENTS  */
	/***************************************/

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
					$this->defaultStylesheet ."' />";

		$vars = array();
		$vars["class"] = "StandardMapper";
		$vars["testCall"] = "true";

		$submission = "<input type='submit' name='call' value='Map' />";
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

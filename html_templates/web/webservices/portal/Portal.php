<?php

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/portal/FetcherFactory.php');
require_once ($WEB_ROOT . '/webservices/portal/FetcherDriver.php');
require_once ($WEB_ROOT . '/webservices/lib/WebServiceObject.php');
require_once ($WEB_ROOT . '/webservices/lib/StructuredQuery.php');
require_once ($WEB_ROOT . '/webservices/lib/DataCacher.php');
require_once ($WEB_ROOT . '/webservices/lib/Transformation.php');
if (file_exists($WEB_ROOT . '/webservices/mapper/SimpleMapper.php'))
	require_once ($WEB_ROOT . '/webservices/mapper/SimpleMapper.php');



/**
 * Class Portal
 *
 * @package EMuWebServices
 *
 */
class Portal extends FetcherDriver
{

//public:

	var $systemName = "KE Software EMu Portal Version 2";
	var $serviceDirectory = "webservices/portal";
	var $serviceName = "Portal";
	var $defaultQueryScreen = "portal_queryscreen.xsl";
	
	var $sourceList = array();
	var $response = array();

	// records to display on page	
	var $firstRec = 0;
	var $recordsPerPage = 25;

	var $sortby = '';
	var $order = 'ascending';

	var $defaultStylesheet = 'portal/style/portal.xsl';

	var $standardSchema = 'http://digir.sourceforge.net/schema/conceptual/darwin/full/2003/1.0/darwin2full.xsd';

	var $queryTerms = Array(
			'Genus',
			'Species',
	);

	var $suggestedQueryScreenParameters = Array(
		"maxPerSource" => 50,
		"timeoutSeconds" => 25,
		"image" => './mapper/images/discover.jpg',
	);

	var $defaultMapExtent = Array(-180,-90,180,90); // x1,y1,x2,y2

//private:

	var $_statusMapAvailable = false;
	var $_statusMapWanted = false;
	var $_mapFile = "";

	function Portal($backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		$this->{get_parent_class(__CLASS__)}($backendType,$webRoot,$webDirName,$debugOn);
		if (file_exists($this->webRoot . '/webservices/mapper/SimpleMapper.php'))
		{
			$this->_statusMapAvailable = true;
		}
	}

	function configureInterfaces()
	{
		parent::configureInterfaces();
	}

	function describe()
	{
		return	"A Portal is a system to allow querying of multiple\n".
			"data providers.  It will also collate and transform the\n".
			"returned data.  The system needs to be  configured\n".
			"to have one or more 'Fetchers' that know how to talk\n".
			"to data providers.\n\n".
			parent::describe();
	}

	function provideStatusMap($minLong,$minLat,$maxLong,$maxLat,$mapFile)
	{
		if ($this->_statusMapAvailable)
		{
			$this->_statusMapWanted = true;
			$this->defaultMapExtent = Array($minLong,$minLat,$maxLong,$maxLat);
			$this->_mapFile = $mapFile;
		}
		else
		{
			$this->errorResponse("Status Map Requested by Stystem does not have mapper");
		}
	}

	function setStandardSchema($schema)
	{
		$this->standardSchema = $schema;
	}

	function setStandardStylesheet($xslSheet)
	{
		$stylesheet = "/". $this->webDirName . $xslSheet;
	}

	function formatOutput($request,$rawData=false)
	{
		$action = 'notset';
		if (isset($request['action']))
			$action = $request['action'];

		switch ($action)
		{
			case 'analysis' :
				return $this->sendAnalysis($request);
				break;
			case 'export' :
				return $this->sendCsvExport($request['selected'],$request['extractedOnly']);
			case 'notset' :
			default:
				return parent::formatOutput($request,$rawData);
				break;

		}
	}

	function haversineGcd($long1,$lat1,$long2,$lat2)
	{
		// Calculate great circle distance
		// Haversine Formula (from R.W. Sinnott, "Virtues of the
		// Haversine", Sky and Telescope, vol. 68, no. 2, 1984, p.
		// 159)

		$R = 6367; // earth radius km

		$dlong = $long2 - $long1;
		$dlat = $lat2 - $lat1;
		$latT = sin($dlat/2);
		$longT = sin($dlong/2);
		
		$a = ($latT * $latT) + (cos($lat1) * cos($lat2) * $longT * $longT);
		$c = 2 * arcsin(min(1,sqrt($a)));
		return $R * $c;
	}

	function sendAnalysis($request)
	{
		$this->errorResponse("Cannot do Analysis yet !");
	}

	function sendCsvExport($selected,$extractedOnly)
	{
		foreach (preg_split('/\s*,\s*/',$selected) as $select)
			$markRecord[$select] = true;

		foreach ($this->_translators as $src => $translator)
		{
			$groups =  $translator->getGroups();
			foreach ($groups as $group)
				$this->_knownFields[$group]++;

			while ($translator->nextRecord())
			{
				if ( ! ($extractedOnly == 'true') || $markRecord[$current])
				{
					$recordBits = Array();
					foreach ($groups as $group)
						if ($value =  $translator->getGroup($group))
							$recordBits[$group] = $value;
						else
							$recordBits[$group] = "";
					$record['src'] = $src;
					$records[] = $recordBits;
					$totalCount++;
				}
				$current++;
			}
		}	
		$csv = Array();
		$csv[] = implode(",", array_keys($this->_knownFields));

		foreach ($records as $record)
		{
			$csvLine = Array();
			foreach ($this->_knownFields as $field => $used)
				if ($value =  $record[$field])
					$csvLine[] = $value;
				else
					$csvLine[] = "";
			$csv[] = implode(",",$csvLine);		
		}			
		$this->_headers[] = "Content-type: text/plain";
		return implode("\n",$csv);			
	}

	function request($rawData=false,$instance=0,$setHeaders=true)
	{
		if ($this->_request['queryScreen'])	
		{
			// just return query screen
			$this->suggestedQueryScreenParameters["dataSchema"] = $this->standardSchema;
			$this->suggestedQueryScreenParameters["displayStylesheet"] = $this->findStylesheet();
			$this->suggestedQueryScreenParameters["queryStylesheet"] = $this->findStylesheet($this->_request['queryScreen']);

			// we want to allow user to select any available
			// fetcher so get list of all potentials
			$sources = $this->getFetchers();
			$this->response[] = $this->queryScreen($this->systemName,
						$this->suggestedQueryScreenParameters,
						$sources,
						$this->_statusMapAvailable);

			$response = $this->formatOutput($this->_request,$rawData);
			if ($setHeaders)
				foreach ($this->_headers as $header)
					header($header,1);

			return $response;	
		}
		else
		{
			return parent::request($rawData,$instance,$setHeaders);
		}
	}

	function makeXmlResponse($recordXml,$rootTag,$mergeStatus,$srcCount,$fields)
	{
		$response = parent::makeXmlResponse($recordXml,$rootTag,$mergeStatus,$srcCount,$fields);
		if ($this->_statusMapWanted && $this->_statusMapAvailable)
		{
			$map = "<mapImage>" .
					$this->generateStatusMap($recordXml) .
				"</mapImage>";
			$response = preg_replace("/(<\/statusBlock>\s+)/","$map\n$1",$response);
		}
		return $response;
	}

	function generateStatusMap($xmlData)
	{
		#$this->_mapFile = 'simple.map';
		/*$mapper = new SimpleMapper($this->_mapFile,$this->backendType,$this->webRoot,$this->webDirName.$this->debugOn);
		$mapper->passive = true;
		$mapper->addDataAndType($xmlData,'Generic');
		$mapper->setMinResolution(0.02);
		$mapper->allowExtentExpansion(false);
		$mapper->showLabels(false);

		$mapper->setExtent($this->defaultMapExtent[0],
				$this->defaultMapExtent[1],
				$this->defaultMapExtent[2],
				$this->defaultMapExtent[3]);
		$mapper->setSize(315,500);
		return $mapper->request() ."?" . rand(0,1000) . '.'. time();*/
		return "N/A";
	}

//-------------------------------------------------------------------------
	/***************************************/
	/*  BELOW HERE ARE TESTING COMPONENTS  */
	/***************************************/
	function test($clientSpecific=false,$dir='')
	{
		if (isset($this->_request['testCall']))
		{
			header("Content-type: text/xml",1);
			print $this->request(true);
		}
		else	
		{
			header("Content-type: text/html",1);
			print $this->makeTestPage('','');
		}
	}


	function makeTestPage($title,$description)
	{
		$sourceBoxes = array();
		$sourceQuery = array();

		foreach ($this->getFetchers() as $source)
		{
			$factory = new FetcherFactory();
			if ($factory != null)
			{
				$instance =  $factory->getInstance($source);
				if ($instance != null)
				{
					$sourceQuery[] = $instance->testQueryTerms();
					$sourceBoxes[] = "<input type='checkbox' name='source[]' value='$source' checked='1' />$instance->sourceName";
				}	
			}
		}	

		$sources = implode("<br/>",$sourceBoxes);
		$terms = implode ("<br/> OR <br/>\n",$sourceQuery). "\n";

		if (! $title)
			$title = "Quick Test for KE Portal: ". $this->serviceName;

		$stylesheet = $this->findStylesheet();

		$args['Fetchers'] = $sources;	
		$args['Query Terms'] = $terms;	
		$args['Start (per Fetcher)'] = "<input type='input' name='start' value='0' size='2' />";
		$args['Limit (per Fetcher)'] = "<input type='input' name='limit' value='5' size='2' />";
		$args['Start (merged set)'] = "<input type='input' name='allStart' value='0' size='2' />";
		$args['Limit (merged set)'] = "<input type='input' name='allLimit' value='10' size='2' />";
		$args['Scatter (sample all or just sequential)'] = 
			"<input type='radio' name='scatter' value='' checked='true' />NO <br/>\n".
			"<input type='radio' name='scatter' value='true' />YES<br/>";

		$args['Timeout'] = "<input type='input' name='timeout' value='18' size='2' /> seconds";
		$args['Translation (client side xslt)'] = 
			"<input type='radio' name='stylesheet' value='' checked='true' />none <br/>\n".
			"<input type='radio' name='stylesheet' value='$stylesheet' />$stylesheet<br/>";
		$submission = "<input type='button' name='action' value='query' onClick='makeRequest();' />";

		$vars['schema'] = 'http://digir.sourceforge.net/schema/conceptual/darwin/full/2003/1.0/darwin2full.xsd';
		$vars['testCall'] = 'true';
		$vars['Queried Data-smap'] = 'false';
		$vars ['search'] = '';

		$js = <<<JAVASCRIPT

			function makeRequest()
			{

				var search = '';
				var records = '';
				var start = '';
				var limit = '';
				var termCount = 0;

				var inputs = document.getElementsByTagName('input');

				for (var i=0; i < inputs.length; i++)
				{
					var inputName =  inputs[i].name;
					var value =  inputs[i].value;
					if (inputName.match(/^qry_/))
					{
						field = inputName.replace(/^qry_/,'');
						field = field.replace(/\[\]$/,'');
						field = field.replace(/^darwin:/,'');
						search += "<equals><"+field+">"+value+"</"+field+"></equals>";
						termCount++;
					}
					else if (inputName == 'start')
					{
						start = "start = '"+ value +"'";
					}
					else if (inputName == 'limit')
					{
						limit = "limit='"+ value+ "'";
					}
					else if (inputName == 'schema')
					{
						schema = value;
					}
				}
				if (termCount > 1)
					search = "<filter><or>"+ search +"</or></filter>";
				else	
					search = "<filter>"+ search +"</filter>";

				records = "<records "+ limit +" "+ start +">";
				records += "<structure schemaLocation='" + schema +"'/></records>";
				search += records;

				document.getElementById('search').value= search;
				document.getElementById('message').innerHTML = search.replace(/</g,'&lt;');
				alert(document.getElementById('testCall'));

				document.forms[0].submit();
			}
JAVASCRIPT;

		$instanceToCall = preg_replace("/^.*\//",'./',$_SERVER['PHP_SELF']);

		$page = $this->makeDiagnosticPage(
					$title,
					$description,
					$js,
					$instanceToCall,
					$args,
					$submission,
					$vars,
					$this->describe()
				);
		print $page;		
	}

}

if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'Portal.php')
	{
		$portal = new Portal();
		print $portal->test();
	}
}

?>

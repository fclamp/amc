<?php

/* CURRENTLY THIS STUFF IS UNDER CONSTRUCTION */

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/common/SourceFactory.php');
require_once ($WEB_ROOT . '/objects/common/WebServiceObject.php');
require_once ($WEB_ROOT . '/objects/common/DataCacher.php');
require_once ($WEB_ROOT . '/objects/common/Transformation.php');
require_once ($WEB_ROOT . '/objects/common/Mapper.php');


/**
 * Class Portal
 *
 * @package EMuWebServices
 * @tutorial EMuWebServices/Portal.cls
 *
 */
class Portal extends WebServiceObject
{

//public:

	var $systemName = "KE Software EMu Portal Version 2";
	var $serviceName = "Portal";
	
	var $sourceList = array();
	var $response = array();

	// records to display on page	
	var $firstRec = 0;
	var $recordsPerPage = 25;

	var $sortby = '';
	var $order = 'ascending';

	var $standardXsl = '';
	var $standardSchema = 'http://digir.sourceforge.net/schema/conceptual/darwin/full/2003/1.0/darwin2full.xsd';

	var $queryTerms = Array(
			'Genus',
			'Species',
	);

	var $request = Array();

	var $queryScreen = Array(
		'standardTimeout' => 25,
		'orRows' => 5,
		'maxPerSource' => 50,
		'showTransformOption' => true,
		'diagnostics' => true,
	);
	var $defaultMapExtent = Array(-180,-90,180,90); // x1,y1,x2,y2

//private:

	var $_cacher = null;

	var $_statusMessages = array();

	var $_pruneStart = 0;
	var $_pruneLimit = -1;
	var $_pruneScatter = false;

	var $_knownFields = array();

	var $_statusMapWanted = false;
	var $_selectedRecords = '';
	var $_translators = '';


	function Portal($backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		$this->{get_parent_class(__CLASS__)}($backendType,$webRoot,$webDirName,$debugOn);
		$this->_cacher = new DataCacher($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
		$this->standardXsl = "/". $this->webDirName ."/pages/common/portal.xsl";
	}

	function setSystemName($name)
	{
		$this->systemName = "KE EMu $name";
	}

	function describe()
	{
		return	"A Portal is a system to allow querying of multiple\n".
			"data providers.  It will also collate and transform the\n".
			"returned data.  The system needs to be  configured\n".
			"to have one or more 'Sources' that know how to talk\n".
			"to data providers.\n\n".
			Parent::describe();
	}

	function setStandardSchema($schema)
	{
		$this->standardSchema = $schema;
	}

	function setStandardStylesheet($xslSheet)
	{
		$stylesheet = "/". $this->webDirName . $xslSheet;
	}

	function request($rawData=false,$instance=0,$setHeaders=true)
	{
		if (isset($_REQUEST['queryScreen']))
			return $this->queryScreen();


		// read any session saved parameters
		// NB the reading of session parameters has been spaghettied
		// over time - next few lines needs to be cleaned up properly !

		if (isset($_REQUEST['instance']))
		{
			$instance = $_REQUEST['instance'];
			$this->_currentInstance = $instance;
		}	

		if ($instance)
		{
			if (! $this->request = $this->retrieveCallingParameters($instance,$_REQUEST))
			{
				$_REQUEST['action'] = '';
				$this->request = $_REQUEST;
				$this->saveCallingParameters($instance,$_REQUEST);
			}
		}
		else	
		{
			$instance = $this->_currentInstance;
			$_REQUEST['action'] = '';
			$this->request = $_REQUEST;
			$this->saveCallingParameters($instance,$_REQUEST);
		}

		if (0)
		{
			if ($instance)
				$this->request = $this->readState($instance,$_REQUEST);
			else	
				$this->request = $this->saveCurrentState($_REQUEST,Array('action' => ''));
		}



		// Create sources via factories
		if  (isset($this->request['source']))
			foreach ($this->request['source'] as $source)
			{
				$this->_log("<action>creating source $source</action>");
				$factory = new SourceFactory();
				if ($factory != null)
				{
					$newSource =  $factory->getInstance($source);
					if ($newSource != null)
						$this->sourceList[] = $newSource;
					else
					{
						$this->_addStatusMessage($source,
							"Source dropped from query. No configuration found for $source",st_Warn);
						$this->_log("<warn>Source dropped from query. No configuration found for $source</warn>");
					}
				}
				else
					$this->_debug("Cannot make instance !",$source,1);
			}


		// Start all the sources handling the request.

			// NB iterating over elements in sourceList is done
			// clumsily. In PHP 4 if you use 'foreach' to iterate
			// over objects it uses copy by value rather than
			// returning references to the objects in the array so
			// makes a copy of each object rather than returning a
			// reference to it.  Rather than 
			// 'foreach ($this->sourceList as $source)' you have to
			// do 'for' and replace object back in list after
			// dealing with it in case its properties/state have
			// changed.  There may be better ways to do this but I
			// gave up...

		if (isset($this->request['timeout']))
			$timeout = $this->request['timeout'];
		else
			$timeout = 0; // 0 == use the default for the source

		for ($i = 0; $i < count($this->sourceList); $i++)
		{
			$sourceObj = $this->sourceList[$i];
			if (is_object($sourceObj))
			{
				$sourceObj->request($timeout,$this->request);
				$this->sourceList[$i] = $sourceObj;
			}
			else
				$this->_debug("Source not properly created ".$i." ",$sourceObj,1);
		}

		/* 
		 * Now while they have something to process keep
		 * going. Timeout is handled in the source itself.
		 */

		$handling = true;
		$this->_log("<action>poll requests</action>");
		while ($handling)
		{
			$handling = false;

			for ($i = 0; $i < count($this->sourceList); $i++)
			{
				$sourceObj = $this->sourceList[$i];
				if ($sourceObj->getStatus() == st_Reading)
				{
					if ($sourceObj->process())
					{
						$handling = true;
					}
				}	
				$this->sourceList[$i] = $sourceObj;
			}
		}

		// Merge the results and return data processed as requested

		$this->merge($this->request);

		// check for missing parameters (means cache expired)
		if (! $this->request['stylesheet'])
			$this->request['stylesheet'] = '/'. $this->webDirName .'/pages/common/portal.xsl'; 

		// clean cache of old records
		$stats = $this->_cacher->cacheStats(900,true);

		// send response
		$response = $this->formatOutput($this->request,$rawData);
		if ($setHeaders)
			foreach ($this->_headers as $header)
				header($header,1);

		return $response;	
	}

	function sendResults()
	{
		//  Send the generated results back to the client.

		$this->_log("<action>sendResults</action>");
		return "<xml>\n". implode($this->response,"\n"). "</xml>";
	}

	function getSources()
	{
		// returns a list of all potential sources in this client

		global $WEB_ROOT;
		$sourceList = array();
		$sourceDir = $this->webRoot .'/portal/';
		if (is_dir($sourceDir))
		{
			if ($dh = opendir($sourceDir))
			{
				while (($file = readdir($dh)) != false)
				{
					if (is_dir($sourceDir.$file) && ! preg_match('/\./',$file))
						$sourceList[] = $file;
				}
				closedir($dh);
			}
		}
		return $sourceList;
	}

	function saveCurrentState($hash,$exceptions=Array())
	{
		// method that can allow a portal to save state information for
		// later retrieval (typically the CGI request parameters
		// if param set in exceptions, don't save that parameter

		$status = array();

		ksort($hash);
		foreach ($hash as $param => $value)
		{
			if (! isset ($exceptions[$param]))
			{
				if (is_array($value))
					foreach ($value as $multiValue)
					{
						if (get_magic_quotes_gpc())
							$multiValue = stripslashes($multiValue);
						$status[] = "${param}[] = $multiValue";
					}	
				else	
				{
					if (get_magic_quotes_gpc())
						$value = stripslashes($value);
					$status[] = "$param = $value";
				}
			}
		}
		$status[] = "instance = ". $this->_currentInstance;
		$this->_cacher->save($this->_currentInstance,implode("\n",$status));
		$hash['instance'] = $this->_currentInstance;
		return $hash;
	}

	function readState($instance,$overrides = null,$ignores = Array())
	{
		// read and use parameters from previously cached statefile.
		// Can pass potential override values to override state values.
		// Can also specify ignores which will drop specified
		// parameters

		$request = array();
		if ($this->_cacher->exists($instance))
		{
			$state = $this->_cacher->retrieve($instance);
			foreach (preg_split('/\n/',$state) as $args)
			{
				preg_match('/^(.+?)\s*=\s*(.*)$/',$args,$match);
				if (! isset($ignores[$match[1]]))
					if (preg_match('/(.+)\[\]$/',$match[1],$name))
						$request[$name[1]][] = $match[2];
					else
						$request[$match[1]] = $match[2];
			}
			if (isset($request['instance']))
				$this->_currentInstance = $request['instance'];

			// override any parameters cached if new values passed
			if ($overrides)
			{
				foreach ($overrides as $param => $value)
				{
					$request[$param] = $value;
				}
				$excludes = Array();
				$excludes['action']++;
				return $this->saveCurrentState($request,$excludes);
			}
			else
				return $request;
		}
		
		return null;
	}



	function queryScreen()
	{
		// display a query screen to drive portal
		// 

		$this->setMergeLimits(0,10,false);
		$sourceBoxes = array();
		$sourceQuery = array();
		$exampleQueries = array();

		$sources = $this->getSources();
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
		$stylesheet = $this->standardXsl;


		$termCount = count($this->queryTerms);
		for ($row=0; $row < $this->queryScreen['orRows']; $row++)
			foreach ($this->queryTerms as $term)
				$qryRows[$term][] = "<input type='text' id='qry_${term}_$row' name='qry_${term}[]' value='' />";
		
		foreach ($qryRows as $term => $options)
		{
			$term = preg_replace('/.+?:/','',$term);
			$rows[] = "<td>$term<br/>\n\t" . implode("<br/>\n\t",$options) . "</td>";
		}
		$qryBlock = implode("\n",$rows);


		$jsSnippet = "/* dynamically generated js */\n";
		$jsSnippet .= "\t\t\t\tvar orTerms = '';\n";
		$jsSnippet .= "\t\t\t\tvar andTerms = '';\n\n";
		for ($row=0; $row < $this->queryScreen['orRows']; $row++)
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
			if ($i < $this->queryScreen['orRows'])
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

		$specifiedTimeout = $this->queryScreen['standardTimeout'];
		$maxPerSource = $this->queryScreen['maxPerSource'];	
		$allLimitDefault = $termCount * $maxPerSource;	

		if ($this->queryScreen['showTransformOption'])
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

		if ($this->queryScreen['diagnostics'])
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
		$html = <<<HTML
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
				<form method='POST' action='/$this->webDirName/webservices/portal.xml'>
					<table border='1'>
						<tr>
							<td>Data Sources</td>
							<td colspan='$termCount' align='center'>$sources</td>
							<td rowspan=10' align='center'>
 								<img border="0" alt='discover' src='http://kesoftware.com/images/emu/discover.jpg'/>
							</td>
						</tr>
						<tr>
							<td>Query Terms<br/><i>blank terms ignored</i></td>
							$qryBlock
						</tr>
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
						<tr>
							<td>Mini Distribution Map</td>
							<td colspan='$termCount'>
								<input type='radio' name='smap' value='true' checked='true'/>Display Map<br/>
								<input type='radio' name='smap' value='false' />No Map
							</td>
						</tr>
						<tr><td>Timeout per Source</td><td colspan='$termCount'>
							<input type='input' name='timeout' value='$specifiedTimeout' size='2' 
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
		return $html;
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
				return Parent::formatOutput($request,$rawData);
				break;

		}
	}

	function setMergeLimits($start = 0,$limit = -1,$scatter = false)
	{
		// restricts merged data to start at a $start record  (0=first)
		// restricts merged data to $limit records in total.
		// $limit of -1 = all records
		// $scatter:
		// =  true means take a record from each source in turn until
		//    limit reached so get data from multiple sources even if
		//    only a handful of records requested
		// =  false (default) means take block of records in sequence
		//    ignoring source (so may end up with records all from one
		//    source)

		$this->_pruneStart = $start;
		$this->_pruneLimit = $limit;
		$this->_pruneScatter = $scatter;
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


	function _addStatusMessage($source,$message,$code)
	{
		$msg =  "<status source='$source' code='$code'>$message</status>";
		$this->_statusMessages[] = $msg;
		$this->_log($msg);
		return st_OK;
	}

	function sortAndAssemble($translators,
			$start=0,
			$limit=-1,
			$sortBy='',
			$order='ascending',
			$selected = '',
			$extractedOnly = 'false',
			$forceSelected = '',
			$statusMapWanted = false)
	{
		// takes translators, extracts the xml records from each, sorts
		// them and returns those in requested start and limit
		// window (limit=-1 means unlimited) *after sorting*

		$records = array();
		$unWanted = array();
		$keys = array();
		$current = 0;
		$markedCount = 0;
		$totalCount = 0;
		$markRecord = Array();

		$uniques = array();

		$recordSpecial = array();
		foreach (preg_split('/\s*,\s*/',$selected) as $select)
			if ($select)
				$markRecord[$select] = true;

		$valueSelect = Array();

		if (isset($this->request['selectByValue']))
			foreach ($this->request['selectByValue'] as $selectByValue)
			{
				list($field,$value) = preg_split('/:/',$selectByValue,2);
				if ($field)
					$valueSelect[$field][] = $value;
			}

		// get all xml from translators (irrespective of requested
		// viewing window) and record key items
		foreach ($translators as $src => $translator)
		{
			$groups =  $translator->getGroups();
			foreach ($groups as $group)
				$this->_knownFields[$group]++;

			while ($translator->nextRecord())
			{
				$lat = $translator->getLatitude();
				$long = $translator->getLongitude();

				if ($markRecord[$current])
					$marked = "true";
				else
					$marked = "false";

				$fields = Array();
				foreach ($groups as $group)
				{
					if ($value =  $translator->getGroup($group))
					{
						$fields[] = "\t\t<group name='$group'>$value</group>";
						if (isset($valueSelect[$group]))
							foreach ($valueSelect[$group] as $want)
								if (preg_match("/$want/",$value))
								{
									$markRecord[$current] = "true";
									$marked = "true";
								}
					}
					$uniques[$group][$value]++;	
				}


				$translated = "\t<record index='$current' marked='$marked'>\n";
				$translated .= "\t\t<recordSource>".  $src ."</recordSource>\n";
				$translated .= "\t\t<description>".  $translator->getDescription() ."</description>\n";
				$translated .= "\t\t<latitude>$lat</latitude>\n";
				$translated .= "\t\t<longitude>$long</longitude>\n";
				foreach ($fields as $data)
					$translated .= $data;
				$translated .= "\t</record>\n";
					
				$records[] = $translated;

				// extract sort info:
				// take the records sort key and store the
				// index with that key
				// NB if sortBy not a known field then use
				// record source
				if (isset($this->_knownFields[$sortBy]))
					$value =  $translator->getGroup($sortBy);
				else
					$value = $src;
							
				if (! isset($keys[$value]))
					$keys[$value] = array();
				$keys[$value][] = $current;
				if ($markRecord[$current])
					$markedCount++;
				$totalCount++;
				$current++;
			}
		}

		// sort keys
		if ($order == 'descending')
			krsort($keys);
		else	
			ksort($keys);

		$sorted = array();
		foreach ($keys as $key => $indices)
			foreach ($indices as $index)
				$sorted[] = $index;
		

		if ($start > $totalCount - $this->recordsPerPage)
			$start = $totalCount - $this->recordsPerPage;
		if ($start < 0)
			$start = 0;


		// assemble in sorted order and truncate based on viewing
		// window
		$sortedRecords = array();
		$sortedPosition = 0;
		$count = 0;

		foreach ($sorted as $i)
		{
			if ($sortedPosition >= $start)
			{
				if (($limit == -1) || ($count < $limit))
				{
					if ( ! $extractedOnly || $markRecord[$i])
					{
						$sortedRecords[] = $records[$i];
						$count++;
					}
				}	
				else if ($statusMapWanted)
					$unWanted[] = $records[$i];
				else
					break;
			}	
			else if ($statusMapWanted)
				$unWanted[] = $records[$i];

			$sortedPosition++;
		}

		$map = "";
		if ($statusMapWanted)
			$map = $this->generateStatusMap($sortedRecords,$unWanted);

		if (count($markRecord) && $extractedOnly)
		{
			$this->_selectedRecords = implode(array_keys($markRecord),",");
			$overrides['selected'] = $this->_selectedRecords;
			//$request = $this->readState($this->request['instance'],$overrides);
			$request = $this->retrieveCallingParameters($this->request['instance'],$overrides);
		}	

		return array($sortedRecords,$start,$totalCount,$uniques,$map);
	}

	function merge($request=null)
	{
		/*  Take the list of sources and merge the results of
		**  all of them into one result set.
		*/


		// reset any passed data access controls
		if (isset($request['allStart']) && $request['allStart'])
			$this->_pruneStart = $request['allStart'];
		if (isset($request['allLimit']) && $request['allLimit'])
			$this->_pruneLimit = $request['allLimit'];
		if (isset($request['scatter']) && $request['scatter'])
			$this->_pruneScatter = $request['scatter'];


		$_statusMessages = array();

		$sourceCount = count($this->sourceList);
		
		$start = $this->_pruneStart;
		$limit = $this->_pruneLimit;
		$remaining = $limit;

		$translators = array();
		$metadata = array();

		for ($i = 0; $i < $sourceCount; $i++)
		{
			$source = $this->sourceList[$i];
			$status = $source->getStatus();
			

			switch($status)
			{
				case st_UsingCachedData:
						$this->_addStatusMessage($source->sourceName,"Using locally cached Data",$status);
				case st_Completed:
						if ($this->_pruneLimit == -1 || $remaining > 0)
						{
							if ($this->_pruneScatter)
								$perSource = round($remaining / ($sourceCount - $i));
							else
							{
								$perSource = $remaining;
								if ($i > 0)
									$start = 0;
							}

							$translator = $source->getData();

							$remaining = $remaining - count($translator->records);
							$translators[$source->sourceName] = $translator;
							$metadata[$source->sourceName] = $source->metaData();

						}
						$this->_addStatusMessage($source->sourceName,"completed read OK",$status);
					break;
				case st_Reading:
						$data = array();
						$this->_addStatusMessage($source->sourceName,"incomplete data",$status);
					break;
				case st_TimeOutNoResponse:
						$data = array();
						$this->_addStatusMessage($source->sourceName,"no response",$status);
					break;
				case st_TimeOutPartialResponse:
						$data = array();
						$this->_addStatusMessage($source->sourceName,"partial response",$status);
					break;
				case st_Unknown:
				default:
						$data = array();
						$this->_addStatusMessage($source->sourceName,"unknown error",$status);
					break;
			}
			$this->sourceList[$i] = $source;

		}	
		$this->_translators = $translators;

		// reset any passed display controls
		if (isset($request['sortby']) && $request['sortby'])
			$this->sortby = $request['sortby'];
		if (isset($request['order']) && $request['order'])
			$this->order = $request['order'];
		if (isset($request['recordsPerPage']) && $request['recordsPerPage'])
			$this->recordsPerPage = $request['recordsPerPage'];
		if (isset($request['firstRec']) && $request['firstRec'])
			$this->firstRec = $request['firstRec'];
		if (! (isset($request['scrollLeft']) && $request['scrollLeft']))
			$request['scrollLeft'] = 0;
		if (! (isset($request['scrollTop']) && $request['scrollTop']))
			$request['scrollTop'] = 0;
		if (isset($request['smap']) == 'true' && $request['smap'] == 'true')
			$this->_statusMapWanted = true;
		if (isset($request['selected']))
			$this->_selectedRecords = $request['selected'];

		// sort all data
		$extractedOnly = (isset($request['extractedOnly']) && $request['extractedOnly'] == 'true');
		if (! isset($request['forceSelected']))
			$request['forceSelected'] = '';
		

		list($records,$adjustedStart,$totalCount,$uniques,$map) = $this->sortAndAssemble($translators,
					$this->firstRec,
					$this->recordsPerPage,
					$this->sortby,
					$this->order,
					$this->_selectedRecords,
					$extractedOnly,
					$request['forceSelected'],
					$this->_statusMapWanted);
		$recordCount = count($records);			

		// specify known fields
		$fields = array();
		$checklist = array();
		foreach ($this->_knownFields as $field => $count)
		{
			if ($uniques[$field])
			{
				ksort($uniques[$field]);

				$fields[] = "<group>$field</group>";
				$checklist[] = "<group name='$field'>";
				foreach ($uniques[$field] as $value => $count)
					$checklist[] = "\t<value count='$count'>$value</value>";
				$checklist[] = "</group>";
			}
		}


		$this->_log("<action>data merged</action>");

		if (isset($this->request['source']))
			foreach ($this->request['source'] as $source)
				$args[] = "source[]=$source";

		foreach (Array('limit',
				'allLimit',
				'scatter',
				'sortby',
				'order',
				'smap',
				'timeout',
				'start',
				'allStart',
				'schema',
				'search') as $term)
		{		
			if (isset($this->request[$term]))
				$args[] = $term ."=". urlencode($this->request[$term]);
			else	
				$args[] = $term ."=";
		}

		$args[] = "stylesheet=/".  $this->webRoot .
				"/pages/common/standardmap.html";
	
		$args[] = "transform=SimpleTransformation";
	
		$args[] = "id=". rand(0,1000);
	

		$mapperUrl = "/".  $this->webDirName .  "/webservices/mapper.xml?".
				implode('&amp;',$args);
			
		if ($this->_currentInstance)
			$mergeStatus = 'success';
		else	
			$mergeStatus = 'expired';
		
		if (! isset($request['extractedOnly']))
			$request['extractedOnly'] = 'false';

		$this->response[] =  "<mergedData>\n".
			"\n<statusBlock status='$mergeStatus'>\n".
			"\t<instance>". $this->_currentInstance . "</instance>\n".
			"\t<displayRequests>\n".  
			"\t\t<systemName>". $this->systemName ."</systemName>\n".
			"\t\t<firstRecord>$adjustedStart</firstRecord>\n".
			"\t\t<recordsPerPage>". $this->recordsPerPage ."</recordsPerPage>\n".
			"\t\t<sort order='". $this->order ."'>". $this->sortby ."</sort>\n".
			"\t\t<selected>". $this->_selectedRecords ."</selected>\n".
			"\t\t<selectedOnly>". $request['extractedOnly'] ."</selectedOnly>\n".
			"\t\t<emuwebBase>". $this->webDirName ."</emuwebBase>\n".
			"\t\t<scroll>\n".
			"\t\t\t<scrollLeft>". $request['scrollLeft'] ."</scrollLeft>\n".
			"\t\t\t<scrollTop>". $request['scrollTop'] ."</scrollTop>\n".
			"\t\t</scroll>\n".
			"\t</displayRequests>\n\t".
			implode("\n\t",$this->_statusMessages).
			"\n</statusBlock>\n".
			"\n<sourceDescription>\n\t".
			implode("\n\t",$metadata). "\n".
			"\t<groups>\n\t\t".
			implode("\n\t\t",$fields). "\n".
			"\t</groups>\n".
			"\t<uniqueValues>\n\t\t".
			implode("\n\t\t",$checklist). "\n".
			"\t</uniqueValues>\n".
			"</sourceDescription>\n\n".
			"<images>\n".
			"\t<map>$map</map>\n".
			"\t<mapperApplication>$mapperUrl</mapperApplication>\n".
			"</images>\n\n".
			"<records displayed='$recordCount' total='$totalCount'>\n".
			implode ($records,"\n").
			"\n</records>\n\n".
			"</mergedData>\n";
	}

	function generateStatusMap($wanted,$unWanted)
	{
		$xmlData = "<records>". implode("\n",$wanted) ."</records>";
		$mapper = new SimpleMapper('simple.map',$this->backendType,$this->webRoot,$this->webDirName.$this->debugOn);
		$mapper->passive = true;
		$mapper->addDataAndType($xmlData,'Generic');

		$mapper->setExtent($this->defaultMapExtent[0],
				$this->defaultMapExtent[1],
				$this->defaultMapExtent[2],
				$this->defaultMapExtent[3]);
		return $mapper->request() ."?" . rand(0,1000) . '.'. time();
	}

	function test($clientSpecific=false,$dir='')
	{
		if (isset($_REQUEST['testCall']))
		{
			header("Content-type: text/xml",1);
			print $this->request($_REQUEST['search']);
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
		foreach ($this->getSources() as $source)
		{

			$factory = new SourceFactory();
			if ($factory != null)
			{
				$instance =  $factory->getInstance($source);
				if ($instance != null)
				{
					$sourceQuery[] = $instance->testQueryTerms();
					$sourceBoxes[] = "<input type='checkbox' name='source[]' value='$source' checked='1' />$source<br/>\n";
				}	
			}
		}	

		$sources = implode("<br/>",$sourceBoxes);
		$terms = implode ("<br/> OR <br/>\n",$sourceQuery). "\n";

		if (! $title)
			$title = "Quick Test for KE Portal: ". $this->serviceName;


		$args['Sources'] = $sources;	
		$args['Query Terms'] = $terms;	
		$args['Start (per Source)'] = "<input type='input' name='start' value='0' size='2' />";
		$args['Limit (per Source)'] = "<input type='input' name='limit' value='5' size='2' />";
		$args['Start (merged set)'] = "<input type='input' name='allStart' value='0' size='2' />";
		$args['Limit (merged set)'] = "<input type='input' name='allLimit' value='10' size='2' />";
		$args['Scatter (sample all or just sequential)'] = 
			"<input type='radio' name='scatter' value='' checked='true' />NO <br/>\n".
			"<input type='radio' name='scatter' value='true' />YES<br/>";

		$args['Timeout'] = "<input type='input' name='timeout' value='18' size='2' /> seconds";
		$args['Translation (client side xslt)'] = 
			"<input type='radio' name='stylesheet' value='' checked='true' />none <br/>\n".
			"<input type='radio' name='stylesheet' value='/$this->webDirName/pages/common/portal.xss' />portal.xss<br/>";
		$submission = "<input type='button' name='action' value='query' onClick='makeRequest();' />";

		$vars['schema'] = 'http://digir.sourceforge.net/schema/conceptual/darwin/full/2003/1.0/darwin2full.xsd';
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
						field = inputName.replace(/\[\]$/,'');
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

				document.forms[0].submit();
			}
JAVASCRIPT;

		$page = $this->makeDiagnosticPage(
					$title,
					$description,
					$js,
					'./Portal.php',
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

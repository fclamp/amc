<?php

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */




if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/portal/Fetcher.php');


/**
 *
 * Class DummyFetcher
 *
 * This is for testing only - not normally used by clients
 * For making dummy data fetchers that return test data
 * a Dummy Fetcher Does not connect to any actual Data Provider - just pretends
 * it does
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class DummyFetcher extends Fetcher
{

	var 	$serviceName = "DummyFetcher";

	/*  Describe Dummy configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "Generic Dummy Fetcher";
	var	$hostname = "localhost";
	var	$port = 80;
	var	$provider = "emuweb/webservices/dummy.php";
	var	$resource = "emu";
	var 	$translatorType = 'Digir';

	var 	$queryableFields = Array(
			'darwin:Family' => Array(1,"Baridae"),
			'darwin:Genus' => Array(2,"Barella"),
			'darwin:Species' => Array(3,"barii"),
	);


	function describe()
	{
		return 
			"A Dummy Fetcher is a Fetcher that knows how to\n".
			"talk with Dummy Data Providers.  Is used for Tesing\n\n".  parent::describe();
	}

	function makeIndex()
	{
		$index = $this->serviceName .':'. $_REQUEST['search'];
		$index = urldecode($index);	
		if (get_magic_quotes_gpc())
			$index = stripslashes($index);
		return $index;
	}

	function parseDigirSearchRequest($digirSearch)
	{
		return array(urlencode("Genus, Species, CatalogNumber"),urlencode("Genus = 'Macropus'"),1,20);
	}

	function makeUrl()
	{
		list($select,$where,$start,$limit) = $this->parseDigirSearchRequest($_REQUEST['search']);
		$time = $this->timeStamp($unixTime);	
		$host = $this->hostname;
		$provider = $this->provider;
		$get="?repository=". $this->resource . "&".
			"sql=SELECT+$select+FROM+DataSet+WHERE+$where&".
			"batchSize=$limit&".
			"batchStart=$start&".
			"portsurvey=". $_REQUEST['portSurvey'];

		return array($provider.$get,$this->hostname,$this->port,null,null);
	}

	function setWantedGroups()
	{
		$this->_translator->addPotentialGroups( 
			array(
              			"InstitutionCode",
              			"CatalogNumber",
              			"ScientificName",
              			"TypeStatus",
              			"Kingdom",
              			"Phylum",
              			"Class",
              			"Order",
              			"Family",
              			"Genus",
              			"Species",
              			"Subspecies",
              			"Longitude",
              			"Latitude",
              			"ContinentOcean",
              			"Country",
              			"StateProvince",
              			"County",
              			"Locality",
              			"Collector",
              			"YearCollected",
              			"PreparationType",
              			"DateLastModified",
			)
		);
	}

	function makeDummyData()
	{
		$t = Array('Ayefelotype','','Veefelotype');
		$g = Array('Saintkildus','Carltonus','Hawthornus','Sydneyus','Collingwoodus','Geelongus');
		$s = Array('magpius','tigerus','swanus','kangaroous');
		for ($i=0; $i < 5; $i++)
		{
			$reg = rand(0,3000);
			$long = rand(-180,179) + rand(0,3600)/3600;
			$lat = rand(-40,-20) + rand(0,3600)/3600;
			$genus = $g[rand(0,count($g)-1)];
			$species = $s[rand(0,count($s)-1)];
			$type = $t[rand(0,count($t)-1)];
		
			$records[] = "<record>".
				"	<DateLastModified>2005-05-06 17:15:00.00Z</DateLastModified>".
				"	<InstitutionCode>KE</InstitutionCode>".
				"	<CatalogNumber>$i:$reg</CatalogNumber>".
				"	<ScientificName>$genus $species</ScientificName>".
				"	<TypeStatus>$type</TypeStatus>".
				"	<CollectionCode>KE Cryptozoology Department</CollectionCode>".
				"	<Kingdom>Animalia</Kingdom>".
				"	<Phylum>Conodonta</Phylum>".
				"	<Family>Culumbodinadae</Family>".
				"	<Genus>$genus</Genus>".
				"	<Species>$species</Species>".
				"	<Longitude>$long</Longitude>".
				"	<Latitude>$lat</Latitude>".
				"</record>";
		}

		return "<records>\n". implode("\n",$records) . "\n</records>";
	}

	function request($timeout,$parameters=null)
	{
		// doesn't actualy make a request - just pretends it has !

		$this->_index = $this->makeIndex();
		if ($this->cacheIsOn && $this->_cacher->exists($this->_index))
		{
			$this->_isCached = true;
			$this->setStatus(st_Reading);
			$this->_startTime = time();
		}
		else
		{
			$this->_startTime = time();
			$this->setStatus(st_Reading);
		}
		return 0;
	}

	function process()
	{
		/* see if any to be processed. Return true if still not
		 * finished querying data source and retrieving results.
		 * Note a 'Finite State Machine' needs to be used here
		 * to control flow.
		 */

		$elapsed = time() - $this->_startTime;

		if ($this->cacheIsOn && $this->_isCached)
		{
			if ($this->_cacher->exists($this->_index))
			{
				$this->_data[] = $this->_cacher->retrieve($this->_index);
				$this->setStatus(st_UsingCachedData);
				return false;
			}
			else
			{
				$this->errorResponse("Index ".$this->_index ." dont exist");
			}
		}
		else
		{
			$this->_data[] = $this->makeDummyData();
			$this->setStatus(st_Completed);
			return false;
		}
		return false;
	}

	function test($serviceSpecific=false,$dir='')
	{
		if (! $serviceSpecific)
			// look for fetcher in ~/web/portal
			parent::test(true,$this->webRoot.'/portal');
		else	
		{
			if (isset($_REQUEST['testCall']))
			{
				header("Content-type: text/xml",1);
				print $this->requestAndProcess($_REQUEST['timeout']);
			}
			else	
			{
				header("Content-type: text/html",1);
				$this->makeTestPage('','Dummy Fetcher Test','','','','');
			}
		}	
	}

	function testQueryTerms()
	{
		/* define some simple query for use when testing
		 * The parameter name should be prefaced with 'qry_'
		 */
		return "Genus = <input type='text' name='qry_genus' value='Rattus' />";
	}


	function makeTestPage($title,$description,$terms,$countNum,$schema)
	{
		if (! $title)
			$title = "KE EMu ". $this->serviceName;
		if (! $terms)
			$terms = $this->testQueryTerms();
		if (! $countNum)
			$countNum = 10;
		if (! $schema)
			$schema = 'http://digir.sourceforge.net/schema/conceptual/darwin/full/2003/1.0/darwin2full.xsd';

		$describe = $this->describe();
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
				records = "<records "+ limit +" "+ start +">";

				if (termCount > 1)
					search = "<filter><or>"+ search +"</or></filter>";
				else	
					search = "<filter>"+ search +"</filter>";

				records += "<structure schemaLocation='" + schema +"'/></records>";
				search += records;

				document.getElementById('search').value= search;
				document.getElementById('message').innerHTML = search.replace(/</g,'&lt;');

				document.forms[0].submit();
			}
JAVASCRIPT;

		$args['Query Terms'] = $terms;
		$args['Start'] = "<input type='input' name='start' value='0'  size='2'/>";
		$args['Limit'] = "<input type='input' name='limit' value='5'  size='2'/>";
		$args['Timeout'] = "<input type='input' name='timeout' value='18'  size='2'/>";
		$args['Record Schema'] = "<input type='input' name='schema' value='$schema'  size='60'/>";
		$submission = "<input type='button' name='action' value='query' onClick='makeRequest();' />";
		$vars ['search'] = '';

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
	$serviceFile = basename($_SERVER['PHP_SELF']);

	if (basename($serviceFile) == "DummyFetcher.php")
	{
		$webObject = new DummyFetcher();
		$webObject->test(true);
	}
}

?>

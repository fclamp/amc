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
 * Class OzcamFetcher
 *
 * This is a generic Ozcam source object.  Actual Fetcher Objects inherit from
 * this and set specific properties to match the actual Provider it is to talk
 * to and also set some 'typical' test queries.
 * The inherited Fetchers should be placed in ~web/portal/SOURCE/Fetcher.php
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class OzcamFetcher extends Fetcher
{

	var 	$serviceName = "OzcamFetcher";

	/*  Describe Ozcam configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "Generic Ozcam Fetcher";
	var	$hostname = "localhost";
	var	$port = 80;
	var	$provider = "emuweb/webservices/ozcam.php";
	var	$resource = "emu";
	var 	$translatorType = 'Ozcam';


	function describe()
	{
		return 
			"A Ozcam Fetcher is a Fetcher that knows how to\n".
			"talk with Ozcam 2 Data Providers.\n\n".  parent::describe();
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

	function test($serviceSpecific=false,$dir='')
	{
		if (! $serviceSpecific)
			// look for sources in ~/web/portal
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
				$this->makeTestPage('','Ozcam Fetcher Test','','','','');
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

		$page = $this->makeDiagnosticPage(
					$title,
					$description,
					$js,
					'./Fetcher.php',
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

	if (basename($serviceFile) == "OzcamFetcher.php")
	{
		$webObject = new OzcamFetcher();
		$webObject->test();
	}
}

?>

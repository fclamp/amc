<?php

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */




if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/common/PortalSource.php');

/**
 *
 * DigirSource is Class for accessing DiGIR Sources
 *
 *
 * This is a generic Digir source object.  Actual Source Objects inherit from
 * this and set specific properties to match the actual Provider it is to talk
 * to and also set some 'typical' test queries.
 * The inherited Sources should be placed in ~web/portal/SOURCE/Source.php
 *
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */

class DigirSource extends PortalSource
{

	var 	$serviceName = "DigirSource";

	/*  Describe Digir configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "Generic Digir Source";
	var	$hostname = "localhost";
	var	$port = 80;
	var	$provider = "emuweb/webservices/digir.php";
	var	$resource = "emu";
	var 	$translatorType = 'Digir';


	function describe()
	{
		return 
			"A Digir Source is a Portal Source that knows how to\n".
			"talk with Digir Data Providers.\n\n".  Parent::describe();
	}

	function makeIndex()
	{
		$index = urldecode($_REQUEST['search']);	
		if (get_magic_quotes_gpc())
			$index = stripslashes($index);
		return $this->serviceName .':'. $index;
	}

	function makeUrl()
	{
		$time = $this->timeStamp($unixTime);	
		$host = $this->hostname;
		$provider = $this->provider;
		$resource = $this->resource;

		$params = array();
		if (isset($_REQUEST['search']))
		{
			$search = $_REQUEST['search'];
			if (is_array($search))
				$search = $search[0];
		 	if (get_magic_quotes_gpc())
		       		$search=stripslashes($search);
			$search = urldecode($search);

			$params['doc'] = 
				"<request xmlns='http://www.namespaceTBD.org/digir'\n".
				"	xmlns:xsd='http://www.w3.org/2001/XMLSchema'\n".
				"	xmlns:darwin='http://digir.net/schema/conceptual/darwin/2003/1.0'\n".
				"	xmlns:dwc='http://digir.net/schema/conceptual/darwin/2003/1.0'>\n".
				"	<header>\n".
				"		<version>1.0.0</version>\n".
				"		<sendTime>$time</sendTime>\n".
				"		<source>$host</source>\n".
				"		<destination resource='$resource'>http://$host/$provider</destination>\n".
				"		<type>search</type>\n".
				"	</header>\n".
				"	<search> $search </search>\n".
				"	</request>";
				
		}
		return array('/'.$provider,$this->hostname,$this->port,null,$params);
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
				$this->makeTestPage('','Digir Source Test','','','','');
			}
		}	
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
					'./Source.php',
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

	if (basename($serviceFile) == "DigirSource.php")
	{
		$webObject = new DigirSource();
		$webObject->test();
	}
}

?>

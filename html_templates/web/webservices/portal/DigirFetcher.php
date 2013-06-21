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
 * DigirFetcher is Class for accessing DiGIR Fetchers
 *
 *
 * This is a generic Digir Fetcher object.  Actual Fetcher Objects inherit from
 * this and set specific properties to match the actual Provider it is to talk
 * to and also set some 'typical' test queries.
 * The inherited Fetchers should be placed in ~web/portal/SOURCE/Fetcher.php
 *
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */

class DigirFetcher extends Fetcher
{
	function DigirFetcher($backendType='',$webRoot='',$webDirName='',$debugOn='')
	{
		$this->{get_parent_class(__CLASS__)}($backendType,$webRoot,$webDirName,$debugOn);
	}

	var 	$serviceName = "DigirFetcher";

	/*  Describe Digir configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "Generic Digir Fetcher";
	var	$hostname = "localhost";
	var	$port = 80;
	var	$provider = "emuweb/webservices/digir.php";
	var	$resource = "emu";
	var 	$translatorType = 'Digir';
	var 	$queryableFields = Array(
			'darwin:Genus' => Array(2,""),
			'darwin:Species' => Array(3,""),
		);

	var 	$standardSchema = 'http://digir.sourceforge.net/schema/conceptual/darwin/full/2003/1.0/darwin2full.xsd';

	// use for testing when no external internet access to schemas
	var	$_simpleTestFields = "<structure>
			<xsd:element name='record'>
			  <xsd:complexType>
			   <xsd:sequence>
			    <xsd:element ref='darwin:Family'/>
			    <xsd:element ref='darwin:Genus'/>
			   </xsd:sequence>
			  </xsd:complexType>
			 </xsd:element>
			</structure>";

	function describe()
	{
		return 
			"A Digir Fetcher is a Fetcher that knows how to\n".
			"talk with Digir Data Providers.\n\n".  parent::describe();
	}

	function makeUrl()
	{
		$time = $this->timeStamp($unixTime);	
		$host = $this->hostname;
		$provider = $this->provider;
		$resource = $this->resource;

		$params = array();
		$search = "";
		if (isset($_REQUEST['structuredQuery']))
		{
			if (get_magic_quotes_gpc())
				$xml = stripslashes($_REQUEST['structuredQuery']);
			$search = $this->makeDigirSearchFromStructure($xml);
		}
		else if (isset($_REQUEST['search']))
		{
			$search = urldecode($_REQUEST['search']);
		}
		if ($search)
		{		
			$params['doc'] = 
				"<request xmlns=\"http://www.namespaceTBD.org/digir\"\n".
				"	xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"\n".
				"	xmlns:darwin=\"http://digir.net/schema/conceptual/darwin/2003/1.0\"\n".
				"	xmlns:dwc=\"http://digir.net/schema/conceptual/darwin/2003/1.0\">\n".
				"	<header>\n".
				"		<version>1.0.0</version>\n".
				"		<sendTime>$time</sendTime>\n".
				"		<source>$host</source>\n".
				"		<destination resource=\"$resource\">http://$host/$provider</destination>\n".
				"		<type>search</type>\n".
				"	</header>\n".
				"	<search> $search </search>\n".
				"	</request>";
				
		}
		return array('/'.$provider,$this->hostname,$this->port,null,$params);
	}

	function setWantedGroups()
	{
		if (! $this->_translator->potentialGroups)
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
	}
	
	function makeDigirSearchFromStructure($serialisedQuery)
	{
		$sql = new StructuredQuery();
		List($select,$source,$stack,$limits) = $sql->deSerialiseSqlStructure($serialisedQuery);

		$filter = "";
		foreach ($stack as $item)
		{
			if (preg_match("/^\*\* (\S+) \*\*$/",$item,$match))
			{
				$field = $match[1];
				$filter = "<$field>\n$filter\n</$field>";
			}
			else if (preg_match("/(\S+)\s+(\S+)\s+(\S.*)/",$item,$match))
			{
				$field = $match[1];
				$field = "darwin:$field";
				$compareOp = $sql->symbolToOperator($match[2]);

				if (strtoupper($compareOp) == 'CONTAINS')
					$compareOp = 'LIKE';
				$value = $match[3];
				$filter .= "<$compareOp>\n<$field>$value</$field>\n</$compareOp>";
			}
		}

		$request = "<filter>\n$filter\n</filter>\n<records limit=\"" .
				$limits[to] .  "\" start=\"". $limits[from] ."\">\n".
			"<structure schemaLocation=\"$this->standardSchema\"/>\n".
			"</records>\n";
		return $request;
	}


	function test($serviceSpecific=false,$dir='')
	{
		if (isset($_REQUEST['testCall']))
		{
			header("Content-type: text/xml",1);
			print $this->requestAndProcess($_REQUEST['timeout']);
		}
		else	
		{
			header("Content-type: text/html",1);
			$this->makeTestPage('','Digir Fetcher Test','','','','');
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

				document.getElementById('message').innerHTML = search.replace(/</g,'&lt;');

				document.forms[0].search.value = search;
				document.forms[0].emudebug.value = '';

				if (document.forms[0].display[0].checked == true)
				{
					alert("<search>\\n"+ search.replace(/></g,">\\n<") +"\\n</search>");
					return;
				}
				else if (document.forms[0].display[2].checked == true)
					document.forms[0].emudebug.value = 'emudebug';
				document.forms[0].submit();
			}
JAVASCRIPT;

		$args['Query Terms'] = $terms;
		$args['Start'] = "<input type='input' name='start' value='0'  size='2'/>";
		$args['Limit'] = "<input type='input' name='limit' value='5'  size='2'/>";
		$args['Timeout'] = "<input type='input' name='timeout' value='18'  size='2'/>";
		$args['Record Schema'] = "<input type='input' name='schema' value='$schema'  size='60'/>";
		$args['Action'] = "<input type='radio' name='display' value='request' checked='1'/>Show Request<br/>".
			"<input type='radio' name='display' value='act'/>Get Data<br/>".
			"<input type='radio' name='display' value='texql'/>Provider Debug Response";
		$submission = "<input type='button' name='action' value='query' onClick='makeRequest();' />";
		$vars ['search'] = '';
		$vars ['emudebug'] = '';

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

	if (basename($serviceFile) == "DigirFetcher.php")
	{
		$webObject = new DigirFetcher();
		$webObject->test();
	}
}

?>

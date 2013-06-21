<?php

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */




if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/portal/Fetcher.php');
require_once ($WEB_ROOT . '/webservices/lib/StructuredQuery.php');

/**
 *
 * TexxmlFetcher is Class for accessing DiGIR Fetchers
 *
 *
 * This is a generic Texxml Fetcher object.  Actual Fetcher Objects inherit from
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

class TexxmlFetcher extends Fetcher
{

	var 	$serviceName = "TexxmlFetcher";

	/*  Describe Texxml configuration parameters
	 *  of the source
	*/
	var 	$sourceName = "Generic Texxml Fetcher";
	var	$hostname = "localhost";
	var	$provider = "/texxmlserver/post";
	var	$resource = "emu";
	var 	$translatorType = 'texxml';
	var 	$queryableFields = Array(
			'irn'         => Array(1,"1"),
			'SummaryData' => Array(2,""),
		);

	// these provided as guide - override in children
	var $exampleQueryTerms = Array(
			"Genus" => "Aus",
			"Species" => "bus",
	);

	var	$cacheIsOn = false;

	var	$_hardWiredRestrictions = array();
	var	$_directTranslations = array();

	function TexxmlFetcher($backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		global $XML_SERVER_PORT;

		$this->{get_parent_class(__CLASS__)}($backendType,$webRoot,$webDirName,$debugOn);
		$this->port = $XML_SERVER_PORT;
	}

	function addAHardWiredRestriction($texqlFilter)
	{
		$this->_hardWiredRestrictions[] = $texqlFilter;
	}

	function setDirectTranslation($from,$to)
	{
		$this->_directTranslations[$from] = $to;
	}

	function describe()
	{
		return 
			"A Texxml Fetcher is a Fetcher that knows how to\n".
			"talk with Texpress TexXML Data Providers.\n\n".  parent::describe();
	}

	function makeIndex()
	{
		# because we are potentially adding a hard wired query term to
		# texql that is not mentioned in the request, the caching key
		# needs to add any hardwired bits otherwise potential for
		# different fetchers to have same key

		$index = parent::makeIndex();
		if (count($this->_hardWiredRestrictions) > 0)
		{
			$index .= ":" . implode (",",$this->_hardWiredRestrictions);
		}
		return $index;
	}

	function simplifyEMuSelectAll($texql)
	{
		// translate SELECT ALL into SELECT f1,f2,f3,...
		// where f1,f2,f3 etc are the list of EMu fields
		// 'known' by the client specific texxml translator instance
		// (see TranslatorFactory translations property)
		if (preg_match("/SELECT\s+ALL\s+FROM\s+(\S+)/",$texql,$match))
		{
			$fieldList = $this->_translator->returnAllFields();
			$table = $match[1];
			$fieldListArray = preg_grep("/$table\./",preg_split("/\s*,\s*/",$fieldList));
			if ($fieldListArray)
				$fieldList = implode(",",$fieldListArray);
			$texql = preg_replace("/SELECT\s+ALL\s+/","SELECT $fieldList ",$texql);
			// some texapi versions had memory issues when doing
			// queries with multiple table specifiers in the select
			// clause.  Assume all our queries will be from one
			// table and strip table specifiers to avoid problem.
			$texql = preg_replace("/$table\./","",$texql);
		}
		$texql = preg_replace("/\s*&\s*/","",$texql);
		return $texql;
	}

	function addHardwiredFilters($texql)
	{
		if (count($this->_hardWiredRestrictions) == 0)
			return $texql;

		$extraFields = "(" . implode(" AND ",$this->_hardWiredRestrictions) . ")";
		
		$texql = preg_replace("/ FROM (e\S+) WHERE /"," FROM $1 WHERE $extraFields AND ",$texql);
		return $texql;
	}

	function makeUrl()
	{
		// if passed texql parameter, ignore the search parameter and
		// use the texql one.  This enables both darwin core and texql
		// requests to coexist but be ignored by appropriate fetcher
		// flavour
		if (isset($_REQUEST[structuredQuery]))
		{
			$queryXml = $_REQUEST['structuredQuery'];
			if (get_magic_quotes_gpc())
				$queryXml = stripslashes($queryXml);

			$sql = new StructuredQuery();
			list ($select,$from,$where,$limits) = $sql->deSerialiseSqlStructure($queryXml);
			// generate SELECT
			$wanted = Array();
			foreach ($select as $field)
			{
				if (($field == '*') || ($field == 'ALL'))
				{
					$wanted[] = 'ALL';
				}
				else if (isset($this->_knownConcepts[$field]))
				{
					$wanted[] = $this->_knownConcepts[$field][0];
				}
				else
				{
					$wanted[] = $field;
				}
			}

			// get field types
			$fieldType = Array();
			foreach ($from as $table)
			{
				foreach ($sql->getFilterFields($where) as $field)
				{
					if (isset($this->_knownConcepts[$field]))
					{
						$fieldName = $this->_knownConcepts[$field][0];
						$type = $this->_knownConcepts[$field][2];
						$fieldType[$fieldName] = $type;
						$fieldType[$field] = $type;
					}
					else
					{
						$fieldType[$field] = "string";
					}
				}
			}
			

			$translations = Array();
			foreach ($this->_knownConcepts as $concept => $map)
			{
				$translations[$concept] = $map[0];
			}	
			// generate WHERE using field types and "where stack"
			$whereClause = $sql->_postfixWhereToInfix($where,$fieldType,$translations);
			// modify syntax if necessary for searches
			// within nested table
			$whereClause = $this->texqlSyntaxPolish($whereClause,$translations);
			$texql = "(SELECT " . 
				implode(",",$wanted) .
				" FROM " .
				implode(",",$from) .
				" WHERE $whereClause" .
				") { $limits[from] to $limits[to] }";

		}
		else if (isset($_REQUEST[search]))
		{
			$texql = $_REQUEST[search];
			if (get_magic_quotes_gpc())
				$texql = stripslashes($texql);
		}
		else
		{
			$texql = $_REQUEST[texql];
			if (get_magic_quotes_gpc())
				$texql = stripslashes($texql);
		}
		
		$texql = $this->simplifyEMuSelectAll($texql);
		$texql = $this->addHardwiredFilters($texql);
		$this->_log("generated texql=$texql");
		//$this->_debug($texql,$texql,1);
		$params[texql] = $texql;
		return array($this->provider,$this->hostname,$this->port,null,$params);
	}

	function texqlSyntaxPolish($whereClause)
	{
		// need to translate stuff like:
		// 	QuiTaxonomyStatus_tab[QuiTaxonomyStatus] contains 'Vulnerable and Threatened'
		//      and
		//	QuiDepth_tab[QuiDepth] = 123
		//      and
		//	HorFlowerColour_tab[HorFlowerColour] contains 'Yellow'
		// into
		// 	exists (QuiTaxonomyStatus_tab where QuiTaxonomyStatus contains 'Vulnerable and Threatened')
		//      and
		//	exists (QuiDepth_tab where QuiDepth = 123)
		//      and
		//	exists (HorFlowerColour_tab where HorFlowerColour contains 'Yellow')


		while (preg_match("/\b(\S+?)\[(.+?)\]\s+(\S+\s+'.*?')/",$whereClause,$matches))
		{
			$match = preg_quote($matches[0],"/");
			$whereClause = preg_replace("/$match/","exists ( $matches[1] where $matches[2] $matches[3] )",$whereClause);
		}

		foreach ($this->_directTranslations as $from => $to)
		{
			$match = preg_quote($from,"/");
			$whereClause = preg_replace("/$from/",$to,$whereClause);
		}
		return $whereClause;
	}

	function setWantedGroups()
	{
		$this->_translator->addPotentialGroups( array());
	}

	function testQueryTerms()
	{
		// builds some test 'example' queries
		$terms = Array();
		$i = 0;
		foreach ($this->exampleQueryTerms as $field => $value)
		{
			$terms[] = "$field: <input value='$value' field='$field' id='qry_field:${field}_$i' type='text'>";
			$i++;
		}
		return implode("<br/>OR<br/>\n",$terms);
	}

	function test($serviceSpecific=false,$dir='')
	{
		if (isset($_REQUEST['testCall']))
		{
			if (preg_match("/Texql/i",$_REQUEST['action']))
			{
				$_REQUEST['structuredQuery'] = null;
				if (get_magic_quotes_gpc())
					$_REQUEST['texql'] = stripslashes($_REQUEST['texql']);

			}
			else
			{
				$_REQUEST['texql'] = null;
				if (get_magic_quotes_gpc())
					$_REQUEST['structuredQuery'] = stripslashes($_REQUEST['structuredQuery']);
			}
			header("Content-type: text/xml",1);
			print $this->requestAndProcess($_REQUEST['timeout']);
		}
		else	
		{
			header("Content-type: text/html",1);
			$this->makeTestPage('','Texxml Fetcher Test','','','','');
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

		$describe = $this->describe();

		$xml = "SELECT ALL\nFROM ecatalogue\nWHERE irn = 1";
		$structuredQuery = 
				"<query>\n".
				"  <select><field>*</field></select>\n".
				"  <sources><source>ecatalogue</source></sources>\n".
				"  <postfixFilterStack>\n".
				"    <stackItem level='0'>\n".
				"      <comparison type='equals'>\n".
				"        <field>SummaryData</field><value>Potamopyrgus</value>\n".
				"      </comparison>\n".
				"    </stackItem>\n".
				"  </postfixFilterStack>\n".
				"  <limits from='0' to='50' />\n".
				"</query>";

		$args['Texql'] = "<textarea name='texql' cols='20' rows='20'>$xml</textarea><br/>".
				"<input type='submit' name='action' value='Use Texql Query'/>";
		$args['StructuredQuery'] = "<textarea name='structuredQuery' cols='60' rows='20'>$structuredQuery</textarea><br/>" .
				"<input type='submit' name='action' value='Use Structured Query'/>";

		$instanceToCall = preg_replace("/^.*\//",'./',$_SERVER['PHP_SELF']);

		$page = $this->makeDiagnosticPage(
					$title,
					$description,
					"",
					$instanceToCall,
					$args,
					"",
					$vars,
					$this->describe()
				);
		print $page;		

	}
}


if (isset($_REQUEST['test']))
{
	$serviceFile = basename($_SERVER['PHP_SELF']);

	if (basename($serviceFile) == "TexxmlFetcher.php")
	{
		$webObject = new TexxmlFetcher();
		$webObject->test();
	}
}

?>

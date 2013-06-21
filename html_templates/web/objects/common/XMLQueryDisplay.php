<?php

/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*
*	XMLQueryDisplay acts as a wrapper around texxmlserver.
*	Takes a query and outputs the results as XML
*	Allows control over what fields are displayed and can be queried upon.
*	This object should be placed in a PHP page and configured accordingly.
*	See web/webservices/tableaccessexample.php for an example of its use.
*
*	A user (remote application) would query by using a url like:
*	   http://server/interface.php?NamFirst=John&NamLast=Smith
*
*	They can view a list of valid fields that can be used to construct a query with:
*	   http://server/interface.php?listqueryfields=show
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'texquery.php');
require_once ($LIB_DIR . 'querybuilder.php');

class
XMLQueryDisplay
{
	var $InternetOnly		= 1;
	var $AllowFullWhereQuery	= 1;
	var $Database			= "ecatalogue";
	var $ReturnLimit		= 100;
	var $Restriction		= "";  // eg.  "CatDepartment = 'Archeology'"

	// Fields to display in results
	var $SelectFields		= "all"; // a comma separated list like texql

	// Fields user may query upon GET/POST via form variables
	var $QueryTextFields		= array("AdmWebMetaData");
	var $QueryDateFields		= array();
	var $QueryIntegerFields		= array();
	var $QueryLatLongFields		= array();


	function
	Show()
	{
		global $ALL_REQUEST;
		
		/*
		*   If "listqueryfields" then print them out and exit.
		*/
		if (isset($ALL_REQUEST["listqueryfields"])
		{
			$this->_showValidQueryFields();
			return;
		}

		/*
		*   If full where clause then do query if allowed
		*/
		$where = "";
		if (isset($ALL_REQUEST["where"]) 
				&& $this->AllowFullWhereQuery))
		{
			$where = $ALL_REQUEST["where"];
		}
		else 
		{
			$queryarray = array();
			foreach ($this->QueryTextFields as $f)
			{
				if (isset($ALL_REQUEST[$f]))
				{
					$i = new QueryItem;
					$i->ColName = $f;
					$i->ColType = 'text';
					$i->QueryTerm = $ALL_REQUEST[$f];
					array_push($queryarray, $i);
				}
			}
			foreach ($this->QueryDateFields as $f)
			{
				if (isset($ALL_REQUEST[$f]))
				{
					$i = new QueryItem;
					$i->ColName = $f;
					$i->ColType = 'date';
					$i->QueryTerm = $ALL_REQUEST[$f];
					array_push($queryarray, $i);
				}
			}
			foreach ($this->QueryIntegerFields as $f)
			{
				if (isset($ALL_REQUEST[$f]))
				{
					$i = new QueryItem;
					$i->ColName = $f;
					$i->ColType = 'integer';
					$i->QueryTerm = $ALL_REQUEST[$f];
					array_push($queryarray, $i);
				}
			}
			$qb = new StandardQueryBuilder;
			$qb->QueryItems = $queryarray;
			$where = $qb->Generate();
		}

		if ($where == "")
			$where = "true ";

		if ($this->InternetOnly)
		{
			$where .= " AND AdmPublishWebNoPassword contains '";
			$where .= GetLutsEntry("system yes");
			$where .= "'";
		}

		if ($this->Restriction != "")
		{
			$where .= " AND " . $this->Restriction;
		}

		$texql = "SELECT " . $this->SelectFields;
		$texql .= " FROM " . $this->Database;
		$texql .= " WHERE " . $where;

		$offset = 1;
		$limit	= $this->ReturnLimit;
		if (isset($ALL_REQUEST["offset"]) 
				&& is_numeric($ALL_REQUEST["offset"]))
		{
			$offset = $ALL_REQUEST["offset"];
		}
		if (isset($ALL_REQUEST["limit"]) 
				&& is_numeric($ALL_REQUEST["limit"]))
		{
			$limit = $ALL_REQUEST["limit"];
			if($limit > $this->ReturnLimit)
			{
				$limit = $this->ReturnLimit;
			}
		}

		$texql = "($texql){ $offset to " . ($offset + $limit) . "}";

		$query = new Query;
		$query->PrintXML($texql);
		
	}

	function
	_showValidQueryFields()
	{
		Header("Content-type: text/xml");
		print "<?xml version=\"1.0\" ?>\n";
		print "<validfields>\n";
		foreach ($this->QueryTextFields as $f)
		{
			print "<field type=\"text\">$f</field>\n";
		}
		foreach ($this->QueryDateFields as $f)
		{
			print "<field type=\"date\">$f</field>\n";
		}
		foreach ($this->QueryIntegerFields as $f)
		{
			print "<field type=\"integer\">$f</field>\n";
		}
		print "</validfields>\n";
	}
}

/* test code */
/*
$xmldisplay = new XMLQueryDisplay;
$xmldisplay->Database 		= "eparties";
$xmldisplay->QueryTextFields 	= array("SummaryData");
$xmldisplay->QueryDateFields 	= array();
$xmldisplay->Show();
*/

?>

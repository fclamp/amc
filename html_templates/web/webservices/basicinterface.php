<?php

/*
** Copyright (c) 2002 - KE Software Pty. Ltd.
**
** This page provides a basic, semi-configurable XML WebServices 
** interface to the EMu Catalogue.
** 
** example: http://server/web/webservices/basicinterface.php?queryterm=fish
**
** Optional CGI arguments are:
**	interface=<name of interface definition>
**	limit=<maximum number of records>
**	offset=<begin listing a [offet] record>
**	password=<interface's password>
**
** Interfaces are defined in the CONFIG.php file in a global
** variable called $WEBSERVICES_BASIC_INTERFACE.  Format is as follows:
**
**        <interface name="default">
**                <Password></Password>
**                <QueryColumns>AdmWebMetadata,SummaryData</QueryColumns>
**                <Database>ecatalogue</Database>
**                <CatagoryColumn>TitObjectType</CatagoryColumn>
**                <ExtraReturnColumns></ExtraReturnColumns>
**                <MaximumRetrievalLimit>100</MaximumRetrievalLimit>
**        </interface>
**        <interface name="notes">
**                <Password>mypassword</Password>
**                <QueryColumns>NotNotes</QueryColumns>
**                <Database>ecatalogue</Database>
**                <ExtraReturnColumns>NotNotes</ExtraReturnColumns>
**                <MaximumRetrievalLimit>100</MaximumRetrievalLimit>
**        </interface>
**
** The "default" service is called if no interface is specified in the
** request.
**
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(realpath(__FILE__)));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'texquery.php');
require_once ($LIB_DIR . 'querybuilder.php');
require_once ($LIB_DIR . 'common.php');


$WEBSERVICE_NAME		= "basicquery";
$DEFAULT_RETRIEVAL_LIMIT	= 100;
$DEFAULT_DATABASE 		= "ecatalogue";
$DEFAULT_QUERY_COLUMNS 		= array("AdmWebMetadata", "SummaryData");

main();
// end




/*
*************************************************
** Functions and Classes
*************************************************
*/

function
main()
{
	global $ALL_REQUEST;
	/*
	** retreive interface definitions
	*/
	$interfaces = ParseInterfaceDefinitions($GLOBALS['WEBSERVICES_BASIC_INTERFACE']);
	if (isset($ALL_REQUEST['interface']))
	{
		if (isset($interfaces[$ALL_REQUEST['interface']]))
		{
			$interface = $interfaces[$ALL_REQUEST['interface']];
		}
		else
		{
			InvalidRequest();
		}
	}
	else
	{
		$interface = $interfaces["default"];
	}

	/*
	** Validate Arguments
	*/
	if (!isset($ALL_REQUEST['queryterms']) 
		|| $ALL_REQUEST['queryterms'] == '')
	{
		InvalidRequest();
	}

	/*
	** Security Checks
	*/
	if (!$GLOBALS['ENABLE_WEBSERVICES'])
	{
		AccessDenied();
	}
	elseif ($interface->password != ""
		&& $interface->password != $ALL_REQUEST['password'])
	{
		AccessDenied();
	}

	// columns to return in xml summary
	$selectCols = array("SummaryData", "irn_1", "MulMultiMediaRef:1");
	if ($interface->nameCol != "")
	{
		$selectCols = array_merge($selectCols, 
					array($interface->nameCol));
	}
	if ($interface->catagoryCol != "")
	{
		$selectCols = array_merge($selectCols, 
					array($interface->catagoryCol));
	}
	if ($interface->descriptionCol != "")
	{
		$selectCols = array_merge($selectCols, 
					array($interface->descriptionCol));
	}
	$selectCols = array_merge($selectCols, $interface->extraReturnCols);

	$selectCols = array_unique($selectCols);

	// columns for limit and offset
	$limit = $GLOBALS['DEFAULT_RETRIEVAL_LIMIT'];
	if (is_numeric($ALL_REQUEST['limit']))
		$limit = $ALL_REQUEST['limit'];
	if ($limit > $interface->maximumRetrievalLimit)
		$limit = $interface->maximumRetrievalLimit;

	$offset = 0;
	if (is_numeric($ALL_REQUEST['offset']))
		$offset = $ALL_REQUEST['offset'];

	$database = $GLOBALS['DEFAULT_DATABASE'];
	if ($inteface->database != "")
		$database = $interface->database;

	/*
	** Perform the query
	*/

	$query = new Query();
	$query->Select = $selectCols;
	$query->From = $database;
	$query->Where = BuildWhereStatement($interface->queryCols, $ALL_REQUEST['queryterms']);
	$query->Limit = $limit;
	$query->Offset = $offset;

	$results	= $query->Fetch();
	$status		= $query->Status;
	$matches	= "";
	$error		= "";
	if ($query->Matches > 0)
		$matches = ' matches="' . $query->Matches . '"';
	if ($query->Error != "")
		$error = ' error="' . $query->Error . '"';

	/*
	** Output XML Results
	*/
	header("Content-type: text/xml");

	print "<?xml version=\"1.0\" ?>\n";
	print "<results status=\"$status\"$matches$error>\n";

	// Set displaypage to default if not defined in interface
	if ($interface->displayPage != "")
	{
		$displaypage = $interface->displayPage;
	}
	else
	{
		$displaypage = 'http://' 
			. $GLOBALS['HTTP_SERVER_VARS']['SERVER_NAME'] 
			. $GLOBALS['DEFAULT_DISPLAY_PAGE'];
	}
	$imagepage = 'http://' 
		. $GLOBALS['HTTP_SERVER_VARS']['SERVER_NAME'] 
		. $GLOBALS['MEDIA_URL'];

	foreach ($results as $rec)
	{
		print "<record>\n";

		// Print out Summary and link to record
		$data = EncodeXmlSpecialChars($rec->{"SummaryData"});
		print "\t<Summary>$data</Summary>\n";

		$refirn = $rec->{"irn_1"};
		print "\t<RecordReference>$displaypage?irn=$refirn</RecordReference>\n";

		// Print others
		foreach ($selectCols as $fld)
		{
			$data = EncodeXmlSpecialChars($rec->{$fld});
			if ($fld == "MulMultiMediaRef:1")
			{
				$refirn = $rec->{$fld};
				if (!is_numeric($rec->{$fld}) )
					continue;
				print "\t<ImageReference>$imagepage?irn=$refirn</ImageReference>\n";
				print "\t<ThumbnailReference>$imagepage?irn=$refirn&amp;thumb=yes</ThumbnailReference>\n";
			}
			elseif ($fld == $interface->nameCol)
			{
				print "\t<Name>$data</Name>\n";
			}
			elseif ($fld == $interface->catagoryCol)
			{
				print "\t<Catagory>$data</Catagory>\n";
			}
			elseif ($fld == $interface->descriptionCol)
			{
				print "\t<Description>$data</Description>\n";
			}
			elseif ($fld == "SummaryData")
			{
				//ignore. already printed above outside loop
			}
			elseif ($fld == "irn_1")
			{
				//ignore. already printed above outside loop
			}
			else
			{
				//sub out invalid chars in colnames
				$fld = str_replace(":", "_", $fld);
				print "\t<$fld>$data</$fld>\n";
			}
		}
		print "</record>\n";
	}
	print "</results>\n";

}

function
AccessDenied()
{
	header("HTTP/1.0 403 Forbidden");
	header("Status: 403 Forbidden");
	exit;
}

function
InvalidRequest()
{
	header("HTTP/1.0 400 Bad request");
	header("Status: 400 Bad request");
	exit;
}

function
EncodeXmlSpecialChars($data)
{
	$find = array("&", ">", "<", "\"", "'");
	$replace = array("&amp;", "&gt;", "&lt;", "&quot;", "&apos;");
	return (str_replace($find, $replace, $data));
}

function
BuildWhereStatement($cols, $queryterms)
{
	$queryArray = array();
	foreach($cols as $col)
	{
		$qryItem = new QueryItem;
		$qryItem->ColName = $col;
		$qryItem->ColType = 'text';
		$qryItem->QueryTerm = $queryterms;
		array_push($queryArray, $qryItem);
	}
	$queryBuilder = new StandardQueryBuilder;
	$queryBuilder->Logic = 'OR';
	$queryBuilder->QueryItems = $queryArray;
	return($queryBuilder->Generate());
}


class
InterfaceDefinition
{
	var $password;
	var $queryCols;
	var $database;
	var $extraReturnCols;
	var $maximumRetrievalLimit;

	function
	InterfaceDefinition()
	{
		// defaults
		$this->password = "";
		$this->queryCols = $GLOBALS['DEFAULT_QUERY_COLUMNS'];
		$this->database = "ecatalogue";
		$this->extraReturnCols = array();
		$this->maximumRetrievalLimit = 100;
		$this->nameCol = "";
		$this->descriptionCol = "";
		$this->catagoryCol = "";
		$this->displayPage = "";
	}
}

function
ParseInterfaceDefinitions($definition)
{
	// Use quick and dirty regex parser for the simple format
	$interfaces = array();
	$count = preg_match_all("/<interface name=\"(.*?)\">(.*?)<\/interface>/s", $definition, $interdefs);
	if ($count > 0)
	{
		for ($i = 0; $i < $count; $i++)
		{
			$name = $interdefs[1][$i];
			$defs = $interdefs[2][$i];

			$interface = new InterfaceDefinition;

			if (preg_match("/<Password>(.*?)<\/Password>/",
				$defs, $matches))
			{
				$interface->password = $matches[1];
			}
			if (preg_match("/<DisplayPage>(.*?)<\/DisplayPage>/",
				$defs, $matches))
			{
				$interface->displayPage = $matches[1];
			}
			if (preg_match("/<QueryColumns>(.*?)<\/QueryColumns>/", 
				$defs, $matches))
			{
				$interface->queryCols = preg_split("/\s*,\s*/", $matches[1]);
			}
			if (preg_match("/<Database>(.*?)<\/Database>/"
				, $defs, $matches))
			{
				$interface->database = $matches[1];
			}
			if (preg_match("/<NameColumn>(.*?)<\/NameColumn>/"
				, $defs, $matches))
			{
				$interface->nameCol = $matches[1];
			}
			if (preg_match("/<CatagoryColumn>(.*?)<\/CatagoryColumn>/"
				, $defs, $matches))
			{
				$interface->catagoryCol = $matches[1];
			}
			if (preg_match("/<DescriptionColumn>(.*?)<\/DescriptionColumn>/"
				, $defs, $matches))
			{
				$interface->descriptionCol = $matches[1];
			}
			if (preg_match("/<ExtraReturnColumns>(.*?)<\/ExtraReturnColumns>/", 
				$defs, $matches))
			{
				if ($matches[1] == "")
					$interface->extraReturnCols = array();
				else
					$interface->extraReturnCols = preg_split("/\s*,\s*/", $matches[1]);
			}
			if (preg_match("/<MaximumRetrievalLimit>(.*?)<\/MaximumRetrievalLimit>/", 
				$defs, $matches))
			{
				$interface->maximumRetrievalLimit = $matches[1];
			}
			$interfaces[$name] = $interface;
		}
	}
	if (count($interfaces) < 1)
		WebDie('No Intfaces are defined in CONFIG.php.  Please see CONFIG.sample.php');

	return $interfaces;
}
	


?>

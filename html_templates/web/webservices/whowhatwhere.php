<?php

/*
** Copyright (c) 2003 - KE Software Pty. Ltd.
**
** Provide a Who/What/Where query interface.  Designed for KE Web Portal.
** 	See Chris Dance/Alex Fell for details.
** 
** example: http://server/web/webservices/whowhatwhere.php?who=jones&what=creatoaintingr
**
** Optional CGI arguments are:
**	interface=<name of interface definition>
**	limit=<maximum number of records>
**	offset=<begin listing a [offet] record>
**	password=<interface's password>
**
** Interfaces are defined in the CONFIG.php file in a global
** variable called $WEBSERVICES_DUBLIN_CORE_INTERFACE.  Format is as follows:
**
**	$WEBSERVICES_WHO_WHAT_INTERFACE = 
**	'<interface name="default">
**		<Database>ecatalogue</Database>
**		<NameColumn>TitMainTitle</NameColumn>
**		<DescriptionColumn>SummaryData</DescriptionColumn>
**		<FieldMapping>
**			<What>
**				<Col type="text">TitMainTitle</Col>
**			</What>
**			<Who>
**				<Col type="text">CreCreatorRef_tab-&gt;eparties-&gt;SummaryData</Col>
**			</Who>
**		</FieldMapping>
**	</interface>';
**
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


$WEBSERVICE_NAME		= "whowhatwherequery";
$WEBSERVICE_VERSION		= "1.0";
$DEFAULT_RETRIEVAL_LIMIT	= 100;
$DEFAULT_DATABASE 		= "ecatalogue";
$DENY_NULL_QUERY		= 1;

// Valid Interface Fields
$WHO_WHAT_FIELDS = array(	'who', 
				'what', 
				'where', 
				'when',
				'all'		// for convenience
				);


/*
** Call main function
*/
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
	$interfaces = ParseInterfaceDefinitions($GLOBALS['WEBSERVICES_WHO_WHAT_INTERFACE']);
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
	$where = BuildWhereStatement($interface->mapping);
	$query = new Query();
	$query->Select = $selectCols;
	$query->From = $database;
	$query->Where = BuildWhereStatement($interface->mapping);
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


/*
*  Parse the request arguments and construct a texql where statement using mapping.
*/
function
BuildWhereStatement($mapping)
{
	// only look for fields defined in $WHO_WHAT_FIELDS
	global $WHO_WHAT_FIELDS;
	global $ALL_REQUEST;
	global $DENY_NULL_QUERY;

	$hasterm = 0;

	$queryArray = array();
	foreach($WHO_WHAT_FIELDS as $f)
	{
		$fname = strtolower($f);
		if (isset($ALL_REQUEST[$fname]) 
				&& $ALL_REQUEST[$fname] != ""
				&& isset($mapping{$fname}))
		{
			if (! is_array($mapping{$fname}))
				WebDie('Invalid Interface Schema');

			$hasterm++;
			foreach ($mapping{$fname} as $c)
			{
				$qryItem = new QueryItem;
				$qryItem->ColName = $c->Name;
				$qryItem->ColType = $c->Type;
				$qryItem->QueryTerm = $ALL_REQUEST[$fname];
				array_push($queryArray, $qryItem);
			}
		}
	}
	$queryBuilder = new StandardQueryBuilder;
	$queryBuilder->Logic = 'AND';
	$queryBuilder->QueryItems = $queryArray;
	
	$r = $queryBuilder->Generate();

	if ($DENY_NULL_QUERY && $hasterm == 0)
		InvalidRequest();
		
	return($r);
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
DecodeXmlSpecialChars($data)
{
	$find = array("&amp;", "&gt;", "&lt;", "&quot;", "&apos;");
	$replace = array("&", ">", "<", "\"", "'");
	return (str_replace($find, $replace, $data));
}



class
InterfaceDefinition
{
	var $password;
	var $database;
	var $mapping;
	var $maximumRetrievalLimit;

	function
	InterfaceDefinition()
	{
		// defaults
		$this->mapping = array();
		$this->database = "ecatalogue";
		$this->extraReturnCols = array();
		$this->maximumRetrievalLimit = 100;
		$this->nameCol = "";
		$this->catagoryCol = "";
		$this->descriptionCol = "";
		$this->displayPage = "";
	}
}

class
MappingColumn
{
	var $Name;
	var $Type = "text";
}


function
ParseCol($coldef)
{

	$c = new MappingColumn;
	$r = array();

	$matches 	= array();
	$count = preg_match_all("/<Col type=\"(.*?)\">(.*?)<\/Col>/is", $coldef, $matches);

	for ($i = 0; $i < $count; $i++)
	{
		$c->Type = $matches[1][$i];
		$c->Name = DecodeXmlSpecialChars($matches[2][$i]);
		array_push($r, $c);
	}
	return($r);
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

			/*
			** We add a default for the all fields mapping (AdmWebMetadata)
			*/
			$colmd = new MappingColumn;
			$colmd->Name = 'AdmWebMetadata';
			$colmd->Type = 'text';

			$colsd = new MappingColumn;
			$colsd->Name = 'SummaryData';
			$colsd->Type = 'text';

			$interface->mapping{"all"} = array($colmd, $colsd);

			/*
			** Now parse the mapping structure
			*/
			if (preg_match("/<FieldMapping>(.*?)<\/FieldMapping>/s", 
				$defs, $matches))
			{
				$s = $matches[1];

				if (preg_match("/<Who>(.*?)<\/Who>/si", $s, $matches))
					$interface->mapping{"who"} = ParseCol($matches[1]);

				if (preg_match("/<What>(.*?)<\/What>/si", $s, $matches))
					$interface->mapping{"what"} = ParseCol($matches[1]);

				if (preg_match("/<Where>(.*?)<\/Where>/is", $s, $matches))
					$interface->mapping{"where"} = ParseCol($matches[1]);

				if (preg_match("/<When>(.*?)<\/When>/is", $s, $matches))
					$interface->mapping{"when"} = ParseCol($matches[1]);

				if (preg_match("/<All>(.*?)<\/All>/is", $s, $matches))
					$interface->mapping{"all"} = ParseCol($matches[1]);
			}

			$interfaces[$name] = $interface;
		}
	}
	if (count($interfaces) < 1)
		WebDie('No Intfaces are defined in CONFIG.php.  Please see CONFIG.sample.php');

	return $interfaces;
}



?>





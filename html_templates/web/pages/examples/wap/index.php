<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*
* A very simple WAP interface for locating an object in a museum.
* Just type in the object's catalogue number or title and the WAP Phone
* will return the object's current location (Location SummaryData).
*
* This PHP page is intended a proof of concept only.  Please see 
* Chris Dance if you want more details.
*
*/
require_once("../../../objects/lib/configuredquery.php");

// CONFIGURATION
$CATALOGUE_NUMBER_FIELD = "TitAccessionNo";



// Set WAP Headers
header("Content-type: text/vnd.wap.wml");
// expires in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");              
// Last modified, right now
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");   
// Prevent caching
header("Cache-Control: no-cache, must-revalidate");              
header("Pragma: no-cache");                                

print "<?xml version=\"1.0\"?>";

?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">
<wml>
<!-- EMu WAP -->
<?php

// Start WAP Card content

$cmd = $_REQUEST['cmd'];
if (empty($cmd))
	$cmd = "Query";

switch($cmd)
{
    case "Query";
	QueryCard();
    case "Show";
    	ShowLocationCard();
}

?>
</wml>
<?php



/******************************************************************************
*/

function
QueryCard()
{

	print "<card id=\"Query\">\n";
	print "<do type=\"accept\" label=\"Go\">\n";
	print "<go href=\"?cmd=Show&amp;query=\$searchtext\">\n";
	print "</go>\n";
	print "</do>\n";

	print "<p>\n";
	print "<b>EMu Location Query</b><br/>Find location of cat no:\n";
	print "<input name=\"searchtext\" title=\"Search\" type=\"text\"";
	print "  format=\"10m\"/>";
	print "</p>\n";
	print "</card>\n";
}


function
ShowLocationCard()
{
	print "<card>\n";

	$queryterm = $_REQUEST['query'];
	$catNumberField = $GLOBALS['CATALOGUE_NUMBER_FIELD'];
	$query = new ConfiguredQuery;
	$query->Intranet = 1;
	$query->Select = array("LocCurrentLocationRef->elocations->SummaryData");
	$query->From = "ecatalogue";
	$query->Where = "SummaryData contains '$queryterm' OR " .
			"$catNumberField contains '$queryterm'";
	
	$results = $query->Fetch();

	$location = $results[0]->{"LocCurrentLocationRef->elocations->SummaryData"};

	print "<p>\n";
	if (count($results) < 1 || $location == "")
	{
		print "Unknown Object.<br />\n";
	}
	else
	{
		print "<b>The current location of $queryterm is: </b><br />\n";
		print "$location <br />\n";
	}

	print "<do type=\"accept\" label=\"Back\"> <go href=\"?cmd=Query\"/> </do>";
	print "</p></card>\n";
    
}

?>

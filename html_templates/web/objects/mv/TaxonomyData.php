<?php 

/****************************************** 
 * Copyright (c) 1998-2009 KE Software Pty Ltd
 *
 * Returns xml data from $sourceDatabase
 * with matching values in $linkingField
 * values passed as a 'irn list'
 * via cgi parameter eg 
 * 	irns=123[,456]*
 ******************************************/

/*  
 $Revision: 1.2 $
 $Date: 2009/01/28 22:03:55 $
 */

/********* Change these values to Change Behaviour *********************/
$sourceDatabase = 'ecatalogue';
$linkingField = 'TaxTaxonomyRef';
$clientName = 'sam';
$emuWebName = 'emuwebsam';
$irnTag = 'QUERY_TERM_IRN';

// What fields to return
// ensure all wanted fields have alias start with lowercase letter
$fieldList = array (
	'irn_1',
	'SummaryData as summary',
	'ClaGenusLocal as genus',
	'ClaSpeciesLocal as species',
	'IdeScientificNameLocal_tab as name',
	'MapLatitudeLocal0 as "latitude"',
	'MapLatitudeLocal0 as "longitude"',
	'IdeFiledAsRef as "taxonomy_irn"',
);

// link to detail pages
$link1 = "<a href='/$emuWebName/pages/$clientName/Display.php?irn=";
/***********************************************************************/

require_once ('../../objects/lib/xmlparser.php');
require_once ('../../objects/lib/serverconnection.php');


header("Content-type: text/xml"); 
print "<?xml version='1.0' encoding='ISO-8859-1' ?>";



// read required irns
$irn = $HTTP_POST_VARS['irns'];
if (! $irn)
	$irn = $HTTP_GET_VARS['irns'];

if ($irn)
{
	$where = "$linkingField = ";
	$irns = explode(',',$irn);
	$where .= implode($irns," or $linkingField = ");


	// make texql statement
	$texql = "SELECT " . implode($fieldList,',');
	$texql .= " FROM " . $sourceDatabase;
	$texql .= " WHERE EXISTS ( $linkingField" ."_tab WHERE " . $where .")";

	// Open connection to texxmlserver and run query
	$conn = new TexxmlserverConnection;
	$fd = $conn->Open();
	if (!$fd || $fd < 0)
	{
		WebDie('Cannot connect to the KE XML database server.', 'Query - _printRawXML()');
	}
	$get = "GET /?texql=" . urlencode($texql) . " HTTP/1.0\r\n\r\n";
	fputs($fd, $get);
	fflush($fd);
	
	
	print "\n<!-- $texql -->\n";
	
	// read returned results
	while (!feof($fd))
	{
		// trim off any headers
		$out = trim(fgets($fd, 4096));
		if ($out == '')
			break;
	}
	
	
	// send remainder of XML to output (after tweaking a bit)
	while (!feof($fd))
	{
		$dataline = trim(fgets($fd, 4096));
	
		// mung xml a bit
		$dataline = preg_replace('/\<\?xml.*?\>/s','',$dataline);
		$dataline = preg_replace('/(<irn_1>(.*?)<\/irn_1>)/s',
			"$1\n<link>$link1$2'>$2</a></link>",$dataline);
		$dataline = preg_replace('/<\/*[A-Z][A-Za-z0-9_]+>/s','',$dataline);
		print $dataline."\n";
	}
}
else
{
	print "<!-- error - no parameters to search on -->\n";
	print "</results>\n";
}

?>


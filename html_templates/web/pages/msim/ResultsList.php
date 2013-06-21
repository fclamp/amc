<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Search results</title>
</head>

<body bgcolor="#E0F5DF">
      <h3><font face="Tahoma" color="#013567">&nbsp;Search results...</font></h3>

<center>
<?php
require_once('../../objects/msim/ResultsLists.php');

/*
** This code test to see if the GeoLoc variable was set in the URL
**   If so, then we form a "Where" clause to pass to the object.
*/
if (isset($GLOBALS['GeoLoc']) && $GLOBALS['GeoLoc'] != '')
{
	$GLOBALS['Where'] = "WebGeographicLocation contains '" . $GLOBALS['GeoLoc'] . "'";
	$GLOBALS['QueryPage'] = 'Query.php';
}

$resultlist = new MsimStandardResultsList;
$resultlist->BodyColor = '#DFF5E0';
$resultlist->Width = '80%';
$resultlist->HighlightColor = '#EDFAEE';
$resultlist->HighlightTextColor = '#DDDDDD';
$resultlist->FontFace = 'Tahoma';
$resultlist->FontSize = '2';
$resultlist->TextColor = '#013567';
$resultlist->HeaderColor = '#013567';
$resultlist->BorderColor = '#013567';
$resultlist->HeaderTextColor = '#DFF5E0';
$resultlist->DisplayPage = 'LabelDisplay.php';
$resultlist->Title = " ";
$resultlist->Show();
?>
</center>

</body>

</html>


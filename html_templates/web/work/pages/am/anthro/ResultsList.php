<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search results</title>
</head>

<body bgcolor="#FFFFE8">
<center><font face="Tahoma" size=2 color="#336699"><u><b>Search Results</b></u></font></center>
<br>
<br>

<center>
<b><font size=2 face=Tahoma color="#336699">Narratives:</font></b>
<br>
<?php
require_once('../../../objects/am/ResultsLists.php');

$resultlist = new AmStandardResultsList;
$resultlist->NoResultsText = "<b>No Narratives Found!</b><br>";
$resultlist->LimitPerPage = 5;
$resultlist->BodyColor = '#FFFFE8';
$resultlist->Width = '80%';
$resultlist->HighlightColor = '#FFFFFF';
$resultlist->HighlightTextColor = '#DDDDDD';
$resultlist->FontFace = 'Tahoma';
$resultlist->FontSize = '2';
$resultlist->TextColor = '#336699';
$resultlist->HeaderColor = '#336699';
$resultlist->BorderColor = '#336699';
$resultlist->HeaderTextColor = '#FFFFE8';
$resultlist->Show();

?>
</center>

</body>

</html>


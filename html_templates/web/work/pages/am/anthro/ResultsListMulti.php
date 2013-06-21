<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search results</title>

</head>

<body bgcolor="#FFFFE8">
<center><font face="Tahoma" size=2 color="#336699"><b><u>Search Results</u></b></font></center>
<br>
<br>

<center>
<b><font size=2 face=Tahoma color="#336699">Narratives:</font></b>
<br>
<?php
require_once('../../../objects/am/anthro/ResultsLists.php');

$resultlist = new AmStandardResultsList;
$resultlist->NoResultsText = "<b><font size=2 face=Tahoma color=#336699>No Narratives Found!</font></b><br>";
$resultlist->ContactSheetPage = "ContactSheetNarrative.php";
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

<br>
<br>

<center>
<b><font size=2 face=Tahoma color="#336699">Objects:</font></b>
<br>
<?php
require_once('../../../objects/am/anthro/ResultsLists.php');

$resultlist = new AmObjectResultsList;
$resultlist->ContactSheetPage = "ContactSheetObject.php";
$resultlist->DisplayPage = "DisplayObject.php";
$resultlist->NoResultsText = "<b><font size=2 face=Tahoma color=#336699>No Objects Found!</font></b><br>";
$resultlist->LimitPerPage = 5;
$resultlist->Database = 'ecatalogue';
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


<br>
<br>

<center>
<b><font size=2 face=Tahoma color="#336699">Parties:</font></b>
<br>
<?php
require_once('../../../objects/am/anthro/ResultsLists.php');

$resultlist = new AmStandardResultsList;
$resultlist->ContactSheetPage = "ContactSheetParty.php";
$resultlist->DisplayPage = "DisplayParty.php";
$resultlist->NoResultsText = "<b><font size=2 face=Tahoma color=#336699>No Parties Found!</font></b><br>";
$resultlist->LimitPerPage = 5;
$resultlist->Database = 'eparties';
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


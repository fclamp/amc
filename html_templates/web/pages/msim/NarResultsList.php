<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Search results</title>
</head>

<body bgcolor="#E0F5DF">
      <h3><font face="Tahoma" color="#013567">&nbsp;Search results...</font></h3>

<center>
<?php
require_once('../../objects/common/NarrativeResultsLists.php');

$resultlist = new NarrativeResultsList;
$resultlist->ContactSheetPage = 'NarContactSheet.php';
$resultlist->DisplayPage = 'NarDisplay.php';
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
$resultlist->Title = " ";
$resultlist->Show();
?>
</center>

</body>

</html>


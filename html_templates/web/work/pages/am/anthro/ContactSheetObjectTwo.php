<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search results</title>
</head>

<body bgcolor="#FFFFE8">

	<center>
      <font face="Tahoma" size=2 color="#336699"><b><u>Search Results</u></b></font>
	<center>



      <br>
      <br>
      <center>
      <b><font face="Tahoma" size=2 color="#336699">Objects:</font></b>
      <br>
      </center>

<center>
<?php
require_once('../../../objects/am/anthro/ResultsLists.php');

$resultlist = new AmObjectContactSheet;
$resultlist->ResultsListPage = "ResultsListObject.php"; 
$resultlist->DisplayPage = "DisplayObject.php";
$resultlist->Database = 'ecatalogue';
$resultlist->BodyColor = '#FFFFE8';
$resultlist->Width = '80%';
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
<br><br>

</body>

</html>


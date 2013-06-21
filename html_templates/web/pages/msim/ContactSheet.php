<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search results</title>
</head>

<body bgcolor="#FFFFFF">
<img align=left border="0" src="images/column.jpg" width="84" height="120">
      <h3><font face="Tahoma" color="#013567">&nbsp;Search results...</font></h3>

<center>
<?php
require_once('../../objects/msim/ResultsLists.php');

$resultlist = new MsimContactSheet;
$resultlist->BodyColor = '#DFF5E0';
$resultlist->Width = '80%';
$resultlist->HighlightTextColor = '#DDDDDD';
$resultlist->FontFace = 'Tahoma';
$resultlist->FontSize = '2';
$resultlist->TextColor = '#013567';
$resultlist->HeaderColor = '#013567';
$resultlist->BorderColor = '#013567';
$resultlist->HeaderTextColor = '#013567';
$resultlist->Show();
?>
</center>
</body>

</html>


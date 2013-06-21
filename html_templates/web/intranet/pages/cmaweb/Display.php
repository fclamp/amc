<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>CMA Results Detail</title>
</head>

<body bgcolor="#b5b6b5">
<img align=left border="0" src="images/column.jpg" width="84" height="120">
      <h3><font face="Tahoma" color="#336699">&nbsp;Carnegie Museum of Art</font></h3><br>

<p align=center>
<?php
require_once('../../objects/cmaweb/DisplayObjects.php');
$display = new CmaStandardDisplay;
$display->FontFace = 'Tahoma';
$display->FontSize = '2';
$display->BodyTextColor = '#336699';
$display->BorderColor = '#336699';
$display->HeaderTextColor = '#FFFFFF';
$display->BodyColor = '#FFFFE8';
$display->HighlightColor = '#FFFFFF';
$display->Intranet = 1;  //this is on a restricted page so display intranet only records
$display->Show();
?>
</p>
<p align="center">
<font color="#336699" size="1" face="Tahoma">Powered by: </font>
<img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></p>

</body>

</html>

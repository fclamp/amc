<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Display</title>
</head>

<body bgcolor="#FFFFE8">
<img align=left border="0" src="images/gag150.jpg">
      <h3><font face="Tahoma" color="#336699">&nbsp;Our Collection...</font></h3><br>

<p align=center>
<?php
require_once('../../objects/gag/DisplayObjects.php');
$display = new GalleryPartyDisplay;
$display->FontFace = 'Tahoma';
$display->FontSize = '2';
$display->BodyTextColor = '#336699';
$display->BorderColor = '#336699';
$display->HeaderTextColor = '#FFFFFF';
$display->BodyColor = '#FFFFE8';
$display->HighlightColor = '#FFFFFF';
$display->Show();
?>
</p>
<br>

</body>

</html>

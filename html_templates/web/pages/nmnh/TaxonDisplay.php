<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Display</title>
</head>

<body bgcolor="#AAC1C0">
      <h3><font face="Tahoma" color="#013567">&nbsp;Our Collection...</font></h3><br>

<p align=center>
<?php
require_once('../../objects/common/TaxonomyDisplayObject.php');
$display = new MapperStandardDisplay;
$display->FontFace = 'Arial';
$display->FontSize = '2';
$display->BodyTextColor = '#013567';
$display->BorderColor = '#013567';
$display->HeaderTextColor = '#FFFFFF';
$display->BodyColor = '#FFF3DE';
$display->HighlightColor = '#FFFFFF';
$display->Show();
?>
</p>
<br>

</body>

</html>

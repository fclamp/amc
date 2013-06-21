<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Display</title>
</head>

<body bgcolor="#E0F5DF">
      <h3><font face="Tahoma" color="#013567">&nbsp;Our Collection...</font></h3><br>

<p align=center>
<?php
require_once('../../objects/msim/DisplayObjects.php');
$display = new MsimStandardDisplay;
$display->FontFace = 'Tahoma';
$display->FontSize = '2';
$display->BodyTextColor = '#013567';
$display->BorderColor = '#013567';
$display->HeaderTextColor = '#013567';
$display->BodyColor = '#DFF5E0';
$display->HighlightColor = '#EDFAEE';
$display->Show();
?>
</p>
<br>
<center>
<a href = "LabelDisplay.php?irn=<?echo $irn ?>">Back to Narrative</a>
</body>

</html>

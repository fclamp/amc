<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Display</title>
</head>


<body bgcolor="#FFFFE8">

<center>

<font color=#336699 face=Tahoma size=2><u><b>Bibliography</b></u></font>
<br>
<br>
<br>
<?php

require_once('../../../objects/am/anthro/DisplayObjects.php');
$display = new AmBibDisplay;
$display->FontFace = 'Tahoma';
$display->FontSize = '2';
$display->Width = "80%";
$display->BodyTextColor = '#336699';
$display->BorderColor = '#336699';
$display->HeaderTextColor = '#FFFFFF';
$display->BodyColor = '#FFFFE8';
$display->HighlightColor = '#FFFFFF';
$display->SuppressEmptyFields = 0;
$display->Show();

?>
<br>

</center>

</body>
</html>

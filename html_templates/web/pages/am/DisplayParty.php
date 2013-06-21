<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Display</title>
</head>


<body bgcolor="#FFFFE8">

<font color=#336699 face=Tahoma><h2>Party</h2></font>

<br>
<?php

require_once('../../objects/am/DisplayObjects.php');
$display = new AmPartyDisplay;
$display->FontFace = 'Tahoma';
$display->FontSize = '2';
$display->Width = "600";
$display->BodyTextColor = '#336699';
$display->BorderColor = '#336699';
$display->HeaderTextColor = '#FFFFFF';
$display->BodyColor = '#FFFFE8';
$display->HighlightColor = '#FFFFFF';
$display->SuppressEmptyFields = 0;
$display->Show();

?>

<br>

</body>
</html>

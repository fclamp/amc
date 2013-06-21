<html>

<head>
<title>Display</title>
</head>

<body bgcolor="#FFFFFF">
<?php
require_once('Header.php');
?>

<br/>
<br/>
<br/>

<p align=center>
<?php
require_once('../../objects/mm/DisplayObjects.php');
$GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'] = 'PartyDisplay.php';
$display = new LcmsStandardDisplay;
$display->FontFace = 'Ariel, Tahoma';
$display->FontSize = '2';
$display->BodyTextColor = '#663399';
$display->BorderColor = '#663399';
$display->HeaderTextColor = '#EEEEEE';
$display->BodyColor = '#FFFFFF';
$display->HighlightColor = '#EEEEEE';
$display->Show();
?>
</p>

<br/>
<br/>
<br/>
<?php
require_once('Footer.php');
?>

</body>

</html>

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
require_once('web/objects/mm/lcms/DisplayObjects.php');
$display = new LcmsPartyDisplay;
$display->FontFace = 'Tahoma';
$display->FontSize = '2';
$display->BodyTextColor = '#663399';
$display->BorderColor = '#663399';
$display->HeaderTextColor = '#EEEEEE';
$display->BodyColor = '#663399';
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

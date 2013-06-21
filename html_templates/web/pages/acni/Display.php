<?php
include('header.inc');
?>

<?php
require_once('../../objects/acni/DisplayObjects.php');
$display = new AcniStandardDisplay;
$display->FontFace = 'Tahoma';
$display->FontSize = '2';
$display->BodyTextColor = '#000000';
$display->BorderColor = '#ccccc3';
$display->HeaderTextColor = '#5e5e5e';
$display->BodyColor = '#ffffff';
$display->HighlightColor = '#ecece6';

$display->Show();
?>

<?php
include('footer.inc');
?>

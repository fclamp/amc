<?php
include('includes/header.inc');

require_once('../../objects/ram/DisplayObjects.php');
$display = new RamPartyDisplay();
$display->TextColor = "#000000";
$display->BorderColor = '#B6CD35';
$display->Border= '0';
$display->BodyColor = '#D9D9D9';
$display->HeaderField = "";


$display->FontSize = "2";
?>
<div align="center"><?php $display->Show(); ?></div>
<?php
include('includes/footer.inc');
?>

<?php
include('includes/header.inc');

require_once('../../objects/ram/DisplayObjects.php');
/*function
PPrint ($text, $face='', $size='', $color='', $hightlightColor='', $raw=0)
{
	if (! $raw)
	{
		$text = htmlspecialchars($text);
		$text = preg_replace('/\\r?\\n/', "<br />\n", $text);
	}

	print $text;
}*/
$display = new RamStandardDisplay();
$display->BorderColor = '#B6CD35';
$display->Border= '1';
$display->BodyColor = '#D9D9D9';
$display->TextColor = '#000000';
$display->KeepAssociatedImagesAspectRatio = 1;
$display->FontSize = '2';
$display->HeaderField = "";
$display->ShowImageBorders = '0';
$display->QueryPage = 'Query.php';
?>
<div align="center"><?php $display->Show(); ?></div>
<?php
include('includes/footer.inc');
?>

<?php
include('header.inc');
?>

<?php
$where = "";
$order = "";
if (isset($_REQUEST['browse']) && $_REQUEST['browse'] == "artist")
{
	$where = "true";
	$order = "TitMainTitle";
}
?>

<?php
require_once('../../objects/acni/ResultsLists.php');

$resultlist = new AcniStandardResultsList;
$resultlist->BodyColor = '#ffffff';
$resultlist->Width = '80%';
if (!empty($where))
{
	$resultlist->Where = $where;
	$resultlist->Order = $order;
}
$resultlist->HighlightColor = '#ecece6';
$resultlist->HighlightTextColor = '#000000';
$resultlist->FontFace = 'Tahoma';
$resultlist->FontSize = '2';
$resultlist->TextColor = '#000000';
$resultlist->HeaderColor = '#ccccc3';
$resultlist->BorderColor = '#ccccc3';
$resultlist->HeaderTextColor = '#5e5e5e';
$resultlist->Show();

?>

<?php
include('footer.inc');
?>

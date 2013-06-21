<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="ushmmits.css"> 
<Title>ITS Test</Title>
</head>
<body>
<?php
require_once('../../objects/ushmmits/QueryForms.php');
$qry = new UshmmitsDetailedQueryForm;
$qry->Title = "Search ITS Test ...";
$qry->FontFace = "Arial";
//$qry->FontSize = "1.25em";
$qry->TitleTextColor = "#000000";
$qry->BodyTextColor = "#000000";
$qry->BodyColor = "#D2D7A4";
$qry->BorderColor = "#D2D7A4";
$qry->ResultsListPage = "Results.php";
//$qry->SecondSearch = 1;
$qry->ImagesOnlyOption = 0;
$qry->LimitPerPageOptions = array(
	25 => "25 records",
	50 => "50 records",
	100 => "100 records",
	250 => "250 records",
	500 => "500 records");
$qry->LimitPerPageSelected = 50;

$qry->DropDownLists = array(
	'AUType' => '|A1|A2|A3|A4|BC1|BC2|BC3',
	'DataVersion' => '|1|2|3',
	'ImageVersion' => '|1|2|3',
	'LocDetailsType' => '|C|H|P|U',
	'ListType' => '|0|1|2|3|4|5|6|7|8|9|10|11',
	'MimeType' => '|"image/jpeg"|"image/tiff"|"text/plain"',
	'NewDoc' => '|0|1',
	'PageCount' => '|1|2|3|4|5|6|7|8|9|10|11|12|13|14|15',
);

$qry->LookupLists = array(
	'FirstName' => 'FirstName',
	'LastName' => 'LastName',
	'LocInfo' => 'LocInfo',
	'MaidenName' => 'MaidenName',
	'Nationality' => 'Nationality',
	'RefCC' => 'RefCC',
);


$qry->Show();
?>
</body>
</html>

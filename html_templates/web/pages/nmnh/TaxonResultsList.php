<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Search results</title>
</head>

<body bgcolor="#AAC1C0">
      <h3><font face="Arial" color="#013567">&nbsp;Search results...</font></h3>

<table align=center width=80%>
<tr><td align=right>
<?php
require_once('../../objects/common/CsvExporter.php');

$csvexport = new CsvExporter;
$csvexport->Database = 'etaxonomy';
$csvexport->ExportFields = 'ClaScientificName';
$csvexport->Show();
?>
</td></tr>
</table>

<center>

<?php
require_once('../../objects/common/TaxonomyResultsLists.php');

$resultlist = new TaxonomyResultsList;

$resultlist->DisplayThumbnails = 0;
$resultlist->BodyColor = '#FFF3DE';
$resultlist->Width = '82%';
$resultlist->HighlightColor = '#FFFFFF';
$resultlist->HighlightTextColor = '#DDDDDD';
$resultlist->FontFace = 'Arial';
$resultlist->FontSize = '2';
$resultlist->TextColor = '#013567';
$resultlist->HeaderColor = '#013567';
$resultlist->BorderColor = '#013567';
$resultlist->HeaderTextColor = '#FFFFFF';
$resultlist->Show();
?>
</center>

</body>

</html>


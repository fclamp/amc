<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252"/>
	<link rel="stylesheet" type="text/css" href="Query.css">
	<title>QAG Search Results</title>
</head>

<body>

	<table id="HeaderTable">
		<tr>
    			<td id="HeaderCellLeft">
				<a href="http://www.qag.qld.gov.au"><img id="HeaderImage" src="images/qagLogo.gif"></img>
			</td>
			<td id="HeaderCellMiddle">
			</td>
			<td id="HeaderCellRight">
				<p>Asia Pacific Collection Online</p>
			</td>
		</tr>
	</table>

	<br>
<?php
require_once('../../objects/common/RecordExtractor.php');
require_once('../../objects/qag/ImageDisplay.php');

$extractor = new RecordExtractor();
$extractor->Intranet = 0;
$extractor->Database = "emultimedia";
$extractor->ExtractFields(array(
		"NotNotes",
		"DetRights"));

$id = new ImageDisplay();
$id->Intranet = 0;
$id->Notes = $extractor->FieldAsValue("NotNotes");

?>

<font face="Verdana" size="1">
<table id="MainTable" align="center" width="100">
	<tr>
		<td nowrap="nowrap" align="center">
			<?php $id->Show() ?>
		</td>
	</tr>
</table>
<br />
<?php
if ($extractor->HasData("DetRights"))
{?>
	<center>&#xA9;&nbsp;<?php $extractor->PrintField("DetRights");?></center>
<?php
}
?>
</font>
</body>
</html>

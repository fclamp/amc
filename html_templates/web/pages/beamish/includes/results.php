<?php
require_once('emuweb/php5/query.php');

$Keywords = "";
if (isset($_REQUEST['Keywords']))
	$Keywords = $_REQUEST['Keywords'];

$StartAt = 1;
if (isset($_REQUEST['start']) && is_numeric($_REQUEST['start']) && $_REQUEST['start'] > 0)
	$StartAt = $_REQUEST['start'];

$qry = new Query;
$qry->StartRec = $StartAt;
$qry->EndRec = $StartAt + 39;
$qry->Select('SummaryData');
$qry->Select('MulMultiMediaRef_tab->emultimedia->SummaryData');
/*
 * Work out all the query fields and do some querying
 */
if (isset($_REQUEST['Keywords']) && !empty($_REQUEST['Keywords']))
{
	$qry->Term("SummaryData", mysql_escape_string($_REQUEST['Keywords']));
}
if (isset($_REQUEST['ObjectName']) && !empty($_REQUEST['ObjectName']))
{
	$qry->Term("TitObjectName", mysql_escape_string($_REQUEST['ObjectName']));
}
if (isset($_REQUEST['AccessionNo']) && !empty($_REQUEST['AccessionNo']))
{
	$qry->Term("TitAccessionNo", mysql_escape_string($_REQUEST['TitAccessionNo']));
}
if (isset($_REQUEST['CurrentLocation']) && !empty($_REQUEST['CurrentLocation']))
{
	$qry->Term("LocCurrentLocationLocal", mysql_escape_string($_REQUEST['CurrentLocation']));
}
if (isset($_REQUEST['BriefDescription']) && !empty($_REQUEST['BriefDescription']))
{
	$qry->Term("CreBriefDescription", mysql_escape_string($_REQUEST['BriefDescription']));
}
if (isset($_REQUEST['CollectionGroup']) && !empty($_REQUEST['CollectionGroup']))
{
	$qry->Term("TitCollectionGroup_tab", mysql_escape_string($_REQUEST['CollectionGroup']));
}
if (isset($_REQUEST['CollectionSubGroup']) && !empty($_REQUEST['CollectionSubGroup']))
{
	$qry->Term("TitCollectionSubGroup_tab", mysql_escape_string($_REQUEST['CollectionSubGroup']));
}
if (isset($_REQUEST['SHIC']) && !empty($_REQUEST['SHIC']))
{
	$qry->Term("PhyShicClassification_tab", mysql_escape_string($_REQUEST['SHIC']));
}
if (isset($_REQUEST['CreatorsName']) && !empty($_REQUEST['CreatorsName']))
{
	$qry->Term("CreCreatorLocal_tab", mysql_escape_string($_REQUEST['CreatorsName']));
}
if (isset($_REQUEST['CreatorsRole']) && !empty($_REQUEST['CreatorsRole']))
{
	$qry->Term("CreRole_tab", mysql_escape_string($_REQUEST['CreatorsRole']));
}
if (isset($_REQUEST['PlaceOfCreation']) && !empty($_REQUEST['PlaceOfCreation']))
{
	$texql = "exists(CreCreationPlace1_tab where CreCreationPlace1 contains '" . mysql_escape_string($_REQUEST['PlaceOfCreation']) . "') OR ";
	$texql = "exists(CreCreationPlace2_tab where CreCreationPlace2 contains '" . mysql_escape_string($_REQUEST['PlaceOfCreation']) . "') OR ";
	$texql = "exists(CreCreationPlace3_tab where CreCreationPlace3 contains '" . mysql_escape_string($_REQUEST['PlaceOfCreation']) . "') OR ";
	$texql = "exists(CreCreationPlace4_tab where CreCreationPlace4 contains '" . mysql_escape_string($_REQUEST['PlaceOfCreation']) . "') OR ";
	$texql = "exists(CreCreationPlace5_tab where CreCreationPlace5 contains '" . mysql_escape_string($_REQUEST['PlaceOfCreation']) . "')";

	$qry->TexqlTerm($texql);
}
if (isset($_REQUEST['CreationPlace3']) && !empty($_REQUEST['CreationPlace3']))
{
	$qry->Term("CreCreationPlace3_tab", mysql_escape_string($_REQUEST['CreationPlace3']));
}
if (isset($_REQUEST['CreationPlace4']) && !empty($_REQUEST['CreationPlace4']))
{
	$qry->Term("CreCreationPlace4_tab", mysql_escape_string($_REQUEST['CreationPlace4']));
}
if (isset($_REQUEST['CreationPlace5']) && !empty($_REQUEST['CreationPlace5']))
{
	$qry->Term("CreCreationPlace5_tab", mysql_escape_string($_REQUEST['CreationPlace5']));
}
if (isset($_REQUEST['PeriodDate']) && !empty($_REQUEST['PeriodDate']))
{
	$qry->Term("CrePeriodDate", mysql_escape_string($_REQUEST['PeriodDate']));
}
if (isset($_REQUEST['DateCreated']) && !empty($_REQUEST['DateCreated']))
{
	$qry->Term("CreDateCreated", mysql_escape_string($_REQUEST['DateCreated']));
}
if (isset($_REQUEST['EarliestDate']) && !empty($_REQUEST['EarliestDate']))
{
	$qry->Term("CreEarliestDate", mysql_escape_string($_REQUEST['EarliestDate']), "date");
}
if (isset($_REQUEST['LatestDate']) && !empty($_REQUEST['LatestDate']))
{
	$qry->Term("CreLatestDate", mysql_escape_string($_REQUEST['LatestDate']), "date");
}
if (isset($_REQUEST['PrimaryInscription']) && !empty($_REQUEST['PrimaryInscription']))
{
	$qry->Term("CrePrimaryInscriptions", mysql_escape_string($_REQUEST['PrimaryInscription']));
}
if (isset($_REQUEST['OtherInscription']) && !empty($_REQUEST['OtherInscription']))
{
	$qry->Term("CreOtherInscriptions", mysql_escape_string($_REQUEST['OtherInscription']));
}
if (isset($_REQUEST['Technique']) && !empty($_REQUEST['Technique']))
{
	$qry->Term("PhyTechnique_tab", mysql_escape_string($_REQUEST['Technique']));
}
if (isset($_REQUEST['Material']) && !empty($_REQUEST['Material']))
{
	$qry->Term("PhyMaterial_tab", mysql_escape_string($_REQUEST['Material']));
}
if (isset($_REQUEST['Description']) && !empty($_REQUEST['Description']))
{
	$qry->Term("PhyDescription", mysql_escape_string($_REQUEST['Description']));
}
/*
 * Actually run the query
 */
$results = $qry->Fetch();

if ($qry->EndRec > $qry->Matches)
{
	$truematches = $qry->StartRec + count($results) - 1;
	if ($truematches < $qry->Matches)
		$qry->Matches = $truematches;
	if ($truematches < $qry->EndRec)
		$qry->EndRec = $truematches;
}

$NextPageURL = "";
if ($qry->Matches > $qry->EndRec)
{
	$NextPageURL = $_SERVER['PHP_SELF'] . "?";
	$Params = "";
	foreach ($_REQUEST as $key => $val)
	{
		if ($key == "start")
			continue;
		if (!empty($Params))
			$Params .= "&amp;";
		$Params .= $key . "=" . urlencode($val);
	}
	$nextstart = $qry->StartRec + 40;
	$NextPageURL .= $Params . "&amp;" . "start=$nextstart";
}

$PrevPageURL = "";
if ($qry->StartRec > 1)
{
	$PrevPageURL = $_SERVER['PHP_SELF'] . "?";
	$Params = "";
	foreach ($_REQUEST as $key => $val)
	{
		if ($key == "start")
			continue;
		if (!empty($Params))
			$Params .= "&amp;";
		$Params .= $key . "=" . urlencode($val);
	}
	$prevstart = $qry->StartRec - 40;
	if ($prevstart < 1)
		$prevstart = 1;

	$PrevPageURL .= $Params . "&amp;" . "start=$prevstart";
}

?>



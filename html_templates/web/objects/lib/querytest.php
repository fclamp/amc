<?php
include("texquery.php");

$PartyTestList = array(
			"SummaryData",
			"ColRecordByRef_eparties_SummaryData",
			"ColRecordByRef_eparties_NamFirst",
			"ColRecordByRef_eparties_NamLast"
			);

$qry = new Query;
$qry->select = $PartyTestList;
$qry->from = "ecatalogue";
$qry->where = "irn = 1";
$qry->start = 0;
$qry->limit  = 20;
$records = $qry->fetch();

$i = 0;
while ($records[$i]->SummaryData != "" && $i < 100)
{
	print "Results <br />\r\n";
	print "Nested Test " . $records[$i]->ColRecordByRef_eparties_SummaryData . "<br />\r\n";
	print "NamFirst " . $records[$i]->ColRecordByRef_eparties_NamFirst . "<br />\r\n";
	print "NamLast " . $records[$i]->ColRecordByRef_eparties_NamLast . "<br />\r\n";
	print "Summary Data " . $records[$i]->SummaryData . "<br />\r\n";
	$i++;
}

?>

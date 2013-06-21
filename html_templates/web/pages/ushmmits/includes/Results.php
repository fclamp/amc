<?php
require_once('includes/MatchLimit.php');

/*
 * Use a seesion object to store our results list irns to use on
 * the display page to navigate between records
 */
require_once('../../objects/common/EMuWebSessions.php');
$session = new EMuWebSession;
$session->ClearSession();

require_once('../../objects/lib/BaseQueryGenerator.php');
$qryGenerator = new BaseQueryGenerator;
$qryGenerator->Database = "ecatalogue";
$qryAttrib = $qryGenerator->DetailedQuery();
$WhereString = $qryAttrib->Where;
if (empty($WhereString))
	$WhereString = "true";

$FromRec = $_REQUEST['StartAt'];
$PerPage = $_REQUEST['LimitPerPage'];
$ToRec = $FromRec + $PerPage;

require_once('../../objects/lib/texquery.php');
$qry = new Query;
$qry->Select = array("irn", "SummaryData");
$qry->From = "ecatalogue";
$qry->Where = $WhereString;
$qry->Limit = $PerPage + 1;
$qry->Offset = $FromRec;
$qry->All = 1;

/*
 * Build reordering logic
 */
$OrderString = "";
if (isset($_REQUEST['Order1']) && !empty($_REQUEST['Order1']))
{
	$OrderString .= $_REQUEST['Order1'];
	if ($_REQUEST['Order1AscDesc'] == "descending")
		$OrderString .= " desc";
	array_push($qry->Select, $_REQUEST['Order1']);
}
if (isset($_REQUEST['Order2']) && !empty($_REQUEST['Order2']))
{
	if (!empty($OrderString))
		$OrderString .= ", ";
	$OrderString .= $_REQUEST['Order2'];
	if ($_REQUEST['Order2AscDesc'] == "descending")
		$OrderString .= " desc";
	array_push($qry->Select, $_REQUEST['Order2']);
}
if (isset($_REQUEST['Order3']) && !empty($_REQUEST['Order3']))
{
	if (!empty($OrderString))
		$OrderString .= ", ";
	$OrderString .= $_REQUEST['Order3'];
	if ($_REQUEST['Order3AscDesc'] == "descending")
		$OrderString .= " desc";
	array_push($qry->Select, $_REQUEST['Order3']);
}

/*
 * Set reordering logic on Query
 */
$qry->Order = $OrderString;

$Results = $qry->Fetch();
//print_r($Results);
//print_r($qry);

/*
 * Build next and previous URL's
 */
$prevstart = $FromRec - $PerPage;
$nextstart = $FromRec + $PerPage;

$prevUrl = "";
if ($prevstart > 0)
{
	$prevUrl = $_SERVER['PHP_SELF'] . "?";
	$urlparams = "";
	foreach ($_REQUEST as $key => $val)
	{
		if ($val == "")
			continue;
		if ($urlparams != "")
			$urlparams .= "&amp;";
		if ($key == "StartAt")
		{
			$urlparams .= $key . "=" . $prevstart;
		}
		else
		{
			$val = stripslashes($val);
			$urlparams .= $key . "=" . urlencode($val);
		}
	}
	$prevUrl .= $urlparams;	
}

$nextUrl = "";
$cnt = count($Results);
if ($cnt > $PerPage)
{
	$nextUrl = $_SERVER['PHP_SELF'] . "?";
	$urlparams = "";
	foreach ($_REQUEST as $key => $val)
	{
		if ($val == "")
			continue;
		if ($urlparams != "")
			$urlparams .= "&amp;";
		if ($key == "StartAt")
		{
			$urlparams .= $key . "=" . $nextstart;
		}
		else
		{
			$val = stripslashes($val);
			$urlparams .= $key . "=" . urlencode($val);
		}
	}
	$nextUrl .= $urlparams;	
}

/*
 * Array to hold irns of records, or URL to next results set
 */
$irnlist = array();
if (! empty($prevUrl))
	array_push($irnlist, $prevUrl);
for ($i = 0; $i < $cnt && $i < $PerPage; $i++)
{
	array_push($irnlist, $Results[$i]->{"irn_1"});
}
if ($FromRec - 1 + $cnt - 1 < intval($MatchLimit / $PerPage) * $PerPage)
	array_push($irnlist, $nextUrl);
//print_r($irnlist);

/*
 * Save irnlist into a session variable
 */
$session->SaveVar("irnlist", $irnlist);

/*
 * Build variables to use in the 'results x to y' text
 */
$StartRec = $FromRec;
$EndRec = $ToRec - 1;
if ($cnt < $PerPage)
	$EndRec = $StartRec + $cnt - 1;
?>

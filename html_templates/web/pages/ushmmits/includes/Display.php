<?php
require_once("../../objects/common/EMuWebSessions.php");
require_once("../../objects/lib/texquery.php");
require_once("../../objects/lib/MediaImage.php");

error_reporting(E_ERROR);

if (isset($_REQUEST['irn']) && is_numeric($_REQUEST['irn']))
	$IRN = $_REQUEST['irn'];
$Recno;
if (isset($_REQUEST['recno']))
	$Recno = $_REQUEST['recno'];

/*
 * Grab the list of irns in set from the session
 */
$session = new EMuWebSession;
$irnlist = $session->GetVar("irnlist");

$PrevIRN = "";
$PrevPage = "";
$NextIRN = "";
$NextPage = "";
$irnindex = array_search($IRN, $irnlist);
if ($irnindex > 0)
{
	if (is_numeric($irnlist[$irnindex - 1]))
		$PrevIRN = $irnlist[$irnindex - 1];
	else
		$PrevPage = $irnlist[$irnindex - 1];
}
if (is_numeric($irnlist[$irnindex + 1]))
	$NextIRN = $irnlist[$irnindex + 1];
elseif ($irnindex + 1 <= count($irnlist))
	$NextPage = $irnlist[$irnindex + 1];

/*
 * Work out which IRN's are next and previous (in number) from this one.
 * Then query for each to make sure it exists
 */
$NextIRNSeq;
$PrevIRNSeq;
$NextIRNUrl;
$PrevIRNUrl;
if (is_numeric($IRN))
{
	$NextIRNSeq = $IRN + 1;
	$PrevIRNSeq = $IRN - 1;
	$prevqry = new Query;
	$prevqry->Texql = "SELECT irn FROM ecatalogue WHERE irn_1=$PrevIRNSeq";
	$results = $prevqry->Fetch();
	if (count($results) == 1)
	{
		$PrevIRNUrl = $_SERVER['PHP_SELF'] . "?irn=" . $PrevIRNSeq . "&amp;seq=yes";
	}

	$nextqry = new Query;
	$nextqry->Texql = "SELECT irn FROM ecatalogue WHERE irn_1=$NextIRNSeq";
	$results = $nextqry->Fetch();
	if (count($results) == 1)
	{
		$NextIRNUrl = $_SERVER['PHP_SELF'] . "?irn=" . $NextIRNSeq . "&amp;seq=yes";
	}
}

/*
 * Main record query
 */
$qry = new Query;
$qry->Select = array(
	"irn_1",
	"SummaryData",
	"DocId",
	"MulMultiMediaRef_tab",
	"InventoryNo",
	"PageCount",
	"MimeType",
	"ImageVersion",
	"DataVersion",
	"AUNumber",
	"AUType",
	"NewDoc",
	"ContainerName",
	"FilingNo",
	"PageNo",
	"SequenceNo",
	"DocCategory",
	"Nationality",
	"DateFrom",
	"RefCC",
	"LocInfo",
	"LocDetails",
	"LocDetailsType",
	"ListType",
	"LastName",
	"FirstName",
	"MaidenName",
	"DateOfBirth",
	"Number",
	);
$qry->From = "ecatalogue";
$qry->Where = "irn = $IRN";
$qry->All = 1;
$Results = $qry->Fetch();
$Record = $Results[0];

/*
 * Get an array of multimedia attachments
 */
$MediaIrns = array();
$fieldstart = "MulMultiMediaRef:";
for ($i = 1; 1; $i++)
{
	$fieldname = $fieldstart . $i;
	if (! empty($Record->{$fieldname}))
		array_push($MediaIrns, $Record->{$fieldname});
	else
		break;
}

/*
 * Grab starting Media pos from url if present
 */
$MediaStart = 0;
if (isset($_REQUEST['media']) && is_numeric($_REQUEST['media']))
	$MediaStart = $_REQUEST['media'];

$MediaPrev;
if ($MediaStart > 0)
	$MediaPrev = $MediaStart - 1;

$MediaNext;
if (count($MediaIrns) > ($MediaStart + 1))
	$MediaNext = $MediaStart + 1;
?>

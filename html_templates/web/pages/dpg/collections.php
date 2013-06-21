<?php
/*
 * Copyright (c) 1998-2009 KE Software Pty Ltd
 */

/*
 * Change to set path to media.php on this server
 */
$MediaURL = "http://" . $_SERVER['HTTP_HOST'] . "/web/php5/media.php";

require_once('G:\home\emu\dpg\web\php5\query.php');

if (isset($_REQUEST['type']))
{
	if ($_REQUEST['type'] == "results")
	{
		FormResults();
	}
	if ($_REQUEST['type'] == "details")
	{
		FormDetails();
	}
	if ($_REQUEST['type'] == "dropdown")
	{
		FormDropdown();
	}
}

function
FormResults()
{
	global $MediaURL;

	$qry = new Query;
	$qry->Select("irn_1");
	$qry->Select("TitMainTitle");
	$qry->Select("SummaryData");
	$qry->Select("MulMultiMediaRef_tab->emultimedia->AdmPublishWebNoPassword");

	if (isset($_REQUEST['start']) && is_numeric($_REQUEST['start']))
	{
		$qry->StartRec = $_REQUEST['start'];
	}
	else
		$qry->StartRec = 1;

	if (isset($_REQUEST['end']) && is_numeric($_REQUEST['end']))
	{
		$qry->EndRec = $_REQUEST['end'];
	}
	else
		$qry->EndRec = $qry->StartRec + 14;
	

	/* Boolean set to know whether to run query */
	$RunQuery = 0;

	$Keywords = "";
	if (isset($_REQUEST['keywords']))
	{
		if (!empty($_REQUEST['keywords']))
		{
			$Keywords = addslashes($_REQUEST['keywords']);
			$qry->Term("SummaryData", $Keywords);
		}
		$RunQuery = 1;
	}	

	$Artist = "";
	if (isset($_REQUEST['artist']))
	{
		$Artist = addslashes($_REQUEST['artist']);
		$qry->Term("CreCreatorLocal_tab", $Artist);
		$RunQuery = 1;
	}

	$Theme = "";
	if (isset($_REQUEST['theme']))
	{
		$Theme = addslashes($_REQUEST['theme']);
		$narqry = new Query;
		$narqry->Table = "enarratives";
		$narqry->Select("ObjObjectsRef_tab");
		$narqry->Term("NarTitle", "\"$Theme\"");
		$narresults = $narqry->Fetch();
		foreach ($narresults as $narresult)
		{
			foreach ($narresult->ObjObjectsRef_tab as $catirn)
			{
				$qry->Term("irn_1", $catirn);
				$RunQuery = 1;
			}
		}
	}

	if ($RunQuery == 0)
	{
		return 0;
	}

	$results = $qry->Fetch();

	header("Content-type: text/xml");
	print '<?xml version="1.0" encoding="utf-8"?>' ."\n";
	print "<results>\n";
	print "<firstrecord>" . $qry->StartRec . "</firstrecord>\n";

	$LastRecord = $qry->EndRec;
	if (count($results) < ($qry->EndRec - $qry->StartRec))
	{
		$LastRecord = $qry->StartRec + count($results) - 1;
	}
	print "<lastrecord>" . $LastRecord . "</lastrecord>\n";

	$Matches = $qry->Matches;
	if ($qry->EndRec > $Matches)
		$Matches = $LastRecord;
	print "<matches>" . $Matches . "</matches>\n";

	foreach ($results as $result)
	{
		print "<result>\n";
		$ThumbnailURL = "";
		if ($result->MulMultiMediaRef_tab[0]->AdmPublishWebNoPassword == "Yes")
		{
			$ImageURL = $MediaURL . "?irn=" . $result->MulMultiMediaRef_tab[0]->irn_1 . "&image=yes";
			$ThumbnailURL = $ImageURL . "&width=169&height=96";
		}
		print "<thumbnail>" . htmlspecialchars($ThumbnailURL) . "</thumbnail>\n";

		print "<id>" . $result->irn_1 . "</id>\n";
		print "<title>" . htmlspecialchars($result->TitMainTitle) . "</title>";
		print "<summary>" . htmlspecialchars($result->SummaryData) . "</summary>";
		print "</result>\n";
	}
	print "</results>\n";
}

function
FormDetails()
{
	global $MediaURL;

	$Irn = 0;
	if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
	{
		$Irn = $_REQUEST['id'];
	}

	if ($Irn == 0)
		return 0;

	$qry = new Query();
	$qry->Select("MulMultiMediaRef_tab->emultimedia->AdmPublishWebNoPassword");
	$qry->Select("TitMainTitle");
	$qry->Select("CreCreatorRef_tab->eparties->SummaryData");
	$qry->Select("CreDateCreated");
	$qry->Select("PhyDescription");
	$qry->Term("irn", $Irn);
	$results = $qry->Fetch();

	if (count($results) != 1)
		return 0;

	/*
	 * Work out if the multimedia is visible and set helper variables
	 */
	$ImageURL = "";
	$ThumbnailURL = "";
	$DetailThumbnailURL = "";

	if ($results[0]->MulMultiMediaRef_tab[0]->AdmPublishWebNoPassword == "Yes")
	{
		$ImageURL = $MediaURL . "?irn=" . $results[0]->MulMultiMediaRef_tab[0]->irn_1 . "&image=yes";
		$ThumbnailURL = $ImageURL . "&width=169&height=96";
		$DetailThumbnailURL = $ImageURL . "&width=420&height=215";
		$ImageURL .= "&width=500&height=500";
	}
	
	header("Content-type: text/xml");
	print '<?xml version="1.0" encoding="utf-8"?>' ."\n";
	print "<record>\n";
	print "<id>" . $results[0]->irn_1 . "</id>\n";
	print "<thumbnail>" . htmlspecialchars($ThumbnailURL) . "</thumbnail>\n";
	print "<detailthumbnail>" . htmlspecialchars($DetailThumbnailURL) . "</detailthumbnail>\n";
	print "<image>" . htmlspecialchars($ImageURL) . "</image>\n";
	print "<name>" . htmlspecialchars($results[0]->TitMainTitle) . "</name>\n";
	print "<artist>" . htmlspecialchars($results[0]->CreCreatorRef_tab[0]->SummaryData) . "</artist>\n";
	print "<date>" . htmlspecialchars($results[0]->CreDateCreated) . "</date>\n";
	print "<description>" . htmlspecialchars($results[0]->PhyDescription) . "</description>\n";

	/*
	 * Now work out what theme the object is in
	 */
	$themeqry = new Query;
	$themeqry->Table = "enarratives";
	$themeqry->Select("NarTitle");
	$themeqry->Term("ObjObjectsRef_tab", $results[0]->irn_1, "int");
	$themes = $themeqry->Fetch();
	
	print "<themes>\n";
	foreach ($themes as $theme)
	{
		print "<theme>" . htmlspecialchars($theme->NarTitle) . "</theme>\n";
	}
	print "</themes>\n";

	print "</record>\n";
}

function
FormDropdown()
{
	if (!isset($_REQUEST['dropdown']))
		return 0;

	if ($_REQUEST['dropdown'] == "artist")
	{
		$qry = new Query;
		$qry->Table = "eluts";
		$qry->Visibility = QUERY::$ALL;
		$qry->Select("Value000");
		$qry->Term("NameText", '"Creator Name"');
		$results = $qry->Fetch();
		
		header("Content-type: text/xml");
		print '<?xml version="1.0" encoding="utf-8"?>' ."\n";
		print "<dropdown name=\"artist\">\n";
		foreach ($results as $record)
		{
			print "<value>" . htmlspecialchars($record->Value000) . "</value>\n";
		}
		print "</dropdown>\n";		
	}

	if ($_REQUEST['dropdown'] == "theme")
	{
		$qry = new Query;
		$qry->Table = "enarratives";
		$qry->Select("NarTitle");
		$qry->Term("DesType_tab", '"Web Theme"');
		$results = $qry->Fetch();

		header("Content-type: text/xml");
		print '<?xml version="1.0" encoding="utf-8"?>' ."\n";
		print "<dropdown name=\"theme\">\n";
		foreach ($results as $record)
		{
			print "<value>" . htmlspecialchars($record->NarTitle) . "</value>\n";
		}
		print "</dropdown>\n";
	}
}

?>


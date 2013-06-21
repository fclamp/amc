<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*
*  Inherite off the narrative results list and provide "section" support.
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($COMMON_DIR . 'NarrativeResultsLists.php');


// This function in used by the STW sections support.
// It's reponsible for using the "sections" variable
// and constructing a sutible restriction

function
SectionsRestriction()
{
	global $ALL_REQUEST;
	$section = "";
	if ($ALL_REQUEST['section'])
	{
		$section = $ALL_REQUEST['section'];
	}

	if ($section == "")
	{
		return("");
	}
	else
	{
		// The Dc1Subject field is used to denote the section
		$r = "exists (DesSubjects_tab where DesSubjects contains '";
		$r .= $section . "')";
		return($r);
	}
}

class
StwNarrativeResultsList extends NarrativeResultsList
{
	// Overide the constructor and set the restriction
	function
	StwNarrativeResultsList()
	{
		$this->NarrativeResultsList();
		$this->Restriction = SectionsRestriction();
	}
}

class
StwNarrativeContactSheet extends NarrativeContactSheet
{

	// Overide the constructor and set the restriction
	function
	StwNarrativeContactSheet()
	{
		$this->BaseContactSheet();
		$this->Restriction = SectionsRestriction();
	}

} 


?>

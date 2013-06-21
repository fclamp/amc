<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');


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
		$r = "exists (Dc1Subject_tab where Dc1Subject contains '";
		$r .= $section . "')";
		return($r);
	}
}

class
StwStandardResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'Dc1CreatorLocal:1',
				'Dc1Title',
				'Dc2DateCreated',
				);	

	// Overide the constructor and set the restriction
	function
	StwStandardResultsList()
	{
		$this->BaseStandardResultsList();
		$this->Restriction = SectionsRestriction();
	}
}

class
StwContactSheet extends BaseContactSheet
{
	var $Fields = array(	'Dc1Title',
				'Dc1CreatorLocal:1',
				);	

	// Overide the constructor and set the restriction
	function
	StwContactSheet()
	{
		$this->BaseContactSheet();
		$this->Restriction = SectionsRestriction();
	}

} 


?>

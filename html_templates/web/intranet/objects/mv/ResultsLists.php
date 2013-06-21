<?php

/*
**
**	Copyright (c) 1998-2009 KE Software Pty Ltd
**
**      Template.  Change all reference to "Client"
**
**         **Example Only**
**
*/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');


class
MvStandardResultsList extends BaseStandardResultsList
{
	function
	MvStandardResultsList()
	{

		$regNumber = new FormatField;
		$regNumber->Format = "{ColRegPrefix} {ColRegNumber} {ColRegPart}";
		$regNumber->Label = "Registration Number";


		$this->Fields = array(	'SummaryData',
					'DesObjectDescription',
					$regNumber,
					'ColCategory',
					//'TitAccessionNo',
					//'CreCreatorLocal:1',
					//'CreDateCreated'
					);	

		$this->BaseStandardResultsList();
	}	

}


class
MvContactSheet extends BaseContactSheet
{
	function
	MvContactSheet()
	{
		$this->Fields = array(	'SummaryData',
					//'TitAccessionNo',
					);	

		$this->BaseContactSheet();
	}

}

?>

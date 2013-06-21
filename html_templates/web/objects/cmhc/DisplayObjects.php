<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
cmhcStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	cmhcStandardDisplay()
	{

		$this->Fields = array(
				'ObjTitle',
				'ObjAccessionNumber',
				'ObjDateOfObject',
				'ObjLocation_tab',
				'ObjLocationProvince_tab',
				'ObjDescription_tab',
				'ObjPhotographerRef_tab->eparties->SummaryData',
				);
		
		$this->BaseStandardDisplay();
	}
}

class
cmhcPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	cmhcPartyDisplay()
	{
		$this->Fields = array(
				'ObjTitle'
				);
		$this->Database = 'eparties';

		$this->BaseStandardDisplay();
	}
}
?>

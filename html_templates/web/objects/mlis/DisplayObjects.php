<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
MlisStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	MlisStandardDisplay()
	{
		$this->Fields = array(
				'Dc1Title',
				'Dc1Title',
				'Dc1CreatorRef_tab->eparties->SummaryData',
				'Dc2DateCreated',
				'Dc1Subject_tab',
				'Dc1Identifier',
				'NotNotes',
				);

		$this->BaseStandardDisplay();
	}
}
?>

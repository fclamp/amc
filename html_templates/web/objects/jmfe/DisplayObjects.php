<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
jmfeStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	jmfeStandardDisplay()
	{
		$this->HeaderField = '';
		$this->CenterImage = 1;
		$this->Fields = array(
				'SummaryData',
				'irn_1',
				'TitMainTitle',
				'SumAssocPartyLocal_tab',
				'CreDateCreated',
				'TitItemType',
				'TitItemDescription',
				);
		
		$this->BaseStandardDisplay();
	}
}

class
jmfePartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	jmfePartyDisplay()
	{
		$this->Fields = array(
				'SummaryData',
				'NamTitle',
				'NamFirst',
				'NamMiddle',
				'NamLast',
				'BioBirthPlace',
				'BioDeathPlace',
				'BioEthnicity',
				'NotNotes',
				);
		$this->Database = 'eparties';

		$this->BaseStandardDisplay();
	}
}
?>

<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
RbgStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	RbgStandardDisplay()
	{
		$colRole = new Field();
		$colRole->ColName = 'CorCollectorRole_tab';
		$colRole->Italics = 1;
		
		$colCollectorRef = new Field();
		$colCollectorRef->ColName = 'CorCollectorRef_tab->eparties->SummaryData';
		$colCollectorRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		$collectorTable = new Table();
		$collectorTable->Name = "COLLECTOR";
		$collectorTable->Columns = array($colRole, $colCollectorRef);

		$this->Fields = array(
 				'IdePlantNameLocal',
				'IdeDeterminavitRef_nesttab->eparties->SummaryData',
				$collectorTable,
				'CorNative',
				'NotNotes',
				);
		
		$this->BaseStandardDisplay();
	}
}

class
RbgPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	RbgPartyDisplay()
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

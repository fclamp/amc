<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
WarclipStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	WarclipStandardDisplay()
	{
//		$creMakerRef = new Field();
//		$creMakerRef->ColName = 'DesMakerRef_tab->eparties->SummaryData';
//		$creMakerRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
//		$creatorTable = new Table();
//		$creatorTable->Name = "CREATOR";
//		$creatorTable->Columns = array($creMakerRef);

		$this->Database = "warclip";

		$this->Fields = array(
				'NumCatNo',
				'WarSubjectHeading_tab',
				'WarSubHeading1_tab',
				'WarSubHeading2_tab',
				'WarSubHeading3_tab',
				'WarArticleSummary',
				'DatManufacture',
				'WarHeadline',
				'WarSourceNewspaperSummData',
				$creatorTable,
				);
		
		$this->BaseStandardDisplay();
	}
}


class
WarclipPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	WarclipPartyDisplay()
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

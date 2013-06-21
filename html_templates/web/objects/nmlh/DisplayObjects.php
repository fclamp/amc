<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
NmlhStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	NmlhStandardDisplay()
	{
		
			
		$creCreatorRef = new Field;
		$creCreatorRef->ColName = 'CreCreatorRef_tab->eparties->SummaryData';
		$creCreatorRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		$notNotes = new Field;
		$notNotes->ColName = 'NotNotes';
		//$notNotes->Filter = '/Public(.*?)(Private|$)/i';

		$notNotes->Filter = '/PHM-NARRATIVE(.*?)(Private|$)/is'; 

		$this->Fields = array(
				'TitAccessionNo',
				'TitObjectName',
				'TitTitle',
				'TitCollectionTitle',
				'TitKeyName_tab',
				'AssAssociatedPlaces',
				'AssAssociatedPeople',
				'AssAssociatedEvents',
				'CreDateCreated',
				'AssAssociatedDates',
				$creCreatorRef,
				$notNotes,
				);
		
		$this->BaseStandardDisplay();
	}
}

class
NmlhPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	NmlhPartyDisplay()
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

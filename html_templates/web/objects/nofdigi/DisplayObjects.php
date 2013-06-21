<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
NofdigiStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	NofdigiStandardDisplay()
	{
	//	$creRole = new Field();
	//	$creRole->ColName = 'CreRole_tab';
	//	$creRole->Italics = 1;
	//	
		$Dc1CreatorNameRef = new Field;
		$Dc1CreatorNameRef->ColName = 'Dc1CreatorRef_tab->eparties->SummaryData';
		$Dc1CreatorNameRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
	//	$creatorTable = new Table;
	//	$creatorTable->Name = "CREATOR";
	//	$creatorTable->Columns = array($creRole, $creCreatorRef);

		// Creation Place
//		$creCreationPlace1 = new Field;
	//	$creCreationPlace1->ColName = 'CreCreationPlace1_tab';
	//	$creCreationPlace2 = new Field;
	//	$creCreationPlace2->ColName = 'CreCreationPlace2_tab';
	//	$creCreationPlace3 = new Field;
	//	$creCreationPlace3->ColName = 'CreCreationPlace3_tab';
	//	$creCreationPlace4 = new Field;
	//	$creCreationPlace4->ColName = 'CreCreationPlace4_tab';
	//	$creCreationPlace5 = new Field;
	//	$creCreationPlace5->ColName = 'CreCreationPlace5_tab';
	//	$creationPlaceTable = new Table;
	//	$creationPlaceTable->Name = "Creation Place";
	//	$creationPlaceTable->Columns = array(	$creCreationPlace1,
	//						$creCreationPlace2,
	//						$creCreationPlace3,
	//						$creCreationPlace4,
	//						$creCreationPlace5);

		// CreCulturalOrigin
//		$creCulturalOrigin1 = new Field;
	//	$creCulturalOrigin1->ColName = 'CreCulturalOrigin1';
	//	$creCulturalOrigin2 = new Field;
	//	$creCulturalOrigin2->ColName = 'CreCulturalOrigin2';
	//	$creCulturalOrigin3 = new Field;
	//	$creCulturalOrigin3->ColName = 'CreCulturalOrigin3';
	//	$creCulturalOrigin4 = new Field;
	//	$creCulturalOrigin4->ColName = 'CreCulturalOrigin4';
	//	$creCulturalOrigin5 = new Field;
	//	$creCulturalOrigin5->ColName = 'CreCulturalOrigin5';
	//	$culturalOriginTable = new Table;
	//	$culturalOriginTable->Name = "Cultural Origins";
	//	$culturalOriginTable->Columns = array(	$creCulturalOrigin1,
	//						$creCulturalOrigin2,
	//						$creCulturalOrigin3,
	//						$creCulturalOrigin4,
	//						$creCulturalOrigin5);

//		$notNotes = new Field;
//		$notNotes->ColName = 'NotNotes';
//		$notNotes->Filter = '/Public(.*?)(Private|$)/is';

		$this->Fields = array(
				'Dc1Title',
				'Dc1Type',
				$Dc1CreatorNameRef,
				'Dc1Description',
				);
	$this->SuppressEmptyFields = 0;	
		$this->BaseStandardDisplay();
	}
}

class
NofdigiPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	NofdigiPartyDisplay()
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
class
NofdigiNarrativeDisplay extends BaseStandardDisplay
{

	function
	NofdigiNarrativeDisplay()
	{
		$this->Fields = array(
				'SummaryData',
				'NarTitle',
				);

		$this->Database = 'enarratives';

		$this->BaseStandardDisplay();
	}
}
?>
